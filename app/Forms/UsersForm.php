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

namespace c2system\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

use Phalcon\Forms\Element\Submit;
use Models\Core\Profiles;
use Models\Core\Roles;

class UsersForm extends Form
{
    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        // In edition the id is hidden
        if (!empty($options['edit'])) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);

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
		
		//Profile
		
		
		$myRoles = [];
		if($entity)
		{
			foreach($entity->AssignedRoles as $ar)
			{
				$myRoles[] = $ar->roleid;
			}
		}
        //$roles = Roles::find();
		$Role = new Hidden('roles', ['value' => json_encode($myRoles)]);
		$this->add($Role);



		if($entity === null)
		{
			$password = new Text('password', [
				'class' => "form-control",
				'autocomplete' => 'new-password'
			]);
			$password->addValidators([
				new PresenceOf([
					'message' => 'A Password is required',
				]),
			]);
			$this->add($password);
		}

        /*$this->add(new Select('profilesId', $profiles, [
            'using'      => [
                'id',
                'name',
            ],
            'useEmpty'   	=> true,
        	'class' 		=> "form-control select2",
        	'id'			=> 'kt_selectUserProfile',
            'emptyText'  	=> 'Select Role',
            'emptyValue' 	=> '',
        ]));*/

       
		//Active
        /*$this->add(new Select('status', [
            'Y' => 'Active',
            'N' => 'Inactive',
        ], [
        	'useEmpty'   	=> true,
        	'class' 		=> "form-control select2",
        	'id'			=> 'kt_selectActive',
        	'emptyText'  	=> 'Select Active status',
        	'emptyValue' 	=> '',
        ]));*/
        
		
		//Submit
        $this->add(new Submit('Submit', [
        	'class' => 'btn btn-primary mr-2',
        ]));
    }
}
