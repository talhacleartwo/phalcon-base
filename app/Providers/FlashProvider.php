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

use Phalcon\Escaper;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Flash\Direct as Flash;
//use Phalcon\Flash\Session as Flash;

class FlashProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'flash';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set($this->providerName, function () {
            $escaper = new Escaper();
            $flash = new Flash($escaper);
            $flash->setImplicitFlush(false);
            $flash->setCssClasses([
                'error' => 'alert alert-custom alert-outline-danger fade show mb-5',
                'success' => 'alert alert-custom alert-outline-success fade show mb-5',
                'notice' => 'alert alert-custom alert-outline-info fade show mb-5',
                'warning' => 'alert alert-custom alert-outline-warning fade show mb-5'
            ]);

            return $flash;
        });
    }
}
