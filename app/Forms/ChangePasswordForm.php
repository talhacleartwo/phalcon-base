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

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Forms\Element\Submit;

class ChangePasswordForm extends Form
{
    public function initialize()
    {
        // Password
    	$password = new Password('password', [
    		'autocomplete' => 'off',
    		'class' 		=> "form-control"
    	]);
        $password->addValidators([
            new PresenceOf([
                'message' => 'Password is required',
            ]),
            new StringLength([
                'min'            => 6,
                'messageMinimum' => 'Password is too short. Minimum 8 characters',
            ]),
            new Confirmation([
                'message' => 'Password doesn\'t match confirmation',
                'with'    => 'confirmPassword',
            ]),
        ]);

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword', [
        	'autocomplete' => 'off',
        	'class' 		=> "form-control"
        ]);
        $confirmPassword->addValidators([
            new PresenceOf([
                'message' => 'The confirmation password is required',
            ]),
        ]);

        $this->add($confirmPassword);
        
        $this->add(new Submit('Submit', [
        	'class' => 'btn btn-primary mr-2',
        ]));
    }
}
