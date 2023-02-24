@extends('layouts.home')

@section('content')

<!-- BANNER -->
<div class="home-banner">
    <img src="{{asset('front-assets/images/banner-img.jpg') }}"/>
    <div class="banner-wrap d-flex align-items-end">
        <h1 class="primary-color w-100">
            <div class="container">
                <div class="col-xxl-7 col-lg-6 col-md-6 px-0">The best place to explore your desired Out-Of-Home Advertising Formats</div>
            </div>
        </h1>
        <div class="container">
            <div class="search-widget">
                <form method="post" action="{{ route('frontend.areaSearch') }}">
                    <input type="text" placeholder="Enter a location. Eg. City. locality or landmark" id="search"/>
                    <input type="hidden" name="area_id" id="area_id" value="" />
                    <input type="hidden" name="city_id" id="city_id" value="" />
                    <button class="btn btn-search" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- // END BANNER -->

<!-- SITES DEMAND -->
<section class="section-demand sec-ptb">
    <div class="container">
        <h2 class="sec-title text-center pt-4">Sites In Demand</h2>
        <div class="row sites-items">
            @foreach($areas as $area)
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="{{ route('area-details', ['id' => $area->id]) }}" class="d-block img-elm">
                    @if($area->area_pic1 == NULL)
                        <span class="d-block"><img class="w-100" src="{{asset('images/area/no-image.png')}}" alt="img"/></span>
                    @else
                        <span class="d-block"><img src="{{ url('public/application_files/area_images') . '/'. $area->area_pic1 }}" alt="img"/></span>
                    @endif
                    </a>
                    <div class="info-elmnt">
                        <h3><a href="javascript:void(0);">{{ $area->site_location }}</a></h3>
                        <h4>{{ $area->title }}</h4>
                    </div>
                    <div class="bottom-widget d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Starting from</h6>
                        <h5 class="mb-0"><span class="currency">&#x20B9;</span> {{ $area->rent_per_month }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5"><a href="javascript:void(0);" class="btn btn-primary btn-more">View More<svg id="right-circle-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="Left_Arrow_5_" d="M6.5,12.5a.5.5,0,0,0,.354-.146l4-4a.5.5,0,0,0,0-.707l-4-4a.5.5,0,1,0-.707.707L9.793,8,6.147,11.646A.5.5,0,0,0,6.5,12.5ZM0,8a8,8,0,1,1,8,8A8.009,8.009,0,0,1,0,8ZM1,8A7,7,0,1,0,8,1,7.008,7.008,0,0,0,1,8Z" fill="#fff"/></svg></a></div>
    </div>	
</section>	
<!-- // END SITES DEMAND -->		

<!-- CHOOSE CITIES -->
<section class="section-cities sec-ptb">
    <div class="container">
        <h2 class="sec-title text-center">Choose From The Cities</h2>
        <div class="city-items">
            @foreach($cities as $city)
            <div>
                <div class="city-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        @if($city->image == NULL)
                            <span class="d-block"><img class="w-100" src="{{ url('public/application_files/city/no-image.png') }}" alt="img"/></span>
                        @else
                            <span class="d-block"><img class="w-100" src="{{ url('public/application_files/city') . '/'. $city->image }}" alt="img"/></span>
                        @endif
                    </a>
                    <div class="botm-elmnt">
                        <h3>{{ $city->name }}</h3>
                        <a href="javascript:void(0);" class="arrow-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>	
</section>	
<!-- // END CHOOSE CITIES -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
           $('#id').val(ui.item.id);
           $('#city_id').val(ui.item.city_id);
           console.log(ui.item); 
           return false;
        }
    });
</script>
@endsection