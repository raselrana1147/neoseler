@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            @include('includes.user-dashboard-sidebar')
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="account-info">
                        <div class="header-area">
                            <h4 class="title">
                                Apply Affiliate Membership
                            </h4>
                            @include('error.error');
                        </div>
                        <div class="edit-info-area">
                
        <div class="body">
            <form action="{{route('store.affilate.user')}}" method="POST">
                {{csrf_field()}}
              <div class="row">
                  <div class="col-lg-6">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                    <div class="form-group">
                        <input type="text" class="form-control"  placeholder="username" name="username" id="username" value="{{old('username')}}">
                        <span id="displaymessage"></span>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control"  placeholder="referel username (optional)" name="ref_username" id="ref_username" value="{{old('ref_username')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control"  placeholder="facebook profile link" name="fbprofile" id="fbprofile" value="{{old('fbprofile')}}">
                    </div>
                    
                  </div>
                  <div class="col-lg-6">
                      <div class="form-group">
                        <p style="font-weight: bold;">How do you want to sell our products ?</p>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="sellmethod" id="" value="1" > Social Media Marketing
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="sellmethod" id="" value="2" > Offline Marketing
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="sellmethod" id="" value="3" > Both
                        </div>
                      </div>

                       <div class="form-group">
                        <p style="font-weight: bold;">Are you a Shop owner ?</p>
                         <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="usertype" style="display: block" id="yesowner" value="yes">Yes <br>
                                <div id="ownerinfo" style="display: none">
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Shop name" name="shopname" id="shopname" >
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Location" name="location" id="location">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control"  placeholder="Business  type" name="businesstype" id="businesstype">
                                    </div>
                                </div>
                           <input class="form-check-input" type="checkbox" name="usertype" id="noowner" style="display: block" value="no">No
                        </div>
                      </div>
                  </div>
              </div>
             
             
              <button type="submit" class="btn btn-primary">Apply Now</button>
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

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#username').keyup(function(){
               //e.preventDefault();
            var username=$(this).val();

            var value="";
            if (username !="") {
                $.get('http://localhost/oferri/check-affiliate-username/'+username,function(resposne){
                       var data=JSON.parse(resposne);
                       if (data.status==1) {
                        value="<span style='color:green'>"+data.msg+"</span>"
                       }else{
                         value="<span style='color:red'>"+data.msg+"</span>"
                       }

                       $("#displaymessage").html(value);
                  });
            }else{
                value="";
                $("#displaymessage").html(value);
            }
            


            // $.ajax({
            //   method: "GET",
            //   url: "http://localhost/oferri/check-affiliate-username/",
            //   data: {username:username},
            //   contentType:false,
            //   cache: false,
            //   processData: false,
            //   success: function (data) {
            //     console.log(data);
            //   }

            // });

            });///

                $("#yesowner").click(function () {
                       if ($(this).is(":checked")) {
                           $("#ownerinfo").show();
                           $('#shopname').attr("required", "true");
                           $('#location').attr("required", "true");
                           $('#businesstype').attr("required", "true");

                           //$("#noowner").hide();
                       } else {
                           $("#ownerinfo").hide();
                           //$("#noowner").show();
                           $('#shopname').removeAttr("required");
                           $('#location').removeAttr("required");
                           $('#businesstype').removeAttr("required");
                       }
                   });
   
        });
    </script>
@endsection