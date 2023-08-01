@extends('layouts.home')

@section('content')

<!-- // START LOGIN BODY -->
<div class="inner-shade"></div>
<section class="sec-pb sec-log-regi">
    <div class="container">
        <h1>Login</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form method="POST" action="{{ route('frontend.loginSubmit') }}">
            @csrf
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <input type="hidden" name="prev_route" value="{{ $prev_route ?? '' }}">
            <button class="btn btn-primary btn-submit w-100" type="submit">Login</button>
            <div class="d-flex justify-content-between flex-wrap-xs">
                <p class="text-muted mt-3 mb-0 w-100-xs"><a href="{{ route('frontend.showForgetPasswordForm') }}">Forgot password?</a></p>
                <p class="text-muted mt-sm-3 w-100-xs">Don't have an account? <a href="javascript:void(0)">Sign up</a></p>
            </div>
        </form>
        <div class="mt-2 mt-sm-5 or-text"><span>OR</span></div>
        <a href="{{ route('google.login') }}" class="mt-4 mt-sm-5 d-block gbtn"><img src="{{asset('front-assets/images/google-login.png') }}" alt="icon"></a>
    </div>
</section>
<!-- // END LOGIN BODY -->
@endsection