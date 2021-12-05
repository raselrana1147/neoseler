@extends('layouts.admin')

@section('styles')
  <link href="{{asset('assets/admin/drofify/css/drofify.demo.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/drofify/css/drofify.min.css')}}" rel="stylesheet" />
@endsection

@section('scripts')
  <script src="{{asset('assets/admin/drofify/js/drofify.min.js')}}"></script>
  <script src="{{asset('assets/admin/drofify/js/more.js')}}"></script>
@endsection

@section('content')  
          <input type="hidden" id="headerdata" value="BANNER">
          <div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">Change Dynamic Text</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">Dashboard </a>
                      </li>
                      <li>
                        <a href="javascript:;">Dynamic text Settings</a>
                      </li>
                      <li>
                        <a href="{{ route('admin-featuredbanner-index') }}">Dynamic Content</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="product-area">
              <div class="row">
                @php
                 
                  $dynamic_content=array_search('dynamic_content', array_column($metas->toArray(), 'meta_name'));
              
                @endphp
                <div class="col-lg-12">
                  <div class="card-group">
                    <div class="card">
                      <p>{{$metas[$dynamic_content]['meta_content']}}</p>
                    
                     <div class="card-footer">
                         <span class="text-danger" data-toggle="modal" data-target="#dynamic_content"><i class="fas fa-edit"></i></span>
                     </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>





{{-- ADD / EDIT MODAL --}}

    <div class="modal fade" id="dynamic_content" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">             
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="submit-loader">
              <img  src="{{asset('assets/images/rasel/loader.gif')}}" alt="">
          </div>
        <div class="modal-header">
        <h4 class="modal-title">Change Shopping Content</h4>
        
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.change.merchant',$metas[$dynamic_content]['id']) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                  

                 
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Dynmaic Content</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                    <textarea class="input-field" rows="5" cols="60" required="" name="meta_content">{{$metas[$dynamic_content]['meta_content']}}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="submit" name="" value="Change" class="btn btn-secondary">
                    </div>
                  </div>

                </form>
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

@endsection   