@extends('layouts.home')

@section('content')

<section class="sec-ptb sec-log-regi">
    <div class="container">
        <h1>Reset Password</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('frontend.submitResetPasswordForm') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control" name="email">
            </div>
  
            <div class="form-group">
                <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
  
            <div class="form-group">
                <input type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation">
            </div>
            <button class="btn btn-primary btn-submit w-100" type="submit">Reset Password</button>
        </form>
    </div>
</section>
