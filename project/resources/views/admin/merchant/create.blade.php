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
                      <h4 class="heading">{{ __('Merchant Create') }} <a class="add-btn" href="{{ route('admin.dashboard') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                      <li>
                        <a href="{{ route('merchant.create') }}">{{ __('Merchant') }} </a>
                      </li>
                      
                       
                      </ul>
                  </div>

                </div>
                @include('admin.errors.validate')
              </div>
              <div class="add-product-content">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                            <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                            <form action="{{route('merchant.store')}}" method="POST">
                                {{csrf_field()}}
                            @include('includes.admin.form-both')
                             <input type="hidden" name="apply_id" value="{{$applicant->id}}">
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Name') }}* </h4>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <input type="text" class="input-field" placeholder="{{ __('Enter Merchant Name') }}" name="name" required="" value="{{$applicant->name}}">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Email') }}* </h4>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <input type="email" class="input-field" placeholder="{{ __('Enter Merchant email') }}" name="email" required="" value="{{$applicant->email}}">
                              </div>
                            </div>
                             <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Phone') }}* </h4>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <input type="text" class="input-field" placeholder="{{ __('Enter Merchant phone') }}" name="phone" required="" value="{{$applicant->phone}}">
                              </div>
                            </div>
                             <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Password') }}* </h4>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <input type="password" class="input-field" placeholder="{{ __('Enter Merchant password') }}" name="password" required="">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Company commission') }}* </h4>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <input type="number" class="input-field" placeholder="{{ __('Enter commission') }}" name="commission" required="" min="5" step="2" value="{{old('commission')}}">
                              </div>
                            </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                            </div>
                          </div>
                          <div class="col-lg-7 text-center">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create Merchant') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

    <div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Image Gallery') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="top-area">
            <div class="row">
              <div class="col-sm-6 text-right">
                <div class="upload-img-btn">
                      <label for="image-upload" id="prod_gallery"><i class="icofont-upload-alt"></i>{{ __('Upload File') }}</label>
                </div>
              </div>
              <div class="col-sm-6">
                <a href="javascript:;" class="upload-done" data-dismiss="modal"> <i class="fas fa-check"></i> {{ __('Done') }}</a>
              </div>
              <div class="col-sm-12 text-center">( <small>{{ __('You can upload multiple Images.') }}</small> )</div>
            </div>
          </div>
          <div class="gallery-images">
            <div class="selected-image">
              <div class="row">


              </div>
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

  $(document).on('click', '#prod_gallery' ,function() {
    $('#uploadgallery').click();
     $('.selected-image .row').html('');
    $('#geniusform').find('.removegal').val(0);
  });
                                        
                                
  $("#uploadgallery").change(function(){
     var total_file=document.getElementById("uploadgallery").files.length;
     for(var i=0;i<total_file;i++)
     {
      $('.selected-image .row').append('<div class="col-sm-6">'+
                                        '<div class="img gallery-img">'+
                                            '<span class="remove-img"><i class="fas fa-times"></i>'+
                                            '<input type="hidden" value="'+i+'">'+
                                            '</span>'+
                                            '<a href="'+URL.createObjectURL(event.target.files[i])+'" target="_blank">'+
                                            '<img src="'+URL.createObjectURL(event.target.files[i])+'" alt="gallery image">'+
                                            '</a>'+
                                        '</div>'+
                                  '</div> '
                                      );
      $('#geniusform').append('<input type="hidden" name="galval[]" id="galval'+i+'" class="removegal" value="'+i+'">')
     }

  });

// Gallery Section Insert Ends  

</script>

<script type="text/javascript">
  
$('.cropme').simpleCropper();
$('#crop-image').on('click',function(){
$('.cropme').click();
});
</script>


<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection