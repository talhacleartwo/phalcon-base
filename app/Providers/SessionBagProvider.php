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
use Phalcon\Session\Bag;

class SessionBagProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'sessionBag';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set($this->providerName, function () {
            return new Bag('conditions');
        });
    }
}
