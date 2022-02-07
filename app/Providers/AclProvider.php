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
use c2system\Application;
use Plugins\Acl\Acl;

class AclProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'acl';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var Application $application */
        $application = $di->getShared(Application::APPLICATION_PROVIDER);
		
        /** @var string $rootPath */
        $rootPath = $application->getRootPath();

        $di->setShared($this->providerName, function () use ($rootPath) 
		{
            $filename         = $rootPath . '/config/acl.php';
            $publicResources = [];
            if (is_readable($filename)) 
			{
                $publicResources = include $filename;
                /*if (!empty($privateResources['private'])) {
                    $privateResources = $privateResources['private'];
                }*/
            }

            $acl = new Acl();
            $acl->addPublicResources($publicResources);

            return $acl;
        });
    }
}
