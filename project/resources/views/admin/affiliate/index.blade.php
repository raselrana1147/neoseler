@extends('layouts.admin') 

<?php
	function selltype($value){
		switch ($value) {
			case '1':
				echo 'Social Media marketing';
				break;
				case '2':
					echo 'Offline marketing';
				break;
				case '3':
				echo 'Both';
				break;
		}
	}	
  ?>
	
@section('content')  

			
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('Affiliate members') }}</h4>
										
								</div>
							</div>
							@include('admin.errors.error')
						</div>
						<div class="product-area">
							<div class="row">

								<div class="col-lg-12">
									<div class="mr-table allproduct">

                        

										<div class="table-responsiv">
												<table id="affilatetable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
										<thead>
					<tr>
                        <th width="10%">{{ __('Username') }}</th>
                        <th  width="10%">{{ __('Ref Username') }}</th>
                        <th  width="10%">{{ __('Facebook profile') }}</th>
                        <th  width="10%">{{ __('Sell Type') }}</th>
                        <th  width="10%">{{ __('Shop owner') }}</th>
                        <th  width="10%">{{ __('Actions') }}</th>
					</tr>
										</thead>
				{{-- ===body --}}
				<tbody>
			   @foreach ($amember as $member)
			   <tr>
				   	<td>{{$member->username}}</td>
				   	<td>
				   		
				   <?php
				   	  if ($member->ref_username !=""){
				   		
				   	?>
				   	{{$member->ref_username}}

				   	<?php }else{?>
						N/A
				   	<?php }?>


				   	</td>
				   	<td>{{$member->fbprofile}}</td>
				   	<td><?=selltype($member->sellmethod)?></td>
				   	<td class="dropdown">
				   	<?php
				   	  if ($member->usertype=="yes"){
				   		
				   	?>
			        <nav class="navbar navbar-expand-lg navbar-light bg-light">
			          

			          <div class="collapse navbar-collapse" id="navbarSupportedContent">
			            <ul class="navbar-nav mr-auto">
			              
			              
			              <li class="nav-item dropdown">
			                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #1f224f; color: #fff;width: 55px;">
			                  Yes
			                </a>
			                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background:#1f224f;width: 250px">
			                 	<p style="padding: 4px;color: #fff;margin: 0px">Shop Name: {{$member->shopname}}</p>
			                 	<p style="padding: 4px;color: #fff;margin: 0px">Location: {{$member->location}}</p>
			                 	<p style="padding: 4px;color: #fff;margin: 0px">Business: {{$member->businesstype}}</p>
			           
			                </div>
			              </li>
			              
			            </ul>
			            
			          </div>
			        </nav>
			         
				 <?php }else { ?>
				   		<span>No</span>
				   	<?php }?>
				   	</td>
				   	<td>
				   		<a href="#" class="btn btn-success btn-sm delete" style="background: #1f224f" id="{{$member->id}}">
				   			<i class="fas fa-trash-alt"></i>
				   		</a>

						@if ($member->active=='0')
							<a href="{{route('active.membership',$member->id)}}" class="btn btn-success btn-sm" style="background: #1f224f"><i class="fas fa-check-circle" ></i>
				   		</a>
				   		@else
				   		<span class="btn btn-success" style="background: #1f224f">Actived</span>
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



{{-- ADD / EDIT MODAL --}}

							

{{-- ADD / EDIT MODAL ENDS --}}


{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header d-block text-center">
		<h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	</div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center">{{ __('You are about to reject this member.') }}</p>
            <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>

            <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- DELETE MODAL ENDS --}}


@endsection    



@section('scripts')


{{-- DATA TABLE --}}

  <script type="text/javascript">

		$(document).ready( function () {
		    $('#affilatetable').DataTable();
		} );

		$(document).ready(function(){
			var id;
			$('.delete').click(function(){
				 id=$(this).attr('id');
				$('#confirm-delete').modal('show');
				
			});

			$('.btn-ok').click(function(){
				
				$.ajax({
					url:"http://localhost/oferri/reject-member/"+id,
					method:"GET",
					beforeSend:function(){
					   $('.btn-ok').text('Deleting...');
					},
					success:function(data){
						setTimeout(function(){
						   $('#confirm-delete').modal('hide');
						  // $('#affilatetable').DataTable().ajax.reload();
						   window.location.href = "{{URL::to('admin/affilates')}}"
						},20)
					}

				});

			});


		});	

			

</script>

{{-- DATA TABLE ENDS--}}

@endsection   