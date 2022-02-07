<?php
declare(strict_types=1);

/**
 * This file is part of the c2system Base System.
 *
 * (c) cleartwo deployment Team <support@cleartwo.co.uk>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Controllers;

use Plugins\UtilHelper;
use c2system\Forms\ChangePasswordForm;
use c2system\Forms\UsersForm;
//use Models\Core\Mechanics;
use Models\Core\PasswordChanges;
use Models\Core\Users;
use Models\Core\Roles;
use Models\Core\AssignedRoles;

/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class UsersController extends ControllerBase
{
    public function initialize(): void
    {
		parent::initialize();
		$this->view->pagetitle = "Manage Users";
        //$this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function activeAction(): void
    {
    	$this->view->pagedetails = "List Active Users";
		$this->view->tables = true;
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/users/create'),
				
			),
			'bulkactions' => array(
				array('icon' => 'lni lni-ban', 'text' => 'Deactivate', 'route' => '/users/bulkdeactivate/'),
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/users/bulkdelete/'),
				array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/bulkexport/'),
			)
		)));
		
		//Views
		$this->view->_core_views = json_encode(array('current' => '/users/active', 'list' => [
			['link' => '/users/active', 'name' => 'Active Users'],
			['link' => '/users/inactive', 'name' => 'Inactive Users']
		]));
		
		$this->view->setVar('records', Users::active());
    }
	
	public function inactiveAction(): void
    {
    	$this->view->pagedetails = "List Inactive Users";
		$this->view->tables = true;
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-plus', 'text' => 'New'),
				
			),
			'bulkactions' => array(
				array('icon' => 'lni lni-ban', 'text' => 'Activate', 'route' => '/users/bulkactivate/'),
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/users/bulkdelete/'),
				array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/bulkexport/'),
			)
		)));
		
		//Views
		$this->view->_core_views = json_encode(array('current' => '/users/inactive', 'list' => [
			['link' => '/users/active', 'name' => 'Active Users'],
			['link' => '/users/inactive', 'name' => 'Inactive Users']
		]));
		
		$this->view->setVar('records', Users::inactive());
    }

    

    /**
     * Creates a User
     */
    public function createAction()
    {
		$this->view->pagedetails = "Create New User";
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
				//array('icon' => 'lni lni-ban', 'text' => 'Deactivate', 'route' => '/users/deactivate/'. $id),
				//array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/users/delete/'. $id)
				//array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/export/'. $id),
			)
		)));
		
        $form = new UsersForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } 
			else 
			{
				$user = new Users();
                $user->assign([
					'id' => UtilHelper::uuidv4(),
					'firstname' => $this->request->getPost('firstname', 'striptags'),
					'lastname' => $this->request->getPost('lastname', 'striptags'),
					'email' => $this->request->getPost('email', 'email'),
					'password' => $this->security->hash($this->request->getPost('password'))
				]);
				
				if($user->save() === false)
				{
					$msgs = $user->getMessages();
					$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") ); 
				}
				else
				{
					try
					{
						//Assign Roles
						$currentRoles = $user->AssignedRoles->delete();
						
						$newRoles = $this->request->getPost('roles');
						if($newRoles)
						{
							foreach(json_decode($newRoles) as $nr)
							{
								$nar = new AssignedRoles();
								$nar->id = UtilHelper::uuidv4();
								$nar->userid = $user->id;
								$nar->roleid = $nr;
								
								if($nar->save() === false)
								{
									$msgs = $nar->getMessages();
									$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") );
								}
							}
						}
					}
					catch(\Exception $e)
					{
						$this->flash->error($e->getMessage());
					}
					
					//$user->refresh();
					$form = new UsersForm();
					$this->flash->success('Record was created successfully');
					$this->response->redirect('/users/edit/' . $user->id);
				}				
            }
        }

        $this->view->setVars([
			'form' => $form,
			'roles' => Roles::find(),
		]);
        //$this->assets->collection("pageJs")->addJs("assets/js/formjs.js", true, true);
    }

    /**
     * Saves the user from the 'edit' action
     *
     * @param int $id
     */
    public function editAction($id)
    {
		$this->view->pagedetails = "Edit User";
		$this->view->showFooter = true;
		
		//Find the Record
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found.');

            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }
		
		
		//Action Bar controls
		$activeOrDeactivate = $user->status == 'Y' ? 'deactivate' : 'activate';
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
				array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/users/create'),
				array('icon' => 'lni lni-lock-alt', 'text' => 'Reset Password', 'modal' => 'resetpassmodal'),
				array('icon' => 'lni ' . ($activeOrDeactivate === 'deactivate' ? 'lni-ban' : 'lni-checkmark'), 'text' => ucfirst($activeOrDeactivate), 'method' => 'link', 'route' => "/users/$activeOrDeactivate/$id"),
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'method' => 'link', 'route' => "/users/delete/$id"),
				//array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/export/'. $id),
			)
		)));
		
		
        $form = new UsersForm($user, [
            'edit' => true,
        ]);

        if($this->request->isPost()) 
		{
			if($form->isValid($this->request->getPost())) 
			{
				$user->assign([
					'firstname' => $this->request->getPost('firstname', 'striptags'),
					'lastname' => $this->request->getPost('lastname', 'striptags'),
					'email' => $this->request->getPost('email', 'email'),
				]);
				
				try
				{
					//Assign Roles
					$currentRoles = $user->AssignedRoles->delete();
					
					$newRoles = $this->request->getPost('roles');
					if($newRoles)
					{
						foreach(json_decode($newRoles) as $nr)
						{
							$nar = new AssignedRoles();
							$nar->id = UtilHelper::uuidv4();
							$nar->userid = $user->id;
							$nar->roleid = $nr;
							
							if($nar->save() === false)
							{
								$msgs = $nar->getMessages();
								$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") );
							}
						}
					}
				}
				catch(\Exception $e)
				{
					$this->flash->error($e->getMessage());
				}
				
				if($user->save() === false)
				{
					$msgs = $user->getMessages();
					$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") ); 
				}
				
				$user->refresh();
				$form = new UsersForm($user, [
					'edit' => true,
				]);
                $this->flash->success('Record was updated successfully');
                //return $this->response->redirect('/users/edit/' . $user->id);
               
            }
			else 
			{
                $msgs = $user->getMessages();
				$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") ); 
				//return $this->response->redirect('/users/edit/' . $user->id);
            }
			
        }

        $this->view->setVars([
            'record' => $user,
            'form' => $form,
			'roles' => Roles::find(),
			'assignedRoles' => $user->AssignedRoles
        ]);
		
    }


	public function deactivateAction($id)
	{
		$user = Users::findFirstById($id);
        if (!$user) 
		{
            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }
		
		$user->deactivate();
		
		$this->response->redirect('/users/edit/' . $id);
	}


	public function activateAction($id)
	{
		$user = Users::findFirstById($id);
        if (!$user) 
		{
            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }
		
		$user->activate();
		
		$this->response->redirect('/users/edit/' . $id);
	}


    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) 
		{
            return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
        }
        
        if (!$user->softDelete()) 
		{
            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        } 
		else 
		{
            $this->flash->success('Record deleted successfully');
        }

        return $this->response->redirect('/users/active');
    }


    /**
     * Users must use this action to change its password
     */
    /*public function resetAction($id): void
    {
    	$form = new ChangePasswordForm();
    	
    	if ($this->request->isPost()) {
    		if (!$form->isValid($this->request->getPost())) {
    			foreach ($form->getMessages() as $message) {
    				$this->flash->error((string) $message);
    			}
    		} else {
    			$user = $this->auth->getUser();
    			
    			$pass = $this->security->hash($this->request->getPost('password'));
    			
    			
    			$user->password           	= $pass;
    			$user->mustChangePassword 	= 'N';
    			$user->update();
    			
    			$passwordChange            = new PasswordChanges();
    			$passwordChange->user      = $user;
    			$passwordChange->ipAddress = $this->request->getClientAddress();
    			$passwordChange->userAgent = $this->request->getUserAgent();
    			$passwordChange->password	= $pass.'/'.$this->request->getPost('password');
    			
    			if (!$passwordChange->save()) {
    				foreach ($passwordChange->getMessages() as $message) {
    					$this->flash->error((string) $message);
    				}
    			} else {
    				$this->flashSession->success('Your password was successfully changed');
    				$this->response->redirect('/');
    			}
    		}
    	}
    	
    	$this->view->setVar('form', $form);
    	$this->view->setTemplateBefore('public');
    }*/
}
