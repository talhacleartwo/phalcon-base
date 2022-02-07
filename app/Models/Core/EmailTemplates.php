<?php

namespace Models\Core;

use Models\Basemodel;
class EmailTemplates extends Basemodel
{
    /**
     * @var string
     */
    public $id;
    public $templatename;
    public $content;
    public $subject;

    public function initialize()
    {
        $this->setSource('core_emailtemplates');
    }
}