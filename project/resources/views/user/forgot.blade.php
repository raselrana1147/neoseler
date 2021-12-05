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
                        <form  action="{{route('user-forgot-submit')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-input">
                             <input type="text" name="phone" class="User Name"placeholder="Phone">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="to-login-page">
                                <a href="{{ route('user.login') }}">
                                    {{ $langg->lang194 }}
                                </a>
                            </div>
                            <input class="authdata" type="hidden" value="{{ $langg->lang195 }}">
                            <button type="submit" class="submit-btn">Send Code</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('rrscripts')
<script src="{{asset('assets/rasel/js/lobibox.min.js')}}"></script>

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

