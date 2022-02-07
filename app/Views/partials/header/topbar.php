<!-- begin:: Content Head -->
<div class="kt-subheader kt-grid__item" id="kt_subheader">
    <div class="kt-container kt-container--fluid">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                <?php echo $pagetitle; ?>
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span> 
			<span class="kt-subheader__desc"><?php echo $pagedetails; ?></span> 
			<!--<a href="#" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10"> Add New </a>--> 
            <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="flaticon2-search-1"></i></span>
                </span>
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <a href="#" class="btn kt-subheader__btn-secondary">Today</a> <a href="#" class="btn kt-subheader__btn-secondary">Month</a> <a href="#" class="btn kt-subheader__btn-secondary">Year</a> 
                <a href="#" class="btn kt-subheader__btn-primary">
                    Actions &nbsp; 
                    <!--<i class="flaticon2-calendar-1"></i>-->
                </a>
                <div class="dropdown dropdown-inline" data-toggle-="kt-tooltip" title="Quick actions" data-placement="left">
                    <a href="#" class="btn btn-icon"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--md">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
								<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
								<path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" id="Combined-Shape" fill="#000000"/>
							</g>
						</svg>
						<!--<i class="flaticon2-plus"></i>-->
					</a>
					<div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">
						<!--begin::Nav-->
						<ul class="kt-nav">
							<li class="kt-nav__head"> Add anything or jump to: <i class="flaticon2-information" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more..."></i> </li>
							<li class="kt-nav__separator"></li>
							<li class="kt-nav__item">
								<a href="#" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-drop"></i> <span class="kt-nav__link-text">Order</span> </a>
							</li>
							<li class="kt-nav__item">
								<a href="#" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-calendar-8"></i> <span class="kt-nav__link-text">Ticket</span> </a>
							</li>
							<li class="kt-nav__item">
								<a href="#" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-link"></i> <span class="kt-nav__link-text">Goal</span> </a>
							</li>
							<li class="kt-nav__item">
								<a href="#" class="kt-nav__link">
									<i class="kt-nav__link-icon flaticon2-new-email"></i> <span class="kt-nav__link-text">Support Case</span> 
									<span class="kt-nav__link-badge"> <span class="kt-badge kt-badge--brand kt-badge--rounded">5</span> </span>
								</a>
							</li>
							<li class="kt-nav__separator"></li>
							<li class="kt-nav__foot"> <a class="btn btn-label-brand btn-bold btn-sm" href="#">Upgrade plan</a> <a class="btn btn-clean btn-bold btn-sm kt-hidden" href="#" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">Learn more</a> </li>
						</ul>
						<!--end::Nav-->
					</div>
                </div>
            </div>
        </div>
		<!-- begin:: Header Topbar -->
		<div class="kt-header__topbar">
			<!--[html-partial:include:{"file":"partials\/_topbar-my-cart.html"}]/-->
			<!--begin: User Bar -->
			<div class="kt-header__topbar-item kt-header__topbar-item--user">
				<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
					<div class="kt-header__topbar-user">
						<?php
							$name = $this->auth->getName();
							$i1 = explode(" ",$name)[0];
							$i2 = explode(" ",$name)[1];
							$i1 = substr($i1,0,1);
							$i2 = substr($i2,0,1);
						?>
						<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span> <span class="kt-header__topbar-username kt-hidden-mobile"><?php echo $name; ?></span> 
						<!--<img class="kt-hidden" alt="Pic" src="/theme/assets/media/users/300_25.jpg" />-->
						<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
						<span class="kt-badge kt-badge--username kt-badge--unified-brand kt-badge--lg kt-badge--rounded kt-badge--bold"><?php echo $i1 . $i2;?></span> 
					</div>
				</div>
				<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
					<?php /*$this->partial("partials/header/user-dropdown");*/ ?>
				</div>
			</div>
			<!--end: User Bar -->
		</div>
		<!-- end:: Header Topbar -->
    </div>
</div>
<!-- end:: Content Head -->