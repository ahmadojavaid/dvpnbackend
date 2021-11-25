<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8" />
    <title>Login - Admin Panel</title>
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

<body class="authentication-bg">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                <i class="mdi mdi-alert-circle-outline mr-2"></i>{{ Session::get('message') }}
                <script>
                    setTimeout(function(){
                        $('div.alert').toggle(1000);
                    },3500);
                </script>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="{{ url('/login') }}">
                                <span><img src="{{ asset('assets/admin/images/logo.png') }}" alt="" height="70"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                        </div>

                        <form action="{{ url('/user-login') }}" method="POST" class="needs-validation validateForm" novalidate>
                                @csrf
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email address</label>
                                <input class="form-control" type="email" name="email" id="emailaddress" required placeholder="Enter your email">
                                <div class="invalid-feedback">
                                    Valid email address is required
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" required id="password" placeholder="Enter your password">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="{{ url('/reset-password') }}" class="text-black ml-1">Forgot your password?</a></p>
                        </div> <!-- end col -->
                    </div>
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

<!-- Validation init js-->
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>

</body>

</html>