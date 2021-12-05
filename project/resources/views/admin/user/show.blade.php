@extends('layouts.admin')

@section('styles')

<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}

</style>

@endsection

@section('content')

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __("Customer Details") }} <a class="add-btn" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{ __("Back") }}</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-user-index') }}">{{ __("Customers") }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-user-show',$data->id) }}">{{ __("Details") }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                            <div class="add-product-content customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                            <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="user-image">
                                                            @if($data->is_provider == 1)
                                                            <img src="{{ $data->photo ? asset($data->photo):asset('assets/images/'.$gs->user_image)}}" alt="No Image">
                                                            @else
                                                            <img src="{{ $data->photo ? asset('assets/images/users/'.$data->photo):asset('assets/images/'.$gs->user_image)}}" alt="No Image">                                            
                                                            @endif
                                                       {{--  <a href="javascript:;" class="mybtn1 send" data-email="{{ $data->email }}" data-toggle="modal" data-target="#vendorform">{{ __("Send Message") }}</a> --}}
                                                        <a href="javascript:;" class="mybtn1 send" data-email="{{ $data->email }}" data-toggle="modal" data-target="#vendorform">{{ __("Send Message") }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th>{{ __("ID#") }}</th>
                                                            <td>{{$data->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Name") }}</th>
                                                            <td>{{$data->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Email") }}</th>
                                                            <td>{!!$data->email !=null ? $data->email : "<span class='badge badge-danger'>Not added</span>" !!}</td>
                                                        </tr>
                                                        <tr>
                                                                <th>{{ __("Phone") }}</th>
                                                                <td>{{$data->phone}}</td>
                                                        </tr>
                                                        <tr>
                                                                <th>{{ __("Emergency Number") }}</th>
                                                                <td>{!!$data->emergency_number !=null ? $data->emergency_number : "<span class='badge badge-danger'>Not added</span>" !!}</td>
                                                        </tr>
                                                            <tr>
                                                                <th>{{ __("Address") }}</th>
                                                                <td>{{$data->address}}</td>
                                                            </tr>

                                                             <tr>
                                                                <th>{{ __("Facebook Page") }}</th>
                                                                <td>{!!$data->facebook_link !=null ? "<a href='".$data->facebook_link."' target='_blank'>Go to page</a>" : "<span class='badge badge-danger'>Not added</span>" !!}</td>
                                                            </tr>

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table">
                                                            
                                                            @if($data->city != null)
                                                            <tr>
                                                                <th>{{ __("City") }}</th>
                                                                <td>{{$data->city}}</td>
                                                            </tr>
                                                            @endif
                                                           
                                                            <tr>
                                                                <th>{{ __("Income Balance") }}</th>
                                                                <td>{{$data->incomebalance}} BDT</td>
                                                            </tr>
                                                
                                                           
                                                            <tr>
                                                                <th>{{ __("Shop Owner") }}</th>
                                                                <td>{{$data->is_shopowner}}</td>
                                                            </tr>
                                                            @if ($data->is_shopowner !=="No")
                                                               <tr>
                                                                  <th>{{ __("Business Name") }}</th>
                                                                   <td>{{$data->businessname}}</td>
                                                               </tr>

                                                               <tr>
                                                                  <th>{{ __("Business type") }}</th>
                                                                   <td>{{$data->businesstype}}</td>
                                                               </tr>

                                                                <tr>
                                                                  <th>{{ __("Shop Name") }}</th>
                                                                   <td>{{$data->shopname}}</td>
                                                               </tr>

                                                               <tr>
                                                                  <th>{{ __("Shop Location") }}</th>
                                                                   <td>{{$data->location}}</td>
                                                               </tr>

                                                               
                                                            @endif

                                                            <tr>
                                                                <th>{{ __("Selling Way") }}</th>
                                                                <td>
                                                                    
                                                                    @if ($data->selling_way =="1")
                                                                        {{'By Business'}}
                                                                    @elseif($data->selling_way =="2")
                                                                    {{'online Marketing'}}
                                                                    @else
                                                                    {{'Both of'}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Selling bonus") }}</th>
                                                                <td>{{$data->sellbonus}} BDT</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>{{ __("Joined") }}</th>
                                                                <td>{{$data->created_at->diffForHumans()}}</td>
                                                            </tr>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-table-wrap">
                                                <div class="order-details-table">
                                                    <div class="mr-table">
                                                        <h4 class="title">{{ __("Products Ordered") }}</h4>
                                                        <div class="table-responsive">
                                                                <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>{{ __("Order ID") }}</th>
                                                                            <th>{{ __("Purchase Date") }}</th>
                                                                            <th>{{ __("Amount") }}</th>
                                                                            <th>{{ __("Status") }}</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($data->orders as $order)
                                                                        <tr>
            <td><a href="{{ route('admin-order-invoice',$order->id) }}">{{sprintf("%'.08d", $order->id)}}</a></td>
                                                                            <td>{{ date('Y-m-d h:i:s a',strtotime($order->created_at)) }}</td>
                                                                            <td>{{ $order->currency_sign . round($order->pay_amount * $order->currency_value , 2) }}</td>
                                                                            <td>{{ $order->status }}</td>
                                                                            <td>
                                                                                <a href=" {{ route('admin-order-show',$order->id) }}" class="view-details">
                                                                                    <i class="fas fa-check"></i>{{ __("Details") }}
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                        
                                                                    </tbody>
                                                                </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __("Send Message") }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form action="{{ route('send.user.message') }}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="user_id" value="{{$data->id}}">
                                    <ul>
                                       {{--  <li>
                                            <input type="email" class="input-field eml-val" id="eml1" name="to" placeholder="{{ __("Email") }} *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj1" name="subject" placeholder="{{ __("Subject") }} *" required="">
                                        </li> --}}
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg1" placeholder="{{ __("Your Message") }} *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub1" type="submit">{{ __("Send Message") }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



           




            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

@endsection

@section('scripts')

<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>


@endsection