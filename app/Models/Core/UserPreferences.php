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

use Phalcon\Security;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

use Phalcon\Mvc\Model;
/**
 * All the users registered in the application
 */
class UserPreferences extends Model
{
	/**
     * @var UUID
     */
    public $id;

    /**
     * @var UUID
     */
    public $userid;
	
	/**
     * @var string
     */
    public $displayname;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value;
	
	
	public function initialize()
    {
		$this->setSource('core_user_preferences');
		
        $this->belongsTo('userid', Users::class, 'id', [
            'alias'    => 'User',
            'reusable' => true,
        ]);
		
	}
	
	/**
     * Validate that emails are unique across users
     */
    /*public function validation()
    {
        $validator = new Validation();

        $validator->add('name', new Uniqueness([
            "message" => "The name of the preference is already registered",
        ]));

        return $this->validate($validator);
    }*/
	
}