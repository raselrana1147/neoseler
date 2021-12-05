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
                                  <h4 class="heading">{{ __('Merchant Application') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                                  <ul class="links">
                                    <li>
                                      <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                    </li>
                                  <li>
                                    <a href="javascript;:">{{ __('Application List') }} </a>
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

                        @php
                          $username=Auth::guard('admin')->user()->username;
                          echo $username;
                        @endphp

                    <div class="table-responsiv">
                    <table id="merchant_application" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                    <thead>
                     <tr>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th> 
                          <th>Business Name</th>
                          <th>Action</th>
                       
                      </tr>
                    </thead>

                    <tfoot>
                     <tr>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th> 
                          <th>Business Name</th>
                          <th>Action</th>
                       
                      </tr>
                    </tfoot>
  
            
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
  
// Gallery Section Inser

 var table = $('#merchant_application').DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin-merchant-apply','none') }}',
        columns: [
                 { data: 'name', name: 'name' },
                 { data: 'phone', name: 'phone' },
                 { data: 'email', name: 'email' },
                 { data: 'businessname', name: 'businessname' },
                 { data: 'action', searchable: false, orderable: false },
                
              ],
        language : {
             processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
         },
         drawCallback : function( settings ) {
                 $('.select').niceSelect();  
         }
     });
       
</script>

<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection