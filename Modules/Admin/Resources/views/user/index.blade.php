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
                                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Admin Users</span></h5>
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="{{ route('admin.user') }}">Users</a>
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
                            <div class="row">
                                <div class="col s12 m6 l10">
                                    &nbsp;
                                </div>
                                <div class="col s12 m6 l2 display-flex align-items-center show-btn mb-3">
                                    <a class="btn waves-effect waves-light invoice-create border-round z-depth-4" href="{{ route('admin.user_add') }}"><i class="material-icons">add</i>Add User</a>
                                </div>
                            </div>
                            <div class="users-list-filter">
                                <div class="card-panel">
                                    <div class="row">
                                        <form method="GET">
                                            <div class="col s12 m6 l3">
                                                <label for="users-list-verified">Name</label>
                                                <div class="input-field">
                                                    <input type="text" name="user_name" class="form-control" id="users-list-verified" value="{{ $filters['user_name'] }}">
                                                </div>
                                            </div>
                                            <div class="col s12 m6 l3">
                                                <label for="users-list-role">Role</label>
                                                <div class="input-field">
                                                    <select class="form-control" id="users-list-role" name="role_id">
                                                        <option value="">Any</option>
                                                        @foreach($roles as $role)
                                                            @if($filters['role_id'] == $role->id)
                                                                <option value="{{ $role->id }}" selected>{{ $role->title }}</option>
                                                            @else
                                                                <option value="{{ $role->id }}">{{ $role->title }}</option>
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
                                            @if($users->count())
                                                <table id="users-list-datatable1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>@sortablelink('id', 'ID')</th>
                                                            <th>@sortablelink('full_name', 'Name')</th>
                                                            <th>@sortablelink('role.title', 'Role')</th>
                                                            <th>Status</th>
                                                            <th>@sortablelink('created_at', 'Created')</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($users as $user)
                                                            <tr>
                                                                <td>{{ $user->id }}</td>
                                                                <td>{{ $user->full_name }}</td>
                                                                <td>{{ $user->role->title }} </td>
                                                                <td>
                                                                    @if($user->status == 1)
                                                                    <span class="chip green lighten-5">
                                                                        <span class="green-text">Active</span>
                                                                    </span>
                                                                    @else
                                                                    <span class="chip green lighten-5">
                                                                        <span class="green-text">Inactive</span>
                                                                    </span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $user->created_at }}</td>
                                                                <td><a href="{{ route('admin.user_edit', ['id' => $user->id]) }}"  title="Edit User"><i class="material-icons">edit</i></a>
                                                                    <a class="waves-effect waves-light modal-trigger" href="#modal{{$user->id}}"><i class="material-icons red-text">delete</i></a>    
                                                                    <form action="{{ route('admin.user_delete', ['id' => $user->id]) }}" id="user-{{$user->id}}" method="POST">
                                                                        @csrf    
                                                                        <div class="modal" id="modal{{$user->id}}" >
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="form-header">
                                                                                        <h3>Delete user</h3>
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
                                                {!! $users->appends(\Request::except('page'))->render() !!}
                                                <p>
                                                    Displaying {{$users->count()}} of {{ $users->total() }} users.
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
