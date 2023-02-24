
@extends('layouts.home')

@section('content') 

<!-- BANNER -->
<div class="home-banner banner-search">
	<img src="{{asset('front-assets/images/search-page-banner.jpg') }}" alt="Banner" />
	<div class="banner-wrap d-flex align-items-end">
			
		<div class="container">
			<div class="search-widget">
				<form>
					<input type="text" placeholder="Enter a location. Eg. City. locality or landmark"/>
					<button class="btn btn-search">Search</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- // END BANNER -->

<section class="section-demand sec-ptb">
	<div class="container"> 
		<h4 class="search-title sec-pt">Additional Filters (Optional)</h4>
		<div class="search-form row align-items-center">				
			<div class="col-auto">
				<select class="form-control">
					<option>Minimum Price</option>
					<option>1000</option>
					<option>2000</option>
					<option>3000</option>
					<option>4000</option>
					<option>5000</option>
				</select>
			</div>				
			<div class="col-auto">
				<select class="form-control">
					<option>Maximum Price</option>
					<option>10000</option>
					<option>20000</option>
					<option>30000</option>
					<option>40000</option>
					<option>50000</option>
				</select>
			</div>	
			<div class="col-auto">
				<select class="form-control">
					<option>Media Formats</option>
					<option>Flex</option>
					<option>Digital</option>
				</select>
			</div>
			<div class="col-auto">
				<button class="btn btn-warning">Search<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"></path></svg></button>
			</div>
		</div>
		<div class="row row-reverse search-results">
			<div class="col-md-6">
				<div class="map-search">
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10420.161365955086!2d88.43267758710955!3d22.57598455697892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1672218003341!5m2!1sen!2sin" width="100%" height="820" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
			<div class="col-md-6">
				<div class="search-content">
					<div class="row sites-items">
						@foreach($area_lists as $area_info)
							<div class="site-item d-flex col-md-6 col-xxl-6 item-m6-l4-xxl3">
								<div class="site-box">
									<a href="{{ route('area-details', ['id' => $area_info->id]) }}" class="d-block img-elm">
										<span class="d-block">
											@if($area_info->area_pic1 == NULL)
												<img class="w-100" src="{{asset('images/area/no-image.png')}}" alt="img"/>
											@else
												<img src="{{ url('public/application_files/area_images') . '/'. $area_info->area_pic1 }}" alt="img"/>
											@endif
										</span>
									</a>
									<div class="info-elmnt">
										<h3><a href="{{ route('area-details', ['id' => $area_info->id]) }}">{{ $area_info->title }}</a></h3>
										<ul>
											<li><h4>State</h4><span>{{ $area_info->state->name ?? '' }}</span></li>
											<li><h4>City</h4><span>{{ $area_info->city->name ?? '' }}</span></li>
											<li><h4>Size</h4><span>{{ $area_info->height }}x{{ $area_info->width }}</span></li>
										</ul>
										
									</div>
									<div class="bottom-widget d-flex justify-content-between align-items-center">
										<h6 class="mb-0">Display Charges PM</h6>
										<h5 class="mb-0"><span class="currency">&#x20B9;</span> {{ $area_info->display_charge_pm }}</h5>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<!-- end second row -->
				<!-- loader start -->
					<div class="loader-container" style="display:none">
						<div class="loader-spinner">
							<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
								<circle cx="50" cy="50" r="46" />
							</svg>
						</div>
					</div>
				<!-- loader end -->
			</div>
		</div>
		<!-- end main row -->
	</div>
</section>
<!-- ens search result -->

@endsection


	

