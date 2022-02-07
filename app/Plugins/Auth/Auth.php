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

namespace Plugins\Auth;

use Phalcon\Di\Injectable;
use Phalcon\Http\Response;
use Models\Core\FailedLogins;
use Models\Core\RememberTokens;
use Models\Core\SuccessLogins;
use Models\Core\Users;
use Phalcon\Security\Random;
//use \AuthException;
//use Models\Accounts\Customer;

/**
 * C2 System\Auth\Auth
 * Manages Authentication/Identity Management in Vokuro
 */
class Auth extends Injectable
{
    /**
     * Checks the user credentials
     *
     * @param array $credentials
     *
     * @throws Exception
     */
    public function check($credentials)
    {
        $email = $credentials['email'];
		
        // Check if the user exist
        //$user = Users::findFirstByEmail($credentials['email']);
        $user = Users::findFirst([
            'conditions' => "email = :email:",
            'bind' => array(
                'email' => $email
            )
            
        ]);
		
		if(!$user instanceof Users)
        {
			$random = new Random();
            //$this->registerUserThrottling(0);
            $this->security->hash($random->bytes(12));
            //$this->flash->error('NO Active User Found. Please check your Credentials');
			
			return ['Success' => false, 'Message' => "Invalid Login Credentials1"];
		}
		

		// Check the password
		$check = $this->security->checkHash($credentials['password'], $user->password);
		
		if($check === false)
		{
			$random = new Random();
			//$this->registerUserThrottling($user->id);
			$this->security->hash($random->bytes(12));
			//$this->flash->error('Wrong email/password combination');
			return ['Success' => false, 'Message' => "Invalid Login Credentials2"];
		}
		

			
		// Check if the user was flagged
		if(!$this->checkUserFlags($user))
		{
			$random = new Random();
			//$this->registerUserThrottling($user->id);
			$this->security->hash($random->bytes(12));
			return ['Success' => false, 'Message' => "Invalid Login Credentials3"];
		}
		
		// Register the successful login
		//$this->saveSuccessLogin($user);
		
		// Check if the remember me was selected
		if (isset($credentials['remember'])) {
			$this->createRememberEnvironment($user);
		}
		
		
		$twofa = $user->getPreference('enable2fa') == 1 ? true : false;
		
		if(!$twofa)
		{
			$this->session->set('auth-identity', [
				'id' 		=> $user->id,
				'firstname' => $user->firstname,
				'lastname' 	=> $user->lastname,
				'roles' 	=> $user->getRolesArray(),
				'email'     => $user->email,
				'LAST_ACTIVITY' => time(),
			]);
			
			return ['Success' => true, '2fa' => $twofa];
		}
		else
		{
			$this->session->set('auth-2fa', [
				'userid' => $user->id
			]);
			return ['Success' => true, '2fa' => $twofa];
		}
		/*if($user->profilesId!=5) {
			return $this->response->redirect('leads/filter/todayleads');
		}else{
			return $this->response->redirect('job/1');
		}*/
    }
	
	
	
	public function check2fa($code, $userid)
	{
		$user = Users::findFirstById($userid);
		
		if(!$user instanceof Users)
        {	
			return ['Success' => false, 'Message' => "User Not Found"];
		}
		
		$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
		if ($g->checkCode($user->twofasecret, $code)) 
		{
			$this->session->remove('auth-2fa');
			$this->session->set('auth-identity', [
				'id' 		=> $user->id,
				'firstname' => $user->firstname,
				'lastname' 	=> $user->lastname,
				'roles' 	=> $user->getRolesArray(),
				'email'     => $user->email,
				'LAST_ACTIVITY' => time(),
			]);
			return ['Success' => true];
		} 
		else 
		{
			return ['Success' => false, 'Message' => "Invalid Code"];
		}
	}

    /**
     * Creates the remember me environment settings the related cookies and
     * generating tokens
     *
     * @param Users $user
     *
     * @throws Exception
     */
    public function saveSuccessLogin($user)
    {
        $successLogin            = new SuccessLogins();
        $successLogin->usersId   = $user->id;
        $successLogin->ipAddress = $this->request->getClientAddress();
        $successLogin->userAgent = $this->request->getUserAgent();
        $successLogin->attempted = date('Y-m-d');
        if (!$successLogin->save()) {
            $messages = $successLogin->getMessages();
            $this->flash->error($messages[0]);
            //throw new Exception($messages[0]);
        }
    }

    /**
     * Implements login throttling
     * Reduces the effectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId)
    {
        $failedLogin            = new FailedLogins();
        $failedLogin->usersId   = $userId;
        $failedLogin->ipAddress = $this->request->getClientAddress();
        $failedLogin->attempted = date('Y-m-d');
        $failedLogin->save();

        $attempts = FailedLogins::count([
            'ipAddress = ?0 AND attempted >= ?1',
            'bind' => [
                $this->request->getClientAddress(),
                time() - 3600 * 6,
            ],
        ]);

        switch ($attempts) {
            case 1:
            case 2:
                // no delay
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }

    /**
     * Creates the remember me environment settings the related cookies and
     * generating tokens
     *
     * @param Users $user
     */
    public function createRememberEnvironment(Users $user)
    {
        $userAgent = $this->request->getUserAgent();
        $token     = md5($user->email . $user->password . $userAgent);

        $remember            = new RememberTokens();
        $remember->usersId   = $user->id;
        $remember->token     = $token;
        $remember->userAgent = $userAgent;

        if ($remember->save() != false) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->id, $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the cookies
     *
     * @return Response
     * @throws Exception
     */
    public function loginWithRememberMe()
    {
        $userId      = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();

        $user = Users::findFirstById($userId);
        if ($user) {
            $userAgent = $this->request->getUserAgent();
            $token     = md5($user->email . $user->password . $userAgent);

            if ($cookieToken == $token) {
                $remember = RememberTokens::findFirst([
                    'usersId = ?0 AND token = ?1',
                    'bind' => [
                        $user->id,
                        $token,
                    ],
                ]);
                if ($remember) {
                    // Check if the cookie has not expired
                    if (((time() - $remember->createdAt) / (86400 * 8)) < 8) {
                        // Check if the user was flagged
                        $this->checkUserFlags($user);

                        // Register identity
                        $this->session->set('auth-identity', [
                            'id' 		=> $user->id,
                            'name' 		=> $user->name,
                            'profile' 	=> $user->profile->name,
                            'email'     => $user->email,
                            'LAST_ACTIVITY' => time(),
                        ]);

                        // Register the successful login
                        $this->saveSuccessLogin($user);

                        return $this->response->redirect('dashboard');
                    }
                }
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();

        return $this->response->redirect('index');
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param Users $user
     *
     * @throws Exception
     */
    public function checkUserFlags(Users $user)
    {
        if ($user->status != 'Y') {
			return false;
            //throw new Exception('The user is inactive');
            //$this->flash->error('The user is inactive');
        }

        /*if ($user->banned != 'N') {
            //throw new Exception('The user is banned');
            $this->flash->error('The user is banned');
        }

        if ($user->suspended != 'N') {
            //throw new Exception('The user is suspended');
            $this->flash->error('The user is suspended');
        }*/
		
		return true;
    }

    /**
     * Returns the current identity
     *
     * @return array|null
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['firstname'] . ' ' . $identity['lastname'];
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $token = $this->cookies->get('RMT')->getValue();

            $userId = $this->findFirstByToken($token);
            if ($userId) {
                $this->deleteToken($userId);
            }

            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove('auth-identity');
    }

    /**
     * Auths the user by his/her id
     *
     * @param int $id
     *
     * @throws Exception
     */
    public function authUserById($id)
    {
        $user = Users::findFirstById($id);
        if ($user == false) {
            //throw new Exception('The user does not exist');
            $this->flash->error('The user does not exist');
        }

        $this->checkUserFlags($user);

        $this->session->set('auth-identity', [
            'id' 		=> $user->id,
            'name' 		=> $user->name,
            'profile' 	=> $user->profile->name,
            'email'     => $user->email,
            'LAST_ACTIVITY' => time(),
        ]);
    }

    /**
     * Get the entity related to user in the active identity
     *
     * @return Users
     * @throws Exception
     */
    public function getUser()
    {
        $identity = $this->session->get('auth-identity');

        if (!isset($identity['id'])) {
            //throw new Exception('Session was broken. Try to re-login');
            $this->flashSession->error('Session was broken. Try to re-login');
            return $this->response->redirect('/');
        }

        $user = Users::findFirstById($identity['id']);
        if ($user == false) {
            //throw new Exception('The user does not exist');
            $this->flashSession->error('The user does not exist');
            return $this->response->redirect('/');
        }

        return $user;
    }

    /**
     * Returns the current token user
     *
     * @param string $token
     *
     * @return int|null
     */
    public function findFirstByToken($token)
    {
        $userToken = RememberTokens::findFirst([
            'conditions' => 'token = :token:',
            'bind'       => [
                'token' => $token,
            ],
        ]);

        return $userToken ? $userToken->usersId : null;
    }

    /**
     * Delete the current user token in session
     *
     * @param int $userId
     */
    public function deleteToken(int $userId): void
    {
        $user = RememberTokens::find([
            'conditions' => 'usersId = :userId:',
            'bind'       => [
                'userId' => $userId,
            ],
        ]);

        if ($user) {
            $user->delete();
        }
    }
}


class AuthException extends \Exception
{
}
