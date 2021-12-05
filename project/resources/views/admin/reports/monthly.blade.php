@extends('layouts.admin') 

@section('content')  
					
		<div class="content-area">
			<div class="mr-breadcrumb">
				<div class="row">
					<div class="col-lg-12">
						<h4 class="heading">{{ __('Daily Reports') }}</h4>
						<h5>Total orders: {{$totalorder}}</h5>	
						<span><strong>From {{date('F-d-Y')}} to {{date('F-d-Y',strtotime('-30 days'))}}</strong></span>
						
						
					</div>
				</div>
				@include('admin.errors.error')
			</div>
			<div class="product-area" style="padding: 20px">
				<div >
					<form  style="width: 100%" class="row" action="{{route('custom.report')}}" method="POST">
						{{csrf_field()}}
					  <div class="form-group col-sm-4" style="margin-bottom: margin-bottom: 0px;">
					    <input type="text" class="form-control" style="padding: 0px" placeholder="Start date" id="rrstartdate" name="rrstartdate" required="">
					  </div>
					  <div class="form-group col-sm-4">
					    <input type="text" class="form-control" style="padding: 0px" style="margin-bottom: margin-bottom: 0px;" placeholder="End date" id="rrenddate" name="rrenddate" required="">
					  </div>
					  <button type="submit" class="btn btn-primary btn-sm col-sm-4" style="height: 27px;padding: 0px;">Generate report</button>
					</form>
				</div>
				<table class="table table-bordered" id="dailyreport">
				  <thead>

				    <tr>
				      <th scope="col">Order ID</th>
				      <th scope="col">Price</th>
				      <th scope="col">Quantity</th>
				      <th scope="col">Shipping charge</th>
				  	   <th scope="col">Sub total</th>
				      <th scope="col">View order</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($orders as $order)
				    <tr>
				      <th scope="row">{{$order->order_number}}</th>
				      <td>{{number_format($order->pay_amount,2)}} TK</td>
				      <td>{{$order->totalQty}}</td>
				      <td>{{$order->shipping_cost}} Tk</td>
				      <td>{{$order->coupon_discount}} TK</td>
				      <td>{{$order->pay_amount+$order->shipping_cost+$order->coupon_discount}} TK</td>
				      <td>
				      	<a href="{{route('admin-order-show',$order->id)}}" title="View this order"><i class="fas fa-eye"></i></a>
				      </td>
				      
				    </tr>
				    @endforeach

				   
				  </tbody>
				   <tr>
				      <td ></td>
				      <td ></td>
				      <td>	<strong>Total Quantity: {{$totalqun}}
				      </strong></td>
				      <td></td>
				      <td></td>
				      <td ><strong>In Total: {{$grandtotal}} TK </strong></td>
				      <td ></td>
				      
				    </tr>
				    
				  <tfoot></tfoot>
				</table>
			</div>

		</div>

@endsection    



@section('scripts')

{{-- DATA TABLE --}}


    <script type="text/javascript">
			$(document).ready( function () {
			    $('#dailyreport').DataTable();
			} );

						
    </script>

{{-- DATA TABLE --}}
    
@endsection   