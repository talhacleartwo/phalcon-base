<!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
									<?php echo isset($pagetitle)? $pagetitle: null;  ?>
								</h3>
								<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
									<li class="m-nav__item m-nav__item--home">
										<a href="#" class="m-nav__link m-nav__link--icon">
											<i class="m-nav__link-icon la la-home"></i>
										</a>
									</li>
									<li class="m-nav__separator">
										<?php echo isset($pagedetails)? '-' : null;  ?>
									</li>
									<li class="m-nav__item">
										<a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												<?php echo isset($pagedetails)? $pagedetails : null;  ?>
											</span>
										</a>
									</li>
									
								</ul>
							</div>
						</div>
					</div>
					<!-- END: Subheader -->