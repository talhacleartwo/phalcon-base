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
use Models\Core\Roles;
use Models\Core\Permissions;
use Models\Core\AssignedPermissions;


class RolesController extends ControllerBase
{
    /**
     * Default action. Set the private (authenticated) layout
     * (layouts/private.volt)
     */
    public function initialize(): void
    {
    	parent::initialize();
		$this->view->pagetitle = "Manage Roles";
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction(): void
    {
		$this->view->pagedetails = "List User Roles";
		$this->view->tables = true;
		
		//Action Bar controls
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-plus', 'text' => 'New', 'method' => 'link', 'route' => '/roles/create'),
				
			),
			'bulkactions' => array(
				//array('icon' => 'lni lni-ban', 'text' => 'Deactivate', 'route' => '/roles/bulkdeactivate/'),
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/roles/bulkdelete/'),
				//array('icon' => 'lni lni-download', 'text' => 'Export', 'route' => '/roles/bulkexport/'),
			)
		)));
		
		//Views
		$this->view->_core_views = json_encode(array('current' => 'active', 'list' => [
			['link' => '/roles', 'name' => 'All Roles'],
		]));
		
		//throw new \Exception("error test", 500);
		//$arr = [1,2,3];
		//$test = $arr->1;
    	//$this->assets->collection('pageCss')->addCss('assets/plugins/custom/datatables/datatables.bundle.css', true, true);
    	//$this->assets->collection('pageJs')->addJs('assets/plugins/custom/datatables/datatables.bundle.js', true, true);
    	//$this->assets->collection("pageJs")->addJs("assets/js/tablejs.js", true, true);
    	
    	$this->view->setVar('records', Roles::find());
    }

    

    /**
     * Creates a new Profile
     */
    public function createAction(): void
    {
        if ($this->request->isPost()) {
            $role = new Roles([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active'),
            ]);

            if (!$role->save()) {
                foreach ($role->getMessages() as $message) {
                    $this->flash->error((string)$message);
                }
            } else {
            	$this->flashSession->success("Role was created successfully");
                $this->response->redirect('roles');
            }
        }

        $this->view->setVar('form', new RolesForm(null));
        //$this->assets->collection("pageJs")->addJs("assets/js/formjs.js", true, true);
    }

    /**
     * Edits an existing Role
     *
     * @param int $id
     */
    public function editAction($id)
    {
		$this->view->pagedetails = "Edit User Role";
		
        $role = Roles::findFirstById($id);
		$this->view->tables = true;
		
		$this->view->ActionBarControls = json_decode(json_encode(array(
			'actions' => array(
				array('icon' => 'lni lni-save', 'text' => 'Save', 'method' => 'save'),
				array('icon' => 'lni lni-trash-can', 'text' => 'Delete', 'route' => '/roles/delete/'. $id),
			)
		)));
		
        if (!$role) {
            $this->flash->error("Role was not found");
            return $this->dispatcher->forward([
                'action' => 'index',
            ]);
        }

		
        if($this->request->isPost())
		{
            //Update assigned permissions
			$permissions = $this->request->getPost('permissions');
			
			//Delete existing assigned permissions
			$role->AssignedPermissions->delete();
			
			foreach($permissions as $perm)
			{
				$ap = new AssignedPermissions();
				$ap->id = UtilHelper::uuidv4();
				$ap->roleid = $id;
				$ap->permissionid = $perm;
				$ap->save();
			}
			
			//Rebuild the ACL after editing a role
			$this->acl->rebuild();
			
			$this->flash->success("Record Updated Successfully");
        }

        $this->view->setVars([
            'record' => $role,
			'permissions' => Permissions::find(),
			'assignedPermissions' => $role->AssignedPermissions
        ]);
    }


    /**
     * Deletes a Profile
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $role = Roles::findFirstById($id);
		
        if (!$role) 
		{
            $this->flash->error("Role was not found");

            return $this->dispatcher->forward([
                'action' => 'index',
            ]);
        }

        if (!$role->delete()) 
		{
            foreach ($role->getMessages() as $message) {
                $this->flash->error((string)$message);
            }
        } 
		else 
		{
			//Rebuild the ACL after deleting a role
			$this->acl->rebuild();
			
            $this->flash->success("Role was deleted");
        }

        return $this->dispatcher->forward([
            'action' => 'index',
        ]);
    }
}
