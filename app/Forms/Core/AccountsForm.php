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

namespace c2system\Forms\Core;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Submit;

class AccountsForm extends Form
{
    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
		
        $companyname = new Text('companyname', [
        	'class' 		=> "form-control"
        ]);
        $companyname->addValidators([
            new PresenceOf([
                'message' => 'Company name is required',
            ]),
        ]);
        $this->add($companyname);
		
		
		$accountnumber = new Text('accountnumber', [
        	'class' 		=> "form-control"
        ]);
        $this->add($accountnumber);
		
		
		$website = new Text('website', [
        	'class' 		=> "form-control"
        ]);
        $this->add($website);
		
		
		$email = new Text('email', [
        	'class' 		=> "form-control"
        ]);
        $email->addValidators([
            new PresenceOf([
                'message' => 'Email is required',
            ]),
        ]);
        $this->add($email);
		
		
		$telephone = new Text('telephone', [
        	'class' 		=> "form-control"
        ]);
        $this->add($telephone);
		
		
		$telephone2 = new Text('telephone2', [
        	'class' 		=> "form-control"
        ]);
        $this->add($telephone2);
		
		
		$addressline1 = new Text('addressline1', [
        	'class' 		=> "form-control"
        ]);
        $this->add($addressline1);
		
		
		$addressline2 = new Text('addressline2', [
        	'class' 		=> "form-control"
        ]);
        $this->add($addressline2);
		
		
		$city = new Text('city', [
        	'class' 		=> "form-control"
        ]);
        $this->add($city);
		
		
		$county = new Text('county', [
        	'class' 		=> "form-control"
        ]);
        $this->add($county);
		
		
		$postcode = new Text('postcode', [
        	'class' 		=> "form-control"
        ]);
        $this->add($postcode);
		
		
		$notes = new TextArea('notes', [
        	'class' 		=> "form-control"
        ]);
        $this->add($notes);

        /*$this->add(new Select('active', [
            'Y' => 'Yes',
            'N' => 'No',
        ], [
        	'useEmpty'   	=> true,
        	'class' 		=> "form-control select2",
        	'id'			=> 'kt_selectActive',
        	'emptyText'  	=> 'Select Active status',
        	'emptyValue' 	=> '',
        ]));*/
        
        
        $this->add(new Submit('Submit', [
        	'class' => 'btn btn-primary mr-2',
        ]));
    }
}
