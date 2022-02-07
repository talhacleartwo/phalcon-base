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

namespace Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Dispatcher;
//use Phalcon\Dispatcher;
use Phalcon\Dispatcher\Exception;
use Phalcon\Events\Manager;
use Phalcon\Events\Event;

class DispatcherProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'dispatcher';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set($this->providerName, function () {
            $dispatcher = new Dispatcher();
            $eventsManager = new Manager();
            $eventsManager->attach("dispatch:beforeException", function ( Event $event, Dispatcher $dispatcher, $ex)
            {
                switch ($ex->getCode()) 
				{
					case 1 ://Dispatcher::EXCEPTION_CYCLIC_ROUTING 
					case 2 ://Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
					case 5 ://Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
					case 3 ://Dispatcher::EXCEPTION_INVALID_HANDLER:
						// Handle 404 exceptions
						$dispatcher->forward(array(                        
							'controller' => 'errors',
							'action' => 'show404',
							'params' => ['trace' => $ex->getTraceAsString(), 'msg' => $ex->getMessage()]
						));
						return false;
					break;
					default:
						// Handle other exceptions
						$dispatcher->forward(array(                   
							'controller' => 'errors',
							'action' => 'show500',
							'params' => ['trace' => $ex->getTraceAsString(), 'msg' => $ex->getMessage()]
						));
						return false;
					break;
				}
            });
			
            
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Controllers');

            return $dispatcher;
        });
    }
}
