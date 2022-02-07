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

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $email = new Text('email', [
            'placeholder'   => 'Email Address',
            'class'         => 'form-control form-control-solid h-auto py-7 px-6 rounded-lg',
            'autocomplete'  => 'off'
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The Username or e-mail is required',
            ]),
        ]);

        $this->add($email);

        // Password
        $password = new Password('password', [
            'placeholder'   => 'Password',
            'class'         => 'form-control form-control-solid h-auto py-7 px-6 rounded-lg',
            'autocomplete'  => 'off'
        ]);
        $password->addValidator(new PresenceOf([
            'message' => 'The password is required',
        ]));
        $password->clear();

        $this->add($password);

        // Remember
        $remember = new Check('remember', [
            'value' => 'yes',
            'id'    => 'login-remember',
        ]);
        $remember->setLabel('Remember me');

        $this->add($remember);

        // CSRF
        /* $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical([
            'value'   => $this->security->getRequestToken(),
            'message' => 'CSRF validation failed',
        ]));
        $csrf->clear();

        $this->add($csrf); */
        $this->add(new Submit('Login', [
            'class' => 'loginbtn',
            'style'=>'border-radius:2px'
        ]));
    }
}
