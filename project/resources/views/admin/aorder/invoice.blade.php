@extends('layouts.admin')

@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Order Invoice') }} <a class="add-btn" href="javascript:history.back();"><i
                            class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Orders') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Invoice') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="order-table-wrap">
        <div class="invoice-wrap">
            <div class="invoice__title">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="invoice__logo text-left">
                           <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo">
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a class="btn  add-newProduct-btn print" href="{{route('aorder.print',$aorder->id)}}"
                        target="_blank"><i class="fa fa-print"></i> {{ __('Print Invoice') }}</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row invoice__metaInfo mb-4">
                <div class="col-lg-6">
                    <div class="invoice__orderDetails">
                        
                        <p><strong>{{ __('Order Details') }} </strong></p>
                        <span><strong>{{ __('Invoice Number') }} :</strong> {{ sprintf("%'.08d", $aorder->id) }}</span><br>
                        <span><strong>{{ __('Order Date') }} :</strong> {{ date('d-M-Y',strtotime($aorder->created_at)) }}</span><br>
                        <span><strong>{{  __('Order ID')}} :</strong> 
                            {{ $aorder->order_number }}
                        </span><br>
                        <span> <strong>{{ __('Payment Method') }} :</strong> {{$aorder->shippingmethod}}</span>
                    </div>
                </div>
            </div>
            <div class="row invoice__metaInfo">
          
                <div class="col-lg-6">
                        <div class="invoice__shipping">
                            <p><strong>{{ __('Shipping Address') }}</strong></p>
                           <span><strong>{{ __('Customer Name') }}</strong>: 
                            {{$aorder->customer_name}}</span><br>

                           <span><strong>{{ __('Address') }}</strong>: 
                            {{ $aorder->customer_address }}</span><br>

                           <span><strong>{{ __('City') }}</strong>: 
                            {{ $aorder->customer_city }}</span><br>
                            <span><strong>{{ __('Phone') }}</strong>: {{ $aorder->customer_phone }}</span>

                        </div>
                </div>

           

                <div class="col-lg-6">
                        <div class="buyer">
                            <p><strong>{{ __('Billing Details') }}</strong></p>
                            <span><strong>{{ __('Customer Name') }}</strong>: {{ $aorder->customer_name}}</span><br>
                            <span><strong>{{ __('Address') }}</strong>: {{ $aorder->customer_address }}</span><br>
                            <span><strong>{{ __('City') }}</strong>: {{ $aorder->customer_city }}</span><br>

                            
                        </div>
                </div>
            </div>

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
<!-- Main Content Area End -->
</div>
</div>
</div>

@endsection