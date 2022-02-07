<?php

/**
 * This file is part of the c2system Base System.
 *
 * (c) cleartwo deployment Team <support@cleartwo.co.uk>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Controllers;

//use c2system\Forms\ChangePasswordForm;
use c2system\Forms\ContactsForm;
//use Models\Core\Mechanics;
//use Models\Core\PasswordChanges;
use Models\Core\Contacts;


class ContactsController extends ControllerBase
{
	public function initialize(): void
    {
		parent::initialize();
		$this->view->pagetitle = "Contacts";
    }
	
	
	public function indexAction()
	{
		$this->view->pagedetails = "List Contacts";
	}
	
	public function createAction()
	{
		$this->view->pagedetails = "Create New Contact";
		
		$form = new ContactsForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) 
			{
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } 
			else 
			{

                $newrecord = new Contacts([
                    'name'       => $this->request->getPost('name', 'striptags'),
                	'username'   => $this->request->getPost('username', 'striptags'),
                    'profilesId' => $this->request->getPost('profilesId', 'int'),
                    'email'      => $this->request->getPost('email', 'email'),
                ]);

                if (!$newrecord->save()) {
                    foreach ($newrecord->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success("Record was created successfully");
                    $this->response->redirect('contacts');
                }
            }
        }

        $this->view->setVar('form', $form);
        //$this->assets->collection("pageJs")->addJs("assets/js/formjs.js", true, true);
	}
}