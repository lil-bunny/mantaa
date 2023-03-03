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
                                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Admin Feedbacks</span></h5>
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ route('admin.feedback') }}">Feedbacks</a>
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
                                            <div class="col s12 m6 l3">
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
                                            <div class="col s12 m6 l3">
                                                <label for="users-list-status">Status</label>
                                                <div class="input-field">
                                                    <select class="form-control" id="users-list-status" name="status">
                                                        <option value="">Any</option>
                                                        @if($filters['status'] == 1)
                                                            <option value="1" selected>Active</option>
                                                        @else
                                                            <option value="1">Active</option>
                                                        @endif
                                                        @if($filters['status'] == 0)
                                                            <option value="0" selected>Inactive</option>
                                                        @else
                                                            <option value="0">Inactive</option>
                                                        @endif
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
                            <div class="users-list-table">
                                <div class="card">
                                    <div class="card-content">
                                        <!-- datatable start -->
                                        <div class="responsive-table">
                                            @if($feedbacks->count())
                                                <table id="users-list-datatable1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>@sortablelink('id', 'ID')</th>
                                                            <th>@sortablelink('user.full_name', 'User')</th>
                                                            <th>@sortablelink('area.title', 'Area')</th>
                                                            <th>Status</th>
                                                            <th>@sortablelink('created_at', 'Created')</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($feedbacks as $feedback)
                                                            <tr>
                                                                <td>{{ $feedback->id }}</td>
                                                                <td>{{ $feedback->user->full_name }}</td>
                                                                <td>{{ $feedback->area->title ?? '' }} </td>
                                                                <td>
                                                                    @if($feedback->status == 1)
                                                                    <span class="chip green lighten-5">
                                                                        <span class="green-text">Active</span>
                                                                    </span>
                                                                    @else
                                                                    <span class="chip green lighten-5">
                                                                        <span class="green-text">Inactive</span>
                                                                    </span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $feedback->created_at }}</td>
                                                                <td><a href="{{ route('admin.feedback_edit', ['id' => $feedback->id]) }}"  title="Edit Feedback"><i class="material-icons">edit</i></a>
                                                                    <a class="waves-effect waves-light modal-trigger" href="#modal{{$feedback->id}}"><i class="material-icons red-text">delete</i></a>    
                                                                    <form action="{{ route('admin.feedback_delete', ['id' => $feedback->id]) }}" id="feedback-{{$feedback->id}}" method="POST">
                                                                        @csrf    
                                                                        <div class="modal" id="modal{{$feedback->id}}" >
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="form-header">
                                                                                        <h3>Delete feedback</h3>
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
                                                {!! $feedbacks->appends(\Request::except('page'))->render() !!}
                                                <p>
                                                    Displaying {{$feedbacks->count()}} of {{ $feedbacks->total() }} feedbacks.
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
