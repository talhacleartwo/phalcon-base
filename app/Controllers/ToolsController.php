<?php
namespace Controllers;

use Phalcon\Mvc\Controller;
use Plugins\Util;

class ToolsController extends ControllerBase
{
	public function initialize()
    {
    	parent::initialize();
		$this->view->pagetitle = "Tools";
    }
	
	public function typographyAction()
	{
		$this->view->pagedetails = "Typography";
	}
	
	public function healthAction()
	{
		$this->view->pagedetails = "System Health";
		$this->view->config = $this->config;
	}
}