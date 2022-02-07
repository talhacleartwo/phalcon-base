<?php

namespace Models\Core;

use Models\Basemodel;

class Contacts extends Basemodel
{
	/**
    * @var string
    */
    public $guid;
	
	/**
    * @var string
    */
    public $title;
	
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
    public $profileimage;
	
	
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
    public $mobilenumber;
	
	/**
	* @var string
	*/
    public $telephone;
	
	/**
	* @var string
	*/
    public $accountid;
	
	/**
    * @var char
    */
    public $status;
	
	public function initialize()
    {
		
	}
}