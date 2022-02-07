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

namespace Plugins\Menu;

use Phalcon\Di\Injectable;

/**
 * Renders the menu for the system
 */
class Menu extends Injectable
{
	/**
     * The file path of the menu config file.
     *
     * @var string
     */
    private $filePath;
	
	/**
     * Set the menu config file path
     *
     * @return string
     */
    protected function getFilePath()
    {
        if (!isset($this->filePath)) {
            $this->filePath = rtrim($this->config->application->configDir, '\\/') . '/menu.php';
        }

        return $this->filePath;
    }
	
	public function render(): string
    {
		$currController = $this->router->getControllerName();
		$currAction = $this->router->getActionName();
		$user = $this->session->get('auth-identity');
		//$roleTL = strtolower(str_replace(' ', '', $user->role->name));
		
		$filename = $this->getFilePath();
		
		//Find file to render menu from
		if (is_readable($filename)) 
		{
			$config = include $filename;
			
			ob_start();
			foreach($config as $item)
			{
				if(isset($item['heading']))
				{
					echo '<li class="menu_heading"><span>'.$item['heading'].'</span></li>';
				}
				else
				{
					$active = '';
					$matchedAction = ($currAction == $item['link'][1] || $currAction == '' && $item['link'][1] == 'index');
					$active = ($currController == $item['link'][0] && $matchedAction) ? 'active' : '';
					echo '<li class="'. $active .'">';
						echo '<a href="/'. $item['link'][0] . ($item['link'][1] !== 'index' ? '/' . $item['link'][1] : '') .'">';
							echo '<i class="'. $item['icon'] .'"></i>';
							echo '<span>' . $item['text'] . '</span>';
						echo '</a>';
					echo '</li>';
				}
			}
			return ob_get_clean();
		}
	}
}