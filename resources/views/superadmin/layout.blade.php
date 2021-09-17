<!doctype html>
<html lang="en">

<!-- Mirrored from borderless.laborasyon.com/default/dashboard-one.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Jun 2021 11:38:46 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Config::get('constants.website.title')}}</title>

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{asset('public/admin/vendors/bundle.css')}}" type="text/css">
    <!-- end::global styles -->

     <!-- begin::dataTable -->
     <link rel="stylesheet" href="{{asset('public/admin/vendors/dataTable/responsive.bootstrap.min.css')}}" type="text/css">
     <!-- end::dataTable -->

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- begin::datepicker -->
    <link rel="stylesheet" href="{{asset('public/admin/vendors/datepicker/daterangepicker.css')}}">
    <!-- begin::datepicker -->

    <!-- begin::vmap -->
    <link rel="stylesheet" href="{{asset('public/admin/vendors/vmap/jqvmap.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('public/admin/vendors/fontawesome-webfont.ttf')}}"> --}}
    <!-- begin::vmap -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{asset('public/admin/css/app.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/admin/css/custom.css')}}" type="text/css">
    <!-- end::custom styles -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        .error{
            color:red;
        }
    </style>

    

    

</head>
<body>

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading</span>
</div>
<!-- end::page loader -->

<!-- begin::sidebar -->

<x-SuperadminSideBar/>

<!-- end::sidebar -->

<!-- begin::side menu -->
<x-SuperadminSideMenu :mainSuperAdminMenu="$mainSuperAdminMenu" :superadminSubMenu="$superadminSubMenu"/>
<!-- end::side menu -->

<!-- begin::navbar -->
<x-SuperadminNavBar/>
<!-- end::navbar -->

<!-- begin::main content -->
@yield('content')
<!-- end::main content -->

<!-- begin::global scripts -->
<script src="{{asset('public/admin/vendors/bundle.js')}}"></script>
<!-- end::global scripts -->





@stack('footer-script')

<!-- begin::custom scripts -->
<script src="{{asset('public/admin/js/custom.js')}}"></script>
<script src="{{asset('public/admin/js/borderless.min.js')}}"></script>
<!-- end::custom scripts -->

<script>
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        
        swal({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be recover!',
            icon: 'warning',
            
            dangerMode: true,
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                swal("success!", "Successfully deleted!", "success");
                window.location.href = url;
            }
        });
    });


</script>


</body>

<!-- Mirrored from borderless.laborasyon.com/default/dashboard-one.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Jun 2021 11:39:16 GMT -->
</html>