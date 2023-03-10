@extends('admin::layouts.admin_dashboard')

@section('content')

<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="col s12">
            <div class="container">
                <div class="section">
                    
                    
                    <div class="row">
                        <div class="col s12 m4 l4">
                            <div class="card padding-4 animate fadeLeft">
                                <div class="row">
                                    <div class="col s5 m5">
                                        <h5 class="mb-0">{{ $active_user_count }}</h5>
                                        <p class="no-margin">Active</p>
                                        <p class="mb-0 pt-8">{{ $total_user_count }}</p>
                                    </div>
                                    <div class="col s7 m7 right-align">
                                        <i class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                        <p class="mb-0">Total Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            <div class="card pt-0 pb-0 animate fadeLeft">
                                <div class="card padding-4 animate fadeLeft">
                                    <div class="row">
                                        <div class="col s5 m5">
                                            <h5 class="mb-0">{{ $active_area_count }}</h5>
                                            <p class="no-margin">Active</p>
                                            <p class="mb-0 pt-8">{{ $total_area_count }}</p>
                                        </div>
                                        <div class="col s7 m7 right-align">
                                            <i
                                                class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                            <p class="mb-0">Sites</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            <div class="card pt-0 pb-0 animate fadeLeft">
                                <div class="card padding-4 animate fadeLeft">
                                    <div class="row">
                                        <div class="col s5 m5">
                                            <h5 class="mb-0">{{ $connect_request_count }}</h5>
                                            <p class="no-margin">Active</p>
                                        </div>
                                        <div class="col s7 m7 right-align">
                                            <i class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                            <p class="mb-0">Connect Requests</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s12 m6 l12">
                            <section class="users-list-wrapper section">
                                
                                <div class="users-list-table">
                                    <div class="card">
                                    
                                            <!-- <div class="card-content pb-1"> -->
                                            <h4 class="card-title mb-0">Recent Onboarded Sites</h4>
                                            
                                            <!-- datatable start -->
                                            <div class="responsive-table">
                                                <table id="users-list-datatable" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Date & Time</th>
                                                            <th>Title</th>
                                                            <th>Site Location</th>
                                                            <th>Pincode</th>
                                                            <th>City</th>
                                                            <th>State</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($area_data as $area)
                                                        <tr>
                                                            <th>{{ $area->id }}</th>
                                                            <td>{{ $area->created_at }}</td>
                                                            <td>{{ $area->title }}</td>
                                                            <td>{{ $area->site_location }}</td>
                                                            <td>{{ $area->pin_code }}</td>
                                                            <td>{{ $area->city->name }}</td>
                                                            <td>{{ $area->state->name }}</td>
                                                            <td>
                                                                @if($area->status == 1)
                                                                    <span class="chip green lighten-5">
                                                                        <span class="green-text">Active</span>
                                                                    </span>
                                                                @else
                                                                    <span class="chip green lighten-5">
                                                                        <span class="green-text">Inactive</span>
                                                                    </span>
                                                                @endif
                                                            </td>    
                                                            <td>
                                                                <a href="{{ route('admin.area_edit', ['id' => $area->id]) }}"  title="Edit Area"><i class="material-icons">edit</i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- datatable ends -->
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Page Main-->
@endsection
