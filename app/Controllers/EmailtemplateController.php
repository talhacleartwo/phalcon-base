<?php

namespace Controllers;

use Models\Core\Accounts;

use Models\Core\EmailTemplates;
use Plugins\UtilHelper;
use c2system\Forms\Core\AccountsForm;

class EmailtemplateController extends ControllerBase
{
    public function initialize(): void
    {
        parent::initialize();
        $this->view->pagetitle = "Manage Accounts";
        //$this->view->setTemplateBefore('private');
    }

    public function activeAction()
    {
        $this->view->pagedetails = "List Active Accounts";
        $this->view->tables = true;

        //Action Bar controls
        $this->view->ActionBarControls = json_decode(json_encode(array(
            'actions' => array(
                array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/accounts/create'),

            ),
            'bulkactions' => array(
                array('icon' => 'lni lni-ban', 'text' => 'Deactivate', 'route' => '/accounts/bulkdeactivate/'),
                array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/accounts/bulkdelete/'),
                array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/accounts/bulkexport/'),
            )
        )));

        //Views
        $this->view->_core_views = json_encode(array('current' => '/accounts/active', 'list' => [
            ['link' => '/accounts/active', 'name' => 'Active Accounts'],
            ['link' => '/accounts/inactive', 'name' => 'Inactive Accounts']
        ]));
        $d=EmailTemplates::find();

        $this->view->setVar('records', EmailTemplates::active());
    }

    public function inactiveAction(): void
    {
        $this->view->pagedetails = "List Inactive Accounts";
        $this->view->tables = true;

        //Action Bar controls
        $this->view->ActionBarControls = json_decode(json_encode(array(
            'actions' => array(
                array('icon' => 'lni lni-plus', 'text' => 'New'),

            ),
            'bulkactions' => array(
                array('icon' => 'lni lni-ban', 'text' => 'Activate', 'route' => '/accounts/bulkactivate/'),
                array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/accounts/bulkdelete/'),
                array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/accounts/bulkexport/'),
            )
        )));

        //Views
        $this->view->_core_views = json_encode(array('current' => '/accounts/inactive', 'list' => [
            ['link' => '/accounts/active', 'name' => 'Active Users'],
            ['link' => '/accounts/inactive', 'name' => 'Inactive Users']
        ]));

        $this->view->setVar('records', Accounts::inactive());
    }

    public function createAction()
    {
        $this->view->pagedetails = "Create New Account";

        //Action Bar controls
        $this->view->ActionBarControls = json_decode(json_encode(array(
            'actions' => array(
                array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
                //array('icon' => 'lni lni-ban', 'text' => 'Deactivate', 'route' => '/users/deactivate/'. $id),
                //array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/users/delete/'. $id)
                //array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/export/'. $id),
            )
        )));

        $form = new AccountsForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
            else
            {
                $record = new Accounts();
                $record->assign([
                    'id' => UtilHelper::uuidv4(),
                    'companyname' => $this->request->getPost('companyname', 'striptags'),
                    'accountnumber' => $this->request->getPost('accountnumber', 'striptags'),
                    'website' => $this->request->getPost('website', 'striptags'),
                    'email' => $this->request->getPost('email', 'email'),
                    'addressline1' => $this->request->getPost('addressline1', 'striptags'),
                    'addressline2' => $this->request->getPost('addressline2', 'striptags'),
                    'city' => $this->request->getPost('city', 'striptags'),
                    'county' => $this->request->getPost('county', 'striptags'),
                    'postcode' => $this->request->getPost('postcode', 'striptags'),
                    'telephone' => $this->request->getPost('telephone', 'striptags'),
                    'telephone2' => $this->request->getPost('telephone2', 'striptags'),
                    'notes' => $this->request->getPost('notes', 'striptags'),
                ]);

                if($record->save() === false)
                {
                    $msgs = $record->getMessages();
                    $this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") );
                }
                else
                {
                    //$user->refresh();
                    $form = new AccountsForm();
                    $this->flash->success('Record was created successfully');
                    $this->response->redirect('/accounts/edit/' . $record->id);
                }
            }
        }

        $this->view->setVars([
            'form' => $form,
        ]);
    }

    public function editAction($id)
    {
        $this->view->pagedetails = "Edit Account";
        $this->view->showFooter = true;

        //Find the Record
        $record = Accounts::findFirstById($id);
        if (!$record) {
            $this->flash->error('Record was not found.');

            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }


        //Action Bar controls
        $activeOrDeactivate = $record->status == 'Y' ? 'deactivate' : 'activate';
        $this->view->ActionBarControls = json_decode(json_encode(array(
            'actions' => array(
                array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
                array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/accounts/create'),
                //array('icon' => 'lni lni-lock-alt', 'text' => 'Reset Password', 'modal' => 'resetpassmodal'),
                array('icon' => 'lni ' . ($activeOrDeactivate === 'deactivate' ? 'lni-ban' : 'lni-checkmark'), 'text' => ucfirst($activeOrDeactivate), 'method' => 'link', 'route' => "/accounts/$activeOrDeactivate/$id"),
                array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'method' => 'link', 'route' => "/accounts/delete/$id"),
                //array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/export/'. $id),
            )
        )));


        $form = new AccountsForm($record, [
            'edit' => true,
        ]);

        if($this->request->isPost())
        {
            if($form->isValid($this->request->getPost()))
            {
                $record->assign([
                    'companyname' => $this->request->getPost('companyname', 'striptags'),
                    'accountnumber' => $this->request->getPost('accountnumber', 'striptags'),
                    'website' => $this->request->getPost('website', 'striptags'),
                    'email' => $this->request->getPost('email', 'email'),
                    'addressline1' => $this->request->getPost('addressline1', 'striptags'),
                    'addressline2' => $this->request->getPost('addressline2', 'striptags'),
                    'city' => $this->request->getPost('city', 'striptags'),
                    'county' => $this->request->getPost('county', 'striptags'),
                    'postcode' => $this->request->getPost('postcode', 'striptags'),
                    'telephone' => $this->request->getPost('telephone', 'striptags'),
                    'telephone2' => $this->request->getPost('telephone2', 'striptags'),
                    'notes' => $this->request->getPost('notes', 'striptags'),
                ]);

                if($record->save() === false)
                {
                    $msgs = $record->getMessages();
                    $this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") );
                }
                else
                {
                    //$user->refresh();
                    $form = new AccountsForm();
                    $this->flash->success('Record was updated successfully');
                    $this->response->redirect('/accounts/edit/' . $record->id);
                }
            }
        }

        $this->view->setVars([
            'record' => $record,
            'form' => $form,
        ]);

    }

    public function deleteAction($id)
    {
        $record = Accounts::findFirstById($id);
        if (!$record)
        {
            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }

        if (!$record->softDelete())
        {
            foreach ($record->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        }
        else
        {
            $this->flash->success('Record deleted successfully');
        }

        return $this->response->redirect('/accounts/active');
    }

    public function deactivateAction($id)
    {
        $record = Accounts::findFirstById($id);
        if (!$record)
        {
            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }

        $record->deactivate();

        $this->response->redirect('/accounts/edit/' . $id);
    }


    public function activateAction($id)
    {
        $record = Accounts::findFirstById($id);
        if (!$record)
        {
            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }

        $record->activate();

        $this->response->redirect('/accounts/edit/' . $id);
    }
}