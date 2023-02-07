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
                                            <form id="accountForm" method="post" action="{{ route('admin.create_area') }}">
                                            @csrf
                                                <!-- Location Details Starts Here -->    
                                                <div class="row">
                                                    <h4>Location Details</h4>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="state_id">
                                                                    @foreach($states as $state)
                                                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                                    @endforeach 
                                                                </select>
                                                                <label>State</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="city_id">
                                                                    @foreach($cities as $city)
                                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>City</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="city_tag">
                                                                    @foreach($city_tags as $key => $city_tag)
                                                                        <option value="{{ $key }}">{{ $city_tag }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>City Tags</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="pin_code" name="pin_code" type="text" class="validate" value="">
                                                                <label>Pincode</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="title" name="title" type="text" class="validate" value="">
                                                                <label>Area Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="road_name" name="road_name" type="text" class="validate" value="">
                                                                <label>Road Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="site_location" name="site_location" type="text" class="validate" value="">
                                                                <label>Location Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                            <input id="face_traffic_from" name="face_traffic_from" type="text" class="validate" value="">
                                                                <label>FTF (Facing Traffic From)</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="place_type">
                                                                    @foreach($location_types as $key => $location_type)
                                                                        <option value="{{ $key }}">{{ $location_type }}</option>
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
                                                                        <option value="{{ $key }}">{{ $media_format }}</option>
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
                                                                        <option value="{{ $key }}">{{ $orientation }}</option>
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
                                                                        <option value="{{ $key }}">{{ $media_tag }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Media Tags</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="height" name="height" type="text" class="validate" value="">
                                                                <label>Height</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="width" name="width" type="text" class="validate" value="">
                                                                <label>Width</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="illumination">
                                                                    @foreach($illuminations as $key => $illumination)
                                                                        <option value="{{ $key }}">{{ $illumination }}</option>
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
                                                                        <option value="{{ $key }}">{{ $illumination }}</option>
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
                                                                        <option value="{{ $ad_spot_duration }}">{{ $ad_spot_duration }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Ad Spot (Duration in seconds)</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="total_ad_spot_perday" name="total_ad_spot_perday" type="text" class="validate" value="">
                                                                <label>Total Ad spot per day</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="total_advertiser" name="total_advertiser" type="text" class="validate" value="">
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
                                                                <input id="display_charge_pm" name="display_charge_pm" type="text" class="validate" value="">
                                                                <label>Display Charges PM</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="production_cost" name="production_cost" type="text" class="validate" value="">
                                                                <label>Production Cost</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="installation_cost" name="installation_cost" type="text" class="validate" value="">
                                                                <label>Installation Cost</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="media_partner_name" name="media_partner_name" type="text" class="validate" value="">
                                                                <label>Media Partner Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Owner & Price Details Ends Here -->

                                                <!-- Area Picture and Video Details Starts Here -->
                                                <div class="row">
                                                    <h4>Area Picture and Video Details</h4>

                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col m6 s12 file-field input-field">
                                                                <div class="btn float-right">
                                                                    <span>Area Picture1 </span>
                                                                    <input type="file" name="area_pic1">
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col m6 s12 file-field input-field">
                                                                <div class="btn float-right">
                                                                    <span>Area Picture2 </span>
                                                                    <input type="file" name="area_pic2">
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col m6 s12 file-field input-field">
                                                                <div class="btn float-right">
                                                                    <span>Area Video</span>
                                                                    <input type="file" name="area_video">
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Area Picture and Video Details Ends Here -->


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
@endsection
