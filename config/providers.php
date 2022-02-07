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

use Providers\AclProvider;
use Providers\AuthProvider;
use Providers\ConfigProvider;
use Providers\CryptProvider;
use Providers\DbProvider;
use Providers\DispatcherProvider;
use Providers\FlashProvider;
use Providers\LoggerProvider;
use Providers\MailProvider;
use Providers\ModelsMetadataProvider;
use Providers\RouterProvider;
use Providers\SecurityProvider;
use Providers\SessionBagProvider;
use Providers\SessionProvider;
use Providers\UrlProvider;
use Providers\ViewProvider;
use Providers\AssetsProvider;
//use Providers\UtilProvider;
//use Providers\PdfProvider;

return [
    AclProvider::class,
    AuthProvider::class,
    ConfigProvider::class,
    CryptProvider::class,
    DbProvider::class,
    DispatcherProvider::class,
    FlashProvider::class,
    LoggerProvider::class,
    MailProvider::class,
    ModelsMetadataProvider::class,
    RouterProvider::class,
    SessionBagProvider::class,
    SessionProvider::class,
    SecurityProvider::class,
    UrlProvider::class,
    ViewProvider::class,
    AssetsProvider::class,
];

//UtilProvider::class,
//PdfProvider::class,