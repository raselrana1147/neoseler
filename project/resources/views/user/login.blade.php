@extends('layouts.app')

@section('appcontent')

<section class="login-signup">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <nav class="comment-log-reg-tabmenu">

          @php
            $val=Session::get('rmessage')
          @endphp
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
            <div class="login-area">
              <div class="header-area">
                <h4 class="title">User</h4>
                <h6>Don't have an account? <a href="{{ route('user.register') }}">Sign Up</a></h6>
              </div>
              <div class="login-form signin-form">

                @include('error.error')

                <form action="{{ route('user.login.submit') }}" method="POST">
                  {{ csrf_field() }}

                  <div class="form-input">
                    <input type="text" name="phone" placeholder="Phone">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div class="form-input">
                    <input type="password" class="Password" name="password" placeholder="Password"
                      >
                    <i class="icofont-ui-password"></i>
                  </div>
                  
                  <input type="hidden" name="modal" value="1">
                  <input class="mauthdata" type="hidden" value="{{ $langg->lang177 }}">
                  <button type="submit" class="submit-btn">{{ $langg->lang178 }}</button>
                   <a href="{{route('user.register')}}" class="btn btn-link">No account yet ?</a>
                  <a href="{{route('showforgetform')}}" class="btn btn-link">Forget Password ?</a>
                </form>
              </div>
            </div>
          </div>

      
          
        </div>

      </div>

    </div>
  </div>
</section>

@endsection