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

namespace Models\Core;

use Phalcon\Mvc\Model;

/**
 * RememberTokens
 * Stores the remember me tokens
 */
class RememberTokens extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $userAgent;

    /**
     * @var integer
     */
    public $createdAt;

    public function initialize()
    {
        $this->belongsTo('usersId', Users::class, 'id', [
            'alias' => 'user',
        ]);
    }

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmation
        $this->createdAt = time();
    }
}
