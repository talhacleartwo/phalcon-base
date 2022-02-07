<?php
	$di = \Phalcon\DI::getDefault();
	$session = $di->get('session');
	$user = $session->get('auth-identity');
?>
<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu"class="kt-aside-menu kt-scroll"data-ktmenu-vertical="1" data-ktmenu-dropdown="0" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500" >
        <ul class="kt-menu__nav ">
			<?php
				$di = \Phalcon\DI::getDefault();
				//echo $di->get('MenuManager')->Render();
			?>
          </ul>  
    </div>
</div>
<!-- end:: Aside Menu -->