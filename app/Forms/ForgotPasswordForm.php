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

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class ForgotPasswordForm extends Form
{
    public function initialize()
    {
        $email = new Text('email', [
            'placeholder' => 'Email',
        	'class' => 'form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6 ',
        	'autocomplete' => 'off'
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

        $this->add(new Submit('Send', [
            'class' => 'btn btn-primary mr-2',
        ]));
    }
}
