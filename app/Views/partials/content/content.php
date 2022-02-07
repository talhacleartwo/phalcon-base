<div id="Main">
	<?php $this->partial("partials/topbar/actionbar"); ?>
	<?php $this->partial("partials/content/subheader"); ?>
	<div class="content">
		<?php echo $this->getContent(); ?>
	</div>
	<?php $this->partial("partials/content/usersidebar"); ?>
	<?php $this->partial("partials/footer/footer-base"); ?>
</div>
