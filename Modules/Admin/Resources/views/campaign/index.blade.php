@extends('admin::layouts.admin_grid')

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
                                    <li class="breadcrumb-item active"><a href="{{ route('admin.campaign_search') }}">Campaigns</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="container">
                        <!-- users list start -->
                        <section class="users-list-wrapper section">
                            <div class="users-list-filter">
                                <div class="card-panel">
                                    <div class="row">
                                        <form method="GET">
                                            <div class="col s12 m6 l3">
                                                <label for="users-list-role">City</label>
                                                <div class="input-field">
                                                    <select class="form-control" id="city-list" name="city_id">
                                                        <option value="">Any</option>
                                                        @foreach($cities as $city)
                                                            @if($filters['city_id'] == $city->id)
                                                                <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                                            @else
                                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col s12 m6 l3">
                                                <label for="users-list-role">Income Group</label>
                                                <div class="input-field">
                                                    <select class="form-control" id="income_group" name="income_group">
                                                        <option value="">Any</option>
                                                        @foreach($income_groups as $income_group)
                                                            @if($filters['income_group'] == $income_group)
                                                                <option value="{{ $income_group }}" selected>{{ $income_group }}</option>
                                                            @else
                                                                <option value="{{ $income_group }}">{{ $income_group }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col s12 m3 l3 display-flex align-items-center show-btn">
                                                <button type="submit" class="btn btn-block indigo waves-effect waves-light">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($areas)
                            <div class="users-list-table">
                                <div class="card">
                                    <div class="card-content">
                                        <!-- datatable start -->
                                        <div class="responsive-table">
                                            @if($areas->count())
                                                <table id="users-list-datatable1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="sub-cechbox"><input type="checkbox" class="check_all"/></th>
                                                            <th>@sortablelink('id', 'ID')</th>
                                                            <th>@sortablelink('title', 'Area Name')</th>
                                                            <th>@sortablelink('state_id', 'State')</th>
                                                            <th>@sortablelink('city_id', 'City')</th>
                                                            <th>@sortablelink('site_location', 'Location Name')</th>
                                                            <th>@sortablelink('created_at', 'Created')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($areas as $area)
                                                            <tr>
                                                                <td class="sub-cechbox"><input type="checkbox" id="area_{{$area->id}}" name="area_selected[]" value="{{$area->id}}" class="area_select"></td>
                                                                <td>{{ $area->id }}</td>
                                                                <td>{{ $area->title }}</td>
                                                                <td>{{ $area->state->name }} </td>
                                                                <td>{{ $area->city->name }} </td>
                                                                <td>{{ $area->site_location }} </td>
                                                                <td>{{ $area->created_at }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>No records found</p>
                                            @endif
                                        </div>
                                        <!-- datatable ends -->
                                    </div>
                                </div>
                            </div>
                            @endif
                        </section>
                        <!-- users list ends -->
                    </div>
                    <div class="content-overlay"></div>
                </div>
            </div>
        </div>
        <!-- END: Page Main-->
@endsection
