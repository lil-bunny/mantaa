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
                                            <!-- Admin Users Edit account form start -->
                                            <form id="accountForm" method="post" enctype='multipart/form-data' action="{{ route('admin.update_user',['id'=>$user_data->id]) }}">
                                            @csrf    
                                            <div class="row">
                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="role_id">
                                                                    @foreach($roles as $role)
                                                                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                                                                    @endforeach                                    
                                                                </select>
                                                                <label>Role</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <input id="name" name="name" type="text" class="validate" value="{{ $user_data->full_name }}" data-error=".errorTxt2">
                                                                <label for="name">Name</label>
                                                                <small class="errorTxt2"></small>
                                                            </div>
                                                            <div class="col s12 input-field">
                                                                <input id="email" name="email" type="email" class="validate" value="{{ $user_data->email }}" data-error=".errorTxt3">
                                                                <label for="email">E-mail</label>
                                                                <small class="errorTxt3"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m6">
                                                        <div class="row">
                                                            <div class="col s12 input-field">
                                                                <select name="status">
                                                                    <option value="1" {{ $user_data->status==1 ? 'selected' : ''}}>Active</option>
                                                                    <option value="0" {{ $user_data->status==0 ? 'selected' : ''}}>Inactive</option>
                                                                </select>
                                                                <label>Status</label>
                                                            </div>
                                                            <div class="col s12 input-field">
                                                                <input id="mobile" name="mobile" type="text" value="{{ $user_data->mobile }}" class="validate">
                                                                <label for="mobile">Mobile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col s6 input-field">
                                                                <input id="password" name="password" type="password" class="validate">
                                                                <label for="password">Password</label>
                                                            </div>
                                                            <div class="col s6 input-field">
                                                                <input id="cnf_password" name="cnf_password" type="password" class="validate">
                                                                <label for="cnf_password">Confirm Password</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m12">
                                                        <div class="row">
                                                            <div class="col m6 s12 file-field input-field">
                                                                <div class="btn float-right">
                                                                    <span>Upload Image</span>
                                                                    <input type="file" name="profile_pic">
                                                                </div>    
                                                            </div>
                                                            <img src="{{ url('application_files/user_images') . '/'. $user_data->image }}" alt="" class="image" height="100" width="100">
                                                        </div>
                                                    </div>
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
