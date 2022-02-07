<div id="Topbar">
	<div class="responsive_menu_toggle">
		<div class="toggle"><i class="lni lni-menu"></i></div>
	</div>
	<div class="brand">
		<h5><?php $di = \Phalcon\DI::getDefault(); echo $di->getConfig()->application->systemName; ?></h5>
	</div>
	<div class="subheader">
		<?php echo $pagetitle; echo ($pagedetails ? " | " . $pagedetails : ""); ?>
	</div>
	<div class="session">
		<div class="initalbadge">JP</div>
		<div class="dropdown">
			<div class="userdetails">
				<div class="name">Jamie Peck</div>
				<div class="role">System Admin</div>
			</div>
			<a href="/session/logout">Log Out</a>
		</div>
	</div>
</div>
<div class="alerts_container"><?php echo $this->flash->output(); ?><?php echo $this->flashSession->output(); ?></div>