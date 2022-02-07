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

namespace Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Plugins\Acl\Acl;
use Plugins\Auth\Auth;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 *
 * @property Auth auth
 * @property Acl  acl
 */
class ControllerBase extends Controller
{
	public function initialize()
    {
       $this->view->setTemplateAfter('default');
		
    }
	
    /**
     * Execute before the router so we can determine if this is a private
     * controller, and must be authenticated, or a public controller that is
     * open to all.
     *
     * @param Dispatcher $dispatcher
     *
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher): bool
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName     = $dispatcher->getActionName();
        
		if($this->acl->isPrivate($controllerName))
        {
            // Get the current identity
            $identity = $this->auth->getIdentity();
			
            // If there is no identity available the user is redirected to index/index
            if (is_array($identity))
            {
                if (isset($identity['LAST_ACTIVITY']) && (time() - $identity['LAST_ACTIVITY'] > 7200)) {
                    // last request was more than 2hrs minutes ago
                    
                    $this->auth->remove();
                    
                    //session_unset(); // unset $_SESSION variable for the run-time
                    session_destroy(); // destroy session data in storage }
                }
                else
                {
                    $currSession = $this->auth->getIdentity();
                    $currSession['LAST_ACTIVITY'] = time(); // update last activity time stamp
                    
                    $this->session->set('auth-identity', $currSession);
                    
                }
				
				
				//Check if the user has permission to access this route
				if(!$this->acl->isAllowed($identity['roles'], $controllerName, $actionName))
				{
					$this->flash->notice('You don\'t have permission to perform this action');
					$dispatcher->forward([
						'controller' => 'dashboard',
						'action'     => 'index',
					]);
					return false;
				}
				
				
				
                
                // Check if the user have permission to the current option
                /*if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {
                    $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);
                    
                    if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
                       $dispatcher->forward([
                            'controller' => $controllerName,
                            'action'     => 'index',
                        ]);
                    } else {
                      $dispatcher->forward([
                            'controller' => 'dashboard',
                            'action'     => 'index',
                        ]);
                    }
                    
                    return false;
                }
                
                $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
                if ($is_ajax) {
                    $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
                    
                    $eventsManager = new Manager();
                    
                    $eventsManager->attach('view:afterRender', function ($event, $view) {
                        $view->setContent(json_encode(array(
                            'content' => $view->getContent(),
                            //'title' => \Phalcon\Tag::getTitle(false) 
                        )));
                    });
                        
                        $this->view->setEventsManager($eventsManager);
                        $this->response->setHeader('Content-Type', 'application/json');
                        $this->response->setHeader('Access-Control-Allow-Origin', ' *');
                        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, PUT, POST');
                        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Content-Range, Content-Disposition, Content-Description');
                }*/
            }
            else
            {
                $this->flash->notice('You need to log in to perform this action');
                   $dispatcher->forward([
                    'controller' => 'index',
                    'action'     => 'index',
                ]);
                return false;
            }
        }

        return true;
    }
    
    

}
