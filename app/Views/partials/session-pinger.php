<div class="modal fade" id="sessmodal">
	<form class="kt-form" id="sp_form" method="POST">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Session Expired</h5>
					<p>Log back in to continue working</p>
				</div>
				<div class="modal-body">
					<div class="errors"></div>
					<div class="form-group">
						<input type="text" name="username" class="form-control" required/>
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" required/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="ct_submit" class="btn btn-primary">Login</button>
				</div>
			</div>
		</div>
	</form>
</div>