@extends('master')
@section('content')

<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
		
    <div class="breadcrumb-wrapper">
    
        <div class="container">
        
            <h1 class="page-title">Course Grid</h1>
            
            <div class="row">
            
                <div class="col-xs-12 col-sm-8">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Page</a></li>
                        <li class="active">Course Result</li>
                    </ol>
                </div>
                
                <div class="col-xs-12 col-sm-4 hidden-xs">
                    <p class="hot-line"> <i class="fa fa-phone"></i> Hot Line: 1-222-33658</p>
                </div>
                
            </div>
            
        </div>

    </div>

    <div class="equal-content-sidebar-wrapper">
    
        <div class="equal-content-sidebar-by-gridLex">
        
            <div class="container">
            
                <div class="GridLex-grid-noGutter-equalHeight">
        
                    <div class="GridLex-col-3_sm-4_xs-12_xss-12">

                        <div class="sidebar-wrapper pt-20-xs pb-0-xs">

                            <aside class="filter-sidebar">
            
                                <div class="responsive-filter-wrapper">
                            
                                    <button type="button" class="navbar-toggle btn btn-primary collapsed btn-responsive-filter" data-toggle="collapse" data-target="#responsive-filter-box">Search Again &amp; Filter</button>
                                    
                                    <div class="clear"></div>
                                    
                                    <div class="collapse navbar-collapse responsive-filter-box" id="responsive-filter-box">
                                    
                                        <div class="collapse-inner">

                                            <div class="sidebar-header clearfix">
                                                <h4>Filter Results</h4>
                                                <a href="#" class="sidebar-reset-filter">reset filter</a>
                                            </div>
                                            
                                            <div class="sidebar-inner">
                                            
                                                <div class="row gap-20">
                                                    
                                                    <div class="col-xss-12 col-xs-6 col-sm-12">
                                                    
                                                        <div class="sidebar-module">
                                                            <h6 class="sidebar-title">Price Range</h6>
                                                            <div class="sidebar-module-inner">
                                                                <input id="price_range" />
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-xss-12 col-xs-6 col-sm-12">
                                                    
                                                        <div class="sidebar-module">
                                                            <h6 class="sidebar-title">Star Range</h6>
                                                            <div class="sidebar-module-inner">
                                                                <input id="star_range" />
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="clear"></div>
                                                
                                                    <div class="col-xss-12 col-xs-6 col-sm-12">
                                                    
                                                        <div class="sidebar-module clearfix">
                                                
                                                            <h6 class="sidebar-title">Course Subject</h6>
                                                            <div class="sidebar-module-inner">
                                                                <div class="checkbox-block">
                                                                    <input id="property_type-1" name="property_type" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="property_type-1">Computer <span class="checkbox-count">(854)</span></label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="property_type-2" name="property_type" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="property_type-2">Engineering <span class="checkbox-count">(25)</span></label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="property_type-3" name="property_type" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="property_type-3">Sceince <span class="checkbox-count">(254)</span></label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="property_type-4" name="property_type" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="property_type-4">Music <span class="checkbox-count">(22)</span></label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="property_type-5" name="property_type" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="property_type-5">Photography <span class="checkbox-count">(9)</span></label>
                                                                </div>
                                                                
                                                                <div class="more-less-wrapper">
                                                                    
                                                                    <div id="property_type_more_less" class="collapse"> 
                                                                        <div class="more-less-inner">
                                                                        
                                                                            <div class="checkbox-block">
                                                                                <input id="property_type-6" name="property_type" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="property_type-6">Design <span class="checkbox-count">(3)</span></label>
                                                                            </div>
                                                                            <div class="checkbox-block">
                                                                                <input id="property_type-7" name="property_type" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="property_type-7">Writing <span class="checkbox-count">(25)</span></label>
                                                                            </div>
                                                                            <div class="checkbox-block">
                                                                                <input id="property_type-8" name="property_type" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="property_type-8">Health Sceince <span class="checkbox-count">(2)</span></label>
                                                                            </div>
                                                                            <div class="checkbox-block">
                                                                                <input id="property_type-9" name="property_type" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="property_type-9">Programming <span class="checkbox-count">(1)</span></label>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-more-less collapsed" data-toggle="collapse" data-target="#property_type_more_less">Show more</button>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-xss-12 col-xs-6 col-sm-12">
                                                    
                                                        <div class="sidebar-module clearfix">
                                                
                                                            <h6 class="sidebar-title">Course Category</h6>
                                                            
                                                            <div class="sidebar-module-inner">
                                                                <div class="checkbox-block">
                                                                    <input id="hotel_facilities-1" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="hotel_facilities-1">Programming</label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="hotel_facilities-2" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="hotel_facilities-2">Computer</label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="hotel_facilities-3" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="hotel_facilities-3">Sceince</label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="hotel_facilities-4" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="hotel_facilities-4">Engineering</label>
                                                                </div>
                                                                <div class="checkbox-block">
                                                                    <input id="hotel_facilities-5" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                    <label class="" for="hotel_facilities-5">Photography</label>
                                                                </div>
                                                                
                                                                <div class="more-less-wrapper">
                                                                    
                                                                    <div id="hotel_facilities_more_less" class="collapse"> 
                                                                        <div class="more-less-inner">
                                                                        
                                                                            <div class="checkbox-block">
                                                                                <input id="hotel_facilities-6" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="property_type-6">Design</label>
                                                                            </div>
                                                                            <div class="checkbox-block">
                                                                                <input id="hotel_facilities-7" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="hotel_facilities-7">Writing</label>
                                                                            </div>
                                                                            <div class="checkbox-block">
                                                                                <input id="hotel_facilities-8" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="hotel_facilities-8">Health Sceince</label>
                                                                            </div>
                                                                            <div class="checkbox-block">
                                                                                <input id="hotel_facilities-9" name="hotel_facilities" type="checkbox" class="checkbox"/>
                                                                                <label class="" for="hotel_facilities-9">Computer</label>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-more-less collapsed" data-toggle="collapse" data-target="#hotel_facilities_more_less">Show more</button>
                                                                    
                                                                </div>
                                                                
                                                            </div>
    
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="clear"></div>
                                                
                                                    <div class="col-xss-12 col-xs-12 col-sm-12">
                                                    
                                                        <div class="sidebar-module">
                                                
                                                            <h6 class="sidebar-title">Filter Select</h6>
                                                            
                                                            <select class="select2-single-no-search form-control mt-20" data-placeholder="Select Placeholder">
                                                                <option>&nbsp;</option>
                                                                <option value="0"> Select One</option>
                                                                <option value="1"> Select Two</option>
                                                                <option value="2"> Select Three</option>
                                                                <option value="3"> Select Four</option>
                                                                <option value="4"> Select Five</option>
                                                            </select>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-xss-12 col-xs-12 col-sm-12">
                                                    
                                                        <div class="sidebar-module">
                                                
                                                            <h6 class="sidebar-title">Filter Text</h6>
                                                            <div class="sidebar-module-inner">
                                                                <p>Park fat she nor does play deal our. Procured sex material his offering humanity laughing moderate can. Unreserved had she nay dissimilar admiration interested.</p>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="clear"></div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                
                                </div>

                                <div class="sidebar-box hidden-xs">
                                    <h4 class="sidebar-title">Why Booking With Us?</h4>
                                    <p>Park fat she nor does play deal our. Procured sex material his offering humanity laughing moderate can. Unreserved had she nay dissimilar admiration interested.</p>
                                </div>
                            
                            </aside>
                            
                        </div>
                        
                    </div>

                    <div class="GridLex-col-9_sm-8_xs-12_xss-12">
                
                        <div class="content-wrapper pt-20-xs">

                            <div class="sorting-wrappper">
                                
                                <div class="sorting-form">
                                
                                    <div id="change-search" class="collapse"> 
                                    
                                        <div class="change-search-wrapper">
                                        
                                            <div class="row gap-20">
                                            
                                                <div class="col-xs-12 col-sm-10 col-md-10">
                                                
                                                    <div class="row gap-0">
                                                    
                                                        <div class="col-xs-12 col-sm-7 col-md-7">
                                                        
                                                            <div class="form-group">
                                                                <input type="text" class="form-control no-br" placeholder="Java Programming">
                                                            </div>
                                                        
                                                        </div>
                                                        
                                                        <div class="col-xs-12 col-sm-5 col-md-5">
                                                        
                                                            <div class="form-group">
                                                                <select class="select2-multi form-control" multiple data-placeholder="All Category" data-maximum-selection-length="3" style="width: 100%;">
                                                                    <option>All Category</option>
                                                                    <option value="0"> Mathematics</option>
                                                                    <option value="1"> Business</option>
                                                                    <option value="2"> Computer</option>
                                                                    <option value="3"> Marketing</option>
                                                                    <option value="4"> Physics</option>
                                                                    <option value="5"> Biology</option>
                                                                    <option value="6"> Chemistry</option>
                                                                    <option value="7"> Programming</option>
                                                                    <option value="8"> Engineering</option>
                                                                    <option value="9"> Design</option>
                                                                    <option value="9"> Design</option>
                                                                </select>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-2 col-md-2 mt-10-xs">
                                                    <button class="btn btn-block btn-primary btn-form"><i class="fa fa-search"></i></button>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="sorting-header">
                                
                                    <div class="row">
                                    
                                        <div class="col-xss-12 col-xs-12 col-sm-7 col-md-9">
                                        
                                            <h4>We found <?php echo  App\Helpers\Frontend::getTotalProduct();  ?>  courses for <strong>Computer</strong></h4>
                                        </div>
                                        
                                        <div class="col-xss-12 col-xs-12 col-sm-5 col-md-3">
                                            <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"></button>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="sorting-content">
                                
                                    <div class="row">
                                    
                                        <div class="col-xss-12 col-xs-9 col-sm-9">
                                            <div class="sort-by-wrapper">
                                                <label class="sorting-label block-xs">Sort by: </label> 
                                                <div class="sorting-middle-holder">
                                                    <ul class="sort-by">
                                                        <li class="active up"><a href="#">Name <i class="fa fa-long-arrow-down"></i></a></li>
                                                        <li><a href="#">Price</a></li>
                                                        <li><a href="#">Location</a></li>
                                                        <li><a href="#">Start Rating</a></li>
                                                        <li><a href="#">User Rating</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xss-12 col-xs-3 col-sm-3">
                                            <div class="sort-by-wrapper for-layout-option">
                                                <label class="sorting-label">View as: </label> 
                                                <div class="sorting-middle-holder">
                                                    <a href="course-list.html" class="btn btn-sorting"><i class="fa fa-th-list"></i></a>
                                                    <a href="course-grid.html" class="btn btn-sorting active"><i class="fa fa-th-large"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                
                                </div>

                            </div>
                            
                            <div class="course-item-wrapper alt-bg-light clearfix">
                    
                                <div class="GridLex-gap-20">
                                
                                    <div class="GridLex-grid-noGutter-equalHeight">

                                        @if(!empty($products))
										@foreach($products as $product)
                                    
                                        <div class="GridLex-col-4_mdd-6_sm-6_xs-6_xss-12">
                                            <div class="course-item">
                                                <a href="#">
                                                    <div class="course-item-image">
                                                        <img src="{{asset('public/uploads/products/'.$product->image)}}" alt="Image" class="img-responsive" />
                                                    </div>
                                                    <div class="course-item-top clearfix">

                                                        <?php  
                                            
																$getTeacher = App\Helpers\Frontend::getTeacher($product->teacher_id); 
																// print_r($getprice->price);
															  
															?>

                                                        <div class="course-item-instructor">
                                                            <div class="image">
                                                                <img src="{{asset('public/frontend/images/testimonial/01.jpg')}}" alt="Image" class="img-circle" />
                                                            </div>
                                                          	 <?php  echo (!empty($getTeacher->username))? '<span>'.$getTeacher->username.'</span>':""; ?>
                                                            
                                                        </div>
                                                        <div class="course-item-price bg-danger">
                                                            <?php  
																		$mode = 'online';
																	  $getprice = App\Helpers\Frontend::getProductPrice($product->id,$mode); 
																		// print_r($getprice->price);
																		echo (!empty($getprice->price))? "<i class='fa fa-inr'></i>".$getprice->price:"";
																	?>
                                                        </div>
                                                    </div>
                                                    <div class="course-item-content">
                                                        <div class="rating-wrapper">
                                                            <div class="rating-item">
                                                                <input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fa fa-star-o" data-fractions="2" data-readonly value="3.5"/>
                                                            </div>
                                                            <span> (7 review)</span>
                                                        </div>
                                                        <h3 class="text-primary">{{$product->name}}</h3>
                                                        <p>{{$product->name}}</p>
                                                    </div>
                                                    <div class="course-item-bottom clearfix">
                                                        <div><i class="fa fa-folder-open-o"></i><span class="block"> {{$product->category}}</span></div>
                                                        <div><i class="fa fa-pencil-square-o"></i><span class="block"> 15 Lessons</span></div>
                                                        <div><i class="fa fa-calendar-check-o"></i><span class="block"> 4.5 Hours</span></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        @endforeach
										@endif
                                        
                                    </div>
                                
                                </div>
                                
                            </div>
                            
                            <div class="clear"></div>
                            
                            <div class="pager-wrappper clearfix">
            
                                <div class="pager-innner">
                                
                                    <div class="row">
                                            
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="pagination-text">Showing result <?php echo  count($products) ?> from <?php echo  App\Helpers\Frontend::getTotalProduct();  ?></div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <nav class="pager-right">
                                                <ul class="pagination">
                                                    @if(isset($_GET['query']))

                                                    {{ $products->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                                               @else
                                                {{ $products->links('admin.includes.paginationlinks') }} 
                                                @endif
                                                </ul>
                                            </nav>
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