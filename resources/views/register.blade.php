@extends('master')
@section('content')

<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
		
    <div class="breadcrumb-wrapper">
    
        <div class="container">
            
            <h1 class="page-title">Sign Up</h1>
            
            <div class="row">
            
                <div class="col-xs-12 col-sm-8">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active">Sign up</li>
                    </ol>
                </div>
                
                <div class="col-xs-12 col-sm-4 hidden-xs">
                    <p class="hot-line"> <i class="fa fa-phone"></i> Hot Line: 1-222-33658</p>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <div class="contact-page-wrapper">
    
        <div class="container">
            
            <div class="contact-map">
            
               
                
                <div class="row">

                    <div class="col-sm-7 col-md-6 col-md-offset-1 mb-30">
                    
                        <form action="{{asset('/sign-up')}}" method="post" class="contact-form-wrapper" data-toggle="validator">
                            @csrf
                        
                            <div class="row">
                            
                                <div class="col-sm-12">
                                
                                    <div class="form-group">
                                        <label for="inputName">Your Name <span class="font10 text-danger">(required)</span></label>
                                        <input id="inputName"  name="inputName" type="text" class="form-control" data-error="Your name is required" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                </div>

                                <div class="col-sm-12">
                                
                                    <div class="form-group">
                                        <label>Phone <span class="font10 text-danger">(required)</span></label>
                                        <input id="inputPhone" name="inputPhone" type="number" class="form-control" data-error="Your email is required and must be a valid email address" required>
                                    </div>
                                    
                                </div>

                                
                                <div class="col-sm-12">
                                
                                    <div class="form-group">
                                        <label for="inputEmail">Your Email <span class="font10 text-danger">(required)</span></label>
                                        <input id="inputEmail" name="inputEmail" type="email" class="form-control" data-error="Your email is required and must be a valid email address" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-sm-6">
                                
                                    <div class="form-group">
                                        <label>Password <span class="font10 text-danger">(required)</span></label>
                                        <input id="inputPassword" name="inputPassword" type="text" class="form-control" data-error="Your email is required and must be a valid email address" required>
                                    </div>
                                    
                                </div>

                              

                                <div class="col-sm-6">
                                
                                    <div class="form-group">
                                        <label>Confirm Password <span class="font10 text-danger">(required)</span></label>
                                        <input id="inputCPassword" name="inputCPassword" type="text" class="form-control" data-error="Your email is required and must be a valid email address" required>
                                    </div>
                                    
                                </div>

                                
                          
                                
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary mt-5">Sign Up</button>
                                </div>
                                
                            </div>
                            
                        </form>
                        
                    </div>

                    <div class="col-sm-5 col-md-4">
                        <img src="https://localhost/edukrypt-lms/public/navin.png">
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