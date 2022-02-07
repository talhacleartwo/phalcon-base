<?php
namespace Controllers;

use Phalcon\Mvc\Controller;
use Plugins\Util;

class ErrorsController extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('errortemplate');
        //$this->assets->collection('pageCss')->addCss('assets/css/pages/error/error-6.css', true, true, []);
    }
	
	public function indexAction()
	{

	}
	
    public function show404Action($trace = null, $msg = null)
    {
		$showErrors = $this->config->application->showErrors;
		$this->view->trace = ($showErrors === true ? $trace : null);
		$this->view->msg = ($showErrors === true ? $msg : null);
    }
    
    public function show500Action($trace = null, $msg = null)
    {
		$showErrors = $this->config->application->showErrors;
		$this->view->trace = ($showErrors === true ? $trace : null);
		$this->view->msg = ($showErrors === true ? $msg : null);
    }
	
	public function show401Action()
    {
    }
}

