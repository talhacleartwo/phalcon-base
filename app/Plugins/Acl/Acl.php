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

namespace Plugins\Acl;

use Phalcon\Acl\Adapter\AbstractAdapter;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Component as AclComponent;
use Phalcon\Acl\Enum as AclEnum;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Di\Injectable;
use Models\Core\Roles;

/**
 * Vokuro\Acl\Acl
 */
class Acl extends Injectable
{
    const APC_CACHE_VARIABLE_KEY = 'vokuro-acl';

    /**
     * The ACL Object
     *
     * @var AbstractAdapter|mixed
     */
    private $acl;

    /**
     * The file path of the ACL cache file.
     *
     * @var string
     */
    private $filePath;

    /**
     * Define the resources that are considered "private". These controller =>
     * actions require authentication.
     *
     * @var array
     */
    //private $privateResources = [];
	
	/**
     * Define the resources that are considered "public". These controller =>
     * actions DON'T require authentication.
     *
     * @var array
     */
    private $publicResources = [];

    /**
     * Human-readable descriptions of the actions used in
     * {@see $privateResources}
     *
     * @var array
     */
    /*private $actionDescriptions = [
        'index'          => 'Access',
        'search'         => 'Search',
        'create'         => 'Create',
        'edit'           => 'Edit',
        'delete'         => 'Delete',
        'changePassword' => 'Change password',
    ];*/

    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     *
     * @return boolean
     */
    public function isPrivate($controllerName): bool
    {
		return !isset($this->publicResources[$controllerName]);
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     *
     * @return boolean
     */
    public function isAllowed($roles, $controller, $action): bool
    {
		//Check if resource is public
		if(isset($this->publicResources[$controller][$action])){return true;}
		
		//Check if permission for private resource is allowed
		$acl = $this->getAcl();
		//die(var_export($acl,true));
		$allowed = false;
		foreach($acl as $roleId => $role)
		{
			//Check if the user is assigned this role
			if(in_array($roleId,$roles))
			{		
				//Check if this role has the controller we are looking for
				if(isset($role[$controller]))
				{
					//Check if the action is allowed for this role
					$allowed = in_array($action, $role[$controller]);
				}
			}
			
			if($allowed){break;}
		}
		return $allowed;
        //return $this->getAcl()->isAllowed($roles, $controller, $action);
    }

    /**
     * Returns the ACL list
     *
     * @return AbstractAdapter|mixed
     */
    public function getAcl()
    {
        // Check if the ACL is already created
        if (is_object($this->acl)) 
		{
            return $this->acl;
        }

        // Check if the ACL is in APC
        if(function_exists('apc_fetch')) 
		{
            $acl = apc_fetch(self::APC_CACHE_VARIABLE_KEY);
            if ($acl !== false) 
			{
                $this->acl = $acl;
                return $acl;
            }
        }

        $filePath = $this->getFilePath();

        // Check if the ACL is already generated
        if (!file_exists($filePath)) 
		{
            $this->acl = $this->rebuild();
            return $this->acl;
        }

        // Get the ACL from the data file
        $data      = file_get_contents($filePath);
        $this->acl = unserialize($data);

        // Store the ACL in APC
        if (function_exists('apc_store')) 
		{
            apc_store(self::APC_CACHE_VARIABLE_KEY, $this->acl);
        }

        return $this->acl;
    }

    /**
     * Returns the permissions assigned to a profile
     *
     * @param Profiles $profile
     *
     * @return array
     */
    /*public function getPermissions(Roles $role): array
    {
        $permissions = [];
        foreach ($role->getPermissions() as $permission) {
            $permissions[$permission->controller . '.' . $permission->action] = true;
        }

        return $permissions;
    }*/

    /**
     * Returns all the resources and their actions available in the application
     *
     * @return array
     */
    /*public function getResources(): array
    {
        return $this->privateResources;
    }*/

    /**
     * Returns the action description according to its simplified name
     *
     * @param string $action
     *
     * @return string
     */
    /*public function getActionDescription($action): string
    {
        return $this->actionDescriptions[$action] ?? $action;
    }*/

    /**
     * Rebuilds the access list into a file
     *
     * @return AclMemory
     */
    public function rebuild()
    {
        $acl = [];
        //$acl->setDefaultAction(AclEnum::DENY);

        $roles = Roles::find();
        foreach ($roles as $role) 
		{
			$rolePerms = $role->getPermissions();
			//die(var_export($rolePerms,true));
			$acl[$role->id] = [];
			foreach($rolePerms as $rp)
			{
				if(isset($acl[$role->id][$rp->controller]))
				{
					$acl[$role->id][$rp->controller][] = $rp->action;
				}
				else
				{
					$acl[$role->id][$rp->controller] = [$rp->action];
				}
			}
			
			
            //$acl->addRole(new AclRole($role->name));
        }

        /*foreach ($this->privateResources as $resource => $actions) {
            $acl->addComponent(new AclComponent($resource), $actions);
        }*/

        // Grant access to private area to role Users
        /*foreach ($roles as $role) {
            // Grant permissions in "permissions" model
            foreach ($role->getPermissions() as $permission) {
                $acl->allow($role->name, $permission->controller, $permission->action);
            }

            // Always grant these permissions
            //$acl->allow($role->name, 'users', 'changePassword');
        }*/

        $filePath = $this->getFilePath();
        if (touch($filePath) && is_writable($filePath)) {
            file_put_contents($filePath, serialize($acl));

            // Store the ACL in APC
            if (function_exists('apc_store')) {
                apc_store(self::APC_CACHE_VARIABLE_KEY, $acl);
            }
        } else {
            $this->flash->error('The user does not have write permissions to create the ACL list at ' . $filePath);
        }

        return $acl;
    }


    /**
     * Set the acl cache file path
     *
     * @return string
     */
    protected function getFilePath()
    {
        if (!isset($this->filePath)) {
            $this->filePath = rtrim($this->config->application->cacheDir, '\\/') . '/acl/data.txt';
        }

        return $this->filePath;
    }

    /**
     * Adds an array of private resources to the ACL object.
     *
     * @param array $resources
     */
    /*public function addPrivateResources(array $resources)
    {
        if (empty($resources)) {
            return;
        }

        $this->privateResources = array_merge($this->privateResources, $resources);
        if (is_object($this->acl)) {
            $this->acl = $this->rebuild();
        }
    }*/
	
	
	public function addPublicResources(array $resources)
	{
		$this->publicResources = $resources;
	}
}
