<nav id="sidebar" class="nav-sidebar">
					<ul class="list-unstyled components" id="accordion">
						<li>
							<a href="{{ route('front.index') }}" class="wave-effect active" target="_blank"><i
									class="fa fa-home mr-2"></i>{{ __('Home Page') }}</a>
						</li>
						<li>
							<a href="{{ route('admin.dashboard') }}" class="wave-effect active"><i
									class="fa fa-home mr-2"></i>{{ __('Dashboard') }}</a>
						</li>
                       @if(Auth::guard('admin')->user()->IsAdmin())
                       
						<li>
							<a href="#report" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-chart-bar"></i>{{ __('Reports') }}</a>
							<ul class="collapse list-unstyled" id="report" data-parent="#accordion">
								<li>
									<a href="{{route('daily.report')}}"> {{ __('Daily') }}</a>
								</li>
								<li>
									<a href="{{route('weekly.report')}}"> {{ __('Weekly') }}</a>
								</li>
								<li>
									<a href="{{route('monthly.report')}}"> {{ __('Monthly') }}</a>
								</li>
								
							</ul>
						</li>
					    <li>
							<a href="#merchant" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-chart-bar"></i>{{ __('Merchants') }}</a>
							<ul class="collapse list-unstyled" id="merchant" data-parent="#accordion">
							    
							    <li>
									<a href="{{route('admin.order.commission')}}"> {{ __('Order Commission') }}</a>
								</li>

								<li>
									<a href="{{route('merchant.show')}}"> {{ __('All Merchants') }}</a>
								</li>

								<li>
									<a href="{{route('merchant.sell.history')}}"> {{ __('Marchant Commission') }}</a>
								</li>

								<li>
									<a href="{{route('total.merchant.commission')}}"> {{ __('Total Commission') }}</a>
								</li>
								<li>
									<a href="{{route('merchant.all.withdraw')}}"> {{ __('Withdraw Request') }}</a>
								</li>

								<li>
									<a href="{{ route('merchant.application') }}">
									 {{ __('New Marchant Request') }}</a>
								</li>

								<li>
									<a href="{{ route('merchant.reject.application') }}">
									 {{ __('Reject Application') }}</a>
								</li>
								
							</ul> 
						</li>
						
							<li>
							<a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-user"></i>{{ __('Sellers') }}
							</a>
							<ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-user-index') }}"><span>{{ __('Sellers List') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Sellers Withdraws') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-user-image') }}"><span>{{ __('Seller Default Image') }}</span></a>
								</li>
							</ul>
						</li>
						@endif
                    @if(Auth::guard('admin')->user()->IsMerchant())
						<li>
							<a href="#merchantPtoduct" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								 <i class="fab fa-product-hunt"></i>{{ __('Products') }}</a>
							<ul class="collapse list-unstyled" id="merchantPtoduct" data-parent="#accordion">
								<li>
									<a     
										href="{{ route('admin-prod-physical-create') }}"><span>
										<i class="fa fa-plus-square mr-2"></i>{{ __('Add New Product') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-prod-index') }}"><span>
									 <i class="fab fa-product-hunt"></i> {{ __('My Products') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-prod-stock-low') }}"><span>
									 <i class="fab fa-product-hunt"></i> {{ __('Stock Low Product') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-prod-stock-out') }}"><span>
									 <i class="fab fa-product-hunt"></i> {{ __('Stock Out product') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-prod-deactive') }}"><span><i class="fab fa-creative-commons-zero"></i> {{ __('Deactivated Product') }}</span></a>
								</li>

								<li>
									<a href="#" onclick="return confirm('comming soon')"><span><i class="fab fa-creative-commons-zero"></i> {{ __('Bulk product Upload') }}</span></a>
								</li>
								
							</ul>
						</li>

						<li>
							<a href="#merchanSalesHistory" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-chart-bar"></i>{{ __('Sales History') }}</a>
							<ul class="collapse list-unstyled" id="merchanSalesHistory" data-parent="#accordion">
								
								<li>
									<a href="{{ route('admin.merchant.pending.order') }}"><span><i class="fas fa-history"></i> {{ __('Pending Order') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin.merchant.processing.order') }}"><span><i class="fas fa-history"></i> {{ __('Processing Order') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin.merchant.ondelivery.order') }}"><span><i class="fas fa-file-invoice"></i> {{ __('On Delivery') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin.merchant.completed.order') }}"><span><i class="fab fa-gg-circle"></i> {{ __('Completed Order') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin.merchant.return.order') }}"><span><i class="fab fa-gg-circle"></i> {{ __('Return Order') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin.merchant.declined.order') }}"><span><i class="fab fa-gg-circle"></i> {{ __('Declined order') }}</span></a>
								</li>
							
							</ul>
						</li>

						<li>
							<a href="#merchanAccount" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-chart-bar"></i>{{ __('My Account') }}</a>
							<ul class="collapse list-unstyled" id="merchanAccount" data-parent="#accordion">
							

						     	<li>
									<a
										href="{{ route('admin.merchant.account') }}"><span><i class="fas fa-file-invoice"></i> {{ __('My Balance') }}</span></a>
								</li>

								<li>
									<a
										href="{{ route('admin.merchant.withdraw.list') }}"><span><i class="fab fa-gg-circle"></i> {{ __('Withdraws History') }}</span></a>
								</li>

								<li>
									<a
										href="{{ route('admin.merchant.commission') }}"><span><i class="fas fa-history"></i> {{ __('Commission History') }}</span></a>
								</li>

								<li>
									<a
										href="{{ route('admin.merchant.sale.history') }}"><span><i class="fas fa-history"></i> {{ __('Sales History') }}</span></a>
								</li>
								
							</ul>
						</li>
						@endif

						
						@if (Auth::guard('admin')->user()->IsAdmin())

						<li>
							<a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
							<ul class="collapse list-unstyled" id="order" data-parent="#accordion">
								<li>
									<a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-deliver')}}"> {{ __('On delivery') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-completed')}}"> {{ __('Completed Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-returned')}}"> {{ __('Return Order') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-declined')}}"> {{ __('Declined Orders') }}</a>
								</li>

							</ul>
						</li>
						@endif
					
						 @if(Auth::guard('admin')->user()->IsAdmin())
						<li>
							<a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-cart"></i>{{ __('Products') }}
							</a>
							<ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
								
								<li>
									<a href="{{ route('admin.all.product') }}"><span>{{ __('All Products') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin.low.stock.product') }}"><span>{{ __('Low Stock Product') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin.stock.out.product') }}"><span>{{ __('Stock out Product') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-deactive-product') }}"><span>{{ __('Deactivated Product') }}</span></a>
								</li>
							</ul>
						</li>
							@endif
				

						@if(Auth::guard('admin')->user()->IsAdmin())
						{{-- <li>
							<a href="{{ route('admin-coupon-index') }}" class=" wave-effect"><i
									class="fas fa-percentage"></i>{{ __('Set Coupons') }}</a>
						</li> --}}
						<li>
							<a href="#menu5" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false"><i class="fas fa-sitemap"></i>{{ __('Manage Categories') }}</a>
							<ul class="collapse list-unstyled" id="menu5" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-cat-index') }}"><span>{{ __('Main Category') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-subcat-index') }}"><span>{{ __('Sub Category') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-childcat-index') }}"><span>{{ __('Child Category') }}</span></a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-speech-comments"></i>{{ __('Product Discussion') }}
							</a>
							<ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-rating-index') }}"><span>{{ __('Product Reviews') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-comment-index') }}"><span>{{ __('Comments') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-report-index') }}"><span>{{ __('Reports') }}</span></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="{{ route('admin-subs-index') }}" class=" wave-effect"><i
									class="fas fa-users-cog mr-2"></i>{{ __('Subscribers') }}</a>
						</li>
						<li>
							<a href="#msg" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-fw fa-newspaper"></i>{{ __('Messages') }}
							</a>
							<ul class="collapse list-unstyled" id="msg" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-fw fa-newspaper"></i>{{ __('Blog') }}
							</a>
							<ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a>
								</li>
							</ul>
						</li>


						<li>
							<a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-cogs"></i>{{ __('General Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="general" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-gs-logo') }}"><span>{{ __('Logo') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-gs-fav') }}"><span>{{ __('Favicon') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-change_apitoken') }}"><span>{{ __('Change API Token') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-gs-load') }}"><span>{{ __('Loader') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-shipping-index') }}"><span>{{ __('Shipping Methods') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-package-index') }}"><span>{{ __('Packagings') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-pick-index') }}"><span>{{ __('Pickup Locations') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-gs-contents') }}"><span>{{ __('Website Contents') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-gs-footer') }}"><span>{{ __('Footer') }}</span></a>
								</li>
								

								<li>
									<a href="{{ route('admin-gs-popup') }}"><span>{{ __('Popup Banner') }}</span></a>
								</li>


								<li>
									<a
										href="{{ route('admin-gs-error-banner') }}"><span>{{ __('Error Banner') }}</span></a>
								</li>

							</ul>
						</li>

						@endif




						@if(Auth::guard('admin')->user()->IsAdmin())


						<li>
							<a href="#homepage" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-edit"></i>{{ __('Home Page Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="homepage" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-sl-index') }}"><span>{{ __('Sliders') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-featuredlink-index') }}"><span>{{ __('Featured Links') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-featuredbanner-index') }}"><span>{{ __('Featured Banners') }}</span></a>
								</li>
								<li>
									<a href="{{ route('home.page.content') }}"><span>{{ __('Dynmaic Text') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-service-index') }}"><span>{{ __('Services') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-ps-best-seller') }}"><span>{{ __('Right Side Banner1') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-ps-big-save') }}"><span>{{ __('Right Side Banner2') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-sb-index') }}"><span>{{ __('Top Small Banners') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-sb-large') }}"><span>{{ __('Large Banners') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-sb-bottom') }}"><span>{{ __('Bottom Small Banners') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-review-index') }}"><span>{{ __('Reviews') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-partner-index') }}"><span>{{ __('Partners') }}</span></a>
								</li>


								<li>
									<a
										href="{{ route('admin-ps-customize') }}"><span>{{ __('Home Page Customization') }}</span></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#menu" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-file-code"></i>{{ __('Menu Page Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="menu" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-at"></i>{{ __('Email Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="emails" data-parent="#accordion">
								<li><a href="{{route('admin-mail-index')}}"><span>{{ __('Email Template') }}</span></a>
								</li>
								<li><a
										href="{{route('admin-mail-config')}}"><span>{{ __('Email Configurations') }}</span></a>
								</li>
								<li><a href="{{route('admin-group-show')}}"><span>{{ __('Group Email') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#payments" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-file-code"></i>{{ __('Payment Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="payments" data-parent="#accordion">
								<li><a
										href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a>
								</li>
								<li><a
										href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a>
								</li>
								<li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-paper-plane"></i>{{ __('Social Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="socials" data-parent="#accordion">
								<li><a href="{{route('admin-social-index')}}"><span>{{ __('Social Links') }}</span></a>
								</li>
								<li><a
										href="{{route('admin-social-facebook')}}"><span>{{ __('Facebook Login') }}</span></a>
								</li>
								<li><a href="{{route('admin-social-google')}}"><span>{{ __('Google Login') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#langs" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-language"></i>{{ __('Language Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="langs" data-parent="#accordion">
								<li><a
										href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a>
								</li>
								<li><a
										href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a>
								</li>

							</ul>
						</li>

						<li>
							<a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-wrench"></i>{{ __('SEO Tools') }}
							</a>
							<ul class="collapse list-unstyled" id="seoTools" data-parent="#accordion">
								{{-- <li>
									<a
										href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a>
								</li> --}}
								<li>
									<a
										href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a>
								</li>
							</ul>
						</li>
						{{-- <li>
							<a href="{{ route('admin-staff-index') }}" class=" wave-effect"><i
									class="fas fa-user-secret"></i>{{ __('Manage Staffs') }}</a>
						</li>
 --}}

						

						

						<li>
							<a href="#sactive" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-cog"></i>{{ __('System Activation') }}
							</a>
							<ul class="collapse list-unstyled" id="sactive" data-parent="#accordion">

								<li><a href="{{route('admin-activation-form')}}"> {{ __('Activation') }}</a></li>
								<li><a href="{{route('admin-generate-backup')}}"> {{ __('Generate Backup') }}</a></li>
							</ul>
						</li>

						@endif

						<li>
							<a href="{{ route('transaction.history') }}" class=" wave-effect"><i
									class="fas fa-paper-plane mr-2"></i>{{ __('Transacions') }}</a>
						</li>
						
						<li>
							<a href="{{ route('live.chat') }}"  class=" wave-effect"><i
									class="fas fa-users mr-2"></i>{{ __('Live Chat') }}</a>
						</li>


					</ul>

					<p class="version-name"> Developed By Rasel Rana (Software Engineer)}</p>
				</nav>