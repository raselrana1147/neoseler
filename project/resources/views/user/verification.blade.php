

@extends('layouts.app')
@section('rrstyles')
    <link rel="stylesheet" href="{{asset('assets/rasel/css/lobibox.min.css')}}">
@endsection

@section('appcontent')

<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="pages">
                    <li>
                        <a href="{{ route('front.index') }}">
                            {{ $langg->lang17 }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user-forgot') }}">
                            {{ $langg->lang190 }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<section class="login-signup forgot-password">
    <div class="container">
         @include('error.error')
        <div class="row justify-content-center">

            <div class="col-lg-5">
                <div class="login-area">
                    <div class="header-area forgot-passwor-area">
                        <h4 class="title">Active your account </h4>
                       
                    </div>
                    <div class="login-form">
                        @include('includes.admin.form-login')
                        <form  action="{{route('activeaccount')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-input">
                             <input type="text" name="verifycode" class="User Name"placeholder="Enter 5 digits code">
                                <i class="fas fa-phone"></i>
                            </div>
                           
                            <input class="authdata" type="hidden" value="{{ $langg->lang195 }}">
                            <button type="submit" class="submit-btn">Active Account</button>

                            {{-- <a href="{{route('resendcode')}}" id="showresemdcode" class="badge badge-light">Resend code</a> --}}

                            <div>
                              <span style="display: none !important" id="send">
                                <a href="{{route('resendcode')}}" id="showresemdcode" class="badge badge-light">Resend code</a>
                             </span>
                              <span id="show"><span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('rrscripts')
<script>
 //====make cown down function====
      var start=60;
      function timecount(){
         
          if(start > 0){
             start--;
        $('#show').text('Resend code within 0:'+start);
        if(start > 0){
             setTimeout('timecount()',1000);
        }
        if(start == 0){
         $('#send').show();
         $('#show').hide();
        }
      
     } 
    } 
 // invoke function
  $(window).on('load',function () {
        timecount();
     
 }); 
 
</script>
@endsection

