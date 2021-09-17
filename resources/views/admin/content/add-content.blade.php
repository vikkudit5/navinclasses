@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Content</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Content</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">
                <x-flashMessage/>
                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/content-list/'.Request::segment(3)."/".Request::segment(4))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Content List</a>
                      
                        <h6 class="card-title">Add Video</h6>  
                        <form action="{{asset('admin/add-content/'.Request::segment(3)."/".Request::segment(4))}}" method="post" enctype="multipart/form-data">	
                            @csrf
                            <div class="form-group">
                                <label for="institute">Video</label>
                              
                                <select class="js-example-basic-multiple" multiple name="video_tag[]">
                                    {{-- <option selected disabled>--Select--</option>  --}}
                                    
                                    <?php
                                        if(!empty($videos)){
                                            foreach($videos as $video){
                                    ?>
                                    <option value="<?php echo $video->etag; ?>"><?php echo $video->filename ?></option> 
                                    <?php } }?>                                 
                                    
                                    
                                   
                                </select>

                                <input type="hidden" name="type" value="video">
                                @if ($errors->has('video_tag'))
                                <div class="error">
                                    {{ $errors->first('video_tag') }}
                                </div>
                                @endif
                            </div>
						
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/content-list/'.Request::segment(3)."/".Request::segment(4))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Content List</a>
                    
                        <h6 class="card-title">Add MCQ</h6>  
                        <form action="{{asset('admin/add-content/'.Request::segment(3)."/".Request::segment(4))}}" method="post" enctype="multipart/form-data">	
                            @csrf
                            <div class="form-group">
                                <label for="institute">Mcq</label>
                              
                                <select class="js-example-basic-multiple" multiple name="video_tag[]">
                                    {{-- <option selected disabled>--Select--</option>  --}}
                                    
                                    <?php
                                        if(!empty($mcqs)){
                                            foreach($mcqs as $mcq){
                                    ?>
                                    <option value="<?php echo $mcq->id; ?>"><?php echo $mcq->name ?></option> 
                                    <?php } }?>                                 
                                    
                                    
                                   
                                </select>

                                @if ($errors->has('video_tag'))
                                <div class="error">
                                    {{ $errors->first('video_tag') }}
                                </div>
                                @endif
                            </div>

                            <input type="hidden" name="type" value="practice_test">
						
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/content-list/'.Request::segment(3)."/".Request::segment(4))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Content List</a>
                        
                        <h6 class="card-title">Add Test Pdf</h6>  
                        <form action="{{asset('admin/add-content/'.Request::segment(3)."/".Request::segment(4))}}" method="post" enctype="multipart/form-data">	
                            @csrf
                            <div class="form-group">
                                <label for="institute">Test Pdf</label>
                              
                                <select class="js-example-basic-multiple" multiple name="video_tag[]">
                                    {{-- <option selected disabled>--Select--</option>  --}}
                                    
                                    <?php
                                        if(!empty($pdf_tests)){
                                            foreach($pdf_tests as $pdf_test){
                                    ?>
                                    <option value="<?php echo $pdf_test->etag; ?>"><?php echo $pdf_test->filename ?></option> 
                                    <?php } }?>                                 
                                    
                                    
                                   
                                </select>
                                <input type="hidden" name="type" value="pdf">

                                @if ($errors->has('video_tag'))
                                <div class="error">
                                    {{ $errors->first('video_tag') }}
                                </div>
                                @endif
                            </div>
						
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>


                

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/content-list/'.Request::segment(3)."/".Request::segment(4))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Content List</a>
                        
                        <h6 class="card-title">Add E-Book</h6>  
                        <form action="{{asset('admin/add-content/'.Request::segment(3)."/".Request::segment(4))}}" method="post" enctype="multipart/form-data">	
                            @csrf
                            <div class="form-group">
                                <label for="institute">E-book</label>
                              
                                <select class="js-example-basic-multiple" multiple name="video_tag[]">
                                    {{-- <option selected disabled>--Select--</option>  --}}
                                    
                                    <?php
                                        if(!empty($ebooks)){
                                            foreach($ebooks as $ebook){
                                    ?>
                                    <option value="<?php echo $ebook->etag; ?>"><?php echo $ebook->filename ?></option> 
                                    <?php } }?>                                 
                                    
                                    
                                   
                                </select>

                                <input type="hidden" name="type" value="ebook">
                                @if ($errors->has('video_tag'))
                                <div class="error">
                                    {{ $errors->first('video_tag') }}
                                </div>
                                @endif
                            </div>
						
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>





            </div>
           
        </div>

    </div>

</main>
<!-- end::main content -->

@endsection
@push('footer-script')
    <!-- begin::select2 -->
      <!-- begin::select2 -->
<link rel="stylesheet" href="{{asset('public/admin/vendors/select2/css/select2.min.css')}}" type="text/css">     <!-- end::select2 -->
  
<script src="{{asset('public/admin/vendors/select2/js/select2.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>

<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();

    
});
</script>
<!-- end::select2 -->
@endpush