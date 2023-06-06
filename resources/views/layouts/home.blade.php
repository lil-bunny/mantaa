<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Mantaray') }}</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front-assets/images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front-assets/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front-assets/images/favicon-16x16.png') }}">
        <link rel="stylesheet" href="{{asset('front-assets/font-awesome/css/font-awesome.min.css') }}" type="text/css"/>
        <link href="{{asset('front-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-asset/css/animations.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-assets/css/slick.css') }}" rel="stylesheet" type="text/css">
        <link href="{{asset('front-assets/css/slick-theme.css') }}" rel="stylesheet" type="text/css">
        <link href="{{asset('front-assets/css/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('front-assets/css/responsive.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="{{asset('front-assets/css/jquery-ui.min.css') }}" />
        
        <script src="{{asset('front-assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{asset('front-assets/js/jquery-ui.min.js') }}"></script>
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

        if ($("#dloadForm").length > 0) {
            $("#dloadForm").validate({
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
                    $('#dloadSubmit').html('Please Wait...');
                    $("#dloadSubmit").attr("disabled", true);
                    $.ajax({
                        url: "{{url('dload-file')}}",
                        type: "POST",
                        data: $('#dloadForm').serialize(),
                        success: function(res) {
                            console.log(res.file_name);

                            // changing the submit link
                            $('#dloadSubmit').html('Download Successfull');

                            // downloading the file
                            const link = document.createElement("a");
                            link.download = res.file_name;
                            link.href = res.file_url;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    });
                }
            })
        }
        </script>
    </body>
</html>
