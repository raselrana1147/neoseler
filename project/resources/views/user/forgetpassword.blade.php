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
                        <h4 class="title">{{ $langg->lang191 }} </h4>
                        <p class="text"> Please write your phone </p>
                    </div>
                    <div class="login-form">
                        @include('includes.admin.form-login')
                        <form  action="{{-- {{route('recoverpassword')}} --}}" method="POST">
                            {{ csrf_field() }}
                              <div class="form-input">
                              <input type="text" name="verifycode" class="User Name"placeholder="Enter 5 digits code">
                                <i class="fas fa-user-check"></i>
                             </div>
                             <div class="form-input">
                              <input type="password" name="password" class="User Name"placeholder="Enter new password">
                             <i class="icofont-ui-password"></i>
                             </div>
                            <div class="to-login-page">
                                <a href="{{ route('user.login') }}">
                                    {{ $langg->lang194 }}
                                </a>

                                 {{-- <a href="{{route('resendcode')}}" id="showresemdcode" class="badge badge-light">Resend code</a> --}}

                                    <div>
                                      <span style="display: none !important" id="send">
                                        <a href="{{route('resendcode')}}" id="showresemdcode" class="badge badge-light">Resend code</a>
                                        
                                    </span>
                                      <span id="show"><span>
                                    </div>

                            </div>
                            <input class="authdata" type="hidden" value="{{ $langg->lang195 }}">
                            <button type="submit" class="submit-btn">{{ $langg->lang196 }}</button>
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
<script src="{{asset('assets/rasel/js/lobibox.min.js')}}"></script>

    @if(Session::has('lobiboxsuccess'))
    <script>
        $(document).ready(function(){
           
           Lobibox.notify('success', {
            size: 'normal',
            rounded: false,
            delayIndicator: true,
            position: 'center top', 
            msg: "{{Session::get('lobiboxsuccess')}}"
        });

        });
    </script>
    @endif

    @if(Session::has('lobiboxerror'))
    <script>
        $(document).ready(function(){
           
           Lobibox.notify('error', {
            size: 'normal',
            rounded: false,
            delayIndicator: true,
            position: 'center top', 
            msg: "{{Session::get('lobiboxerror')}}"
        });

        });
    </script>
    @endif

  

@endsection

