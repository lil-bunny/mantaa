<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Mantaray') }}</title>

        <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
        <link rel="stylesheet" href="{{asset('front-assets/font-awesome/css/font-awesome.min.css') }}" type="text/css"/>
        <link href="{{asset('front-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-asset/css/animations.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-assets/css/slick.css') }}" rel="stylesheet" type="text/css">
        <link href="{{asset('front-assets/css/slick-theme.css') }}" rel="stylesheet" type="text/css">
        <link href="{{asset('front-assets/css/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-assets/css/responsive.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        
        <script src="{{asset('front-assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>
        <!-- Topbar -->
        @include('common.front_header')
        <!-- End of Topbar test -->

        @yield('content')

        <!-- Footer -->
        @include('common.front_footer')
        <!-- End of Footer -->

        <!-- BEGIN FOOTER JS-->
        
        <script src="{{asset('front-assets/js/popper.min.js') }}"></script>
        <script src="{{asset('front-assets/js/bootstrap.min.js') }}"></script>
        <script src="{{asset('front-assets/js/css3-animate-it.js') }}"></script>
        <script src="{{asset('front-assets/js/slick.min.js') }}"></script>
        <script src="{{asset('front-assets/js/jquery.fancybox.min.js') }}"></script>
        <script src="{{asset('front-assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{asset('front-assets/js/custom.js') }}"></script>
        <!-- END FOOTER JS-->

        <script type="text/javascript">
        if ($("#contactUsForm").length > 0) {
            $("#contactUsForm").validate({
                rules: {
                    user_id: {
                        required: true,
                        maxlength: 50
                    },
                    area_id: {
                        required: true,
                        maxlength: 50,
                    },  
                },
                messages: {
                    user_id: {
                        required: "Invalid data",
                        maxlength: "Invalid data"
                    },
                    area_id: {
                        required: "Invalid data",
                        maxlength: "Invalid data",
                    },
                },
                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#submit').html('Please Wait...');
                    $("#submit"). attr("disabled", true);
                    $.ajax({
                        url: "{{url('connect-request')}}",
                        type: "POST",
                        data: $('#contactUsForm').serialize(),
                        success: function( response ) {
                            $('#submit').html('Connect request raised successfully');
                        }
                    });
                }
            })
        }
        </script>
    </body>
</html>
