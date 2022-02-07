<?php

namespace Models\Core;

use Phalcon\Security;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Models\Basemodel;

use Plugins\UtilHelper;

/**
 * All the users registered in the application
 */
class Accounts extends Basemodel
{
	/**
     * @var UUID
     */
    public $id;
	
	/**
     * @var string
     */
    public $companyname;
	
	/**
     * @var string
     */
    public $accountnumber;
	
	/**
     * @var string
     */
    public $website;
	
	/**
     * @var string
     */
    public $email;
	
	/**
     * @var string
     */
    public $addressline1;
	
	/**
     * @var string
     */
    public $addressline2;
	
	/**
     * @var string
     */
    public $city;
	
	/**
     * @var string
     */
    public $county;
	
	/**
     * @var string
     */
    public $postcode;
	
	/**
     * @var string
     */
    public $telephone;
	
	/**
     * @var string
     */
    public $telephone2;
	
	/**
     * @var string
     */
    public $notes;
	
	/**
     * @var char
     */
    public $status;
	
	
	public function initialize()
    {
		$this->setSource('core_accounts');
		
        $this->hasMany('id', Contacts::class, 'accountid', [
            'alias'    => 'Contacts',
            'reusable' => true,
        ]);
		
		/*$this->hasMany('id', UserPreferences::class, 'userid', [
            'alias'    => 'Preferences',
            'reusable' => true,
        ]);*/
		
	}
	
	public function beforeValidationOnCreate()
	{
		parent::beforeValidationOnCreate();
		
		//Generate Acc No
		$this->accountnumber = UtilHelper::autoNumber("ACC");
	}
	
	
	public function getInitials()
	{
		//Split name on Space
		$nameParts = explode(' ', $this->companyname);
		if(count($nameParts) >= 2){return strtoupper(substr($nameParts[0],0,1)) . strtoupper(substr($nameParts[1],0,1));}
		else
		{
			return strtoupper(substr($this->companyname,0,2));
		}
	}
}