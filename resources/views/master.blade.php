<!doctype html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Title Of Site -->
	<title>{{$title}}</title>
	<meta name="description" content="HTML Responsive Landing Page Template for Course Online Based on Twitter Bootstrap 3.x.x" />
	<meta name="keywords" content="study, learn, course, tutor, tutorial, teach, college, school, institute, teacher, instructor" />
	<meta name="author" content="crenoveative">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- Fav and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('public/frontend/images/ico/apple-touch-icon-144-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('public/frontend/images/ico/apple-touch-icon-114-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('public/frontend/images/ico/apple-touch-icon-72-precomposed.png')}}">
	<link rel="apple-touch-icon-precomposed" href="{{asset('public/frontend/images/ico/apple-touch-icon-57-precomposed.png')}}">
	<link rel="shortcut icon" href="images/ico/favicon.png">

    <!-- CSS Plugins -->
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/bootstrap/css/bootstrap.min.css')}}" media="screen">	
	<link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/plugin.css')}}" rel="stylesheet">

	<!-- CSS Custom -->
	<link href="{{asset('public/frontend/css/style.css')}}" rel="stylesheet">
	
	<!-- For your own style -->
	<link href="{{asset('public/frontend/css/your-style.css')}}" rel="stylesheet">

	
</head>

<body>
	
	<div id="introLoader" class="introLoading"></div>
	<div class="container-wrapper">

		

        <x-FrontNavBar :frontMenu="$frontMenu"/>
        
		<!-- end Header -->

		<!-- start Main Wrapper -->
		@yield('content')
		<!-- end Main Wrapper -->
		
		<!-- start Footer Wrapper -->
        <x-FrontFooterBar/>
		<!-- end Footer Wrapper -->
		
	</div>
	<!-- end Container Wrapper -->
 
 
<!-- start Back To Top -->
<div id="back-to-top">
   <a href="#"><i class="ion-ios-arrow-up"></i></a>
</div>
<!-- end Back To Top -->

<div id="ajaxLoginModal" class="modal fade login-box-wrapper" data-width="500" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
		
<div id="ajaxRegisterModal" class="modal fade login-box-wrapper" data-width="500" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;">
</div>

<div id="ajaxForgotPasswordModal" class="modal fade login-box-wrapper" data-width="500" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>


<!-- JS -->
<script type="text/javascript" src="{{asset('public/frontend/js/jquery-2.2.4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery-migrate-1.4.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery.waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery.easing.1.3.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/SmoothScroll.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/spin.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery.introLoader.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/typed.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/placeholderTypewriter.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery.slicknav.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery.placeholder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/ion.rangeSlider.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/readmore.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/bootstrap-rating.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/jquery.nicescroll.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/creditly.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/bootstrap-modalmanager.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/bootstrap-modal.js')}}"></script>
<script type="text/javascript" src="{{asset('public/frontend/js/customs.js')}}"></script>
@stack('footer-script')


</body>



<!-- Mirrored from crenoveative.com/envato/edutute/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Dec 2019 10:54:39 GMT -->
</html>