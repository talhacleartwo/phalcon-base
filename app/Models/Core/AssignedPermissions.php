<?php

namespace Models\Core;

use Phalcon\Mvc\Model;

class AssignedPermissions extends Model
{
	/**
     * @var UUID
     */
    public $id;
	
	/**
     * @var integer
     */
    public $permissionid;
	
	/**
     * @var integer
     */
    public $roleid;
	
	/**
     * Define relationships
     */
	public function initialize()
    {
		$this->setSource('core_assigned_permissions');
		
		$this->hasOne('permissionid', Permissions::class, 'id', [
            'alias'      => 'Permission'
        ]);
		
		$this->hasOne('roleid', Roles::class, 'id', [
            'alias'      => 'Role'
        ]);
	}
}