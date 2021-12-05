<!doctype html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="GeniusOcean">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Title -->
	<title>{{$gs->title}}</title>
	<!-- favicon -->
	<link rel="icon" type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}" />
	<!-- Bootstrap -->
	<link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
	<!-- Fontawesome -->
	<link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome.css')}}">
	<!-- icofont -->
	<link rel="stylesheet" href="{{asset('assets/admin/css/icofont.min.css')}}">
	<!-- Sidemenu Css -->
	<link href="{{asset('assets/admin/plugins/fullside-menu/css/dark-side-style.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/plugins/fullside-menu/waves.min.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/admin/css/plugin.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-coloroicker.css') }}">
	<!-- Main Css -->

	<!-- stylesheet -->
	@if(DB::table('admin_languages')->where('is_default','=',1)->first()->rtl == 1)

	<link href="{{asset('assets/admin/css/rtl/style.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/rtl/custom.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/rtl/responsive.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/common.css')}}" rel="stylesheet" />

	@else

	<link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/common.css')}}" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
	@endif
	 <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

	@yield('styles')

</head>

<body>
	
	<div class="page">
		<div class="page-main">
			<!-- Header Menu Area Start -->
			@include('layouts.admin.inc.header')
			<!-- Header Menu Area End -->
			<div class="wrapper">
				<!-- Side Menu Area Start -->
				@include('layouts.admin.inc.sidebar')
				<!-- Main Content Area Start -->
				@yield('content')
				<!-- Main Content Area End -->
			</div>
		</div>
	</div>

	@include("layouts.admin.inc.script")
</body>

</html>