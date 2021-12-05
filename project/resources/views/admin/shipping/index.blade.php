@extends('layouts.admin') 

@section('content')  
          <input type="hidden" id="headerdata" value="{{ __('SHIPPING METHOD') }}">
          <div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Shipping Methods') }}</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                      </li>
                      <li>
                        <a href="javascript:;">{{ __('General Settings') }}</a>
                      </li>
                      <li>
                        <a href="{{ route('admin-shipping-index') }}">{{ __('Shipping Methods') }}</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="product-area">
              <div class="row">

                <div class="col-lg-12">
                  
                  <div class="mr-table allproduct">
                    <a href="#" class="btn btn success btn-sm getid" style="background: #1f224f;color: #fff;border-radius: 50px" data-toggle="modal"  data-target="#createship">
                      <i class="fas fa-plus"></i>Add 
                    </a>

                        @include('includes.admin.form-success')  

                    <div class="table-responsiv">
                                              <table id="afforders" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                          <thead>
                                <tr>
                                               <th>Location</th>
                                               <th>Price</th> 
                                               <th>Duration</th>
                                               <th>Ship type</th>
                                               <th>Action</th>
                                </tr>
                                          </thead>
                              {{-- ===body --}}
                              <tbody>
                               @foreach ($shipps as $sh)
                               <tr>
                                  <td>{{$sh->location}}</td>
                                  <td>{{$sh->price}} TK</td>
                                  <td>{{$sh->duration}}</td>
                                  <td>{{$sh->typeinfo->name}} </td>
                                 
                                  <td>

                                    <a href="#" class="btn btn success btn-sm getid" style="background: #1f224f;color: #fff;border-radius: 50px"><i class="fas fa-edit" shipid="{{$sh->id}}" data-toggle="modal"  data-target="#editDealModal-{{$sh->id}}"></i></a>

                                    <a href="{{route('admin-shipping-delete',$sh->id)}}" class="btn btn success btn-sm getid" style="background: #1f224f;color: #fff;border-radius: 50px" id="delete"><i class="far fa-trash-alt"></i></a>
                                    
                                  </td>
                               </tr>
                                  {{-- modal --}}
                               <div class="modal fade" id="editDealModal-{{$sh->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 70%">
                                   <div class="modal-content">
                                     <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Shipping</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                       </button>
                                     </div>
                                     <div class="modal-body">
                       <div style="padding: 100px">
                         <form action="{{route('admin-shipping-update',$sh->id)}}" method="POST">
                           
                             {{csrf_field()}}
                                   


                                     <div class="form-group">
                                       <input type="text" class="form-control" name="location"  required="" value="{{$sh->location}}">

                                     </div>
                                     <div class="form-group">
                                     </div>
                                     <div class="form-group">
                                      <input type="text" class="form-control" name="duration" required="" value="{{$sh->duration}}">
                                     </div>
                                     <div class="form-group">
                                      <input type="number" class="form-control" name="price" required="" value="{{$sh->price}}">
                                     </div>

                                     <div class="form-group">
                                        <label for="shiptype">Shipping type</label>
                                        <select class="form-control" name="shiptype_id">
                                          
                                          @php
                                             $types=DB::table('shiptypes')->get();
                                             
                                          @endphp
                                          @foreach($types as $type)
                                          <option value="{{$type->id}}" 
                                            {{ $type->id==$sh->shiptype_id ? 'selected="selected"' : ''}}>{{$type->name}}
                                          </option>

                                          @endforeach

                                        </select>
                                      </div>
                                    
                                      

                           <button type="submit" class="btn btn-primary">Update</button>
                         </form>
                       </div>
                     
                     </div>
                                     <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     </div>
                                   </div>
                                 </div>
                               </div>
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

          <!-- Modal -->


                       {{-- modal --}}
                    <div class="modal fade" id="createship" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 70%">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Create Shipping</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
            <div style="padding: 100px">
              <form action="{{route('admin-shipping-store')}}" method="POST">
                
                  {{csrf_field()}}
                        


                          <div class="form-group">
                            <input type="text" class="form-control" name="location"  required="" placeholder="Location">

                          </div>
                          <div class="form-group">
                          </div>
                          <div class="form-group">
                           <input type="text" class="form-control" name="duration" required="" placeholder="Duration (10-8) days">
                          </div>
                          <div class="form-group">
                           <input type="number" class="form-control" name="price" required="" placeholder="price">
                          </div>

                          <div class="form-group">
                             <label for="shiptype">Shipping type</label>
                             <select class="form-control" name="shiptype_id">
                               
                               @php
                                  $types=DB::table('shiptypes')->get();
                                  
                               @endphp
                               @foreach($types as $type)
                               <option value="{{$type->id}}">{{$type->name}}</option>

                               @endforeach

                             </select>
                           </div>
                         
                           

                <button type="submit" class="btn btn-primary">Create</button>
              </form>
            </div>
          
          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
          




{{-- ADD / EDIT MODAL --}}

                 {{--  <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                    
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="submit-loader">
                            <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
                        </div>
                      <div class="modal-header">
                      <h5 class="modal-title"></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                      <div class="modal-body">

                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                      </div>
                    </div>
                    </div>
                  </div>
 --}}



{{-- ADD / EDIT MODAL ENDS --}}


{{-- DELETE MODAL --}}

{{-- <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
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
            <p class="text-center">{{ __('You are about to delete this Shipping Method.') }}</p>
            <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
      </div>

    </div>
  </div>
</div> --}}

{{-- DELETE MODAL ENDS --}}

@endsection    

@section('scripts')


{{-- DATA TABLE --}}

<script type="text/javascript">
                     
                  
{{-- DATA TABLE ENDS--}}

</script>

@endsection   