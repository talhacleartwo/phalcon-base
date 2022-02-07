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

use Phalcon\Mvc\Router;

/**
 * @var $router Router
 */
$router->add('/twofaconfirm',[
	'controller' => 'index',
	'action'     => 'twofaconfirm',
]);


/**
 * Session and emails routes
 */


$router->add('/confirm/{code}/{email}', [
    'controller' => 'UserControl',
    'action'     => 'confirmEmail',
]);

$router->add('/reset-password/{code}/{email}', [
    'controller' => 'user_control',
    'action'     => 'resetPassword',
]);

$router->add('/forgotPassword',[
	'controller' => 'session',
	'action'     => 'forgotPassword',
]);


$router->add('/reset-user-password/{code}/{email}', [
    'controller' => 'index',
    'action'     => 'resetPassword',
]);
