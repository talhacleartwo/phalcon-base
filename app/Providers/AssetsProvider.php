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
use Phalcon\Assets\Manager;

class AssetsProvider implements ServiceProviderInterface
{
    protected const VERSION = "7.0.6";
    /**
     * @var string
     */
    protected $providerName = 'assets';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $assetManager = new Manager();

        $di->setShared($this->providerName, function () use ($assetManager) {

            //Global Stylesheets
            $assetManager->collection('Globalcss')
                /*->addCss('assets/plugins/global/plugins.bundle.css', true, true,["media" => "screen,projection" ], self::VERSION)*/
                /*->addCss('assets/plugins/custom/prismjs/prismjs.bundle.css', true, true, [ "media" => "screen,projection" ], self::VERSION)*/
                /*->addCss('assets/css/style.bundle.css', true, true, [ "media" => "screen,projection" ], self::VERSION)*/
                ->addCss('assets/css/core/normalize.css', true, true, ["media"  => "screen,projection" ], self::VERSION)
                ->addCss('assets/css/core/skeleton.css', true, true, ["media"  => "screen,projection" ], self::VERSION)
                ->addCss('assets/css/core/base.css', true, true, ["media"  => "screen,projection" ], self::VERSION)
                ->addCss('assets/css/custom.css', true, true, ["media"  => "screen,projection" ], self::VERSION);
            
            // Page Injected Css
            $assetManager->collection('pageCss');
                
            // Global Javascripts
            $assetManager->collection('Globaljs')
				->addJs('https://code.jquery.com/jquery-3.6.0.min.js',false,true)
				->addJs('/assets/js/core/util.js',true,true)
				->addJs('/assets/js/core/contextual.js',true,true)
				->addJs('/assets/js/core/base.js',true,true);
                /*->addJs('assets/plugins/global/plugins.bundle.js', true, true, [], self::VERSION)*/
                /*->addJs('assets/plugins/custom/prismjs/prismjs.bundle.js', true,true, [] , self::VERSION)*/
                /*->addJs('assets/js/scripts.bundle.js', true,true, [] , self::VERSION);*/
            
            // page injected Javascripts
                $assetManager->collection('pageJs');
            return $assetManager;
        });
    }
}
