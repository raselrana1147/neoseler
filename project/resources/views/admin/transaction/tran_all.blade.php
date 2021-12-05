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
                                  <h4 class="heading">{{ __('Transaction History') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
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
                    <table id="transaction_history_list" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                    <thead>
                     <tr>
                        <th>{{__('Transaction Number')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Type')}}</th> 
                        <th>{{__('Transaction Date')}}</th>
                      </tr>
                    </thead>
     
             
                    <tfoot></tfoot>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
{{-- ADD / EDIT MODAL --}}


            
@endsection

@section('scripts')

    <script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>

<script type="text/javascript">
  
// Gallery Section Insert

 var table = $('#transaction_history_list').DataTable({
            ordering: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('transaction.index') }}',
            columns: [
                     { data: 'transid', name: 'Transaction Number' },
                     { data: 'amount', name: 'amount' },
                     { data: 'type', name: 'Type' },
                     { data: 'created_at', name:'created_at' }
                  ],
            language: {
               processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
             }
         });


</script>


<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection