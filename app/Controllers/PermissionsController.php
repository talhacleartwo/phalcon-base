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
use Models\Core\Permissions;
use Models\Core\Profiles;
use c2system\Forms\Core\PermissionsForm;

/**
 * View and define permissions for the various profile levels.
 */
class PermissionsController extends ControllerBase
{
	public function initialize(): void
    {
    	parent::initialize();
		$this->view->pagetitle = "Manage Permissions";
    }
	
    /**
     * View the permissions for a profile level, and change them if we have a
     * POST.
     */
    public function indexAction(): void
    {
		$this->view->pagedetails = "List System Permissions";
		$this->view->tables = true;
		$this->view->setVar('records', Permissions::find());
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/permissions/create'),
				
			),
			'bulkactions' => array(
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/users/bulkdelete/'),
				array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/users/bulkexport/'),
			)
		)));
		
		//Views
		$this->view->_core_views = json_encode(array('current' => 'active', 'list' => [
			['link' => '/permissions', 'name' => 'All Permissions'],
		]));
		
	   //$this->view->records = $permissions;
	   
	   
        /*if ($this->request->isPost()) {
            $profile = Profiles::findFirstById($this->request->getPost('profileId'));
            if ($profile) {
                if ($this->request->hasPost('permissions') && $this->request->hasPost('submit')) {
                    // Deletes the current permissions
                    $profile->getPermissions()->delete();

                    // Save the new permissions
                    foreach ($this->request->getPost('permissions') as $permission) {
                        $parts = explode('.', $permission);

                        $permission             = new Permissions();
                        $permission->profilesId = $profile->id;
                        $permission->resource   = $parts[0];
                        $permission->action     = $parts[1];

                        $permission->save();
                    }

                    $this->flash->success('Permissions were updated with success');
                }

                // Rebuild the ACL with
                $this->acl->rebuild();

                // Pass the current permissions to the view
                $this->view->setVar('permissions', $this->acl->getPermissions($profile));
            }

            $this->view->setVar('profile', $profile);
        }

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ],
        ]);

        $profilesSelect = $this->tag->select([
            'profileId',
            $profiles,
            'using'      => [
                'id',
                'name',
            ],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => '',
            'class'      => 'form-control',
            'id'        => 'kt_permissions'
        ]);*/

    }
	
	public function createAction()
	{
		$this->view->pagedetails = "Create System Permission";
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
				array('icon' => 'lni lni-save', 'text' => 'Save & New', 'method' => 'save', 'redir' => '/permissions/create'),
			)
		)));
		
		$form = new PermissionsForm();
		
		if($this->request->isPost())
		{
			$record = new Permissions();
			
			$record->assign([
				'id' => UtilHelper::uuidv4(),
                'name' => $this->request->getPost('name', 'striptags'),
                'controller' => $this->request->getPost('controller', 'striptags'),
                'action' => $this->request->getPost('action', 'striptags')
            ]);
			
			if($record->save() === false)
			{
				$msgs = $record->getMessages();
				$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") ); 
			}
			
			$this->flash->success("Record created successfully");
			
			//Redirect if redirectino was requested
			if($this->request->getPost('redir'))
			{
				return $this->response->redirect($this->request->getPost('redir'));
			}
			
			return $this->response->redirect("/permissions/edit/" . $record->id);
		}		
		
		$this->view->setVar('form', $form);
	}
	
	
	public function editAction($id)
	{
		$this->view->pagedetails = "Edit System Permission";
		
		$record = Permissions::findFirstById($id);
		
		if(!$record)
		{
			//404
			return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
		}
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
				array('icon' => 'lni lni-save', 'text' => 'Save & New', 'route' => '/permissions/create', 'method' => 'post', 'redir' => '/permissions/create'),
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'method' => 'link', 'confirm' => "Are you sure you want to delete this record?", 'route' => '/permissions/delete/' . $record->id, 'redir' => '/permissions'),
			)
		)));
		
		$form = new PermissionsForm($record);
		
		if($this->request->isPost())
		{
			$record->assign([
                'name' => $this->request->getPost('name', 'striptags'),
                'controller' => $this->request->getPost('controller', 'striptags'),
                'action' => $this->request->getPost('action', 'striptags')
            ]);
			
			if($record->save() === false)
			{
				$msgs = $record->getMessages();
				$this->flash->error("Validation Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") ); 
			}
			
			//Rebuild the ACL after editing a permission
			$this->acl->rebuild();
			
			$this->flash->success("Record updated successfully");
			//return $this->response->redirect("/permissions/edit/" . $record->id);
		}
		
		$this->view->setVar('form', $form);
		$this->view->setVar('record', $record);
	}
	
	
	public function deleteAction($id)
	{
		$record = Permissions::findFirstById($id);
		
		if(!$record)
		{
			//404
			return $this->dispatcher->forward([
                'controller' => 'errors',
                'action' => 'show404',
            ]);
		}
		
		//Remove links to assigned permissions
		$record->AssignedPermissions->delete();
		
		//Delete the record
		if($record->delete() === false)
		{
			$msgs = $record->getMessages();
			$this->flash->error("Error: " . $msgs[0] . ( count($msgs) > 1 ? " ( + " . (count($msgs) - 1) . " more errors )" : "") ); 
		}
		
		$this->flash->success("Record deleted successfully");
		
		return $this->response->redirect('/permissions');
	}
}
