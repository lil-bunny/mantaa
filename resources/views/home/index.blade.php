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
                <form  method="post" action="">
                    <input type="text" placeholder="Enter a location. Eg. City. locality or landmark"/>
                    <button class="btn btn-search">Search</button>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="info-elmnt">
                        <h3><a href="plot-details.html">Cras eu nulla sed tellus</a></h3>
                        <h4>Etiam viverra auctor</h4>
                    </div>
                    <div class="bottom-widget d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Starting from</h6>
                        <h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
                    </div>
                </div>
            </div>
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="plot-details.html" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
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
            <div class="site-item d-flex col-md-6 col-lg-3 col-xxl-3 col-xs-cs-6">
                <div class="site-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img src="{{asset('front-assets/images/sites-img.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="info-elmnt">
                        <h3><a href="plot-details.html">Cras eu nulla sed tellus</a></h3>
                        <h4>Etiam viverra auctor</h4>
                    </div>
                    <div class="bottom-widget d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Starting from</h6>
                        <h5 class="mb-0"><span class="currency">&#x20B9;</span> 4950.00</h5>
                    </div>
                </div>
            </div>
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
            <div>
                <div class="city-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img class="w-100" src="{{asset('front-assets/images/mumbai-location.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="botm-elmnt">
                        <h3>Mumbai</h3>
                        <a href="javascript:void(0);" class="arrow-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div>
                <div class="city-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img class="w-100" src="{{asset('front-assets/images/kolkata-location.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="botm-elmnt">
                        <h3>Kolkata</h3>
                        <a href="javascript:void(0);" class="arrow-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div>
                <div class="city-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img class="w-100" src="{{asset('front-assets/images/chennai-location.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="botm-elmnt">
                        <h3>Chennai</h3>
                        <a href="javascript:void(0);" class="arrow-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div>
                <div class="city-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img class="w-100" src="{{asset('front-assets/images/bangaluru-location.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="botm-elmnt">
                        <h3>Bangaluru</h3>
                        <a href="javascript:void(0);" class="arrow-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div>
                <div class="city-box">
                    <a href="javascript:void(0);" class="d-block img-elm">
                        <span class="d-block"><img class="w-100" src="{{asset('front-assets/images/bangaluru-location.jpg') }}" alt="img"/></span>
                    </a>
                    <div class="botm-elmnt">
                        <h3>Bangaluru</h3>
                        <a href="javascript:void(0);" class="arrow-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</section>	
<!-- // END CHOOSE CITIES -->