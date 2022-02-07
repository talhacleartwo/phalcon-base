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

namespace Models\Core;

use Phalcon\Mvc\Model;

/**
 * Permissions
 *
 * Stores the permissions by profile
 */
class Permissions extends Model
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
     * @var integer
     */
    public $controller;

    /**
     * @var string
     */
    public $action;


    public function initialize()
    {
		$this->setSource('core_permissions');
		
        $this->hasMany('id', AssignedPermissions::class, 'permissionid', [
            'alias' => 'AssignedPermissions',
        ]);
    }
}
