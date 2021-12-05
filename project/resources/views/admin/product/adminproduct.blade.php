@extends('layouts.admin') 
@section('styles')
 <script type="text/javascript" src="{{asset('assets/front/css/datatable.css')}}"></script>
@endsection
@section('content')  

			
					<div class="content-area">
						<div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __("All Products") }}</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
                      </li>
                      <li>
                        <a href="javascript:;">{{ __("Products") }} </a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
									<div class="mr-table allproduct">
										<div class="table-responsiv">
												<table id="myTable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
										<thead>
          					<tr>
                         <th>Serial</th>
                        <th>Product Owner</th>
                         <th>Name</th>
                         <th>Product ID</th> 
                         <th>Stock</th>
                         <th>Price</th>
                         <th>Status</th>
          					</tr>
										</thead>
				{{-- ===body --}}
				<tbody>
			   @foreach ($datas as $data)
			   <tr>
            <td>{{$loop->index+1}}</td>
             <td>{{$data->pro_owner}}</td>
				   	<td>{{$data->name}}</td>
            <td>{{$data->proid}}</td>
            <td>
                
               @if ($data->stock <=0 || $data->stock==null)
                 {{"Out of stock"}}
                   @elseif($data->stock>=1 && $data->stock <=5)
                 {{"Stock is Low"}}
                   @else
                 {{$data->stock}}
               @endif
            </td>
				   	<td>{{$data->price}} $</td>
				   	<td>
              @if ($data->status=="1")
               <span class="badge badge-success">{{__('Actived')}}</span> 
              @else
              <span class="badge badge-danger">{{__('Deactivated')}}</span> 
              @endif 
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


@endsection

@section('scripts')
 <script type="text/javascript" src="{{asset('assets/front/js/datatable.js')}}"></script>
 <script>
   $(document).ready( function () {
       $('#myTable').DataTable();
   } );
 </script>
@endsection   

