@extends('layouts.home')

@section('content')

<!-- // Start Forgot-Pasword Body -->

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
        <form action="{{ route('frontend.submitForgetPasswordForm') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control" name="email">
            </div>
            <button class="btn btn-primary btn-submit w-100" type="submit">Send Reset Password Link</button>
        </form>
    </div>
</section>

<!-- End Forgot Password body -->

@endsection