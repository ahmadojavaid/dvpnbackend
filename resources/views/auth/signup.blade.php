<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8" />
    <title>Sign Up - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Driver Pilot is the new way to learn and pass your driving test" name="description"/>
    <meta content="Jobesk" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert">
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
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
                            <a href="{{ url('admin/login') }}">
                                <span><img src="{{ asset('assets/img/header assets/logoscg.png') }}" alt="" height="22"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Don't have an account? Create your account, it takes less than a minute</p>
                        </div>

                        <form action="{{ url('admin/create-admin') }}" method="POST" class="needs-validation validateForm" novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                <div class="invalid-feedback">
                                    Please choose a name.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                <div class="invalid-feedback">
                                    Please choose a name.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">Email address</label>
                                <input class="form-control" type="email" id="emailaddress" name="email" required placeholder="Enter your email">
                                <div class="invalid-feedback">
                                    Valid email address is required
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" required id="password" placeholder="Enter your password" >
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input class="form-control" type="password"  name="confirm_password" required id="confirm password" placeholder="Confirm password" >
                                <div class="invalid-feedback">
                                    Confirm Password is required
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup" required>
                                    <label class="custom-control-label" for="checkbox-signup">I accept <a href="{{ url('/terms-and-conditions') }}" class="text-dark">Terms and Conditions</a></label>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success btn-block" type="submit"> Sign Up </button>
                            </div>

                        </form>

                    </div> <!-- end card-body -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-black-50-50">Already have an account?  <a href="{{ url('admin/login') }}" class="text-black ml-1"><b>Sign In</b></a></p>
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