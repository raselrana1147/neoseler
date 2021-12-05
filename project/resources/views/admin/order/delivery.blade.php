@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')  
                      <form id="geniusformdata" action="{{route('admin-order-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                          <input type="hidden" name="ordernum" value="{{$data->order_number}}" id="ordernum">

                         

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Payment Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="payment_status" required="">
                                <option value="Pending" {{$data->payment_status == 'Pending' ? "selected":""}}>{{ __('Unpaid') }}</option>
                                <option value="Completed" {{$data->payment_status == 'Completed' ? "selected":""}}>{{ __('Paid') }}</option>
                              </select>
                          </div>
                        </div>



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Delivery Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="status" required="" id="statuschange">
                                <option value="pending" {{ $data->status == "pending" ? "selected":"" }}>{{ __('Pending') }}</option>
                                <option value="processing" {{ $data->status == "processing" ? "selected":"" }}>{{ __('Processing') }}</option>
                                <option value="on delivery" {{ $data->status == "on delivery" ? "selected":"" }}>{{ __('On Delivery') }}</option>
                                <option value="completed" {{ $data->status == "completed" ? "selected":"" }}>{{ __('Completed') }}</option>
                                <option value="declined" {{ $data->status == "declined" ? "selected":"" }}>{{ __('Declined') }}</option>
                                <option value="returned" {{ $data->status == "returned" ? "selected":"" }}>{{ __('Returned') }}</option>
                              </select>
                          </div>
                        </div>



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Track Note') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <textarea class="input-field" name="track_text" placeholder="{{ __('Enter Track Note Here') }}" id="statustext" >{{$data->order_note}}</textarea>
                          </div>
                        </div>



                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection

@section('scripts')

<script type="text/javascript">
  $(document).ready(function(){
    $('#statuschange').on('change',function(){
        var ordernum=$('#ordernum').val();
        var paystatus=$(this).val();

        var pendding="Congratulations! You have successfully placed your order from Afan Enterprise. Your order id is "+ordernum+". Soon we'll contact for confirming your order.";

        var processing="Dear customer, your order "+ordernum+" has been confirmed. Thanks for shopping with Afan Enterprise.";

        var completed="Dear customer, your order "+ordernum+" has delivered successfully. Thank you for choosing Afan Enterprise";

        var delivery="Dear customer, your order "+ordernum+" is sending through Sundarban courier service. Your tracking ID. Please follow the link for tracking your product lacation. Thank you.";

       var declined="Order "+ordernum+" has been cancled by admin form some internal problems. Afan Enterprise.";
       var returnorder="Order "+ordernum+" has been returned. Afan Enterprise.";

        if (paystatus =='pending') {
          $('#statustext').text(pendding);
        }else if(paystatus=='processing'){
          $('#statustext').text(processing);
        }else if(paystatus=='completed'){
          $('#statustext').text(completed);
        }else if(paystatus=='on delivery'){
          $('#statustext').text(delivery);
        }else if(paystatus=='declined'){
          $('#statustext').text(declined);
        }else if(paystatus=='returned'){
           $('#statustext').text(returnorder);
        }

        
    });
  });
</script>



@endsection

