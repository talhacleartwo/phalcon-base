<div class="row">
	<div class="col-md-12">
		<div class="kt-portlet">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Contact Details
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<form class="form" method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Title</label>
								<?php echo $form->render('title');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>First Name</label>
								<?php echo $form->render('firstname');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Last Name</label>
								<?php echo $form->render('lastname');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Email Address</label>
								<?php echo $form->render('email');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Mobile Phone</label>
								<?php echo $form->render('mobilephone');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Telephone</label>
								<?php echo $form->render('telephone');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 1</label>
								<?php echo $form->render('addressline1');?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Address Line 2</label>
								<?php echo $form->render('addressline2');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>City</label>
								<?php echo $form->render('city');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>County</label>
								<?php echo $form->render('county');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Postcode</label>
								<?php echo $form->render('postcode');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Profile Image</label>
								<?php echo $form->render('profileimage');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Account</label>
								<?php echo $form->render('accountid');?>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="kt-portlet__foot">
				<div class="col text-left">
					<?php echo $form->render('Submit');?>
				</div>
				<div class="col text-right">
					<button type="reset" class="btn btn-secondary">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>