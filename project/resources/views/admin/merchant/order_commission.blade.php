@extends('layouts.admin')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet"/>

@endsection
@section('content')
      
          <div class="content-area">
            <div class="mr-breadcrumb">
                            <div class="row">
                              <div class="col-lg-12">
                                  <h4 class="heading">{{ __('Order Commission') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                                  <ul class="links">
                                    <li>
                                      <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                    </li>
                                 
                                  
                                  </ul>
                              </div>
                               <h4><strong>Total Commission {{$total}}</strong></h4>
                            </div>
                            @include('admin.errors.validate')
                          </div>
            <div class="product-area">
              <div class="row">

                <div class="col-lg-12">
                  <div class="mr-table allproduct">

                    <div class="table-responsiv">
                    <table id="sell_history_list" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                    <thead>
                     <tr>
                        <th>S.No</th>
                        <th>Order Number</th>
                        <th>Total Commission</th> 
                      </tr>
                    </thead>
        {{-- ===body --}}
              <tbody>
         @foreach ($order_commissions as $commission)
               <tr>
                   <td>#{{$loop->index+1}}</td>
                   <td><a href="{{ route('admin-order-show',$commission->order_id) }}">{{$commission->order->order_number}}</a></td>
                   <td>{{$commission->commission}} TK</td>
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

            
@endsection

@section('scripts')

    <script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>

<script type="text/javascript">
  
// Gallery Section Insert

  $(document).on('click', '.remove-img' ,function() {
    var id = $(this).find('input[type=hidden]').val();
    $('#galval'+id).remove();
    $(this).parent().parent().remove();
  });

  $(document).ready( function () {
      $('#sell_history_list').DataTable();
  } );


</script>


<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection