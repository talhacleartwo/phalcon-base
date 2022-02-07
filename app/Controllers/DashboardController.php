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

namespace Controllers;


/**
 * Display the "Dashboard" page.
 */
class DashboardController extends ControllerBase
{
    /**
     *
     * initalise parent functions
     */
    public function initialize()
    {
        parent::initialize();
		$this->view->pagetitle = "My Dashboard";
    }

    /**
     * index main action
     */
    public function indexAction()
    {
		$this->view->pagedetails = "Overview";
    }
}
