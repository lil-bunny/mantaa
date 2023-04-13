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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">POI Details</a>
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
                                    <form id="accountForm" method="post" action="{{ route('admin.add_poi') }}">
                                        @csrf
                                        <input type="hidden" name="area_id" value="{{ $area_id }}">
                                        <!-- Location Details Starts Here -->    
                                        <div class="row">
                                            <h4>POI Details</h4>
                                            @foreach($poi_data as $key => $poi_info)
                                                <div class="col s12 m6">
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <input id="{{ $key }}" name="{{ $key }}" type="text" class="validate" value="{{ $poi_info['value'] }}">
                                                            <label>{{ $poi_info['label'] }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col s12 display-flex justify-content-end mt-3">
                                                <button type="submit" class="btn indigo">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- poi form ends -->
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Page Main-->
@endsection


