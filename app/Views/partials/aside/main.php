<?php
	use Plugins\Menu\Menu;
?>
<div id="Aside">
	<div class="menu_collapse">
		<div class="menu_collapse_toggle"><i class="lni lni-menu"></i></div>
	</div>
	<div class="main_menu">
		<ul>
			<?php
				$menu = new Menu();
				echo $menu->render();
			?>
			<!--<li>
				<a href="/dashboard"><i class="lni lni-question-circle"></i> <span>Dashboard</span></a>
			</li>
			<li class="menu_heading">
				<span>Customers</span>
			</li>
			<li>
				<a href="/test"><i class="lni lni-question-circle"></i> <span>Accounts</span></a>
			</li>
			<li>
				<a href="/contacts"><i class="lni lni-question-circle"></i> <span>Contacts</span></a>
			</li>
			<li class="menu_heading">
				<span>Sales</span>
			</li>
			<li>
				<a href="/test"><i class="lni lni-question-circle"></i> <span>Leads</span></a>
			</li>
			<li>
				<a href="/test"><i class="lni lni-question-circle"></i> <span>Bookings</span></a>
			</li>
			<li class="menu_heading">
				<span>System</span>
			</li>
			<li>
				<a href="/users"><i class="lni lni-question-circle"></i> <span>Users</span></a>
			</li>
			<li>
				<a href="/roles"><i class="lni lni-question-circle"></i> <span>Roles</span></a>
			</li>
			<li>
				<a href="/permissions"><i class="lni lni-question-circle"></i> <span>Permissions</span></a>
			</li>
			<li class="menu_heading">
				<span>Tools</span>
			</li>
			<li>
				<a href="/tools/typography"><i class="lni lni-question-circle"></i> <span>Typography</span></a>
			</li>
			<li>
				<a href="/tools/health"><i class="lni lni-question-circle"></i> <span>System Health</span></a>
			</li>-->
		</ul>
	</div>
</div>