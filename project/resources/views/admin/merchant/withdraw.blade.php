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
                                  <h4 class="heading">{{ __('Merchant Commission History') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                                  <ul class="links">
                                    <li>
                                      <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                    </li>
                                  <li>
                                    <a href="{{ route('merchant.create') }}">{{ __('Commission History') }} </a>
                                  </li>
                                  
                                  </ul>
                              </div>

                            </div>
                            @include('admin.errors.validate')
                          </div>
            <div class="product-area">
              <div class="row">

                <div class="col-lg-12">
                  <div class="mr-table allproduct">

                    <div class="table-responsiv">
                    <table id="merchantWithdrawllist" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                    <thead>
                     <tr>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Method</th> 
                        <th>Date</th>
                        <th>Status</th>
                         <th>Action</th>
          
                      </tr>
                    </thead>
        {{-- ===body --}}
              <tbody>
         @foreach ($withdraws as $withdraw)
               <tr>
                   <td>{{$withdraw->admin->phone}}</td>
                   <td>{{$withdraw->amount}} TK</td>
                   <td>{{$withdraw->method}}</td>
                    <td>{{$withdraw->created_at}}</td>
                    <td>{{$withdraw->status}}</td>
                    <td>
                      <a href="#" class="add-btn" data-target="#detailsWithdraw{{$withdraw->id}}" data-toggle="modal">
                        <i class="fas fa-eye"></i>Details</a>
                        @if ($withdraw->status=="pending")
                          {{-- expr --}}
                       
                        <a href="{{route('merchant.withdraw.reject',$withdraw->id)}}" id="reject"class="add-btn"><i class="fas fa-trash-alt"></i>Reject</a>

                        <a href="{{route('merchant.withdraw.accept',$withdraw->id)}}"  class="add-btn accept">  <i class="fas fa-check"></i> Accept</a>

                         @endif
                    </td>

                
               </tr>

               {{-- ADD / EDIT MODAL --}}
               {{-- ADD / EDIT MODAL ENDS --}}
               <!-- Modal -->
               <div class="modal fade" id="detailsWithdraw{{$withdraw->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 50%">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalScrollableTitle">Withdrawal Details Information</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                     <div class="modal-body">
                       <div >
                        @php
                          $with=App\Models\Withdraw::findOrFail($withdraw->id);
                        @endphp

                        <div class="card">
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <span><strong>Merchant Name: {{$with->admin->username}}</strong></span>
                            </li>
                             <li class="list-group-item">
                              <span><strong>Withdrwal Amount: {{$withdraw->amount}} Tk</strong></span>
                            </li>
                             <li class="list-group-item">
                              <span><strong>Withdrwal charge: {{$withdraw->fee}} Tk</strong></span>
                            </li>
                            <li class="list-group-item">
                              <span><strong>Withdrwal date: {{date('m D Y',strtotime($withdraw->created_at))}}</strong></span>
                            </li>
                            <li class="list-group-item">
                              <span><strong>Withdrwal Status: {{$withdraw->status}}</strong></span>
                            </li>
                             <li class="list-group-item">
                              <span><strong>Phone Number: {{$withdraw->admin->phone}}</strong></span>
                            </li>
                            <li class="list-group-item">
                              <span><strong>Wathdrawal Method: {{$withdraw->method}}</strong></span>
                            </li>
                             @if ($withdraw->method=="bank")
                            <li class="list-group-item">
                              <span><strong>Bank Name: {{$withdraw->bname}}</strong></span>
                            </li>
                             <li class="list-group-item">
                              <span><strong>Branch Name: {{$withdraw->branchname}}</strong></span>
                            </li>
                             <li class="list-group-item">
                              <span><strong>Account Holder: {{$withdraw->ahname}}</strong></span>
                            </li>
                             <li class="list-group-item">
                              <span><strong>Account No    : {{$withdraw->accountno}}</strong></span>
                            </li>
                            @else
                             <li class="list-group-item">
                              <span><strong>Bkash Number  : {{$withdraw->number}}</strong></span>
                            </li>
                            @endif
                           
                          </ul>
                        </div>
                          
                         
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
      $('#merchantWithdrawllist').DataTable();
  } );


</script>


<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection