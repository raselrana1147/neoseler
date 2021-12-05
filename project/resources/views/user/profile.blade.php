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
                                {{ $langg->lang262 }}
                            </h4>
                        </div>
                        <div class="edit-info-area">

                            <div class="body">
                                <div class="edit-info-area-form">
                                    <div class="gocover"
                                        style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                                    </div>
                                    <form id="userform" action="{{route('user-profile-update')}}" method="POST"
                                        enctype="multipart/form-data">

                                        {{ csrf_field() }}

                                        @include('includes.admin.form-both')
                                        <div class="upload-img">
                                            @if($user->is_provider == 1)
                                            <div class="img"><img
                                                    src="{{ $user->photo ? asset($user->photo):asset('assets/images/'.$gs->user_image) }}">
                                            </div>
                                            @else
                                            <div class="img"><img
                                                    src="{{ $user->photo ? asset('assets/images/users/'.$user->photo):asset('assets/images/'.$gs->user_image) }}">
                                            </div>
                                            @endif
                                            @if($user->is_provider != 1)
                                            <div class="file-upload-area">
                                                <div class="upload-file">
                                                    <input type="file" name="photo" class="upload">
                                                    <span>{{ $langg->lang263 }}</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="name" type="text" class="input-field"
                                                    placeholder="{{ $langg->lang264 }}" required=""
                                                    value="{{ $user->name }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <input name="phone" type="text" class="input-field"
                                                    placeholder="{{ $langg->lang266 }}" required=""
                                                    value="{{ $user->phone }}" disabled="true">
                                            </div>
                                        
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="city" type="text" class="input-field"
                                                    placeholder="{{ $langg->lang268 }}" value="{{ $user->city }}">
                                            </div>

                                            
                                                <div class="col-lg-6">
                                                    <textarea class="input-field" name="address" required=""
                                                        placeholder="{{ $langg->lang270 }}">{{ $user->address }}</textarea>
                                                </div> 
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="email" type="text" class="input-field"
                                                    placeholder="{{ __('Email') }}"
                                                    value="{{ $user->email }}">
                                            </div>

                                             <div class="col-lg-6">
                                                <input name="emergency_number" type="text" class="input-field"
                                                    placeholder="{{ __('Emergency Number') }}"
                                                    value="{{ $user->emergency_number }}">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input name="businessname" type="text" class="input-field"
                                                    placeholder="{{ __('Business Name') }}"
                                                    value="{{ $user->businessname }}">
                                            </div>
                                            
                                             <div class="col-lg-6">
                                                <input name="facebook_link" type="url" class="input-field"
                                                    placeholder="{{ __('Facebook Link') }}"
                                                    value="{{ $user->facebook_link }}">
                                            </div>

                                             
                                        </div>

                                       

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