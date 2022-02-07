<?php

namespace c2system\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

use Phalcon\Forms\Element\Submit;


class ContactsForm extends Form
{
	public function initialize($entity = null, array $options = [])
    {
		// In edition the id is hidden
        if (!$entity === null) {$guid = new Hidden('guid');$this->add($guid);}
		
		//Title
        $title = new Text('title', [
            'placeholder' 	=> 'Title',
        	'class' 		=> "form-control"
        ]);
        $title->addValidators([
            new PresenceOf([
                'message' => 'Title is required',
            ]),
        ]);
        $this->add($title);
		
		
		//First Name
        $firstname = new Text('firstname', [
            'placeholder' 	=> 'First Name',
        	'class' 		=> "form-control"
        ]);
        $firstname->addValidators([
            new PresenceOf([
                'message' => 'First name is required',
            ]),
        ]);
        $this->add($firstname);
		
		
		//Last Name
		$lastname = new Text('lastname', [
            'placeholder' 	=> 'Last Name',
        	'class' 		=> "form-control"
        ]);
        $lastname->addValidators([
            new PresenceOf([
                'message' => 'Last name is required',
            ]),
        ]);
        $this->add($lastname);
		
		
		//Email
        $email = new Text('email', [
            'placeholder' 	=> 'Email',
        	'class' 		=> "form-control"
        ]);
        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required',
            ]),
            new Email([
                'message' => 'The e-mail is not valid',
            ]),
        ]);
        $this->add($email);
		
		
		//Address Line 1
		$addressline1 = new Text('addressline1', [
            'placeholder' 	=> 'Address Line 1',
        	'class' 		=> "form-control"
        ]);
        $this->add($addressline1);
		
		//Address Line 2
		$addressline2 = new Text('addressline2', [
            'placeholder' 	=> 'Address Line 2',
        	'class' 		=> "form-control"
        ]);
        $this->add($addressline2);
		
		//City
		$city = new Text('city', [
            'placeholder' 	=> 'City',
        	'class' 		=> "form-control"
        ]);
        $this->add($city);
		
		//County
		$county = new Text('county', [
            'placeholder' 	=> 'County',
        	'class' 		=> "form-control"
        ]);
        $this->add($county);
		
		//Postcode
		$postcode = new Text('postcode', [
            'placeholder' 	=> 'Postcode',
        	'class' 		=> "form-control"
        ]);
        $this->add($postcode);
		
		//Mobile Phone
		$mobilephone = new Text('mobilephone', [
            'placeholder' 	=> 'Mobile Number',
        	'class' 		=> "form-control"
        ]);
        $this->add($mobilephone);
		
		//Telephone
		$telephone = new Text('telephone', [
            'placeholder' 	=> 'Mobile Number',
        	'class' 		=> "form-control"
        ]);
        $this->add($telephone);
		
		
		//Profile Image
		$profileimage = new Text('profileimage', [
            'placeholder' 	=> 'Profile Image',
        	'class' 		=> "form-control"
        ]);
        $this->add($profileimage);
		
		//Profile Image
		$accountid = new Text('accountid', [
            'placeholder' 	=> 'Account',
        	'class' 		=> "form-control"
        ]);
        $this->add($accountid);
		
		//Submit
        $this->add(new Submit('Submit', [
        	'class' => 'btn btn-primary',
        ]));
	}
}