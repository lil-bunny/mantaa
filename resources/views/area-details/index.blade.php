
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
						<img class="w-100" src="{{asset('images/area/'. $data['area_pic1'])}}" alt="Thumbnail">
					</div>
				</div>
			</div>
		</section>
		<!-- plot thumbnail slider end -->

		<section class="location-sec sec-pb">
			<div class="container">
				<h2 class="sec-title">Location Map</h2>
				<div class="row">
					<div class="col-md-7">
						<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10420.161365955086!2d88.43267758710955!3d22.57598455697892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1672218003341!5m2!1sen!2sin" width="100%" height="553" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
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
								<h3 class="sec-title m-0">{{ $data['display_area'] }} sq.ft</h3>
							</div>
							<div class="p-30 brdtop">
								<p>To know more SMART insights about this site</p>
								<a href="#" class="btn btn-warning">Connect<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"></path></svg></a>
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
						<ul class="list-plot-info">
							<li>
								<figure><img src="../public/front-assets/images/airport-icon.svg" alt="icon"></figure>
								<p>1.4 Km from Airport</p>
							</li>
							<li>
								<figure><img src="../public/front-assets/images/hospital-icon.svg" alt="icon"></figure>
								<p>2.3 Km from Hospital</p>
							</li>
							<li>
								<figure><img src="../public/front-assets/images/metro-icon.svg" alt="icon"></figure>
								<p>500 m from Metro Station</p>
							</li>
							<li>
								<figure><img src="../public/front-assets/images/train-icon.svg" alt="icon"></figure>
								<p>2 Km from Railway Station</p>
							</li>
							<li>
								<figure><img src="../public/front-assets/images/school-icon.svg" alt="icon"></figure>
								<p>3 Km from School</p>
							</li>
							<li>
								<figure><img src="../public/front-assets/images/mall-icon.svg" alt="icon"></figure>
								<p>2 Km from Mall</p>
							</li>
						</ul>
					</div>
					<!-- end column -->
					<div class="col-md-6">
						<h2 class="sec-title">Site Merits</h2>
						<ul class="list-plot-info site-merit-info">
							<li>
								<figure><img src="../public/front-assets/images/location-icon-green.svg" alt="icon"></figure>
								<p><strong>Site Position</strong>High Rise / Eye Level</p>
							</li>	
							<li>
								<figure><img src="../public/front-assets/images/eye-icon.svg" alt="icon"></figure>
								<p><strong>Visibility</strong>Long / Short</p>
							</li>	
							<li>
								<figure><img src="../public/front-assets/images/direction-icon.svg" alt="icon"></figure>
								<p><strong>Junction</strong>Yes / No</p>
							</li>	
							<li>
								<figure><img src="../public/front-assets/images/clutter-icon.svg" alt="icon"></figure>
								<p><strong>Clutter</strong>Solus / Mild / Heavy</p>
							</li>	
							<li>
								<figure><img src="../public/front-assets/images/sign-board-icon.svg" alt="icon"></figure>
								<p><strong>Obstruction</strong>None / Partial / Sever</p>
							</li>	
							<li>
								<figure><img src="../public/front-assets/images/speedo-metter-icon.svg" alt="icon"></figure>
								<p><strong>Visibility Score</strong>NA</p>
							</li>	 
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
					<p>Help us improve by giving more information about this site</p>
					<div class="form-group">
						<textarea class="form-control" placeholder="Write text here..."></textarea> 
					</div>
					<button class="btn btn-warning">Submit<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"></path></svg></button>
				</div>
			</div>
			<div class="col-md-6">
				<h2 class="sec-title">Recent Review</h2>
				<ul class="review-sec">
					<li>
						<div class="d-flex">
							<figure>
								<img src="../public/front-assets/images/avatar-icon.svg" alt="icon">
							</figure>
							<div>
								<p>Drew Reichert <span>17th Jan, 2022</span></p>
							</div>
						</div>
						Donec sed vulputate lacus. Pellentesque et vestibulum libero, nec euismod sem. Donec molestie ipsum erat, ac elementum felis blandit nec. Aenean suscipit tincidunt ipsum.
					</li>
					<li>
						<div class="d-flex">
							<figure>
								<img src="../public/front-assets/images/avatar-icon.svg" alt="icon">
							</figure>
							<div>
								<p>Vince Marvin <span>12th May, 2022</span></p>
							</div>
						</div>
						Donec sed vulputate lacus. Pellentesque et vestibulum libero, nec euismod sem. Donec molestie ipsum erat, ac elementum felis blandit nec. Aenean suscipit tincidunt ipsum.
					</li>
					<li>
						<div class="d-flex">
							<figure>
								<img src="../public/front-assets/images/avatar-icon.svg" alt="icon">
							</figure>
							<div>
								<p>Caesar Kling <span>25th Aug, 2022</span></p>
							</div>
						</div>
						Donec sed vulputate lacus. Pellentesque et vestibulum libero, nec euismod sem. Donec molestie ipsum erat, ac elementum felis blandit nec. Aenean suscipit tincidunt ipsum.
					</li>
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



	

