@extends('layouts.home')

@section('content')

<!-- // START REGISTER BODY -->
<div class="inner-shade"></div>
<section class="sec-pb sec-log-regi">
    <div class="container">
        <h1>Sign Up</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('frontend.registerSubmit') }}">
            @csrf
            <div class="form-group">
                <input type="text" placeholder="Name" class="form-control" name="name">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Phone" class="form-control" name="mobile">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Repeat Password" class="form-control" name="cnf_password">
            </div>
            <button type="submit" class="btn btn-primary btn-submit w-100">Sign Up</button>
            <p class="text-muted mt-3">Already have an account? <a href="{{ route('frontend.login') }}">Login</a></p>
        </form>
        <div class="or-text mt-2 mt-sm-5"><span>OR</span></div>
        <a href="{{ route('google.login') }}" class="mt-4 mt-sm-5 d-block gbtn"><img src="{{ asset('front-assets/images/google-login.png') }}" alt="icon"></a>
    </div>
</section>
<!-- // END REGISTER BODY -->
@endsection