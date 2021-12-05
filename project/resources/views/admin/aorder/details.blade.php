@extends('layouts.admin')
     
@section('styles')

<style type="text/css">
    .order-table-wrap table#example2 {
    margin: 10px 20px;
}

</style>

@endsection


@section('content')
    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Affiliate Order Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Order Details') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>

            <div class="order-table-wrap">
                <div class="row">
                   <div class="col-lg-6">
                       <div class="special-box">
                           <div class="heading-area">
                               <h4 class="title">
                               {{ __('Order Details') }}
                               </h4>
                           </div>
                           <div class="table-responsive-sm">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th class="45%" width="45%">{{ __('Order ID') }}</th>
                                        <td width="10%">:</td>
                                        <td class="45%" width="45%">{{$aorder->order_number}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Total Product') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->quantity}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">${{ __('Total Cost') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->price+$aorder->shipping_cost}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Ordered Date') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{date('d-M-Y H:i:s a',strtotime($aorder->created_at))}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Payment Method') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->shippingmethod}}</td>
                                    </tr>

                                        <th width="45%">{{ __('Payment Status') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{!! $aorder->pay_status == 'unpaid' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>" !!}</td>

                                    </tbody>
                                </table>
                           </div>
                           <div class="footer-area">
                               <a href="{{ route('aorder.invoice',$aorder->id) }}" class="mybtn1"><i class="fas fa-eye"></i> {{ __('View Invoice') }}</a>
                           </div>
                       </div>
                   </div>

                   <div class="col-lg-6">
                       <div class="special-box">
                           <div class="heading-area">
                               <h4 class="title">
                               {{ __('Billing Details') }}
                               </h4>
                           </div>
                           <div class="table-responsive-sm">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th class="45%" width="45%">{{ __('Name') }}</th>
                                        <td width="10%">:</td>
                                        <td class="45%" width="45%">{{$aorder->customer_name}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Phone') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->customer_phone}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Address') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">${{$aorder->customer_address}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('City') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->customer_city}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Payment Method') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->shippingmethod}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Affiliate Username') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{$aorder->username}}</td>

                                    </tr>

                                    <tr>
                                        <th width="45%">{{ __('Comission') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">${{$aorder->commission}}</td>

                                    </tr>
                                        
                                    </tbody>
                                </table>
                           </div>
                       </div>
                   </div>
                    <div class="col-lg-6">
                       <div class="special-box">
                           <div class="heading-area">
                               <h4 class="title">
                               {{ __('Shipping Details') }}
                               </h4>
                           </div>
                           <div class="table-responsive-sm">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th class="45%" width="45%">{{ __('Name') }}</th>
                                        <td width="10%">:</td>
                                        <td class="45%" width="45%">{{$aorder->customer_name}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Phone') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->customer_phone}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Address') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->customer_address}}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('City') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{$aorder->customer_city}}</td>
                                    </tr>
                                        
                                    </tbody>
                                </table>
                           </div>
                       </div>
                   </div>

               </div>
           {{--  product details --}}

           <div class="row">
                   <div class="col-lg-12 order-details-table">
                       <div class="mr-table">
                           <h4 class="title">{{ __('Products Ordered') }}</h4>
                           <div class="table-responsiv">
                                   <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                       <thead>
                                           <tr>
               <tr>
                   <th width="10%">{{ __('Product ID#') }}</th>
                   <th width="30%">{{ __('Image') }}</th>
                   <th width="35%">{{ __('Product Title') }}</th>
                   <th width="10%">{{ __('Quantity') }}</th>

                   <th width="15%">{{ __('Total Price') }}</th>
               </tr>
                                           </tr>

                                       </thead>
                                       <tbody>
                                @php
                                   

                                @endphp
                  
                                        <tr>
                                            <td>{{$aorder->order_number}}</td>
                                            <td>
                                      <img src="{{asset('assets/images/products/'.$aorder->product->photo)}}" style="width: 100px">
                                            </td>
                                            <td>{{$aorder->product->name}}</td>
                                            <td>{{$aorder->quantity}}</td>
                                            <td>${{$aorder->price+$aorder->shipping_cost}}</td>
                                            
                                        </tr>
                         
             
                                       </tbody>
                                   </table>
                           </div>
                       </div>
                   </div>
                  
               </div>



                </div>



            </div>

                       
                   
          
         </div>

{{-- LICENSE MODAL --}}




{{-- LICENSE MODAL ENDS --}}

{{-- MESSAGE MODAL --}}


{{-- MESSAGE MODAL ENDS --}}

{{-- ORDER MODAL --}}

<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="submit-loader">
            <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
        </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">{{ __("You are about to update the order's status.") }}</p>
        <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- ORDER MODAL ENDS --}}


@endsection


@section('scripts')

@endsection