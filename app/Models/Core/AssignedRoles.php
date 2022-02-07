<?php

namespace Models\Core;

use Phalcon\Mvc\Model;

class AssignedRoles extends Model
{
	/**
     * @var UUID
     */
    public $id;
	
	/**
     * @var integer
     */
    public $userid;
	
	/**
     * @var integer
     */
    public $roleid;
	
	/**
     * Define relationships
     */
	public function initialize()
    {
		$this->setSource('core_assigned_roles');
		
		$this->hasOne('userid', Users::class, 'id', [
            'alias'      => 'user'
        ]);
		
		$this->hasOne('roleid', Roles::class, 'id', [
            'alias'      => 'role'
        ]);
	}
}