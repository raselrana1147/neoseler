@extends('layouts.app')
@section('rrstyles')
	<style type="text/css">
		.our-program{
			font-size: 25px;
		    font-family: sans-serif;
		    font-weight: bold;
		    padding: 10px 0px
		}
	</style>
@endsection
@section('appcontent')

	<section class="blogpagearea">
			  <div class="container">
			  	 <h4 class="our-program">Our Mian Programs</h4>
			    <div id="ajaxContent">
	  	        @php
	  	        	
	  	        $get_reseller=array_search('reseller', array_column($metas->toArray(), 'meta_name'));
	  	        $get_shopping=array_search('shopping', array_column($metas->toArray(), 'meta_name'));
	  	        $get_merchant=array_search('merchant', array_column($metas->toArray(), 'meta_name'));
	  	        
	  	        @endphp
			      <div class="row">

			      	<div class="col-md-6 col-lg-4">
			      	  <div class="blog-box">
			      	    <div class="blog-images">
			      	      <div class="img">
			      	        <img
			      	          src="{{asset('assets/admin/meta/'.$metas[$get_shopping]['meta_value']) }}"
			      	          class="img-fluid" alt="" style="min-height: 200px; max-height: 200px;">
			      	        
			      	      </div>
			      	    </div>
			      	    <div class="details">
			      	        <h4 class="blog-title">
			      	         {{$metas[$get_shopping]['meta_title']}}
			      	        </h4>
			      	     
			      	      <p class="blog-text text-justify">
			      	      	{!!$metas[$get_shopping]['meta_content'] !!}
			      	      </p>
			      	      <a class="read-more-btn" href="{{ route('front.index') }}">Continue Shopping</a>
			      	    </div>
			      	  </div>
			      	</div>
			     
			        <div class="col-md-6 col-lg-4">
			          <div class="blog-box">
			            <div class="blog-images">
			              <div class="img">
			                <img
			                  src="{{asset('assets/admin/meta/'.$metas[$get_reseller]['meta_value']) }}"
			                  class="img-fluid" alt="" style="min-height: 200px; max-height: 200px;">
			              </div>
			            </div>
			            <div class="details">
			             
			                <h4 class="blog-title">
			                 {{$metas[$get_reseller]['meta_title']}}
			                </h4>
			             
			              <p class="blog-text text-justify">
			              	  {!!$metas[$get_reseller]['meta_content'] !!}
			               
			              </p>
			              <a class="read-more-btn" href="{{ route('user.register') }}">Become New Seller</a>
			            </div>
			          </div>
			        </div>

			       

			        <div class="col-md-6 col-lg-4">
			          <div class="blog-box">
			            <div class="blog-images">
			              <div class="img">
			                <img
			                  src="{{asset('assets/admin/meta/'.$metas[$get_merchant]['meta_value']) }}"
			                  class="img-fluid" alt="" style="min-height: 200px; max-height: 200px;">
			                
			              </div>
			            </div>
			            <div class="details">
			              
			                <h4 class="blog-title">
			                {{$metas[$get_merchant]['meta_title']}}
			                </h4>
			             
			              <p class="blog-text text-justify">
			                {!!$metas[$get_merchant]['meta_content'] !!}
			              </p>
			              <a class="read-more-btn" href="{{ route('merchant.apply') }}">Apply For Merchant</a>
			            </div>
			          </div>
			        </div>

			      </div>

			      <div class="page-center">
			       
			      </div>
			    </div>

			  </div>
			</section>

			<section class="partners">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="section-top">
								<h2 class="section-title">
									Our Top Merchants
								</h2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="partner-slider" >
								@foreach($merchants as $merchant)
								<div class="item-slide">
									<a href="#">
										<img src="{{asset('assets/images/admins/'.$merchant->avatar)}}" alt="" 
										style="min-width: 140px;max-width: 140px;min-height:140px;max-height: 140px;border-radius: 50% ">
										<span style="margin-left: 35px">
											<small>{{$merchant->name}}</small>
											
										</span>
										
									</a>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</section>

@endsection

@section('rrscripts')

@endsection
