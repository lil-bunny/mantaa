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
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
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
                <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Repeat Password" class="form-control" name="password_confirmation">
            </div>
            <div class="form-group">
                <input type="file" placeholder="Upload Image" class="form-control" name="profile_pic">
                <img 
                    id="prof-image"
                    onclick="imageModal(this);"
                    src="{{ url('public/application_files/user_images') . '/'. $user_data->image }}" 
                    alt="" 
                    class="image mt-3" 
                    height="100" width="100">
            </div>
            <button type="submit" class="btn btn-primary btn-submit w-100">Update</button>
        </form>
    </div>
</section>
<!-- // END EDIT USER BODY -->

<!-- Profile Image Modal -->
        
<div id="prof-img-modal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
</div>
        
<!-- End Profile Image Modal -->

<script type="text/javascript">
    var imgModal = document.getElementById('prof-img-modal');
    var modalImg = document.getElementById("img01");
    
    function imageModal(e){
        imgModal.style.display = "block";
        modalImg.src = e.src;
    }
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
        imgModal.style.display = "none";
    }
</script> 

@endsection

