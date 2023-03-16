@extends('layouts.home')

@section('content')

<!-- // START EDIT USER BODY -->
<section class="sec-ptb sec-log-regi">
    <div class="container">
        <h1>Update Profile</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" enctype='multipart/form-data' action="{{ route('frontend.update_user') }}">
            @csrf
            <div class="form-group">
                <input type="text" placeholder="Name" value="{{ $user_data->full_name }}" class="form-control" name="name">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" value="{{ $user_data->email }}" class="form-control" name="email">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Phone" value="{{ $user_data->mobile }}" class="form-control" name="mobile">
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <input id="cnf_password" type="password" placeholder="Repeat Password" class="form-control" name="cnf_password">
            </div>
            <div class="form-group">
                <input type="file" placeholder="Upload Image" class="form-control" name="profile_pic">
                <img src="{{ url('public/application_files/user_images') . '/'. $user_data->image }}" alt="" class="image mt-3" height="100" width="100">
            </div>
            <button type="submit" class="btn btn-primary btn-submit w-100">Update</button>
        </form>
    </div>
</section>
<!-- // END EDIT USER BODY -->
@endsection