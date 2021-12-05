@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            @include('includes.user-dashboard-sidebar')
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="account-info">
                        <div class="header-area">
                            <h4 class="title">
                               {{__('Edit Shop Details')}}
                            </h4>
                        </div>
                        <div class="edit-info-area">
                            <div class="body">
                                <div class="edit-info-area-form">
                                    <div class="gocover"
                                        style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                                    </div>
                                    <form id="usershop" action="{{route('user-shop-update')}}" method="POST"
                                        enctype="multipart/form-data">

                                        {{ csrf_field() }}

                                        @include('includes.admin.form-both')
                                       @if ($user->is_shopowner =='Yes')
                                           {{-- expr --}}
                                     
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="shopname" type="text" class="input-field"
                                                    placeholder="{{ __('Shop Name') }}" required=""
                                                    value="{{ $user->shopname }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <input name="location" type="text" class="input-field"
                                                    placeholder="{{ __("Location") }}" required=""
                                                    value="{{ $user->location }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="businesstype" type="text" class="input-field"
                                                    placeholder="{{ __('Business Type') }}" value="{{ $user->businesstype }}">
                                            </div>
                                                <div class="col-lg-6">
                                                   <input type="radio" name="selling_way" value="1" {{ ($user->selling_way)=='1'? 'checked' : ''}}> Social Marketing <br>
                                                    <input type="radio" name="selling_way" value="2" {{($user->selling_way)=='2' ? 'checked' : ''}}> Offline Marketing <br>
                                                    <input type="radio" name="selling_way" value="3" {{($user->selling_way)=='3'? 'checked' : ''}}> Both of
                                                </div> 
                                        </div>
                                          @else
                                          <div class="row">
                                              <div class="col-lg-6">
                                                  <input name="businessname" type="text" class="input-field"
                                                      placeholder="{{ __('Business Name') }}" required=""
                                                      value="{{ $user->businessname }}">
                                              </div>
                                              <div class="col-lg-6">
                                                 <input type="radio" name="selling_way" value="1" {{ ($user->selling_way)=='1'? 'checked' : ''}}> Social Marketing <br>
                                                  <input type="radio" name="selling_way" value="2" {{($user->selling_way)=='2' ? 'checked' : ''}}> Offline Marketing <br>
                                                  <input type="radio" name="selling_way" value="3" {{($user->selling_way)=='3'? 'checked' : ''}}> Both of
                                              </div> 
                                          </div> 
                                          @endif
                                        <div class="form-links">
                                            <button class="submit-btn" type="submit">{{ $langg->lang271 }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection