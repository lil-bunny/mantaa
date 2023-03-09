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
                                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Connect Requests</span></h5>
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ route('admin.connect_request') }}">Connect Requests</a>
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
                            @if($connect_requests->count())
                                <div class="users-list-filter">
                                    <div class="card-panel">
                                        <div class="row">
                                            <form method="GET">
                                                <div class="col s12 m6 l6">
                                                    <label for="users-list-role">User</label>
                                                    <div class="input-field">
                                                        <select class="form-control" id="user-list" name="user_id">
                                                            <option value="">Any</option>
                                                            @foreach($users as $user)
                                                                @if($filters['user_id'] == $user->id)
                                                                    <option value="{{ $user->id }}" selected>{{ $user->full_name }}</option>
                                                                @else
                                                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col s12 m6 l6">
                                                    <label for="users-list-role">Area</label>
                                                    <div class="input-field">
                                                        <select class="form-control" id="area-list" name="area_id">
                                                            <option value="">Any</option>
                                                            @foreach($areas as $area)
                                                                @if($filters['area_id'] == $area->id)
                                                                    <option value="{{ $area->id }}" selected>{{ $area->title }}</option>
                                                                @else
                                                                    <option value="{{ $area->id }}">{{ $area->title }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col s12 m6 l3 display-flex align-items-center show-btn">
                                                    <button type="submit" class="btn btn-block indigo waves-effect waves-light">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="users-list-table">
                                <div class="card">
                                    <div class="card-content">
                                        <!-- datatable start -->
                                        <div class="responsive-table">
                                            @if($connect_requests->count())
                                                <table id="users-list-datatable1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>@sortablelink('id', 'ID')</th>
                                                            <th>@sortablelink('user.full_name', 'User')</th>
                                                            <th>@sortablelink('area.title', 'Area')</th>
                                                            <th>@sortablelink('created_at', 'Created')</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($connect_requests as $connect_request)
                                                            <tr>
                                                                <td>{{ $connect_request->id }}</td>
                                                                <td>{{ $connect_request->user->full_name }}</td>
                                                                <td>{{ $connect_request->area->title ?? '' }} </td>
                                                                <td>{{ $connect_request->created_at }}</td>
                                                                <td><a href="{{ route('admin.connect_request_view', ['id' => $connect_request->id]) }}"  title="View"><i class="material-icons">view</i></a>
                                                                    <a class="waves-effect waves-light modal-trigger" href="#modal{{$connect_request->id}}"><i class="material-icons red-text">delete</i></a>    
                                                                    <form action="{{ route('admin.connect_request_delete', ['id' => $connect_request->id]) }}" id="connect-request-{{$connect_request->id}}" method="POST">
                                                                        @csrf    
                                                                        <div class="modal" id="modal{{$connect_request->id}}" >
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="form-header">
                                                                                        <h3>Delete Connect Request</h3>
                                                                                        <p>Are you want to delete?</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">    
                                                                                <input type="submit" value="Delete" class="btn btn-primary continue-btn">
                                                                                <a href="javascript:void(0);" class="btn btn-primary continue-btn modal-action modal-close">Cancel</a>
                                                                            </div>                
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                {!! $connect_requests->appends(\Request::except('page'))->render() !!}
                                                <p>
                                                    Displaying {{$connect_requests->count()}} of {{ $connect_requests->total() }} connect requests.
                                                </p>
                                            @else
                                                <p>No records found</p>
                                            @endif
                                        </div>
                                        <!-- datatable ends -->
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- users list ends -->
                    </div>
                    <div class="content-overlay"></div>
                </div>
            </div>
        </div>
        <!-- END: Page Main-->
@endsection
