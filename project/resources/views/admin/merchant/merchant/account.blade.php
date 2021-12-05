@extends('layouts.admin')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet"/>

@endsection
@section('content')
      @include('includes.admin.form-both')  
          <div class="content-area">
            <div class="mr-breadcrumb">
                            <div class="row">
                              <div class="col-lg-12">
                                  <h4 class="heading">{{ __('My Available Account') }} 
                                    <a class="add-btn" href=" javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                                  </h4>
                                  <ul class="links">
                                    <li>
                                      <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                    </li>
                              
                                  </ul>
                              </div>

                            </div>
                            @include('admin.errors.validate')
                          </div>
            <div class="product-area">
              <div class="row">

                <div class="col-lg-4">
                  <div style="min-height: 100px;padding: 12px;text-align: left;">
                     <h6 style="margin:0 auto"> <strong>Total Available Balance {!! number_format($admin->balance,2) !!}  TK</strong></h6>
                  </div>
                </div>
                 <div class="col-lg-4">
                  <div style="min-height: 300px;padding: 12px;text-align: center;">
                    <a class="add-btn" href="#" data-target="#merchantWithdrawal" data-toggle="modal"><i class="fas fa-rocket"></i> {{ __('Withdraw') }}</a>
                  </div>
                </div>
                 <div class="col-lg-4">
                  <div style="min-height: 300px;padding: 12px;text-align: left;">
                     <h6 style="margin:0 auto"> <strong>Total Pending Balance {!! number_format($pending_balance,2) !!}  TK</strong></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
{{-- ADD / EDIT MODAL --}}
{{-- ADD / EDIT MODAL ENDS --}}
<!-- Modal -->
<div class="modal fade" id="merchantWithdrawal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 50%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Merchant Withdrawal Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="padding: 50px">
          <form action="{{route('merchant.withdraw')}}" method="post">
            
              {{csrf_field()}}
              
             <div class="form-group">
               <input type="text" class="form-control" name="amount" placeholder="Amount" required="" value="{{old("amount")}}">
             </div>

             <div class="form-group">
              <p style="font-weight: bold;">Payment Method</p>
               <div class="form-check">
                <input class="form-check-input" type="checkbox" name="pmethod" style="display: block" id="bkash" value="bkash">

                Bkash personal <br>
                      <div id="mobileBanking" style="display: none">
                          <div class="form-group">
                              <input type="text" class="form-control"  placeholder="Bkash Account Number" name="phone" id="phone" >
                          </div>
                      </div>

                 <input class="form-check-input" type="checkbox" name="pmethod" id="bankAccount" style="display: block" value="bank">Bank
                 <div id="bankdetails" style="display: none">
                     <div class="form-group">
                         <input type="text" class="form-control"  placeholder="Bank Name" name="bname" id="bnamne" >
                     </div>
                     <div class="form-group">
                         <input type="text" class="form-control"  placeholder="Branch Name" name="branchname" id="branchname">
                     </div>
                     <div class="form-group">
                         <input type="text" class="form-control"  placeholder="Account Holder Name" name="ahname" id="ahname">
                     </div>
                     <div class="form-group">
                         <input type="text" class="form-control"  placeholder="Account Number" name="accountno" id="accountno">
                     </div>
                 </div>
              </div>
            </div>

            <button type="submit" class="btn btn-secondary">Withdraw</button>
          </form>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

            
@endsection

@section('scripts')

    <script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>

<script type="text/javascript">
  
// Gallery Section Inser

  $(document).ready( function () {
      
      $("#bankAccount").on('click',function () {
             if ($(this).is(":checked")) {

                 $("#bankdetails").show();
                 $('#bnamne').prop("required", true);
                 $('#branchname').prop("required", true);
                 $('#ahname').prop("required", true);
                 $('#accountno').prop("required", true);

                 $("#bkash").prop( "checked", false );
                 $("#mobileBanking").hide();
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
           $("#mobileBanking").show();
           $('#phone').prop("required", true);

          $("#bankAccount").prop( "checked", false );

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

            $("#mobileBanking").hide();
            $('#phone').prop("required",false);
             $('#phone').val("");
            
        }


      });
      
  } );
</script>

<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection