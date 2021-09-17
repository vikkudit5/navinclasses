@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Demo Content</h3>
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

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/demo-content-list/'.Request::segment(3)."/".Request::segment(4))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Category List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Content</h6>  
                        <form action="{{asset('admin/add-demo-content/'.Request::segment(3)."/".Request::segment(4))}}" method="post" enctype="multipart/form-data">	
                           
						 	  
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