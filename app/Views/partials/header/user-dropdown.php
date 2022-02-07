<!--begin: Head -->
<?php
	$name = $this->auth->getName();
	$i1 = explode(" ",$name)[0];
	$i2 = explode(" ",$name)[1];
	$i1 = substr($i1,0,1);
	$i2 = substr($i2,0,1);
?>
<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(/theme/assets/media/misc/bg-1.jpg);background: var(--userdropdownbg);">
    <div class="kt-user-card__avatar">
        <img class="kt-hidden" alt="Pic" src="/theme/assets/media/users/300_25.jpg" />
        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
        <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-brand"><?php echo $i1 . $i2;?></span> 
    </div>
    <div class="kt-user-card__name"> <?php echo $name; ?> </div>
    <?php /*<div class="kt-user-card__badge"> <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span> </div> */ ?>
</div>
<!--end: Head -->
<!--begin: Navigation -->
<div class="kt-notification">
    <?php /*<a href="/myaccount" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-calendar-3 kt-font-success"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Account </div>
            <div class="kt-notification__item-time"> Manage your account settings and more </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-mail kt-font-warning"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Messages </div>
            <div class="kt-notification__item-time"> Inbox and tasks </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-rocket-1 kt-font-danger"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Activities </div>
            <div class="kt-notification__item-time"> Logs and notifications </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-hourglass kt-font-brand"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Tasks </div>
            <div class="kt-notification__item-time"> latest tasks and projects </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-cardiogram kt-font-warning"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> Billing </div>
            <div class="kt-notification__item-time"> billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span> </div>
        </div>
    </a> */ ?>
    <div class="kt-notification__custom kt-space-between"> 
		<a href="/session/logout" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a> 
		<?php /*<a href="?page=custom/user/login-v2" target="_blank" class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a> */ ?>
	</div>
</div>
<!--end: Navigation -->