<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8" />
    <title>Set Your New Password - DorkVPN Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="G&D Deposit Tracker" name="description"/>
    <meta content="Jobesk" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">
                    @if(Session::has('message'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                            <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('message') }}
                            <script>
                                // setTimeout(function(){
                                $('div.alert').toggle(1000);
                                // },3500);
                            </script>
                        </div>
                    @endif
                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="index.html">
                                <span><img src="{{ asset('assets/admin/images/logo.png') }}" alt="" height="70"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Please set your new password</p>
                        </div>

                        <form action="{{ url('change-user-password') }}" method="POST" class="parsley-examples">
                            @csrf
                            <input type="hidden" name="userID" value="{{ $userID }}">
                            <div class="form-group mb-3">
                                <label for="newPassword">New Password</label>
                                <input class="form-control" type="password" id="newPassword" name="newPassword" required="" placeholder="Enter your new password">
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirmPassword">Confirm Password</label>
                                <input class="form-control" data-parsley-equalto="#newPassword" type="password" id="confirmPassword" name="confirmPassword" required="" placeholder="Confirm your new password">
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Change Password </button>
                            </div>

                        </form>

                    </div> <!-- end card-body -->
                    <!-- end row -->
                </div>
                <!-- end card -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<footer class="footer footer-alt">
    2019 &copy; DorkVPN. All rights reserved.
</footer>

<!-- Vendor js -->
<script src="{{ asset('assets/admin/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/admin/js/app.min.js') }}"></script>

<!-- Plugin js-->
<script src="{{ asset('assets/admin/libs/parsleyjs/parsley.min.js') }}"></script>

<!-- Validation init js-->
<script src="{{ asset('assets/admin/js/pages/form-validation.init.js') }}"></script>

</body>

</html>