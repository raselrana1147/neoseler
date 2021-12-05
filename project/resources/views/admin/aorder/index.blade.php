@extends('layouts.admin') 

	
@section('content')  

			
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('Affiliate orders') }}</h4>
										
								</div>
							</div>
							{{-- @include('admin.errors.error') --}}
						</div>
						<div class="product-area">
							<div class="row">

								<div class="col-lg-12">
									<div class="mr-table allproduct">

                        

										<div class="table-responsiv">
												<table id="afforders" class="table table-hover dt-responsive" cellspacing="0" width="100%">
										<thead>
					<tr>
                        <th>Name</th>
                        <th>Type</th> 
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Status</th>
                
					</tr>
										</thead>
				{{-- ===body --}}
				<tbody>
			   @foreach ($orders as $order)
			   <tr>
				   	<td>{{$order->order_number}}</td>
				   	<td>{{$order->price}} $</td>
				   	<td>{{$order->quantity}}</td>
				   	<td>{{$order->commission}} $</td>
				   
				   	<td>

				   		<a href="{{route('aorder.details',$order->id)}}" class="btn btn success btn-sm" style="background: #1f224f;color: #fff;border-radius: 50px"><i class="fas fa-eye"></i> Details</a>

				   		<a href="#" class="btn btn success btn-sm orderstatus" style="background: #1f224f;color: #fff;border-radius: 50px" orderid="{{$order->id}}" orderstatus="{{$order->order_stutus}}" paystatus="{{$order->pay_status}}" data-toggle="modal" data-target="#ordermodal">$ Delivary Status</a>


				   		
				   	</td>
			   </tr>
				@endforeach
				</tbody>
										<tfoot></tfoot>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>



{{-- ADD / EDIT MODAL --}}

							

{{-- ADD / EDIT MODAL ENDS --}}




<!-- Modal -->
<div class="modal fade" id="ordermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 70%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">DELIVERY STATUS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div style="padding: 100px">
      		<form action="{{route('update.aff.orderstatus')}}" method="POST">
      			 {{csrf_field()}}
      			<input type="hidden" id="oid" value="" name="oid">
      		  <div class="form-group">
      		   <label for="exampleFormControlSelect1">Payment Status</label>
      		      <select class="form-control" id="" name="pay_status">
                  <option value="unpaid" id="unpaidid">Unpaid</option>
      		        <option value="paid" id="paidid">Paid</option>
      		      </select>
      		  </div>

      		  <div class="form-group">
      		   <label for="exampleFormControlSelect1">Delivery Status</label>
      		      <select class="form-control" id="" name="delivery_status">
      		        <option value="pending" id="penid">Pending</option>
      		        <option value="processing" id="proid">Processing</option>
      		        <option value="on delivery" id="delid">On Delivery</option>
      		        <option value="completed" id="comid">Completed</option>
      		        <option value="declined" id="deid">Declined</option>
      		      </select>
      		  </div>
      		  
      		  
      		  <button type="submit" class="btn btn-primary" style="background: #1f224f;color: #fff;">Save</button>
      		</form>
      	</div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- DELETE MODAL ENDS --}}


@endsection    



@section('scripts')



 <script type="text/javascript" src="{{asset('assets/front/js/datatable.js')}}"></script>
{{-- DATA TABLE --}}

  <script>
    $(document).ready(function() {
        $('#afforders').DataTable();
    } );
  </script>
  <script type="text/javascript">
  	$(document).ready(function(){
  		$('body').on('click','.orderstatus',function(){
  		     var order=$(this).attr('orderid');
  		  
  		    $('#oid').attr('value',order);
  		    var orderstatus=$(this).attr('orderstatus');

  		    if (orderstatus=="pending") {
  		    	$('#penid').attr('selected',true);
  		    }else if(orderstatus=="processing"){
  		    	$('#proid').attr('selected',true);
  		    }else if(orderstatus=="on delivery"){
  		    	$('#delid').attr('selected',true);
  		    }else if(orderstatus=="completed"){
  		    	$('#comid').attr('selected',true);
  		    }else if(orderstatus=="declined"){
  		    	$('#deid').attr('selected',true);
  		    }
  		    var paystatus=$(this).attr('paystatus');
  		    if (paystatus=="paid") {
  		    	$('#paidid').attr('selected',true);
  		    }else if(paystatus=="unpaid"){
  		    	$('#unpaidid').attr('selected',true);
  		    }

  		});
  	});
  </script>

  


{{-- DATA TABLE ENDS--}}

@endsection   

