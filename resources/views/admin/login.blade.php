<!doctype html>
<html lang="en">

<!-- Mirrored from borderless.laborasyon.com/default/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Jun 2021 11:39:46 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Config::get('constants.website.title')}}</title>
    <link rel="shortcut icon" href="{{asset('public/favicon.png')}}" type="image/x-icon">

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{asset('public/admin/vendors/bundle.css')}}" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{asset('public/admin/css/app.min.css')}}" type="text/css">
    <!-- end::custom styles -->

</head>
<body class="bg-white h-100-vh p-t-0">

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading</span>
</div>
<!-- end::page loader -->

<div class="p-b-50 d-block d-lg-none"></div>

<div class="container h-100-vh">
    <div class="row align-items-md-center h-100-vh">
        <div class="col-lg-6 d-none d-lg-block">
            <img class="img-fluid" src="{{asset('public/navin.png')}}" alt="...">
        </div>
        <div class="col-lg-4 offset-lg-1">
            <div class="m-b-20">
                <img src="{{asset('public/logo.png')}}" class="m-r-15" width="180" alt="">
            </div>
            <p>Sign in to continue.</p>
            <x-flashMessage/>

            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="form-group mb-4">
                    <input type="text" class="form-control form-control-lg" name="email" id="exampleInputEmail1" autofocus placeholder="Email">
                </div>
                <div class="form-group mb-4">
                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button class="btn btn-primary btn-lg btn-block btn-uppercase mb-4">Sign In</button>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Keep me signed in</label>
                    </div>
                    {{-- <a href="#" class="auth-link text-black">Forgot password?</a> --}}
                </div>
                {{-- <div class="row">
                    <div class="col-md-6 mb-4">
                        <a href="#" class="btn btn-outline-facebook btn-block">
                            <i class="fa fa-facebook-square m-r-5"></i> With Facebook
                        </a>
                    </div>
                    <div class="col-md-6 mb-4">
                        <a href="#" class="btn btn-outline-google btn-block">
                            <i class="fa fa-google m-r-5"></i> With Google
                        </a>
                    </div>
                </div> --}}
                <div class="text-center">
                    {{-- Don't have an account? <a href="register.html" class="text-primary">Create</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>

<!-- begin::global scripts -->
<script src="{{asset('public/admin/vendors/bundle.js')}}"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="{{asset('public/admin/js/borderless.min.js')}}"></script>
<!-- end::custom scripts -->

</body>

<!-- Mirrored from borderless.laborasyon.com/default/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Jun 2021 11:39:47 GMT -->
</html>