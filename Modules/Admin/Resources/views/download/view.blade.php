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
                                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Downloads</span></h5>
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ route('admin.download') }}">Downloads</a>
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
                                            <div class="row">
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">User</label>
                                                                <input id="user" name="user" type="text" class="validate" value="{{ $download_data->user->full_name ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">User Email</label>
                                                                <input id="user_email" name="user_email" type="text" class="validate" value="{{ $download_data->user->email ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">User Mobile</label>
                                                                <input id="user_mob" name="user_mob" type="text" class="validate" value="{{ $download_data->user->mobile ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">Area</label>
                                                                <input id="area" name="area" type="text" class="validate" value="{{ $download_data->area->title ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">Site Location</label>
                                                                <input id="site_location" name="site_location" type="text" class="validate" value="{{ $download_data->area->site_location ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">Pincode</label>
                                                                <input id="pin_code" name="pin_code" type="text" class="validate" value="{{ $download_data->area->pin_code ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">City</label>
                                                                <input id="city" name="city" type="text" class="validate" value="{{ $city_data->name ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <label for="name">State</label>
                                                                <input id="state" name="state" type="text" class="validate" value="{{ $state_data->name ?? '' }}" data-error=".errorTxt2" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col m6 s12">
                                                                <label for="Feedback">Created At</label><br>
                                                                <p>{{ $download_data->created_at }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
