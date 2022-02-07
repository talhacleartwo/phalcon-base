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

use Exception;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Router;
use c2system\Application;


class RouterProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'router';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Application $application */
        $application = $di->getShared(Application::APPLICATION_PROVIDER);
        /** @var string $basePath */
        $basePath = $application->getRootPath();

        $di->set($this->providerName, function () use ($basePath) {
            $router = new Router();
            //$router->removeExtraSlashes(true);

            $routes = $basePath . '/config/routes.php';
            if (!file_exists($routes) || !is_readable($routes)) {
                throw new Exception($routes . ' file does not exist or is not readable.');
            }

            require_once $routes;

            return $router;
        });
        
            
    }
}
