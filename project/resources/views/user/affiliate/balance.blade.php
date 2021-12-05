@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
      @include('error.error')
        <div class="row">
            @include('includes.user-dashboard-sidebar')

            <div class="col-lg-8">

                <div class="user-profile-details">
                    <div class="account-info">
                        <div class="header-area">
                            <h4 class="title">
                                Affiliate Balance
                        
                            </h4>
                        </div>
                        <div class="edit-info-area">
                            <div class="body">
                                <div class="edit-info-area-form">
                                   <h5 style="font-size: 18px;font-weight: bold;">Available Balance: {{$income_balance}} TK</h5>
                                   <h5 style="font-size: 18px;font-weight: bold;">Pending Balance: {{$pending_balance}} TK</h5>
                                </div>
                            </div>
                            <button class="btn btn-primary" style="position: absolute;right: 40px;top: 12px;"  data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-plus"></i> Withdraw Balance</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Button trigger modal -->
    

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Withdraw Balance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
                      <form action="{{route('affilate.withdraw')}}" method="post">
                        
                          {{csrf_field()}}
                          
                         <div class="form-group">
                           <input type="text" class="form-control" name="amount" placeholder="Amount" required="" value="{{old("amount")}}">
                         </div>

                         <div class="form-group">
                          <p style="font-weight: bold;">Payment Method</p>
                           <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pmethod" style="display: block" id="bkash" value="bkash">

                            Bkash personal <br>
                                  <div id="phonenumber" style="display: none">
                                      <div class="form-group">
                                          <input type="text" class="form-control"  placeholder="Bkash number" name="phone" id="phone" >
                                      </div>
                                  </div>

                             <input class="form-check-input" type="checkbox" name="pmethod" id="bankinfo" style="display: block" value="bank">Bank
                             <div id="bankdetails" style="display: none">
                                 <div class="form-group">
                                     <input type="text" class="form-control"  placeholder="Bank name" name="bname" id="bnamne" >
                                 </div>
                                 <div class="form-group">
                                     <input type="text" class="form-control"  placeholder="Branch name" name="branchname" id="branchname">
                                 </div>
                                 <div class="form-group">
                                     <input type="text" class="form-control"  placeholder="Account holder name" name="ahname" id="ahname">
                                 </div>
                                 <div class="form-group">
                                     <input type="text" class="form-control"  placeholder="Account number" name="accountno" id="accountno">
                                 </div>
                             </div>
                          </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Withdraw</button>
                      </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
          </div>
        </div>
      </div>
    </div>

</section>

@section('scripts')
<script>
  $(document).ready(function(){

    $("#bankinfo").on('click',function () {
           if ($(this).is(":checked")) {

               $("#bankdetails").show();
               $('#bnamne').prop("required", true);
               $('#branchname').prop("required", true);
               $('#ahname').prop("required", true);
               $('#accountno').prop("required", true);

               $("#bkash").prop( "checked", false );
               $("#phonenumber").hide();
               $('#phone').prop("required",false);
               $('#phone').val("");

           }else {

               $("#bankdetails").hide();
               $('#bnamne').prop("required",false);
               $('#branchname').prop("required",false);
               $('#ahname').prop("required");
               $('#accountno').prop("required",false);

               $('#bnamne').val("");
               $('#branchname').val("");
               $('#ahname').val("");
               $('#accountno').val("");
           }
       });


    $('#bkash').on('click',function(){

      if ($(this).is(":checked")) {
         $("#phonenumber").show();
         $('#phone').prop("required", true);

        $("#bankinfo").prop( "checked", false );

         $("#bankdetails").hide();
         $('#bnamne').prop("required",false);
         $('#branchname').prop("required",false);
         $('#ahname').prop("required",false);
         $('#accountno').prop("required",false);


               $('#bnamne').val("");
               $('#branchname').val("");
               $('#ahname').val("");
               $('#accountno').val("");

      } else {

          $("#phonenumber").hide();
          $('#phone').prop("required",false);
           $('#phone').val("");
          
      }


    });
    


  });
</script>
@endsection

@endsection