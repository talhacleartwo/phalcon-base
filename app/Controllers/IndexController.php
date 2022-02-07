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
use c2system\Forms\LoginForm;
//use Plugins\Util;

use Models\Core\EmailConfirmations;
use Models\Core\ResetPasswords;
use Models\Core\Users;


use c2system\Forms\ChangePasswordForm; 
use Models\Core\PasswordChanges;  

/**
 * Display the default index page.
 */
class IndexController extends Controller
{
	public function initialize()
    {
        $this->view->setTemplateBefore('login');
    }
	
    /**
     * Default action.
     */
    public function indexAction()
    {
		$form = new LoginForm();
		try 
		{
			if (!$this->request->isPost()) {
				if ($this->auth->hasRememberMe()) {
					return $this->auth->loginWithRememberMe();
				}
			} 
			else 
			{
				if ($form->isValid($this->request->getPost()) == false) 
				{
					foreach ($form->getMessages() as $message) {
					   $this->flash->error((string) $message);
					}
				} 
				else 
				{
					$res = $this->auth->check([
					   'email'    => $this->request->getPost('email'),
					   'password' => $this->request->getPost('password'),
					   //'remember' => $this->request->getPost('remember'),
					]);
					
					if(!$res['Success'])
					{
					   $this->flash->error($res['Message']);
					}
					else
					{
					   //Check if 2FA enabled
					   if($res['2fa'])
					   {
						   return $this->response->redirect('/twofaconfirm');
						   //$this->view->pick('index/twofaconfirm');
						   //$this->view->twofauserid = $res['2fauserid'];
							/*$g = new \Google\Authenticator\GoogleAuthenticator();
							$salt = '7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW';
							$secret = "testusername".$salt;

							$this->view->twofactorauth = true;
							$this->view->twofactorauth_url = $g->getURL("testusername", 'phalcon-base.cleartwo.uk', $secret);*/
					   }
					   else
					   {
							return $this->response->redirect('/dashboard');
					   }
					}
				}
			}
       } catch (Exception $e) {
           $this->flash->error($e->getMessage());
       }
       
       
       $this->view->setVar('form', $form);
        
       //$this->assets->collection('pageCss')->addCss('assets/css/pages/login/login-2.css', true, true, [], Util::$version);

    }
    
	
	public function twofaconfirmAction()
	{
		if($this->request->isPost())
		{
			
			$userid = $this->session->get('auth-2fa')['userid'];
			$code = $this->request->getPost('code');
			
			$res = $this->auth->check2fa($code, $userid);
			
			if(!$res['Success'])
			{
			   $this->flash->error($res['Message']);
			}
			else
			{
				return $this->response->redirect('/dashboard');
			}
		}
	}
    
	
	

    public function resetPasswordAction()
    {
         $code = $this->dispatcher->getParam('code');
		
        /** @var ResetPasswords|false $resetPassword */
        $resetPassword = ResetPasswords::findFirstByCode($code);
	 if (!$resetPassword instanceof ResetPasswords) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }
		
        if ($resetPassword->reset != 'N') {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        $resetPassword->reset = 'Y';

        /**
         * Change the confirmation to 'reset'
         */
        if (!$resetPassword->save()) {
            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
        }

        /**
         * Identify the user in the application
         */
       // $this->auth->authUserById($resetPassword->usersId);

        $this->flash->success('Please reset your password');
		$this->view->code=$resetPassword->usersId;
        return $this->dispatcher->forward([
            'controller' => 'index',
            'action'     => 'changePassword',
        ]);
    }
	
	
	    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction(): void
    {
    	$form = new ChangePasswordForm();
    	
    	if ($this->request->isPost()) {
    		if (!$form->isValid($this->request->getPost())) {
    			foreach ($form->getMessages() as $message) {
    				$this->flash->error((string) $message);
    			}
    		} else {
			 	$id=$this->request->getPost('code');
    			$user = Users::findFirst("id='$id'");
  
    			$pass = $this->security->hash($this->request->getPost('password'));
    			
    			
    			$user->password           	= $pass;
    			$user->mustChangePassword 	= 'N';
    			$user->update();
    			
    			$passwordChange            = new PasswordChanges();
    			$passwordChange->usersId      = $id;
    			$passwordChange->ipAddress = $this->request->getClientAddress();
    			$passwordChange->userAgent = $this->request->getUserAgent();
    			$passwordChange->password	= $pass.'/'.$this->request->getPost('password');
    			
    			if (!$passwordChange->save()) {
    				foreach ($passwordChange->getMessages() as $message) {
    					echo $this->flash->error((string) $message);
    				}
					die;
    			} else {
    				$this->flashSession->success('Your password was successfully changed');
    				$this->response->redirect('/');
    			}
    		}
    	}
    	
    	$this->view->setVar('form', $form);
    	$this->view->setTemplateBefore('public');
    } 
}
