<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{$seo->meta_keys}}">
        <meta name="author" content="GeniusOcean">

        <title>{{$gs->title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('assets/print/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
  <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}"> 
  <style type="text/css">
@page { size: auto;  margin: 0mm; }
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 287mm;
  }

html {

}
::-webkit-scrollbar {
    width: 0px;  /* remove scrollbar space */
    background: transparent;  /* optional: just make scrollbar invisible */
}
  </style>
</head>
<body onload="window.print();">
    <div class="invoice-wrap">
            <div class="invoice__title">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="invoice__logo text-left">
                           <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="invoice__metaInfo">
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

            <div class="invoice__metaInfo" style="margin-top:0px;">
               
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
<!-- ./wrapper -->

<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>

</body>
</html>
