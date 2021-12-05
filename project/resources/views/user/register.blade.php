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
                <h4 class="title">{{ __('User Registration')}}</h4>
              </div>
              <div class="login-form signup-form">
              {{--   @include('includes.admin.form-login') --}}
               @include('error.error')
                <form action="{{route('user-register-submit')}}" method="POST">

                  {{ csrf_field() }}
                  <div class="form-input">
                    <input type="text"  name="name" placeholder="Name">
                    <i class="icofont-user-alt-5"></i>
                  </div>

                  <div class="form-input">
                    <input type="text"  name="phone" placeholder="An active phone number">
                    <i class="icofont-phone"></i>
                  </div>
                  
                  <div class="form-input">
                    <input type="text"  name="parentuser" placeholder="Enter Referal code (optional)">
                     <i class="icofont-user-alt-5"></i>
                  </div>


                  <div class="form-input">
                    <input type="password" class="Password" name="password" placeholder="Password">
                    <i class="icofont-ui-password"></i>
                  </div>

                  

                  <div class="form-input">
                     <label>How to you want to sell product ?</label><br>
                    <input type="radio" name="selling_way" class="rrradion" value="1" ><span>Social marking</span><br>
                    <input type="radio" name="selling_way" class="rrradion" value="2"><span>Ofline marking</span><br>
                    <input type="radio" name="selling_way" class="rrradion" value="3" checked=""><span>Both of</span>
                  </div>

                    <label>Are you shop owner ?</label><br>
                   <div class="form-check">

                      <input class="form-check-input" type="checkbox" id="yesowner"  name="is_shopowner" value="Yes">
                      <label class="form-check-label" for="yesowner">Yes</label>
                      <div style="margin-left: 50px;display: none" id="ownerinfo">
                        <input type="text" name="shopname" id="shopname" class="form-control rrowner"  placeholder="Shop name">
                        <input type="text" name="location" id="location" class="form-control rrowner" placeholder="Location">
                        <input type="text" name="businesstype" id="businesstype" class="form-control rrowner"  placeholder="Business type">
                      </div>

                      <input class="form-check-input" type="checkbox" id="noowner" name="is_shopowner" value="No">
                      <label class="form-check-label" for="noowner">No</label>

                      <div style="margin-left: 50px;display: none" id="noshopowner">
                        <input type="text" name="businessname" id="businessname" class="form-control rrowner"  placeholder="your business name">
                      
                      </div>
                    
                  </div>          

                  <button type="submit" class="submit-btn">Register Now</button>
                   <a href="{{route('user.login')}}" class="btn btn-link">Already Have Account ?</a>

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