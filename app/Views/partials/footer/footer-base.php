<?php use Plugins\UtilHelper; ?>
<!-- begin:: Footer -->
<div id="Footer">
	<?php if($showFooter) : ?>
		<div class="ccmm_footer">
			<div class="row">
				<div class="columns three">
					Created On: <?php echo UtilHelper::dateTimeNumeric($record->createdon); ?>
				</div>
				<div class="columns three">
					Created By: <?php echo $record->createdby; ?>
				</div>
				<div class="columns three">
					Modified On: <?php echo UtilHelper::dateTimeNumeric($record->modifiedon); ?>
				</div>
				<div class="columns three">
					Modififed By: <?php echo $record->modifiedby; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
    <div class="kt-container kt-container--fluid ">
        <div class="kt-footer__copyright" style="float:left;"><?php $di = \Phalcon\DI::getDefault(); echo $di->getConfig()->company->CompanyName; ?> &copy; <?php echo date('Y'); ?> - Powered By <a style="margin-left:5px;" href="https://cleartwo.co.uk" target="_blank" class="kt-link">Cleartwo</a></div>
        <div class="kt-footer__menu" style="float:right;"><a href="mailto:support@cleartwo.co.uk" class="kt-footer__menu-link kt-link">Contact</a></div>
    </div>
</div>
<!-- end:: Footer -->