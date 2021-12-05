<div class="header">
				<div class="container-fluid">
					<div class="d-flex justify-content-between">
						<div class="menu-toggle-button">
							<a class="nav-link" href="javascript:;" id="sidebarCollapse">
								<div class="my-toggl-icon">
									<span class="bar1"></span>
									<span class="bar2"></span>
									<span class="bar3"></span>
								</div>
							</a>
						</div>

						<div class="right-eliment">
							<ul class="list">

								{{-- <li class="bell-area">
									<a id="notf_conv" class="dropdown-toggle-1" href="javascript:;">
										<i class="far fa-envelope"></i>
										<span data-href="{{ route('conv-notf-count') }}"
											id="conv-notf-count">{{ App\Models\Notification::countConversation() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('conv-notf-show') }}"
											id="conv-notf-show">
										</div>
									</div>
								</li> --}}

								{{-- <li class="bell-area">
									<a id="notf_product" class="dropdown-toggle-1" href="javascript:;">
										<i class="icofont-cart"></i>
										<span data-href="{{ route('product-notf-count') }}"
											id="product-notf-count">{{ App\Models\Notification::countProduct() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('product-notf-show') }}"
											id="product-notf-show">
										</div>
									</div>
								</li> --}}

								{{-- <li class="bell-area">
									<a id="notf_user" class="dropdown-toggle-1" href="javascript:;">
										<i class="far fa-user"></i>
										<span data-href="{{ route('user-notf-count') }}"
											id="user-notf-count">{{ App\Models\Notification::countRegistration() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('user-notf-show') }}"
											id="user-notf-show">
										</div>
									</div>
								</li> --}}
								@if (Auth::guard('admin')->user()->IsAdmin())

								<li class="bell-area">
									<a id="notf_order" class="dropdown-toggle-1" href="javascript:;">
										<i class="far fa-newspaper"></i>
										<span data-href="{{ route('order-notf-count') }}"
											id="order-notf-count">{{ App\Models\Notification::countOrder() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('order-notf-show') }}"
											id="order-notf-show">
										</div>
									</div>
								</li>
								@endif
								<li class="login-profile-area">
									<a class="dropdown-toggle-1" href="javascript:;">
										<div class="user-img">
											<img src="{{ Auth::guard('admin')->user()->avatar ? asset('assets/images/admins/'.Auth::guard('admin')->user()->avatar ):asset('assets/images/noimage.png') }}"
												alt="">
										</div>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper">
											<ul>
												<h5>{{ __('Welcome!') }}</h5>
												<li>
													<a href="{{ route('admin.profile') }}"><i class="fas fa-user"></i>
														{{ __('Edit Profile') }}</a>
												</li>
												<li>
													<a href="{{ route('admin.password') }}"><i class="fas fa-cog"></i>
														{{ __('Change Password') }}</a>
												</li>
												<li>
													<a href="{{ route('admin.logout') }}"><i
															class="fas fa-power-off"></i> {{ __('Logout') }}</a>
												</li>
											</ul>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>