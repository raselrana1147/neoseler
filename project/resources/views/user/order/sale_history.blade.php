@extends('layouts.front')
@section('styles')
	<style type="text/css">
	.returned{
        background-color: red !important;
       }
    .declined {
      background-color:#DC143C !important;
    }
	</style>
@endsection
@section('content')


<section class="user-dashbord">
	<div class="container">
		<div class="row">
			@include('includes.user-dashboard-sidebar')
			<div class="col-lg-8">
				<div class="user-profile-details">
					<div class="order-history">
						<div class="header-area">
							<h4 class="title">
								{{ __('My Sales History') }}
							</h4>
						</div>
						<div class="mr-table allproduct mt-4">
							<div class="table-responsiv">
								<table id="example" class="table table-hover dt-responsive" cellspacing="0"
									width="100%">
									<thead>
										<tr>
											<th>{{ $langg->lang278 }}</th>
											<th>{{ $langg->lang279 }}</th>
											<th>{{ __('Total Amount') }}</th>
											<th>{{ __('Company Get') }}</th>
											<th>{{ __('My Commission') }}</th>
											<th>{{ $langg->lang281 }}</th>
											<th>{{ $langg->lang282 }}</th>
										</tr>
									</thead>
									<tbody>
										@foreach($orders as $order)
										<tr>
											<td>
												{{$order->order_number}}
											</td>
											<td>
												{{date('d M Y',strtotime($order->created_at))}}
											</td>
											<td>
											   {{ round($order->pay_amount * $order->currency_value , 2) }} TK
											</td>
											<td>
											   {{ round($order->company_get * $order->currency_value , 2) }} TK
											</td>
											<td>
											   {{ round($order->affilate_charge * $order->currency_value , 2) }} TK
											</td>
											<td>
												<div class="order-status {{ $order->status }}">
													{{ucwords($order->status)}}
												</div>
											</td>
											<td>
												<a href="{{route('user-order',$order->id)}}">
													{{ __('View') }}
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
</section>
@endsection