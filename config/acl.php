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

return [
	'index' => ['index', 'twofaconfirm', 'forgotpassword'],
	'session' => ['logout']
];
 
/*return [
    'private' => [
        'dashboard' => [
            'index',        	'test',
        ],
        'users' => [
            'index',
            'edit',     'create',
            'delete',   'changePassword',
        ],
        'roles' => [
            'index',
            'edit',             'create',
            'delete',
        ],
        'leads' => [
            'index', 'create','detail','booked','delete','deactivate','recover','sendemail','maildetails','filterleads'
        ],
        'contact' => [
                'index',    'detail',
                'createlead','delete','deactivate','deactivateview'
                ,'create',         'newbooking',         'createcar'
        ],
        'permissions' => [
            'index',
        ],
    ],
	'public' => [
		'index' => ['index']
	]
];*/
 