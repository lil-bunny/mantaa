@extends('admin::layouts.admin_form')

@section('content')

<!-- BEGIN: Page Main-->
<div id="main">
            <div class="row">
                <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
                <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
                    <!-- Search for small screen-->
                    <div class="container">
                        <div class="row">
                            <div class="col s10 m6 l6">
                                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Admin Areas</span></h5>
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ route('admin.area') }}">Area</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="container">
                        <!-- Admin Users Edit start -->
                        <div class="section users-edit">
                            <div class="card">
                                <div class="card-content">
                                    <div class="divider mb-3"></div>
                                    <div class="row">
                                        <div class="col s12" id="account">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form id="accountForm" method="post" enctype='multipart/form-data' action="{{ route('admin.create_area') }}">
                                            @csrf
                                                <!-- Location Details Starts Here -->    
                                                <div class="row">
                                                    <h4>Location Details</h4>
                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="autocomplete" name="autocomplete" type="text" class="validate search-inpt" value="" placeholder="Choose Location" />
                                                                <label>Search Place</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <div id="map"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="site_location" name="site_location" type="text" class="validate" value="{{ $area_data->site_location }}">
                                                                <label>Location Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="road_name" name="road_name" type="text" class="validate" value="{{ $area_data->road_name }}" readonly>
                                                                <label>Road Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="area_name" name="area_name" type="text" class="validate" value="{{ $area_data->title }}" readonly>
                                                                <label>Area Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="pin_code" name="pin_code" type="text" class="validate" value="{{ $area_data->pin_code }}" readonly>
                                                                <label>Pincode</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="lat" name="lat" type="text" class="validate" value="{{ $area_data->lat }}" readonly>
                                                                <label>Latitude</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="lng" name="lng" type="text" class="validate" value="{{ $area_data->lng }}" readonly>
                                                                <label>Longitude</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="city_name" name="city_name" type="text" class="validate" value="{{ $area_data->city->name }}" readonly>
                                                                <label>City</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="state_name" name="state_name" type="text" class="validate" value="{{ $area_data->state->name }}" readonly>
                                                                <label>State</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                    
                                                    

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <select name="city_tag">
                                                                    @foreach($city_tags as $key => $city_tag)
                                                                        <option value="{{ $key }}" {{ $area_data->city_tag==$city_tag ? 'selected' : ''}}>{{ $city_tag }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>City Tags</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    

                                                   
                                                    

                                                    
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                            <input id="face_traffic_from" name="face_traffic_from" type="text" class="validate" value="{{ $area_data->face_traffic_from }}">
                                                                <label>FTF (Facing Traffic From)</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <select name="place_type">
                                                                    @foreach($location_types as $key => $location_type)
                                                                        <option value="{{ $key }}" {{ $area_data->place_type==$location_type ? 'selected' : ''}}>{{ $location_type }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Location Type</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Location Details Ends Here -->


                                                <!-- Site Details Starts Here -->
                                                <div class="row">
                                                    <h4>Site Details</h4>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="media_formats">
                                                                    @foreach($media_formats as $key => $media_format)
                                                                        <option value="{{ $key }}" {{ $area_data->media_formats==$media_format ? 'selected' : ''}}>{{ $media_format }}</option>
                                                                    @endforeach 
                                                                </select>
                                                                <label>Media Formats</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="orientation">
                                                                    @foreach($orientations as $key => $orientation)
                                                                        <option value="{{ $key }}" {{ $area_data->orientation==$orientation ? 'selected' : ''}}>{{ $orientation }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Orientation</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="media_tags">
                                                                    @foreach($media_tags as $key => $media_tag)
                                                                        <option value="{{ $key }}" {{ $area_data->media_tags==$media_tag ? 'selected' : ''}}>{{ $media_tag }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Media Tags</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="height" name="height" type="text" class="validate" value="{{ $area_data->height }}">
                                                                <label>Height</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="width" name="width" type="text" class="validate" value="{{ $area_data->width }}">
                                                                <label>Width</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="media_tags">
                                                                    @foreach($media_tags as $key => $media_tags)
                                                                        <option value="{{ $key }}" {{ $area_data->media_tags==$media_tags ? 'selected' : ''}}>{{ $media_tags }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Media Tags</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="illumination">
                                                                    @foreach($illuminations as $key => $illumination)
                                                                        <option value="{{ $key }}" {{ $area_data->illumination==$illumination ? 'selected' : ''}}>{{ $illumination }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Illuminations</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="ad_spot_per_second">
                                                                    @foreach($ad_spot_durations as $ad_spot_duration)
                                                                        <option value="{{ $ad_spot_duration }}" {{ $area_data->ad_spot_per_second==$ad_spot_duration ? 'selected' : ''}}>{{ $ad_spot_duration }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Ad Spot (Duration in seconds)</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="total_ad_spot_perday" name="total_ad_spot_perday" type="text" class="validate" value="{{ $area_data->total_ad_spot_perday }}">
                                                                <label>Total Ad spot per day</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="total_advertiser" name="total_advertiser" type="text" class="validate" value="{{ $area_data->total_advertiser }}">
                                                                <label>Total Advertisers</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Location Details Ends Here -->

                                                <!-- Owner & Price Details Starts Here -->
                                                <div class="row">
                                                    <h4>Owner & Price Details</h4>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="display_charge_pm" name="display_charge_pm" type="text" class="validate" value="{{ $area_data->display_charge_pm }}">
                                                                <label>Display Charges PM</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="production_cost" name="production_cost" type="text" class="validate" value="{{ $area_data->production_cost }}">
                                                                <label>Production Cost</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="installation_cost" name="installation_cost" type="text" class="validate" value="{{ $area_data->installation_cost }}">
                                                                <label>Installation Cost</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="media_partner_name" name="media_partner_name" type="text" class="validate" value="{{ $area_data->media_partner_name }}">
                                                                <label>Media Partner Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Owner & Price Details Ends Here -->

                                                <!-- Area Picture and Video Details Starts Here -->
                                                <div class="row">
                                                    <h4>Area Picture and Video Details</h4>

                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col m6 s12 input-field">
                                                                <label for="upload_image">Area Picture1</label><br>
                                                                <input type="file" class="mt-4" name="area_pic1" />
                                                            </div>
                                                            <img src="{{ url('public/application_files/area_images') . '/'. $area_data->area_pic1 }}" alt="" class="image" height="100" width="100">
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col m6 s12 input-field">
                                                                <label for="upload_image">Area Picture2</label><br>
                                                                <input type="file" class="mt-4" name="area_pic2" />
                                                                @if ($area_data->area_pic2)
                                                                <img src="{{ url('public/application_files/area_images') . '/'. $area_data->area_pic2 }}" alt="" class="image" height="100" width="100">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col m6 s12 input-field">
                                                                <label for="upload_image">Area Video</label><br>
                                                                <input type="file" class="mt-4" name="area_video" />
                                                            </div>
                                                            @if ($area_data->area_video)
                                                            <a href="{{ url('public/application_files/area_videos') . '/'. $area_data->area_video }}" target="_blank">Video Link</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Area Picture and Video Details Ends Here -->


                                                <!-- Nearby Details Starts Here -->
                                                <div class="row">
                                                    <h4>Nearby Places</h4>

                                                    <div class="col s12 input-field">
                                                        <fieldset class="main-cechbox-holder">
                                                            <legend>Choose Option (Any 6):</legend>
                                                            <div class="main-cechbox">
                                                                @foreach($nearby_places_list as $nearby_places_info)
                                                                    <div class="sub-cechbox">
                                                                        <input type="checkbox" name="nearby_places[]" value="{{ $nearby_places_info }}"  {{ in_array($nearby_places_info, $nearby_places) ? 'checked' : '' }}>
                                                                        <label for="scales">Airport</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <!-- Nearby Details Ends Here -->

                                                <!-- Site Merits Starts Here -->
                                                <div class="row">
                                                    <h4>Site Merits</h4>

                                                    @foreach($site_merits as $site_merit)
                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12 input-field">
                                                                    <select name="site_merit_{{ $site_merit->id }}">
                                                                        @foreach($site_merit->site_merit_values as $site_merit_value)
                                                                            <option value="{{ $site_merit_value->id }}" {{ in_array($site_merit_value->id, $site_merits_values_assigned) ? 'selected' : '' }}>{{ $site_merit_value->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label>{{ $site_merit->title }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!-- Site Merits Ends Here -->


                                                <div class="row">
                                                    <div class="col s12 display-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn indigo">Save changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Admin Users Edit account form ends -->
                                        </div>
                                        
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Admin Users Edit ends -->
                    </div>
                    <div class="content-overlay"></div>
                </div>
            </div>
        </div>
        <!-- END: Page Main-->
       

        <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeK9JLWPV_0-BCT3A63jji-NymGtLWVW4&callback=initAutocomplete&libraries=places&v=weekly"
        defer
        ></script>


        <script type="text/javascript">

            function initAutocomplete() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 22.5726, lng: 88.3639 },
                    zoom: 13,
                    mapTypeId: "roadmap",
                });
                // Create the search box and link it to the UI element.
                const input = document.getElementById("autocomplete");
                const searchBox = new google.maps.places.SearchBox(input);

                //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });

                let markers = [];

                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                    return;
                    }

                    // Clear out the old markers.
                    markers.forEach((marker) => {
                    marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();

                    places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    const icon = {
                        url: place.icon,
                        size: new google.maps.Size(50, 50),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };

                    // Create a marker for each place.
                    markers.push(
                        new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                        })
                    );
                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                    });
                    map.fitBounds(bounds);

                    // define variables
                    let address1 = "";
                    let postcode = "";
                    let city = "";
                    let state = "";
                    let road_name = "";
                    let area_name = "";
                    let lat = "";
                    let lng = "";
                    console.log(places);
                    console.log('place details');

                    // assigning lat lng variables
                    lat = places[0].geometry.location.lat();
                    lng = places[0].geometry.location.lng();

                    // fetching the address components
                    for (const component of places[0].address_components) {
                        // @ts-ignore remove once typings fixed
                        const componentType = component.types[0];

                        switch (componentType) {
                            case "street_number": {
                                address1 = `${component.long_name} ${address1}`;
                                break;
                            }

                            case "route": {
                                address1 += component.short_name;
                                road_name = component.short_name;
                                break;
                            }

                            case "sublocality_level_1": {
                                address1 += ','+component.short_name;
                                area_name = component.short_name;
                                break;
                            }
                            
                            case "locality": {
                                address1 += ','+component.long_name;
                                city = component.long_name;
                                break;
                            }

                            case "postal_code": {
                                postcode = `${component.long_name}${postcode}`;
                                break;
                            }

                            case "postal_code_suffix": {
                                postcode = `${postcode}-${component.long_name}`;
                                break;
                            }
                            
                            case "administrative_area_level_1": {
                                state = component.long_name;
                                break;
                            }
                        }
                    }
                    console.log(city);
                    console.log('Test');
                    // assigning the values in text boxes
                    document.querySelector("#site_location").value = address1;
                    document.querySelector("#road_name").value = road_name;
                    document.querySelector("#area_name").value = area_name;
                    document.querySelector("#pin_code").value = postcode;
                    document.querySelector("#city_name").value = city;
                    document.querySelector("#state_name").value = state;
                    document.querySelector("#lat").value = lat;
                    document.querySelector("#lng").value = lng;
                });
            }

            window.initAutocomplete = initAutocomplete;
        </script>
@endsection
