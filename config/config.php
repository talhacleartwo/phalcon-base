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

use Phalcon\Logger;


return [
    'database'    => [
        'adapter'  => getenv('DB_ADAPTER'),
        'host'     => getenv('DB_HOST'),
        'port'     => getenv('DB_PORT'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname'   => getenv('DB_NAME'),
    ],
    'application' => [
		'systemName' 	  => getenv('APP_NAME'),
        'baseUri'         => getenv('APP_BASE_URI'),
        'publicUrl'       => getenv('APP_PUBLIC_URL'),
        'cryptSalt'       => getenv('APP_CRYPT_SALT'),
        'configDir'       => BASE_PATH. '/config/',
        'viewsDir'        => BASE_PATH. '/app/Views/',
        'cacheDir'        => BASE_PATH . '/var/cache/',
        'sessionSavePath' => BASE_PATH . '/var/cache/session/',
        'logErrors'		  => boolval(getenv('APP_DEBUG_LOG')),
        'showErrors' 	  => boolval(getenv('APP_SHOW_ERRORS')),
    ],
    'company' => [
        'CompanyName'    => 'Cleartwo',
        'Title'          => 'C2 | Phalcon Base System',
        'Address'        => 'Aruba House',
        'Address2'       => '211 Shaw Heath',
        'Town'           => 'Stockport',
        'Postcode'       => 'SK2 6QZ',
        'Telephone'      => '0161 285 0652',
        'Mobile'         => '',
        'VAT'            => '',
        'Email'          => 'info@cleartwo.co.uk',
    ],
    'mail' => [
        'fromName'  => getenv('MAIL_FROM_NAME'),
        'fromEmail' => getenv('MAIL_FROM_EMAIL'),
        'smtp'      => 
		[
            'server'   => getenv('MAIL_SMTP_SERVER'),
            'port'     => getenv('MAIL_SMTP_PORT'),
            'security' => getenv('MAIL_SMTP_SECURITY'),
            'username' => getenv('MAIL_SMTP_USERNAME'),
            'password' => getenv('MAIL_SMTP_PASSWORD'),
        ],
    ],
    'logger' => [
        'path'     => BASE_PATH .'/var/logs/',
        'format'   => '%date% [%type%] %message%',
        'date'     => 'D j H:i:s',
        'logLevel' => Logger::DEBUG,
        'filename' => 'application.log',
    ],
    'useMail'     => true, // Set to false to disable sending emails (for use in test environment)
];
