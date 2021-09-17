@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Category</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Category</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/main-category-list/')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Category List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Category</h6>  
                        <form action="{{asset('admin/save-main-category')}}" method="post" enctype="multipart/form-data">	
                            <input type="hidden" name="parent_id" value="{{ Request::segment(3) }}" /> 	
						 	  
                            @csrf
                            <div class="form-group">
                                <label for="name">Name <span class="error">*</span></label>  
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name" placeholder="Enter Product Name">
                               
                                @if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Type <span class="error">*</span></label>
                                <select class="js-example-basic-single" name="type">
                                    <option selected disabled>--Select--</option> 
                                    <option value="content">Content</option>                                     
                                    <option value="category">Category</option> 
                                    
                                   
                                </select>

                                @if ($errors->has('type'))
                                <div class="error">
                                    {{ $errors->first('type') }}
                                </div>
                                @endif
                            </div>
						
                           
                          
                        <div class="form-group">
                            <label for="image">Image <span class="error">*</span></label>
                            
                              
                                <input type="file" class="form-control" name="image" >
                                {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}

                                @if ($errors->has('image'))
                                <div class="error">
                                    {{ $errors->first('image') }}
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
<!-- end::select2 -->
@endpush