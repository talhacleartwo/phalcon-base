<?php
	$user = $this->auth->getIdentity();
	$name = $this->auth->getName();
	$i1 = explode(" ",$name)[0];
	$i2 = explode(" ",$name)[1];
	$i1 = substr($i1,0,1);
	$i2 = substr($i2,0,1);
?>
<div id="usersidebar">
	<div class="user_profile">
		<div class="initalbadge"><?php echo $i1.$i2; ?></div>
		<div class="profile_details">
			<div class="name"><?php echo $name; ?></div>
			<div class="email"><?php echo $user['email']; ?></div>
		</div>
	</div>
	<div class="user_menu">
		<ul>
			<li>
				<a href="/myaccount">Manage Account</a>
			</li>
			<li>
				<a href="/session/logout">Logout</a>
			</li>
		</ul>
	</div>
</div>