
@extends('layouts.home')

@section('content') 
<style type="text/css">
	#mapCanvas{
		width: 100%;
		height: 400px;
	}
</style>
<!-- BANNER -->
<div class="banner inner-banner banner-search">
	<!-- <img src="{{asset('front-assets/images/search-page-banner.jpg') }}" alt="Banner" /> -->
	<div class="banner-wrap d-flex align-items-end">
			
		<div class="container">
			<div class="search-widget">
				<form method="get" action="{{ route('frontend.areaSearch') }}">
					@csrf
                    <input type="text" name="searchText" value="{{ $filters['search_text'] }}" placeholder="Enter a location. Eg. City. locality or landmark" id="search"/>
                    <input type="hidden" name="area_id" id="area_id" value="{{ $filters['area_id'] }}" />
                    <input type="hidden" name="city_id" id="city_id" value="{{ $filters['city_id'] }}" />
                    <button class="btn btn-search" type="submit">Search</button>
                </form>
			</div>
		</div>
	</div>
</div>
<!-- // END BANNER -->

<section class="section-demand sec-ptb">
	<div class="container"> 
		<h4 class="search-title sec-pt">Additional Filters (Optional)</h4>
			<form method="get" action="{{ url()->full() }}">
				@csrf
				<input type="hidden" name="searchText_filter" value="{{ $filters['search_text'] }}" placeholder="Enter a location. Eg. City. locality or landmark" id="search_filter"/>
				<input type="hidden" name="area_id_filter" id="area_id_filter" value="{{ $filters['area_id'] }}" />
				<input type="hidden" name="city_id_filter" id="city_id_filter" value="{{ $filters['city_id'] }}" />
                <div class="search-form row align-items-center">				
					<div class="col-auto">
						<select class="form-control" name="min_price" id="min">
							<option value="">Minimum Price</option>
							@foreach($min_price as $min_price_info)
								<option value="{{ $min_price_info }}" {{ $filters['min_price']==$min_price_info ? 'selected' : ''}}>{{ $min_price_info }}</option>
							@endforeach
						</select>
					</div>				
					<div class="col-auto">
						<select class="form-control" name="max_price" id="max">
							<option value="">Maximum Price</option>
							@foreach($max_price as $max_price_info)
								<option value="{{ $max_price_info }}" {{ $filters['max_price']==$max_price_info ? 'selected' : ''}}>{{ $max_price_info }}</option>
							@endforeach
						</select>
					</div>	
					<div class="col-auto">
						<select class="form-control" name="media_formats">
							<option value="">Media Formats</option>
							@foreach($media_formats as $key => $media_format)
								<option value="{{ $key }}" {{ $filters['media_formats']==$media_format ? 'selected' : ''}}>{{ $media_format }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-auto">
						<button type="submit" class="btn btn-warning">Search<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"></path></svg></button>
					</div>
				</div>
			</form>
		<div class="row row-reverse search-results">
			<div class="col-md-6">
				<div class="map-search" id="mapCanvas">
					<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10420.161365955086!2d88.43267758710955!3d22.57598455697892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1672218003341!5m2!1sen!2sin" width="100%" height="820" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
				</div>
			</div>
			<div class="col-md-6">
				<div class="search-content" id="post-cont">
					<div class="row sites-items" id="post-data">
						@if ($area_lists->count())
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
												<li><h4>Size</h4><span>{{ $area_info->width }}x{{ $area_info->height }}</span></li>
											</ul>
										</div>
										<div class="bottom-widget d-flex justify-content-between align-items-center">
											<h6 class="mb-0">Starting from</h6>
											<h5 class="mb-0"><span class="currency">&#x20B9;</span>{{ $area_info->display_charge_pm }}</h5>
										</div>
									</div>
								</div>
							@endforeach
						@else
							<P>No Items found</p>
						@endif
					</div>
				</div>
				<!-- end second row -->
				<!-- loader start -->
					<div class="loader-container" id="ajax_loader" style="display:none">
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
<div id="location_result" style="display:none">{{$locations}}</div>
<!-- ens search result -->

<script
src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"
defer
></script>
<script type="text/javascript">
    var path = "{{ url('autocomplete-search') }}";

    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },

        select: function (event, ui) {
           $('#search').val(ui.item.label);
           $('#area_id').val(ui.item.id);
           $('#city_id').val(ui.item.city_id);
		   $('#search_filter').val(ui.item.label);
           $('#area_id_filter').val(ui.item.id);
           $('#city_id_filter').val(ui.item.city_id);
           console.log(ui.item); 
           return false;
        }
    });
</script>
<script type="text/javascript">
	var page = 1;

	jQuery(function($) {
		$('#post-cont').on('scroll', function() {
			if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
				page++;
	        	loadMoreData(page);
			}
		})
	});


	function loadMoreData(page){
		var url_gt = '?page='+page;

		if(jQuery('#search').val() != '') {
			url_gt += '&searchText='+jQuery('#search').val();
		}
		if(jQuery('#area_id').val() != '') {
			url_gt += '&area_id='+jQuery('#area_id').val();
		}
		if(jQuery('#city_id').val() != '') {
			url_gt += '&city_id='+jQuery('#city_id').val();
		}
		if(jQuery('#min_price').val() != '') {
			url_gt += '&min_price='+jQuery('#min_price').val();
		}
		if(jQuery('#max_price').val() != '') {
			url_gt += '&max_price='+jQuery('#max_price').val();
		}
		if(jQuery('#media_formats').val() != '') {
			url_gt += '&media_formats='+jQuery('#media_formats').val();
		}
		jQuery.ajax(
		{
			url: '?page='+page+'&searchText='+jQuery('#search').val()+'&area_id='+jQuery('#area_id').val()+'&city_id='+jQuery('#city_id').val(),
			type: "get",
			beforeSend: function()
			{
				jQuery('#ajax_loader').show();
			}
		})
		.done(function(data)
		{
			if(data.html == " ") {
				jQuery('#ajax_loader').html("No more records found");
				return;
			}

			// fetching the data
			if(data.locations_ajax != '') {
				var location_ht = jQuery('#location_result').html();
				var location_json = JSON.parse(location_ht);
				var location_ajax_json = JSON.parse(data.locations_ajax);
				var new_loc = location_json.concat(location_ajax_json);
				var new_json_loc = JSON.stringify(new_loc);console.log(new_json_loc);
				jQuery('#location_result').html(new_json_loc);
				initMap();
			}
			

			jQuery('#ajax_loader').hide();
			jQuery("#post-data").append(data.html);
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			alert('server not responding...');
		});
	}
</script>

<script type="text/javascript">
	 $("#min").change(function (){
        var $this = $(this);
        $("select option").prop("disabled", false);

        $("#max option").filter(function(){
            return parseInt(this.value) < parseInt($this.val());
        }).prop("disabled", true);
        
        $("#min option").filter(function(){
            return parseInt(this.value) > parseInt($this.val());
        }).prop("disabled", true);
    });

	$("#max").change(function (){
		var $this = $(this);
		$("select option").prop("disabled", false);

		$("#min option").filter(function(){
			return parseInt(this.value) > parseInt($this.val());
		}).prop("disabled", true);

		$("#max option").filter(function(){
			return parseInt(this.value) < parseInt($this.val());
		}).prop("disabled", true);

	});
</script>


<script type="text/javascript">
// Initialize and add the map
function initMap() {
	// Multiple markers location, latitude, and longitude
	var el = document.getElementById('location_result');
	var marker_ht = el.innerHTML;
	var markers = JSON.parse(marker_ht);

    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
		center: { lat: markers[0][1], lng: markers[0][2] },
        mapTypeId: 'roadmap',
		zoom: 2,
		streetViewControl: true,
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    //map.setTilt(50);
	
	
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(markers[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    // var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    //     this.setZoom(14);
    //     google.maps.event.removeListener(boundsListener);
    // });
}

window.initMap = initMap;
</script>
@endsection


	

