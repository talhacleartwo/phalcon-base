<?php

namespace Models\Core;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

class Roles extends Model
{
	/**
	* @var UUID
	*/
	public $id;
	
	/**
     * @var string
     */
    public $name;
	
	/**
     * Define relationships
     */
    public function initialize()
    {
		$this->setSource('core_roles');
		
        $this->hasMany('id', AssignedRoles::class, 'roleid', [
            'alias'      => 'AssignedRoles',
            'foreignKey' => [
                'message' => 'Role cannot be deleted because it\'s still assigned to one or more Users',
            ],
        ]);

        $this->hasMany('id', AssignedPermissions::class, 'roleid', [
            'alias'      => 'AssignedPermissions',
            'foreignKey' => [
				'message' => 'Role cannot be deleted because it\'s still assigned to one or more Permissions',
                //'action' => Relation::ACTION_CASCADE,
            ],
        ]);
    }
	
	
	public function getPermissions()
	{
		$perms = [];
		foreach($this->AssignedPermissions as $ap)
		{
			$perms[] = $ap->Permission;
		}
		return $perms;
	}
}