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
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Submit;

class PermissionsForm extends Form
{
    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        if (!empty($options['edit'])) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);

        $name = new Text('name', [
            'placeholder' => 'Name',
        	'class' 		=> "form-control"
        ]);
        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required',
            ]),
        ]);
        $this->add($name);
		
		
		$controller = new Text('controller', [
            'placeholder' => 'Controller',
        	'class' 		=> "form-control"
        ]);
        $controller->addValidators([
            new PresenceOf([
                'message' => 'The controller is required',
            ]),
        ]);
        $this->add($controller);
		
		
		$action = new Text('action', [
            'placeholder' => 'Action',
        	'class' 		=> "form-control"
        ]);
        $action->addValidators([
            new PresenceOf([
                'message' => 'The action is required',
            ]),
        ]);
        $this->add($action);


        $this->add(new Submit('Submit', [
        	'class' => 'btn btn-primary mr-2',
        ]));
    }
}
