@extends('layouts.app')
@section('appcontent')
<div class="row">
	<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
	    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
	    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner">

	  	@if(count($sliders)>0)
	  	@foreach($sliders as $slider)
			<div class="carousel-item {{($loop->index)==1 ? 'active' : ''}}">
			  <img src="{{asset('assets/images/sliders/'.$slider->photo)}}" class="d-block w-100" alt="..." style="max-height: 600px">
			  <div class="carousel-caption d-none d-md-block">
			    <h5>{{$slider->subtitle_text}}</h5>
			    <p>{{$slider->title_text}}</p>
			  </div>
			</div>
			@endforeach
	  	@endif

	    

	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</div>
<div class="row" style="margin:10px 0px">
	<div class="col-md-4 col-lg-4 col-sm-12">
		<!-- Card -->
		<div class="card">
		 

		  
		  <div class="text-white text-center d-flex align-items-center rgba-black-strong py-5 px-4">
		    <div>
		      <h5 class="pink-text"><i class="fas fa-chart-pie"></i> Marketing</h5>
		      <h3 class="card-title pt-2"><strong>This is the card title</strong></h3>
		      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fugiat, laboriosam, voluptatem,
		        optio vero odio nam sit officia accusamus minus error nisi architecto nulla ipsum dignissimos.
		        Odit sed qui, dolorum!.</p>
		      <a class="btn btn-pink"><i class="fas fa-clone left"></i> View project</a>
		    </div>
		  </div>

		</div>
		<!-- Card -->
	</div>
	<div class="col-md-4 col-lg-4 col-sm-12">
		<!-- Card -->
		<div class="card" style="max-height: 310px">
		  <div class="text-white text-center d-flex align-items-center rgba-black-strong py-5 px-4">
		    <div>
		      <h5 class="pink-text"><i class="fas fa-chart-pie"></i> Marketing</h5>
		      <h3 class="card-title pt-2"><strong>This is the card title</strong></h3>
		      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fugiat, laboriosam, voluptatem,
		        optio vero odio nam sit officia accusamus minus error nisi architecto nulla ipsum dignissimos.
		        Odit sed qui, dolorum!.</p>
		        <p>
		        	<a href="{{ route('user.register') }}" class="sign-log" style="font-size: 20px;font-weight: bold;color: #0f78f2;">
		        	  <span class="join">{{__('Sing up') }}</span>
		        	</a>
		        </p>
		      <a class="btn btn-pink"><i class="fas fa-clone left"></i> View project</a>
		    </div>
		   
		  </div>
				
		</div>
		<!-- Card -->
	</div>
	<div class="col-md-4 col-lg-4 col-sm-12">
		<!-- Card -->
		<div class="card">
		

		
		  <div class="text-white text-center d-flex align-items-center rgba-black-strong py-5 px-4">
		    <div>
		      <h5 class="pink-text"><i class="fas fa-chart-pie"></i> Marketing</h5>
		      <h3 class="card-title pt-2"><strong>This is the card title</strong></h3>
		      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fugiat, laboriosam, voluptatem,
		        optio vero odio nam sit officia accusamus minus error nisi architecto nulla ipsum dignissimos.
		        Odit sed qui, dolorum!.</p>
		      <a class="btn btn-pink"><i class="fas fa-clone left"></i> View project</a>
		    </div>
		  </div>

		</div>
		<!-- Card -->
	</div>
</div>

@endsection