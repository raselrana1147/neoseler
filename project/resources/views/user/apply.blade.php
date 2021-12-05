@extends('layouts.app')
@section('rrstyles')
   <style type="text/css">
        .rrradion{
          
          width: 50px !important;height: 15px !important
        }
        .rrowner{
          width: 300px;margin: 5px
        }
   </style>
@endsection

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
          

       {{--   ================== <registration part> =============--}}
          <div class="tab-pane fade show active "  role="tabpanel" aria-labelledby="nav-reg-tab">
            <div class="login-area signup-area">
              <div class="header-area">
               <h4 class="title">{{ __('Merchant Registration')}}</h4>
                <h6>Already have account? <a href="{{ route('admin.login')}}">Sign In</a></h6>
              </div>
              <div class="login-form signup-form">
              {{--   @include('includes.admin.form-login') --}}
               @include('error.error')
                <form action="{{ route('merchant.application.store') }}" method="POST">

                  {{ csrf_field() }}
                  <div class="form-input">
                    <input type="text"  name="name" placeholder="Name" required="">
                    <i class="icofont-user-alt-5"></i>
                  </div>

                  <div class="form-input">
                    <input type="text"  name="phone" placeholder="An active phone number" required="">
                    <i class="icofont-phone"></i>
                  </div>

                  <div class="form-input">
                    <input type="email"  name="email" placeholder="Valid email" required="">
                    <i class="icofont-email"></i>
                  </div>

                  <div class="form-input">
                    <input type="text"  name="bussinessname" placeholder="Your Business Name" required="">
                    <i class="icofont-home"></i>
                  </div>
                  <button type="submit" class="submit-btn">Apply Now</button>

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

@section('rrscripts')
  <script>
    $(document).ready(function(){

      $('#yesowner').on('click',function(){
       
        if ($(this).is(':checked')) {
          
          $('#ownerinfo').show();
          $('#shopname').attr('required', 'true');
          $('#location').attr('required', 'true');
          $('#businesstype').attr('required', 'true');
          $('#noowner').removeAttr('checked');
          $('#businessname').removeAttr('required');
          $('#noshopowner').hide();

        }else{

           $('#ownerinfo').hide();
           $('#shopname').removeAttr('required');
           $('#location').removeAttr('required');
           $('#businesstype').removeAttr('required');
        }
        //
        $('#noowner').on('click',function(){
          if ($(this).is(':checked')) {

              $('#noshopowner').show();
              $('#businessname').attr('required', 'true');
              $('#yesowner').removeAttr('checked');
              $('#ownerinfo').hide();
              $('#shopname').removeAttr('required');
              $('#location').removeAttr('required');
              $('#businesstype').removeAttr('required');

          }else{

             $('#noshopowner').hide();
             $('#businessname').removeAttr('required');
          }
        })
      });
      // check affiliate username

      $('#username').on("keyup",function(){
       
      var username=$(this).val();
  console.log(username);
      var value="";
      if (username !="") {
          $.get('http://localhost/oferri/affiliate-username/'+username,function(resposne){
                 var data=JSON.parse(resposne);
                 if (data.status==1) {
                  value="<span style='color:green'>"+data.msg+"</span>"
                 }else{
                   value="<span style='color:red'>"+data.msg+"</span>"
                 }

                 $("#usernamesstatus").html(value);
            });
      }else{
          value="";
          $("#usernamesstatus").html(value);
      }
    

      });///

    });
  </script>
@endsection