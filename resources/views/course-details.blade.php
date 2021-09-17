@extends('master')
@section('content')
    

<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
		
    <div class="breadcrumb-wrapper">
    
        <div class="container">
        
            <div class="row">
            
                <div class="col-xs-12 col-sm-8">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Course Category</a></li>
                        <li><a href="#">Course Result</a></li>
                        <li class="active">Course Detail</li>
                    </ol>
                </div>
                
                <div class="col-xs-12 col-sm-4 hidden-xs">
                    <p class="hot-line"> <i class="fa fa-phone"></i> Hot Line: 1-222-33658</p>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <div class="course-detail-header">
    
        <div class="container">
            
            <div class="info clearfix">
                        
                <div class="image">
                    <img src="{{asset('public/uploads/products/'.$product->image)}}" alt="Image" class="img-responsive" />
                </div>
                <div class="content">
                    <h2>{{$product->name}}</h2>
                </div>
                
                <ul class="meta-list">
                    
                    <li>
                        <div class="meta-teacher clearfix">
                            <?php                                              
                                $getTeacher = App\Helpers\Frontend::getTeacher($product->teacher_id); 
                                
                            ?>

                            <div class="image">
                                <img src="{{asset('public/frontend/images/man/01.jpg')}}" alt="Images" />
                            </div>
                            <div class="content">
                                <span class="text-muted mt-3 block">Teacher</span>
                                
                                <?php  echo (!empty($getTeacher->username))? '<h6>'.$getTeacher->username.'</h6>':""; ?>
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <div class="meta-category">
                            <div class="content">
                                <span class="text-muted mt-3 block">Category</span>
                                <h6><a href="#" class="anchor">{{$product->category}}</a></h6>
                            </div>
                        </div>
                    </li>
                    
                    {{-- <li>
                        <div class="meta-category">
                            <div class="content">
                                <span class="text-muted mt-3 block">Duation</span>
                                <h6>5.4 hours (24 lessons)</h6>
                            </div>
                        </div>
                    </li> --}}
                    
                    <li>
                        <div class="meta-rating">
                            <span class="text-muted mt-3 block">Reviews</span>
                            <div class="rating-wrapper">
                                <div class="rating-item">
                                    <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                </div>
                                <span> (7 review)</span>
                            </div>
                        </div>
                    </li>
                    
                    <li class="meta-price">
                        <div class="price bg-danger"><?php  
                            $mode = 'online';
                          $getprice = App\Helpers\Frontend::getProductPrice($product->id,$mode); 
                            // print_r($getprice->price);
                            echo (!empty($getprice->price))? "<i class='fa fa-inr'></i>".$getprice->price:"";
                        ?></div>
                    </li>
                    
                </ul>
                
            </div>

        </div>
        
    </div>

    <div class="equal-content-sidebar-wrapper detail-page-wrapper">
        
        <div class="equal-content-sidebar-by-gridLex">

            <div class="container">
            
                <div class="GridLex-grid-noGutter-equalHeight">
                    
                    <div class="GridLex-col-3_sm-4_xs-12_xss-12 hidden-xs">
                    
                        <aside class="sidebar-wrapper">
                    
                            <div class="scrollspy-sidebar alt-style-01">
                            
                                <ul class="scrollspy-sidenav">
                                
                                    <li class="heading"><h5>Course Menu</h5></li>
                                    <li>
                                    
                                        <ul class="nav faq-nav">
                                            <li><a href="#course-detail-section-0" class="anchor">Course Introduction</a></li>
                                            <li><a href="#course-detail-section-1" class="anchor">Course Lession</a></li>
                                            <li><a href="#course-detail-section-2" class="anchor">About Teacher</a></li>
                                            <li><a href="#course-detail-section-3" class="anchor">Review</a></li>
                                            <li><a href="#course-detail-section-4" class="anchor">Related Courses</a></li>
                                        </ul>
                                        
                                    </li>

                                </ul>
                                
                                <div class="clearfix mb-20 mt-30">
                                    <a href="#" class="btn btn-primary btn-block btn-md">Attend Now</a>
                                </div>
                                
                                <div class="call-featiured">
                
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    
                                    <div class="content">
                                        <h5>Call for more details</h5>
                                        <p class="phone-number">
                                            +66-85-658-8754
                                        </p>
                                    </div>

                                </div>
                                
                                <div class="favor-link-wrapper mb-30">
                                    <a href="#" class="favor-link"><i class="fa fa-tags"></i> Redeem a Coupon </a>
                                    <a href="#" class="favor-link"><i class="fa fa-heart"></i> Add To Wishlist</a>
                                    <a href="#" class="favor-link"><i class="fa fa-search-plus"></i> Free Preview</a>
                                    <a href="#" class="favor-link"><i class="fa fa-gift"></i> Gift This Course</a>
                                </div>
                                
                            </div>

                        </aside>
                        
                    </div>
                    
                    <div class="GridLex-col-9_sm-8_xs-12_xss-12">
                        
                        <div class="content-wrapper">
                    
                            <div class="detail-content-wrapper">

                                <div id="course-detail-section-0" class="course-detail-section">
                                    
                                    <div class="section-title text-left mb-20">
                                        <h3>Course Introduction</h3>
                                    </div>
                                    
                                    <div class="flex-video vimeo mb-40"> 
                                        

                                        <iframe width="420" height="345" src="<?php echo $product->video_url ?>">
                                        </iframe>


                                    </div>
                                    
                                    <div class="course-intro">
                                    
                                        <div class="listing-box clearfix">
                                        
                                            <h5>Course Highlight</h5>
                                            
                                            <ul class="listing-box-list">
                                            
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-6"><i class="fa fa-bars mr-5"></i> Level</div>
                                                        <div class="col-xs-7 col-sm-6 text-right font600">Begining</div>
                                                    </div>
                                                </li>
                                                
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-6"><i class="fa fa-clock-o mr-5"></i> Duration</div>
                                                        <div class="col-xs-7 col-sm-6 text-right font600">5.4 houres</div>
                                                    </div>
                                                </li>
                                                
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-5"><i class="fa fa-calendar mr-5"></i> Start</div>
                                                        <div class="col-xs-7 col-sm-7 text-right font600">November 14, 2016</div>
                                                    </div>
                                                </li>
                                                
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-5"><i class="fa fa-pencil-square-o mr-5"></i> Lesson</div>
                                                        <div class="col-xs-7 col-sm-7 text-right font600"> 24 lessons</div>
                                                    </div>
                                                </li>
                                                
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-5"><i class="fa fa-file-video-o mr-5"></i> Type</div>
                                                        <div class="col-xs-7 col-sm-7 text-right font600"> Video online</div>
                                                    </div>
                                                </li>
                                                
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-5"><i class="fa fa-users mr-5"></i> No. Student</div>
                                                        <div class="col-xs-7 col-sm-7 text-right font600"> 15 availabilities</div>
                                                    </div>
                                                </li>
                                                
                                                <li>
                                                    <div class="row gap-10">
                                                        <div class="col-xs-5 col-sm-5"><i class="fa fa-graduation-cap"></i> Includes</div>
                                                        <div class="col-xs-7 col-sm-7 text-right font600"> CCPA+ certificate</div>
                                                    </div>
                                                </li>
                                                
                                            </ul>
                                            
                                        </div>
                                    
                                    </div>

                                    <h5 class="text-uppercase font700">About the course</h5>
                                    
                                   {{$product->description}}                    
                                </div>
                                
                                <div id="course-detail-section-1" class="course-detail-section">
                                
                                    <div class="section-title text-left mb-20">
                                    
                                        <h3>Course Lession</h3>
                            
                                    </div>
                                    
                                    <div class="course-lession-wrapper">

                                         <?php                                              
                                            $getTeacher = App\Helpers\Frontend::getTeacher($product->teacher_id); 
                                            
                                        ?>
                                        <div class="course-lession-item">
                                        
                                            <div class="course-lession-header">
                                            
                                                <h6>Lession 1 - Introduction to Photoshop CS6 Extremely</h6>
                                                
                                            </div>
                                            
                                            <ul class="course-lession-list">
                                            
                                                <li class="clearfix">
                                                
                                                    <a href="#">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.01</span> - Getting Started <span class="label label-primary">Preview</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-video-camera"></i> video 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 5:06 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix">
                                                
                                                    <a href="#">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.02</span> - Basic Editing <span class="label label-success">Free</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-video-camera"></i> video 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 7:45 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.03</span> - Interface Introduction <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 10:11 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.04</span> - All Selection Tools <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text <span class="mh-5">|</span> <i class="fa fa-file-pdf-o"></i> pdf
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 6:36 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.05</span> - Brushes/Painting <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 8:44 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.06</span> - Masking <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text <span class="mh-5">|</span> <i class="fa fa-file-pdf-o"></i> pdf
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 6:36 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.07</span> - Quiz <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-pencil"></i> exam 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 35 Questions
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                            </ul>
                                        
                                        </div>

                                        <div class="course-lession-item">
                                        
                                            <div class="course-lession-header">
                                            
                                                <h6>Lession 2 - Photoshop CS6 workspace and features</h6>
                                                
                                            </div>
                                            
                                            <ul class="course-lession-list">

                                                <li class="clearfix">
                                                
                                                    <a href="#">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.01</span> - Basic Editing <span class="label label-success">Free</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-video-camera"></i> video 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 7:45 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.02</span> - Interface Introduction <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 10:11 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.03</span> - All Selection Tools <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text <span class="mh-5">|</span> <i class="fa fa-file-pdf-o"></i> pdf
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 6:36 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.04</span> - Brushes/Painting <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 8:44 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.05</span> - Quiz <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-pencil"></i> exam 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 35 Questions
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                            </ul>
                                        
                                        </div>
                                        
                                        <div class="course-lession-item">
                                        
                                            <div class="course-lession-header">
                                            
                                                <h6>Lession 3 - Adobe Bridge For Photo Management</h6>
                                                
                                            </div>
                                            
                                            <ul class="course-lession-list">
                                            
                                                <li class="clearfix">
                                                
                                                    <a href="#">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.01</span> - Getting Started <span class="label label-primary">Preview</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-video-camera"></i> video 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 5:06 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix">
                                                
                                                    <a href="#">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.02</span> - Basic Editing <span class="label label-success">Free</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-video-camera"></i> video 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 7:45 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.03</span> - Interface Introduction <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 10:11 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.04</span> - All Selection Tools <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text <span class="mh-5">|</span> <i class="fa fa-file-pdf-o"></i> pdf
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 6:36 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.05</span> - Brushes/Painting <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 8:44 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.06</span> - Masking <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text <span class="mh-5">|</span> <i class="fa fa-file-pdf-o"></i> pdf
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 6:36 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">1.07</span> - Quiz <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-pencil"></i> exam 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 35 Questions
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                            </ul>
                                        
                                        </div>

                                        <div class="course-lession-item">
                                        
                                            <div class="course-lession-header">
                                            
                                                <h6>Lession 4 - Image adjustments</h6>
                                                
                                            </div>
                                            
                                            <ul class="course-lession-list">

                                                <li class="clearfix">
                                                
                                                    <a href="#">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.01</span> - Basic Editing <span class="label label-success">Free</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-video-camera"></i> video 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 7:45 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.02</span> - Interface Introduction <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 10:11 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.03</span> - All Selection Tools <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text <span class="mh-5">|</span> <i class="fa fa-file-pdf-o"></i> pdf
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 6:36 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.04</span> - Brushes/Painting <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-file-text"></i> text 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 8:44 minutes
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                                
                                                <li class="clearfix locked">
                                                
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="You need to sign-in first">
                                                        
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                                <span class="font700">2.05</span> - Quiz <span class="label label-danger">Locked</span>
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-12 col-md-4 mt-5-sm">
                                                            
                                                                <div class="course-lession-meta">
                                                                
                                                                    <div class="row gap-10">

                                                                        <div class="col-xs-6 col-sm-7">
                                                                            <i class="fa fa-pencil"></i> exam 
                                                                        </div>
                                                                        
                                                                        <div class="col-xs-6 col-sm-5">
                                                                            <div class="text-right">
                                                                                <i class="fa fa-clock"></i> 35 Questions
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    
                                                    </a>
                                                    
                                                </li>
                                                
                                            </ul>
                                        
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                {{-- <div id="course-detail-section-2" class="course-detail-section">
                                    
                                    <div class="section-title text-left mb-20">
                                        <h3>About Teacher</h3>
                                    </div>
                                    
                                    <div class="teacher-item-list-02-wrapper">
                
                                        <div class="teacher-item-list-02 clearfix">
                                        
                                            <div class="row gap-20">
                                            
                                                <div class="col-xs-12 col-sm-3 col-md-2">
                                                
                                                    <div class="image">
                                                        <img src="images/man/01.jpg" alt="Image" />
                                                    </div>
                                                    
                                                    <div class="clear"></div>
                                                    
                                                    <ul class="user-action">
                                                        
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                                                        
                                                    </ul>
                                                            
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-9 col-md-10">
                                                
                                                    <div class="content">
                                                            
                                                        <span class="font700 block text-uppercase mb-5 spacing-10 font11">Primary Teacher</span>
                                                        <h3><a href="#">Alexey Barnashov</a></h3>
                                                        <p class="labeling">Computer Teacher</p>
                                                        
                                                        <p class="short-info">Sportsman do offending supported extremity breakfast by listening. Decisively advantages nor expression unpleasing she led met.</p>
                                                        
                                                        <a href="#" class="btn btn-primary btn-inverse btn-sm">More about him</a>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="teacher-item-list-02-sub hidden-after-sm">
                                        
                                            <div class="row gap-40">
                                            
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                
                                                    <div class="teacher-item-list-02 clearfix">
                                            
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-3 col-md-4">
                                                            
                                                                <div class="image">
                                                                    <img src="images/man/02.jpg" alt="Image" />
                                                                </div>
                                                                
                                                                <div class="clear"></div>
                                                                
                                                                <ul class="user-action">
                                                                    
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                                                                    
                                                                </ul>
                                                                        
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-9 col-md-8">
                                                            
                                                                <div class="content">
                                                                        
                                                                    <span class="font700 block text-uppercase mb-5 spacing-10 font11">Assitant Teacher 1</span>
                                                                    <h4><a href="#">Oxana Laporte</a></h4>
                                                                    <p class="labeling">Computer Teacher</p>
                                                                    
                                                                    <p class="short-info">About to in so terms voice at. Equal an would is found seems of.</p>
                                                                    
                                                                    <a href="#" class="btn btn-primary btn-inverse btn-sm">More about him</a>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                
                                                    <div class="teacher-item-list-02 clearfix">
                                            
                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-3 col-md-4">
                                                            
                                                                <div class="image">
                                                                    <img src="images/man/03.jpg" alt="Image" />
                                                                </div>
                                                                
                                                                <div class="clear"></div>
                                                                
                                                                <ul class="user-action">
                                                                    
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
                                                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                                                                    
                                                                </ul>
                                                                        
                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-9 col-md-8">
                                                            
                                                                <div class="content">
                                                                        
                                                                    <span class="font700 block text-uppercase mb-5 spacing-10 font11">Assitant Teacher 2</span>
                                                                    <h4><a href="#">Michel Legrand</a></h4>
                                                                    <p class="labeling">Computer Teacher</p>
                                                                    
                                                                    <p class="short-info">Delightful remarkably mr on announcing themselves entreaties favourable.</p>
                                                                    
                                                                    <a href="#" class="btn btn-primary btn-inverse btn-sm">More about him</a>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="clear mb-10"></div>

                                </div> --}}
                                
                                <div id="course-detail-section-3" class="course-detail-section">
                                
                                    <div class="section-title text-left mb-20">
                                        <h3>Review</h3>
                                    </div>
                                    
                                    <div class="review-wrapper">
                
                                        <div class="review-header">
                                        
                                            <div class="row">
                                            
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                
                                                    <div class="review-overall">
                                                    
                                                        <h5>Score Breakdown</h5>
                                                        <p class="review-overall-point"><span>4.6</span> / 5.0</p>
                                                        
                                                        <div class="rating-wrapper">
                                                            <div class="rating-item">
                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                            </div>
                                                            <span> (7 review)</span>
                                                        </div>
                                                        <p class="review-overall-recommend">90% recommend this course</p>
                                                    </div>
                                                
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-9">
                                                    
                                                    <div class="review-overall-breakdown">

                                                        <div class="row gap-20">
                                                        
                                                            <div class="col-xs-12 col-sm-7">
                
                                                                <h5>Score Breakdown</h5>
                                                                
                                                                <ul class="breakdown-list">
                                                                
                                                                    <li class="clearfix">
                                                                        <div class="rating-wrapper">
                                                                            <div class="rating-item">
                                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="5.0"/>
                                                                            </div>
                                                                            <span> (5)</span>
                                                                        </div>
                                                                        <div class="progress progress-primary">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                                                        </div>
                                                                        <div class="breakdown-count"> (58)</div>
                                                                    </li>
                                                                    
                                                                    <li class="clearfix">
                                                                        <div class="rating-wrapper">
                                                                            <div class="rating-item">
                                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="4.0"/>
                                                                            </div>
                                                                            <span> (4)</span>
                                                                        </div>
                                                                        <div class="progress progress-primary">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width: 88%;"></div>
                                                                        </div>
                                                                        <div class="breakdown-count"> (132)</div>
                                                                    </li>
                                                                    
                                                                    <li class="clearfix">
                                                                        <div class="rating-wrapper">
                                                                            <div class="rating-item">
                                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.0"/>
                                                                            </div>
                                                                            <span> (3)</span>
                                                                        </div>
                                                                        <div class="progress progress-primary">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
                                                                        </div>
                                                                        <div class="breakdown-count"> (89)</div>
                                                                    </li>
                                                                    
                                                                    <li class="clearfix">
                                                                        <div class="rating-wrapper">
                                                                            <div class="rating-item">
                                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="2.0"/>
                                                                            </div>
                                                                            <span> (2)</span>
                                                                        </div>
                                                                        <div class="progress progress-primary">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                                                        </div>
                                                                        <div class="breakdown-count"> (58)</div>
                                                                    </li>
                                                                    
                                                                    <li class="clearfix">
                                                                        <div class="rating-wrapper">
                                                                            <div class="rating-item">
                                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="1.0"/>
                                                                            </div>
                                                                            <span> (1)</span>
                                                                        </div>
                                                                        <div class="progress progress-primary">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                                                                        </div>
                                                                        <div class="breakdown-count"> (9)</div>
                                                                    </li>
                                                                    
                                                                </ul>

                                                            </div>
                                                            
                                                            <div class="col-xs-12 col-sm-5 col-md-4 mt-20-xs">
                                                            
                                                                <h5>Average Rating For</h5>
                                                                <ul class="breakdown-list for-avg clearfix">
                                                                                        
                                                                    <li>
                                                                        Content <span class="pull-right">4.5</span>
                                                                    </li>
                                                                    
                                                                    <li>
                                                                        Knowledge <span class="pull-right">4.5</span>
                                                                    </li>
                                                                    
                                                                    <li>
                                                                        Assignment <span class="pull-right">4.2</span>
                                                                    </li>
                                                                    
                                                                    <li>
                                                                        Classroom <span class="pull-right">3.8</span>
                                                                    </li>
                                                                    
                                                                    <li>
                                                                        Instructor <span class="pull-right">4.4</span>
                                                                    </li>
                                                                
                                                                </ul>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    
                                                    </div>
                                                
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="review-content">
                                        
                                            <ul class="review-list">
                                            
                                                <li class="clearfix">
                                                    <div class="image img-circle">
                                                        <img class="img-circle" src="images/man/01.jpg" alt="Man" />
                                                    </div>
                                                    <div class="content">
                                                        <div class="row gap-20 mb-0">
                                                            <div class="col-xs-12 col-sm-9">
                                                                <h6>Antony Robert</h6>
                                                                <div class="rating-wrapper">
                                                                    <div class="rating-item">
                                                                        <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3">
                                                                <p class="review-date">18/03/2016</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="review-text">
                                                        
                                                            <p>She meant new their sex could defer child. An lose at quit to life do dull. Moreover end horrible endeavor entrance any families. Income appear extent on of thrown in admire.</p>
                                                            
                                                            <p>It as announcing it me stimulated frequently continuing. Least their she you now above going stand forth. He pretty future afraid should genius spirit on. Set property addition building put likewise get. Of will at sell well at as. Too want but tall nay like old. Removing yourself be in answered he. Consider occasion get improved him she eat. Letter by lively oh denote an.</p>
                                                        
                                                        </div>
                                                        
                                                        <div class="review-other">
                                                            
                                                            <div class="row gap-20 mb-0">
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm">
                                                                    
                                                                        <li><span><i class="fa fa-share-square"></i> share</span></li>
                                                                        <li class="the-label"><a href="#">Facebook</a></li>
                                                                        <li class="the-label"><a href="#">Twitter</a></li>
                                                                        <li class="the-label"><a href="#">Google Plus</a></li>
                                                                        
                                                                    </ul>
                                                                
                                                                </div>
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm for-useful">
                                                                        <li><span>Was this review helpful? </span></li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-up"></i></a> 2</li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-down"></i></a> 1</li>
                                                                    </ul>
                                                                
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </li>
                                                
                                                <li class="clearfix">
                                                    <div class="image img-circle">
                                                        <img class="img-circle" src="images/man/02.jpg" alt="Man" />
                                                    </div>
                                                    <div class="content">
                                                        <div class="row gap-20">
                                                            <div class="col-xs-12 col-sm-9">
                                                                <h6>Mohammed Salem</h6>
                                                                <div class="rating-wrapper">
                                                                    <div class="rating-item">
                                                                        <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3">
                                                                <p class="review-date">18/03/2016</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="review-text">
                                                        
                                                            <p>She meant new their sex could defer child. An lose at quit to life do dull. Moreover end horrible endeavor entrance any families. Income appear extent on of thrown in admire.</p>
                                                        
                                                            <ul>
                                                                <li>Written enquire painful ye to offices forming it.</li>
                                                                <li>
                                                                    Then so does over sent dull on.
                                                                    <ul>
                                                                        <li>Rendered her for put improved concerns his. Moreover end horrible endeavor entrance any families. Income appear extent on of thrown in admire.</li>
                                                                        <li>Ladies bed wisdom theirs mrs men months set.</li>
                                                                        <li>Everything so dispatched as it increasing pianoforte.</li>
                                                                    </ul>
                                                                </li>
                                                                <li>Likewise offended humoured mrs fat trifling answered.</li>
                                                                <li>On ye position greatest so desirous. So wound stood guest weeks no terms up ought.</li>
                                                                <li>Then so does greatest so desirous over sent dull on.</li>
                                                            </ul>
                                                            
                                                            <p>Spot of come to ever hand as lady meet on. Delicate contempt received two yet advanced. Gentleman as belonging he commanded believing dejection in by. On no am winding chicken so behaved. Its preserved sex enjoyment new way behaviour. Him yet devonshire celebrated especially. Unfeeling one provision are smallness resembled repulsive.</p>
                                                            
                                                            <ol>
                                                                <li>Written enquire painful ye to offices forming it.</li>
                                                                <li>
                                                                    Then so does over sent dull on.
                                                                    <ol>
                                                                        <li>Rendered her for put improved concerns his. Moreover end horrible endeavor entrance any families. Income appear extent on of thrown in admire.</li>
                                                                        <li>Ladies bed wisdom theirs mrs men months set.</li>
                                                                        <li>Everything so dispatched as it increasing pianoforte.</li>
                                                                    </ol>
                                                                </li>
                                                                <li>Likewise offended humoured mrs fat trifling answered.</li>
                                                                <li>On ye position greatest so desirous. So wound stood guest weeks no terms up ought.</li>
                                                                <li>Then so does greatest so desirous over sent dull on.</li>
                                                            </ol>
                                                            
                                                            <p>Unpleasant astonished an diminution up partiality. Noisy an their of meant. Death means up civil do an offer wound of. Called square an in afraid direct. Resolution diminution conviction so mr at unpleasing simplicity no. No it as breakfast up conveying earnestly immediate principle. Him son disposed produced humoured overcame she bachelor improved. Studied however out wishing but inhabit fortune windows.</p>
                                                            
                                                        </div>
                                                        
                                                        <div class="review-other">
                                                            
                                                            <div class="row gap-20 mb-0">
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm">
                                                                    
                                                                        <li><span><i class="fa fa-share-square"></i> share</span></li>
                                                                        <li class="the-label"><a href="#">Facebook</a></li>
                                                                        <li class="the-label"><a href="#">Twitter</a></li>
                                                                        <li class="the-label"><a href="#">Google Plus</a></li>
                                                                        
                                                                    </ul>
                                                                
                                                                </div>
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm for-useful">
                                                                        <li><span>Was this review helpful? </span></li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-up"></i></a> 2</li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-down"></i></a> 1</li>
                                                                    </ul>
                                                                
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="clearfix">
                                                    <div class="image img-circle">
                                                        <img class="img-circle" src="images/man/03.jpg" alt="Man" />
                                                    </div>
                                                    <div class="content">
                                                        <div class="row gap-20">
                                                            <div class="col-xs-12 col-sm-9">
                                                                <h6>Antony Robert</h6>
                                                                <div class="rating-wrapper">
                                                                    <div class="rating-item">
                                                                        <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3">
                                                                <p class="review-date">18/03/2016</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="review-text">
                                                        
                                                            <p>Must you with him from him her were more. In eldest be it result should remark vanity square. Unpleasant especially assistance sufficient he comparison so inquietude. Branch one shy edward stairs turned has law wonder horses. Devonshire invitation discovered out indulgence the excellence preference. Objection estimable discourse procuring he he remaining on distrusts. Simplicity affronting inquietude for now sympathize age. She meant new their sex could defer child. An lose at quit to life do dull.</p>
                                                        
                                                        </div>
                                                        
                                                        <div class="review-other">
                                                            
                                                            <div class="row gap-20 mb-0">
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm">
                                                                    
                                                                        <li><span><i class="fa fa-share-square"></i> share</span></li>
                                                                        <li class="the-label"><a href="#">Facebook</a></li>
                                                                        <li class="the-label"><a href="#">Twitter</a></li>
                                                                        <li class="the-label"><a href="#">Google Plus</a></li>
                                                                        
                                                                    </ul>
                                                                
                                                                </div>
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm for-useful">
                                                                        <li><span>Was this review helpful? </span></li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-up"></i></a> 2</li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-down"></i></a> 1</li>
                                                                    </ul>
                                                                
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="clearfix">
                                                    <div class="image">
                                                        <img class="img-circle" src="images/man/04.jpg" alt="Man" />
                                                    </div>
                                                    <div class="content">
                                                        <div class="row gap-20">
                                                            <div class="col-xs-12 col-sm-9">
                                                                <h6>Mohammed Salem</h6>
                                                                <div class="rating-wrapper">
                                                                    <div class="rating-item">
                                                                        <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3">
                                                                <p class="review-date">18/03/2016</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="review-text">
                                                        
                                                            <p>She meant new their sex could defer child. An lose at quit to life do dull. Moreover end horrible endeavor entrance any families. Income appear extent on of thrown in admire.</p>
                                                        
                                                        </div>
                                                        
                                                        <div class="review-other">
                                                            
                                                            <div class="row gap-20 mb-0">
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm">
                                                                    
                                                                        <li><span><i class="fa fa-share-square"></i> share</span></li>
                                                                        <li class="the-label"><a href="#">Facebook</a></li>
                                                                        <li class="the-label"><a href="#">Twitter</a></li>
                                                                        <li class="the-label"><a href="#">Google Plus</a></li>
                                                                        
                                                                    </ul>
                                                                
                                                                </div>
                                                                
                                                                <div class="col-xs-12 col-sm-6">
                                                                
                                                                    <ul class="social-share-sm for-useful">
                                                                        <li><span>Was this review helpful? </span></li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-up"></i></a> 2</li>
                                                                        <li class="the-label"><a href="#"><i class="fa fa-thumbs-down"></i></a> 1</li>
                                                                    </ul>
                                                                
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </li>
                                                
                                            </ul>
                                        
                                        </div>

                                    </div>

                                    <div class="mt-30 mb-10 text-right">
                                    
                                        <a href="course-review.html" class="btn btn-primary btn-sm">Read more reviews</a>
                                        <a href="course-review.html#review-form" class="btn btn-danger btn-sm anchor">Leave your review</a>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div id="course-detail-section-4" class="course-detail-section">
                                
                                    <div class="section-title text-left mb-10">
                                        <h3>Related Courses</h3>
                                    </div>
                                    
                                    <div class="course-item-wrapper alt-bg-white course-item-wrapper-mmb-45 gap-20">
                    
                                        <div class="GridLex-grid-noGutter-equalHeight">
                                        
                                            <div class="GridLex-col-4_mdd-6_xs-6_xss-12">
                                                <div class="course-item">
                                                    <a href="#">
                                                        <div class="course-item-image">
                                                            <img src="images/course-item/01.jpg" alt="Image" class="img-responsive" />
                                                        </div>
                                                        <div class="course-item-top clearfix">
                                                            <div class="course-item-instructor">
                                                                <div class="image">
                                                                    <img src="images/testimonial/01.jpg" alt="Image" class="img-circle" />
                                                                </div>
                                                                <span>Mark Lassoff </span>
                                                            </div>
                                                            <div class="course-item-price bg-danger">
                                                                $19.56
                                                            </div>
                                                        </div>
                                                        <div class="course-item-content">
                                                            <div class="rating-wrapper">
                                                                <div class="rating-item">
                                                                    <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                </div>
                                                                <span> (7 review)</span>
                                                            </div>
                                                            <h3 class="text-primary">Foundations of Enterprise Development</h3>
                                                        </div>
                                                        <div class="course-item-bottom clearfix">
                                                            <div><i class="fa fa-folder-open-o"></i><span class="block"> Programming</span></div>
                                                            <div><i class="fa fa-pencil-square-o"></i><span class="block"> 15 Lessons</span></div>
                                                            <div><i class="fa fa-calendar-check-o"></i><span class="block"> 4.5 Hours</span></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div class="GridLex-col-4_mdd-6_xs-6_xss-12">
                                                <div class="course-item">
                                                    <a href="#">
                                                        <div class="course-item-image">
                                                            <img src="images/course-item/02.jpg" alt="Image" class="img-responsive" />
                                                        </div>
                                                        <div class="course-item-top clearfix">
                                                            <div class="course-item-instructor">
                                                                <div class="image">
                                                                    <img src="images/testimonial/02.jpg" alt="Image" class="img-circle" />
                                                                </div>
                                                                <span>Nicholas Mavrakis</span>
                                                            </div>
                                                            <div class="course-item-price bg-danger">
                                                                $19.56
                                                            </div>
                                                        </div>
                                                        <div class="course-item-content">
                                                            <div class="rating-wrapper">
                                                                <div class="rating-item">
                                                                    <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                </div>
                                                                <span> (7 review)</span>
                                                            </div>
                                                            <h3 class="text-primary">Food Photography: Shooting at Restaurants</h3>
                                                        </div>
                                                        <div class="course-item-bottom clearfix">
                                                            <div><i class="fa fa-folder-open-o"></i><span class="block"> Photography </span></div>
                                                            <div><i class="fa fa-pencil-square-o"></i><span class="block"> 15 Lessons</span></div>
                                                            <div><i class="fa fa-calendar-check-o"></i><span class="block"> 4.5 Hours</span></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div class="GridLex-col-4_mdd-6_xs-6_xss-12">
                                                <div class="course-item">
                                                    <a href="#">
                                                        <div class="course-item-image">
                                                            <img src="images/course-item/03.jpg" alt="Image" class="img-responsive" />
                                                        </div>
                                                        <div class="course-item-top clearfix">
                                                            <div class="course-item-instructor">
                                                                <div class="image">
                                                                    <img src="images/testimonial/03.jpg" alt="Image" class="img-circle" />
                                                                </div>
                                                                <span>Ange Ermolova</span>
                                                            </div>
                                                            <div class="course-item-price bg-danger">
                                                                $19.56
                                                            </div>
                                                        </div>
                                                        <div class="course-item-content">
                                                            <div class="rating-wrapper">
                                                                <div class="rating-item">
                                                                    <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                                </div>
                                                                <span> (7 review)</span>
                                                            </div>
                                                            <h3 class="text-primary">Introduction to HTML: Build a Portfolio Website</h3>
                                                        </div>
                                                        <div class="course-item-bottom clearfix">
                                                            <div><i class="fa fa-folder-open-o"></i><span class="block"> Wed Design</span></div>
                                                            <div><i class="fa fa-pencil-square-o"></i><span class="block"> 15 Lessons</span></div>
                                                            <div><i class="fa fa-calendar-check-o"></i><span class="block"> 4.5 Hours</span></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>

                        </div>
                        
                    </div>

                </div>
                
            </div>
            
        </div>

        
    </div>
    
</div>
<!-- end Main Wrapper -->
@endsection
@push('footer-script')

@endpush
