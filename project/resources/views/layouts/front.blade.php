<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	@if(isset($page->meta_tag) && isset($page->meta_description))
	<meta name="keywords" content="{{ $page->meta_tag }}">
	<meta name="description" content="{{ $page->meta_description }}">
	<title>{{$gs->title}}</title>
	@elseif(isset($blog->meta_tag) && isset($blog->meta_description))
	<meta name="keywords" content="{{ $blog->meta_tag }}">
	<meta name="description" content="{{ $blog->meta_description }}">

	<title>{{$gs->title}}</title>
	@elseif(isset($productt))
	<meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
	<meta property="og:title" content="{{$productt->name}}" />
	<meta property="og:description"
		content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
	<meta property="og:image" content="{{asset('assets/images/'.$productt->photo)}}" />
	<meta name="author" content="GeniusOcean">
	<title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
	@else
	<meta name="keywords" content="{{ $seo->meta_keys }}">
	<meta name="author" content="GeniusOcean">
	<title>{{$gs->title}}</title>
	@endif
	<!-- favicon -->
	<link rel="icon" type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}" />
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
	<!-- Plugin css -->
	<link rel="stylesheet" href="{{asset('assets/front/css/plugin.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/toastr.css')}}">

	<!-- jQuery Ui Css-->
	<link rel="stylesheet" href="{{asset('assets/front/jquery-ui/jquery-ui.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/jquery-ui/jquery-ui.structure.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/jquery-ui/jquery-ui.theme.min.css')}}">

	@if($langg->rtl == "1")

	<!-- stylesheet -->
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/responsive.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common-responsive.css')}}">
	@else

	<!-- stylesheet -->
	<link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/common-responsive.css')}}">
	
	@endif


	<!--Updated CSS-->
	<link rel="stylesheet"
		href="{{ asset('assets/front/css/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">
		
	@yield('styles')

</head>

<body>

	@if($gs->is_loader == 1)
	<div class="preloader" id="preloader"
		style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;"></div>
	@endif

	@if($gs->is_popup== 1)

	@if(isset($visited))
	<div style="display:none">
		<img src="{{asset('assets/images/'.$gs->popup_background)}}">
	</div>

	<!--  Starting of subscribe-pre-loader Area   -->
	<div class="subscribe-preloader-wrap" id="subscriptionForm" style="display: none;">
		<div class="subscribePreloader__thumb"
			style="background-image: url({{asset('assets/images/'.$gs->popup_background)}});">
			<span class="preload-close"><i class="fas fa-times"></i></span>
			<div class="subscribePreloader__text text-center">
				<h1>{{$gs->popup_title}}</h1>
				<p>{{$gs->popup_text}}</p>
				<form action="{{route('front.subscribe')}}" id="subscribeform" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						<input type="email" name="email" placeholder="{{ $langg->lang741 }}" required="">
						<button id="sub-btn" type="submit">{{ $langg->lang742 }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--  Ending of subscribe-pre-loader Area   -->

	@endif

	@endif


	<section class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 remove-padding">
					<div class="content">
						<div class="left-content">
							<div class="list">
							<ul>
									<li class="profilearea my-dropdown">
										<a href="{{ route('merchant.apply') }}" id="profile-icon" class="profile carticon">
											<span class="text">
												Merchant Zone
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="right-content">
							<div class="list">
								<ul>
									@if(!Auth::guard('web')->check())
								        <li class="login">
										<a href="{{ route('user.login') }}" class="sign-log">
											<div class="links">
												<span class="sign-in">User Login</span>
									
											</div>
										</a>
									</li>
									@else
									<li class="profilearea my-dropdown">
										<a href="javascript: ;" id="profile-icon" class="profile carticon">
											<span class="text">
												{{ $langg->lang11 }} <i class="fas fa-chevron-down"></i>
											</span>
										</a>
										<div class="my-dropdown-menu profile-dropdown">
											<ul class="profile-links">
												<li>
													<a href="{{ route('user-dashboard') }}"><i
															class="fas fa-angle-double-right"></i>
														{{ $langg->lang221 }}</a>
												</li>
												<li>
													<a href="{{ route('user-profile') }}"><i
															class="fas fa-angle-double-right"></i>
														{{ $langg->lang205 }}</a>
												</li>
												<li>
													<a href="{{ route('user-logout') }}"><i
															class="fas fa-angle-double-right"></i>
														{{ $langg->lang223 }}</a>
												</li>
											</ul>
										</div>
									</li>
									@endif

								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Top Header Area End -->

	<!-- Logo Header Area Start -->
	<section class="logo-header">
		<div class="container">
			<div class="row ">
				<div class="col-lg-2 col-sm-6 col-5 remove-padding">
					<div class="logo">
						<a href="{{ route('front.index') }}">
							<img src="{{asset('assets/images/'.$gs->logo)}}" alt="">
						</a>
					</div>
				</div>
				<div class="col-lg-8 col-sm-12 remove-padding order-last order-sm-2 order-md-2">
					<div class="search-box-wrapper">
						<div class="search-box">
							<div class="categori-container">
								<select id="category_select" class="categoris">
									<option value="0">{{ $langg->lang1 }}</option>
									@foreach($categories as $data)
									<option value="{{ $data->id }}"
										{{ isset($_GET['category_id']) ? ( $_GET['category_id'] == $data->id ? 'selected' : '' ) : ''}}>
										{{ $data->name }}</option>
									@endforeach
								</select>
							</div>
							<form class="search-form" action="{{ route('front.search') }}" method="GET">
								<input type="hidden" id="category_id" name="category_id"
									value="{{ isset($_GET['category_id']) ? $_GET['category_id'] : '0'}}">
								<input type="text" id="prod_name" name="search" placeholder="{{ $langg->lang2 }}"
									value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}" required=""
									autocomplete="off">
								<div class="autocomplete">
									<div id="myInputautocomplete-list" class="autocomplete-items">
									</div>
								</div>
								<button type="submit"><i class="icofont-search-1"></i></button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-sm-6 col-7 remove-padding order-lg-last">
					<div class="helpful-links">
						<ul class="helpful-links-inner">
							<li class="my-dropdown"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang3 }}">
								<a href="javascript:;" class="cart carticon">
									<div class="icon">
										<i class="icofont-cart"></i>
										<span class="cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
									</div>

								</a>
								<div class="my-dropdown-menu" id="cart-items">
									@include('load.cart')
								</div>
							</li>
							<li class="wishlist"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang9 }}">
								@if(Auth::guard('web')->check())
									<a href="{{ route('user-wishlists') }}" class="wish">
										<i class="far fa-heart"></i>
										<span id="wishlist-count">0</span>
									</a>
								@else
									<a href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" class="wish">
										<i class="far fa-heart"></i>
										<span id="wishlist-count">0</span>
									</a>
								@endif
							</li>
							<li class="compare"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang10 }}">
								<a href="{{ route('product.compare') }}" class="wish compare-product">
									<div class="icon">
										<i class="fas fa-exchange-alt"></i>
										<span id="compare-count">{{ Session::has('compare') ? count(Session::get('compare')->items) : '0' }}</span>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Logo Header Area End -->

	<!--Main-Menu Area Start-->
	<div class="mainmenu-area">
		<div class="container">
			<div class="row align-items-center mainmenu-area-innner">
				<div class="col-lg-3 col-md-6 categorimenu-wrapper remove-padding">
					<!--categorie menu start-->
					<div class="categories_menu">
						<div class="categories_title">
							<h2 class="categori_toggle"><i class="fa fa-bars"></i> {{ $langg->lang14 }} <i
									class="fa fa-angle-down arrow-down"></i></h2>
						</div>
						<div class="categories_menu_inner">
							<ul>
								@php
								$i=1;
								@endphp
								@foreach($categories as $category)

								<li
									class="{{count($category->subs) > 0 ? 'dropdown_list':''}} {{ $i >= 15 ? 'rx-child' : '' }}">
									@if(count($category->subs) > 0)
									<div class="img">
										<img src="{{ asset('assets/images/categories/'.$category->photo) }}" alt="">
									</div>
									<div class="link-area">
										<span><a
												href="{{ route('front.category',$category->slug) }}">{{ $category->name }}</a></span>
										@if(count($category->subs) > 0)
										<a href="javascript:;">
											<i class="fa fa-angle-right" aria-hidden="true"></i>
										</a>
										@endif
									</div>

									@else
									<a href="{{ route('front.category',$category->slug) }}"><img
											src="{{ asset('assets/images/categories/'.$category->photo) }}">
										{{ $category->name }}</a>

									@endif
									@if(count($category->subs) > 0)

									@php
									$ck = 0;
									foreach($category->subs as $subcat) {
									if(count($subcat->childs) > 0) {
									$ck = 1;
									break;
									}
									}
									@endphp
									<ul
										class="{{ $ck == 1 ? 'categories_mega_menu' : 'categories_mega_menu column_1' }}">
										@foreach($category->subs as $subcat)
										<li>
											<a
												href="{{ route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}</a>
											@if(count($subcat->childs) > 0)
											<div class="categorie_sub_menu">
												<ul>
													@foreach($subcat->childs as $childcat)
													<li><a
															href="{{ route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a>
													</li>
													@endforeach
												</ul>
											</div>
											@endif
										</li>
										@endforeach
									</ul>

									@endif

								</li>

								@if($i == 20)

								@break

								@endif
								@if($i == 15)
								<li>
									<a href="{{ route('front.categories') }}"><i class="fas fa-plus"></i>
										{{ $langg->lang15 }} </a>
								</li>
								@break
								@endif


								@php
								$i++;
								@endphp

								@endforeach

							</ul>
						</div>
					</div>
					<!--categorie menu end-->
				</div>
				<div class="col-lg-9 col-md-6 mainmenu-wrapper remove-padding">
					<nav hidden>
						<div class="nav-header">
							<button class="toggle-bar"><span class="fa fa-bars"></span></button>
						</div>
					    <div class="marquee-div">
								<marquee behavior="scroll" direction="left" scrollamount="8">
									
								@php
										 $metas=App\HomeMeta::all();
										 $dynamic_content=array_search('dynamic_content', array_column($metas->toArray(), 'meta_name'));

									@endphp
									<span>
									{{$metas[$dynamic_content]['meta_content']}} </span>
								</marquee>
							</div>
						<!--<ul class="menu">-->
						<!--	@if($gs->is_home == 1)-->
						<!--	<li><a href="{{ route('front.index') }}">{{ $langg->lang17 }}</a></li>-->
						<!--	@endif-->
						<!--	<li><a href="{{ route('front.blog') }}">{{ $langg->lang18 }}</a></li>-->
						<!--	@if($gs->is_faq == 1)-->
						<!--	<li><a href="{{ route('front.faq') }}">{{ $langg->lang19 }}</a></li>-->
						<!--	@endif-->
						<!--	@foreach(DB::table('pages')->where('header','=',1)->get() as $data)-->
						<!--	<li><a href="{{ route('front.page',$data->slug) }}">{{ $data->title }}</a></li>-->
						<!--	@endforeach-->
						<!--	@if($gs->is_contact == 1)-->
						<!--	<li><a href="{{ route('front.contact') }}">{{ $langg->lang20 }}</a></li>-->
						<!--	@endif-->
						
						<!--</ul>-->
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!--Main-Menu Area End-->

	@yield('content')

	<!-- Footer Area Start -->
	<footer class="footer" id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-4">
					<div class="footer-info-area">
						<div class="footer-logo">
							<a href="{{ route('front.index') }}" class="logo-link">
								<img src="{{asset('assets/images/'.$gs->footer_logo)}}" alt="">
							</a>
						</div>
						<div class="text">
							<p>
								{!! $gs->footer !!}
							</p>
						</div>
					</div>
					<div class="fotter-social-links">
						<ul>

							@if(App\Models\Socialsetting::find(1)->f_status == 1)
							<li>
								<a href="{{ App\Models\Socialsetting::find(1)->facebook }}" class="facebook"
									target="_blank">
									<i class="fab fa-facebook-f"></i>
								</a>
							</li>
							@endif

							@if(App\Models\Socialsetting::find(1)->g_status == 1)
							<li>
								<a href="{{ App\Models\Socialsetting::find(1)->gplus }}" class="google-plus"
									target="_blank">
									<i class="fab fa-google-plus-g"></i>
								</a>
							</li>
							@endif

							@if(App\Models\Socialsetting::find(1)->t_status == 1)
							<li>
								<a href="{{ App\Models\Socialsetting::find(1)->twitter }}" class="twitter"
									target="_blank">
									<i class="fab fa-twitter"></i>
								</a>
							</li>
							@endif

							@if(App\Models\Socialsetting::find(1)->l_status == 1)
							<li>
								<a href="{{ App\Models\Socialsetting::find(1)->linkedin }}" class="linkedin"
									target="_blank">
									<i class="fab fa-linkedin-in"></i>
								</a>
							</li>
							@endif

							@if(App\Models\Socialsetting::find(1)->d_status == 1)
							<li>
								<a href="{{ App\Models\Socialsetting::find(1)->dribble }}" class="dribbble"
									target="_blank">
									<i class="fab fa-dribbble"></i>
								</a>
							</li>
							@endif

						</ul>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="footer-widget info-link-widget">
						<h4 class="title">
							{{ $langg->lang21 }}
						</h4>
						<ul class="link-list">
							<li>
								<a href="{{ route('front.index') }}">
									<i class="fas fa-angle-double-right"></i>{{ $langg->lang22 }}
								</a>
							</li>

							@foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
							<li>
								<a href="{{ route('front.page',$data->slug) }}">
									<i class="fas fa-angle-double-right"></i>{{ $data->title }}
								</a>
							</li>
							@endforeach

							<li>
								<a href="{{ route('front.contact') }}">
									<i class="fas fa-angle-double-right"></i>{{ $langg->lang23 }}
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="footer-widget recent-post-widget">
						<h4 class="title">
							{{ $langg->lang24 }}
						</h4>
						<ul class="post-list">
							@foreach (App\Models\Blog::orderBy('created_at', 'desc')->limit(3)->get() as $blog)
							<li>
								<div class="post">
									<div class="post-img">
										<img style="width: 73px; height: 59px;"
											src="{{ asset('assets/images/blogs/'.$blog->photo) }}" alt="">
									</div>
									<div class="post-details">
										<a href="{{ route('front.blogshow',$blog->id) }}">
											<h4 class="post-title">
												{{strlen($blog->title) > 45 ? substr($blog->title,0,45)." .." : $blog->title}}
											</h4>
										</a>
										<p class="date">
											{{ date('M d - Y',(strtotime($blog->created_at))) }}
										</p>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="copy-bg">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="content">
							<div class="content">
								<p>{!! $gs->copyright !!}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer Area End -->

	<!-- Back to Top Start -->
	<div class="bottomtotop">
		<i class="fas fa-chevron-right"></i>
	</div>
	<!-- Back to Top End -->

	<!-- LOGIN MODAL -->
	<div class="modal fade" id="comment-log-reg" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
		aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-log1" role="tabpanel"
							aria-labelledby="nav-log-tab1">
							<div class="login-area">
								<div class="header-area">
									<h4 class="title">{{ $langg->lang172 }}</h4>
								</div>
								<div class="login-form signin-form">
									@include('error.error')

									<form class="" action="{{ route('user.login.submit') }}" method="POST">
										{{ csrf_field() }}

										<div class="form-input">
											<input type="text" name="phone" placeholder="Phone"
												required="">
											<i class="icofont-user-alt-5"></i>
										</div>

										<div class="form-input">
											<input type="password" class="Password" name="password"
												placeholder="{{ $langg->lang174 }}" required="">
											<i class="icofont-ui-password"></i>
										</div>

										
										<input type="hidden" name="modal" value="1">
										<input class="mauthdata" type="hidden" value="{{ $langg->lang177 }}">
										<button type="submit" class="submit-btn">{{ $langg->lang178 }}</button>
										 <a href="{{route('showforgetform')}}" class="btn btn-link">Forget Password ?</a>

										
									</form>


								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- LOGIN MODAL ENDS -->

	<!-- FORGOT MODAL -->
	<div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
		aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="login-area">
						<div class="header-area forgot-passwor-area">
							<h4 class="title">{{ $langg->lang191 }} </h4>
							<p class="text">{{ $langg->lang192 }} </p>
						</div>
						<div class="login-form">
							@include('includes.admin.form-login')
							<form id="mforgotform" action="{{route('user-forgot-submit')}}" method="POST">
								{{ csrf_field() }}
								<div class="form-input">
									<input type="email" name="email" class="User Name"
										placeholder="{{ $langg->lang193 }}" required="">
									<i class="icofont-user-alt-5"></i>
								</div>
								<div class="to-login-page">
									<a href="javascript:;" id="show-login">
										{{ $langg->lang194 }}
									</a>
								</div>
								<input class="fauthdata" type="hidden" value="{{ $langg->lang195 }}">
								<button type="submit" class="submit-btn">{{ $langg->lang196 }}</button>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- FORGOT MODAL ENDS -->

	<!-- Product Quick View Modal -->

	<div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog quickview-modal modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="submit-loader">
					<img src="{{asset('assets/images/'.$gs->loader)}}" alt="">
				</div>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container quick-view-modal">

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Product Quick View Modal -->

	<!-- Order Tracking modal Start-->
	<div class="modal fade" id="track-order-modal" tabindex="-1" role="dialog" aria-labelledby="order-tracking-modal"
		aria-hidden="true">
		<div class="modal-dialog  modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"> <b>{{ $langg->lang772 }}</b> </h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="order-tracking-content">
						<form id="track-form" class="track-form">
							{{ csrf_field() }}
							<input type="text" id="track-code" placeholder="{{ $langg->lang773 }}" required="">
							<button type="submit" class="mybtn1">{{ $langg->lang774 }}</button>
							<a href="#" data-toggle="modal" data-target="#order-tracking-modal"></a>
						</form>
					</div>

					<div>
						<div class="submit-loader d-none">
							<img src="{{asset('assets/images/'.$gs->loader)}}" alt="">
						</div>
						<div id="track-order">

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- Order Tracking modal End -->




	<script type="text/javascript">
		var mainurl = "{{ url('/') }}";
		var gs = {!! json_encode($gs) !!};
		var langg = {!! json_encode($langg) !!};
	</script>

	<!-- jquery -->
	

	<script src="{{asset('assets/front/js/jquery.js')}}"></script>
	{{-- <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script> --}}
	<script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>
	<!-- popper -->
	<script src="{{asset('assets/front/js/popper.min.js')}}"></script>
	<!-- bootstrap -->
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
	<!-- plugin js-->
	<script src="{{asset('assets/front/js/plugin.js')}}"></script>

	<script src="{{asset('assets/front/js/xzoom.min.js')}}"></script>
	<script src="{{asset('assets/front/js/jquery.hammer.min.js')}}"></script>
	<script src="{{asset('assets/front/js/setup.js')}}"></script>

	<script src="{{asset('assets/front/js/toastr.js')}}"></script>
	<!-- main -->
	<script src="{{asset('assets/front/js/main.js')}}"></script>
	<!-- custom -->
	<script src="{{asset('assets/front/js/custom.js')}}"></script>
	

	{!! $seo->google_analytics !!}

	@if($gs->is_talkto == 1)
	<!--Start of Tawk.to Script-->
	{!! $gs->talkto !!}
	<!--End of Tawk.to Script-->
	@endif

	@yield('scripts')

	

</body>

</html>