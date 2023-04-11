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
                                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Review and Modify Campaign</span></h5>
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Review and Modify Campaign</a>
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
                                                <input type="hidden" name="area_count" value="{{ $areas->count() }}">
                                                <input type="hidden" name="area_ids" value="{{ $area_ids }}">
                                                
                                                <div class="row">
                                                    <h4>Campaign Title</h4>
                                                    
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12">
                                                                <input id="campaign_title" name="campaign_title" type="text" class="validate" value="">
                                                                <label>Campaign Title</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Location Details Starts Here -->
                                                @foreach($areas as $area)    
                                                    <div class="row">
                                                        <h4>Site Details for {{ $area->title }}</h4>
                                                        
                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12">
                                                                    <input id="site_location" name="site_location_{{ $area->id }}" type="text" class="validate" value="{{ $area->site_location }}">
                                                                    <label>Location Name</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12">
                                                                    <input id="height_width" name="height_width_{{ $area->id }}" type="text" class="validate" value="{{ $area->height }} x {{ $area->width }} x 1Unit">
                                                                    <label>Size</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12">
                                                                    <input id="illumination" name="illumination_{{ $area->id }}" type="text" class="validate" value="{{ $area->illumination  }}">
                                                                    <label>Illumination</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12">
                                                                    <input id="format" name="format_{{ $area->id }}" type="text" class="validate" value="{{ $area->media_formats  }}">
                                                                    <label>Format</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12">
                                                                    <input id="traffic_count" name="traffic_count_{{ $area->id }}" type="text" class="validate" value="">
                                                                    <label>Traffic Count</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col s12 m6">
                                                            <div class="row">
                                                                <div class="col s12">
                                                                    <input id="impression" name="impression_{{ $area->id }}" type="text" class="validate" value="">
                                                                    <label>Impression</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <!-- Location Details Ends Here -->

                                                <div class="row">
                                                    <div class="col s12 display-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn indigo">Generate Campaign</button>
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
