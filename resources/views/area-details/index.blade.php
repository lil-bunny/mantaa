
@extends('layouts.home')

@section('content') 

<!-- BANNER -->
	<div class="home-banner plot-banner">
		<img src="../public/front-assets/images/plot-banner-photo.jpg"/>
		<div class="banner-wrap d-flex align-items-center sec-pt">
			<div class="container">
				<h1 class="primary-color w-100">{{ $data['title'] }}</h1>
				<div class="banner-cont"> 
					<p><span><img src="../public/front-assets/images/location-icon.svg" alt="icon">State: {{ $data['state'] -> name }}</span><span><img src="../public/front-assets/images/location-icon.svg" alt="icon">City: {{ $data['city'] -> name }}</span><span><img src="../public/front-assets/images/location-icon.svg" alt="icon">Pincode: {{ $data['pin_code'] }}</span></p>
					<p><img src="../public/front-assets/images/latitude-icon.svg" alt="icon">Latitude, Longitude : {{ $data['lat'] }}, {{ $data['lng'] }}</p>
					<p><img src="../public/front-assets/images/caleder-icon.svg" alt="icon">Last Updated : {{ $data['updated_at'] }}</p>
				</div>
			</div>
		</div>
	</div>
	<!-- // END BANNER -->
		<section class="plot-thumb-slider-sec sec-ptb">
			<div class="container">
				<div class="plot-thumb-slider">
					<div>
						<img class="w-100" src="{{ url('public/application_files/area_images') . '/'. $data['area_pic1'] }}" alt="Thumbnail">
					</div>
					<div>
						<img class="w-100" src="{{ url('public/application_files/area_images') . '/'. $data['area_pic1'] }}" alt="Thumbnail">
					</div>
					@if($data['area_pic2'] != NULL)
						<div>
							<img class="w-100" src="{{ url('public/application_files/area_images') . '/'. $data['area_pic1'] }}" alt="Thumbnail">
						</div>
					@endif
				</div>
			</div>
		</section>
		<!-- plot thumbnail slider end -->

		<section class="location-sec sec-pb">
			<div class="container">
				<h2 class="sec-title">Location Map</h2>
				<div class="row">
					<div class="col-md-7">
						<iframe src = "https://maps.google.com/maps?q={{ $data['lat'] }},{{ $data['lng'] }}&hl=es;z=14&amp;output=embed" width="100%" height="553" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
					<div class="col-md-5">
						<div class="display-info">
							<div class="p-30">
								<h4><img src="../public/front-assets/images/rupee-circle-icon.svg" alt="icon"> Display Rentals / Month</h4>
								<h3 class="sec-title">{{ $data['rent_per_month'] }}</h3>
								<p class="text-sm">* The mentioned cost is subject to change as per market dynamics; please connect with the partner before booking.</p>
								<h4><img src="../public/front-assets/images/dimension-icon.svg" alt="icon"> Available Dimension</h4>
								<h3 class="sec-title">{{ $data['width'] }} ft x {{ $data['height'] }} ft</h3>
								<h4><img src="../public/front-assets/images/area-icon.svg" alt="icon"> Available Area</h4>
								<h3 class="sec-title m-0">{{ $data['width']*$data['height'] }} sq.ft</h3>
							</div>
							<div class="p-30 brdtop">
								<p>To know more SMART insights about this site</p>
								<form name="contactUsForm" id="contactUsForm" method="post" action="javascript:void(0)">
									@csrf
									<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
									<input type="hidden" name="area_id" value="{{ $id }}">
									<button type="submit" id="submit" class="btn btn-warning">Connect<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"></path></svg></button>
								</form>
							</div>
						</div>	
					</div>
				</div>
				<ul class="sec-plot-info">
					<li>
						<span>Media Type:</span>
						<p>{{ $data['media_type'] }}</p>
					</li>
					<li>
						<span>Environment:</span>
						<p>{{ $data['environment'] }}</p>
					</li>
					<li>
						<span>Illumination:</span>
						<p>{{ $data['illumination'] }}</p>
					</li>
					<li>
						<span>Media Fromat:</span>
						<p>{{ $data['media_formats'] }}</p>
					</li>
					<li>
						<span>Spot / Loop (in sec.)</span>
						<p>{{ $data['loop_per_second'] }}</p>
					</li>
					<li class="no-brd">
						<span>Partner Name:</span>
						<p>{{ $data['media_partner_name'] }}</p>
					</li>
				</ul>
				<!-- end info -->

				<div class="row">
					<div class="col-md-6">
						<h2 class="sec-title">Nearby Places</h2>
						@if (count($nearby_places) > 0)
							<ul class="list-plot-info">
								@foreach($nearby_places as $key => $nearby_places_info)
									<li>
										<figure>
											<img src="{{ $nearby_places_info['image'] }}" alt="icon">
										</figure>
										<p>{{ $nearby_places_info['value'] }} {{ $nearby_places_info['label'] }}</p>
									</li>
								@endforeach
							</ul>
						@else
							<p>No nearby places found</p>
						@endif
					</div>
					<!-- end column -->
					<div class="col-md-6">
						<h2 class="sec-title">Site Merits</h2>
						<ul class="list-plot-info site-merit-info">
							@if ($data->site_marit_values->count())
								@foreach ($data->site_marit_values as $site_marit_value)
									<li>
										<figure><img src="{{ url('public/front-assets/images').'/'.$site_merits_arr[$site_marit_value->site_merit_id]['icon'] }}" alt="icon"></figure>
										<p><strong>{{ $site_merits_arr[$site_marit_value->site_merit_id]['title'] }}</strong>{{ $site_marit_value->title }}</p>
									</li>
								@endforeach
							@else
								<li>
									<p><strong>No data found</strong></p>
								</li>
							@endif
						</ul>
					</div>
				</div>	
				<!-- end row -->
			</div>	
		</section>
		<!-- end location -->

<section class="feedback-review-sec sec-pb">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2 class="sec-title">Feedback</h2>
				<div class="feedback-sec">
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<p>Help us improve by giving more information about this site</p>
					<form method="POST" action="{{ route('frontend.feedbackSubmit', $id) }}">
						@csrf
						<div class="form-group">
							<textarea class="form-control" placeholder="Write text here..." name="feedback"></textarea> 
						</div>
						<button class="btn btn-warning">Submit<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"></path></svg></button>
					</form>
				</div>
			</div>
			<div class="col-md-6">
				<h2 class="sec-title">Recent Review</h2>
				<ul class="review-sec">
					@if ($feedbacks->count())
						@foreach($feedbacks as $feedback)
						<li>
							<div class="d-flex">
								<figure>
									<img src="../public/front-assets/images/avatar-icon.svg" alt="icon">
								</figure>
								<div>
									<p>{{ $feedback->user-> full_name }} <span>{{ $feedback->created_at }}</span></p>
								</div>
							</div>
							{{$feedback->feedback }}
						</li>
						@endforeach
					@else
						<li>
							<div class="d-flex">
								<div>
									<p>No reviews found</p>
								</div>
							</div>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
</section>
<!--  -->
	<!-- CHOOSE CITIES -->
	<section class="section-cities sec-ptb">
		<div class="container">
			<h2 class="sec-title text-center">Featured Sites</h2>
			<div class="city-items">
				<div>
					<div class="site-item">
						<div class="site-box">
							<a href="javascript:void(0);" class="d-block img-elm">
								<span class="d-block"><img src="../public/front-assets/images/sites-img.jpg" alt="img"/></span>
							</a>
							<div class="info-elmnt">
								<h3><a href="javascript:void(0);">Cras eu nulla sed tellus</a></h3>
								<h4>Etiam viverra auctor</h4>
							</div>
							<div class="bottom-widget d-flex justify-content-between align-items-center">
								<h6 class="mb-0">Starting from</h6>
								<h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="site-item">
						<div class="site-box">
							<a href="javascript:void(0);" class="d-block img-elm">
								<span class="d-block"><img src="../public/front-assets/images/sites-img.jpg" alt="img"/></span>
							</a>
							<div class="info-elmnt">
								<h3><a href="javascript:void(0);">Cras eu nulla sed tellus</a></h3>
								<h4>Etiam viverra auctor</h4>
							</div>
							<div class="bottom-widget d-flex justify-content-between align-items-center">
								<h6 class="mb-0">Starting from</h6>
								<h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="site-item">
						<div class="site-box">
							<a href="javascript:void(0);" class="d-block img-elm">
								<span class="d-block"><img src="../public/front-assets/images/sites-img.jpg" alt="img"/></span>
							</a>
							<div class="info-elmnt">
								<h3><a href="javascript:void(0);">Cras eu nulla sed tellus</a></h3>
								<h4>Etiam viverra auctor</h4>
							</div>
							<div class="bottom-widget d-flex justify-content-between align-items-center">
								<h6 class="mb-0">Starting from</h6>
								<h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="site-item">
						<div class="site-box">
							<a href="javascript:void(0);" class="d-block img-elm">
								<span class="d-block"><img src="../public/front-assets/images/sites-img.jpg" alt="img"/></span>
							</a>
							<div class="info-elmnt">
								<h3><a href="javascript:void(0);">Cras eu nulla sed tellus</a></h3>
								<h4>Etiam viverra auctor</h4>
							</div>
							<div class="bottom-widget d-flex justify-content-between align-items-center">
								<h6 class="mb-0">Starting from</h6>
								<h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="site-item">
						<div class="site-box">
							<a href="javascript:void(0);" class="d-block img-elm">
								<span class="d-block"><img src="../public/front-assets/images/sites-img.jpg" alt="img"/></span>
							</a>
							<div class="info-elmnt">
								<h3><a href="javascript:void(0);">Cras eu nulla sed tellus</a></h3>
								<h4>Etiam viverra auctor</h4>
							</div>
							<div class="bottom-widget d-flex justify-content-between align-items-center">
								<h6 class="mb-0">Starting from</h6>
								<h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
							</div>
						</div>
					</div>
				</div> 
			</div>
		</div>	
	</section>	
	
	<!-- // END CHOOSE CITIES -->
	@endsection


	

