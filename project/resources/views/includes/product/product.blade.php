<div class="col-lg-4 col-md-4 col-6 remove-padding">


	<a href="{{ route('front.product', $prod->slug) }}" class="item">
		<div class="item-img">
				
			@if(!empty($prod->features))
			<div class="sell-area">
				@foreach($prod->features as $key => $data1)
				<span class="sale" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
				@endforeach
			</div>
			@endif
			<img class="img-fluid"
				src="{{ $prod->photo ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}"
				alt="">
		</div>
		<div class="info">
			<h5 class="name">{{ $prod->showName() }}</h5>
			<h4 class="price">{{ $prod->setCurrency() }} <del><small>{{ $prod->showPreviousPrice() }}</small></del></h4>
			<div class="stars">
				<div class="ratings">
					<div class="empty-stars"></div>
					<div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
				</div>
			</div>
			<div class="item-cart-area">
				<ul class="item-cart-options">
				    <li>
							@if(Auth::guard('web')->check())

							<span href="javascript:;" class="add-to-shop"
								data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip"
								data-placement="top" title="{{ __('Add to Wishlist') }}"><i
									class="icofont-heart-alt"></i>
							</span>

							@else

							<span href="javascript:;" rel-toggle="tooltip" title="{{ __('Add to Wishlist') }}"
								data-toggle="modal" id="shop-btn" data-target="#comment-log-reg"
								data-placement="top">
								<i class="icofont-heart-alt"></i>
							</span>

							@endif
					</li>
					<li>
							@if(Auth::guard('web')->check())

							<span href="javascript:;" class="add-to-shop"
								data-href="{{ route('user-shop-add',$prod->id) }}" data-toggle="tooltip"
								data-placement="top" title="{{ __('Add to shop') }}"><i
									class="fas fa-store"></i>
							</span>

							@else

							<span href="javascript:;" rel-toggle="tooltip" title="{{ __('Add to shop') }}"
								data-toggle="modal" id="shop-btn" data-target="#comment-log-reg"
								data-placement="top">
								<i class="fas fa-store"></i>
							</span>

							@endif
					</li>
					
					<li>
							<span href="javascript:;" class="add-to-compare"
							data-href="{{ route('product.compare.add',$prod->id) }}" data-toggle="tooltip"
							data-placement="top" title="{{ $langg->lang57 }}" >
							<i class="icofont-exchange"></i>
						</span>
					</li>
				</ul>
			</div>
		</div>
	</a>

</div>