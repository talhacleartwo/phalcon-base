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
use Models\Basemodel;

use Plugins\UtilHelper;

/**
 * All the users registered in the application
 */
class Users extends Basemodel
{
    /**
     * @var UUID
     */
    public $id;

    /**
     * @var string
     */
    public $firstname;
	
	/**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $mustChangePassword;
	
	/**
     * @var string
     */
    public $twofasecret;

    /**
     * @var char
     */
    public $status;
	

    public function initialize()
    {
		$this->setSource('core_users');
		
        $this->hasMany('id', AssignedRoles::class, 'userid', [
            'alias'    => 'AssignedRoles',
            'reusable' => true,
        ]);
		
		$this->hasMany('id', UserPreferences::class, 'userid', [
            'alias'    => 'Preferences',
            'reusable' => true,
        ]);

        /*$this->hasMany('id', SuccessLogins::class, 'usersId', [
            'alias'      => 'successLogins',
            'foreignKey' => [
                'message' => 'User cannot be deleted because he/she has activity in the system',
            ],
        ]);
        
        $this->hasMany('id', FailedLogins::class, 'usersId', [
        	'alias'      => 'failedLogins',
        	'foreignKey' => [
        		'message' => 'User cannot be deleted because he/she has activity in the system',
        	],
        ]);
        $this->hasMany('id', PasswordChanges::class, 'usersId', [
            'alias'      => 'passwordChanges',
            'foreignKey' => [
                'message' => 'User cannot be deleted because he/she has activity in the system',
            ],
        ]);

        $this->hasMany('id', ResetPasswords::class, 'usersId', [
            'alias'      => 'resetPasswords',
            'foreignKey' => [
                'message' => 'User cannot be deleted because he/she has activity in the system',
            ],
        ]);
        
        $this->hasOne('id', EmailConfirmations::class, 'userId', ['alias'      => 'emailConfirmation']);
        
        $this->hasOne('id', Delivery::class, 'driverId', ['alias'      => 'driver']);*/
    }


	


    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
		parent::beforeValidationOnCreate();
		
		//Set 2FA secret on creation
		$g = new \Google\Authenticator\GoogleAuthenticator();
		$this->twofasecret = $g->generateSecret();
		
        /*if (empty($this->password)) {
            // Generate a plain temporary password
            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

            // The user must change its password in first login
            $this->mustChangePassword = 'Y';

            // @var Security $security
            $security = $this->getDI()->getShared('security');
            // Use this password as default
            $this->password = $security->hash($tempPassword);
        } else {
            // The user must not change its password in first login
            $this->mustChangePassword = 'N';
        }

        // The account must be confirmed via e-mail
        // Only require this if emails are turned on in the config, otherwise account is automatically active
        if ($this->getDI()->get('config')->useMail) {
            $this->active = 'N';
        } else {
            $this->active = 'Y';
        }

        // The account is not suspended by default
        $this->suspended = 'N';

        // The account is not banned by default
        $this->banned = 'N';*/
    }
	
	
	public function afterCreate()
	{
		$this->setDefaultPreferences();
	}
	
	
	public function setDefaultPreferences()
	{
		$prefs = array(
			[
				'name' => 'enable2fa',
				'value' => 0,
				'displayname' => 'Enable Two Factor Authentication'
			],
			[
				'name' => 'loginredirect',
				'value' => '/dashboard',
				'displayname' => 'Redirect to after login'
			],
		);
		
		foreach($prefs as $p)
		{
			$pref = new UserPreferences();
			$pref->assign([
				'id' => UtilHelper::uuidv4(),
				'userid' => $this->id,
				'name' => $p['name'],
				'value' => $p['value'],
				'displayname' => $p['displayname']
			]);
			$pref->save();
		}
	}
	
    /**
     * Send a confirmation e-mail to the user if the account is not active
     */
    /*public function afterCreate()
    {
        // Only send the confirmation email if emails are turned on in the config
        if ($this->getDI()->get('config')->useMail && $this->active == 'N') {
            $emailConfirmation          = new EmailConfirmations();
            $emailConfirmation->usersId = $this->id;

            if ($emailConfirmation->save()) {
                $this->getDI()
                    ->getFlash()
                    ->notice('A confirmation mail has been sent to ' . $this->email);
            }
        }
    }*/

    /**
     * Validate that emails are unique across users
     */
    public function validation()
    {
        /*$validator = new Validation();

        $validator->add('email', new Uniqueness([
            "message" => "The email is already registered",
        ]));
        
        $validator->add('username', new Uniqueness([
        	'message' => 'The username is already Registered',
        ]));

        return $this->validate($validator);*/
    }
	
	
	/**
     * Used by the ACL to get a list of this users roles for session storage
     */
	public function getRolesArray()
	{
		$roles = [];
		foreach($this->AssignedRoles as $ar)
		{
			$roles[] = $ar->roleid;
		}
		return $roles;
	}


	public function getPreference($name)
	{
		foreach($this->Preferences as $p)
		{
			if($p->name === $name){
				return $p->value;
			}
		}
	}

}
