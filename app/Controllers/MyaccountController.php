<?php

namespace Controllers;

use Models\Core\Users;

class MyaccountController extends ControllerBase
{
    public function initialize(): void
    {
		parent::initialize();
		$this->view->pagetitle = "Manage Account";
    }
	
	public function indexAction()
	{
		//Action Bar controls
		//$activeOrDeactivate = $user->status == 'Y' ? 'deactivate' : 'activate';
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
				//array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/users/create'),
				array('icon' => 'lni lni-lock-alt', 'text' => 'Reset Password', 'modal' => 'resetpassmodal'),
				//array('icon' => 'lni ' . ($activeOrDeactivate === 'deactivate' ? 'lni-ban' : 'lni-checkmark'), 'text' => ucfirst($activeOrDeactivate), 'method' => 'link', 'route' => "/users/$activeOrDeactivate/$id"),
				//array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'method' => 'link', 'route' => "/users/delete/$id"),
				//array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/export/'. $id),
			)
		)));
		
		$this->view->systemname = $this->config->application->systemName;
		$this->view->user = Users::findFirstById($this->auth->getIdentity()['id']);
	}
}
