@extends('layouts.home')

@section('content')

<!-- // START REGISTER BODY -->
<section class="sec-ptb sec-log-regi">
    <div class="container">
        <h1>Sign Up</h1>
        <form>
            <div class="form-group">
                <input type="text" placeholder="Name" class="form-control" name="">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control" name="">
            </div>
            <div class="form-group">
                <input type="passowrd" placeholder="Password" class="form-control" name="">
            </div>
            <div class="form-group">
                <input type="passowrd" placeholder="Repeat Password" class="form-control" name="">
            </div>
            <button class="btn btn-primary btn-submit w-100">Sign Up</button>
            <p class="text-muted mt-3">Already have an account? <a href="login.html">Login</a></p>
        </form>
        <div class="or-text mt-2 mt-sm-5"><span>OR</span></div>
        <a href="#" class="mt-4 mt-sm-5 d-block gbtn"><img src="assets/images/google-login.png" alt="icon"></a>
    </div>
</section>
<!-- // END REGISTER BODY -->