@extends('admin.layout')
@section('content')

<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Edit Category</h3>
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
                        <a href="{{asset('admin/category-list/'.$info->product_id)}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Category List</a>                         
                        <x-flashMessage/>  
						<h6 class="card-title">Edit Category</h6>   
						<form action="{{asset('admin/edit-category/'.Request::segment(3))}}" method="post" enctype="multipart/form-data">
						@csrf  
						<input type="hidden" name="product_id" value="{{ $info->product_id }}" />    
                    	
                            <div class="form-group">
                                <label for="name">Name</label>  
                                <input type="text" class="form-control" name="name" value="{{$info->name}}" id="name" placeholder="Enter Product Name">                                
								@if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="institute">Type</label>
                                <select class="js-example-basic-single" name="type">
                                    <option selected disabled>--Select--</option> 
                                    <option value="content" {{($info->type=='content')?"selected":""}}>Content</option>                                     
                                    <option value="category" {{($info->type=='category')?"selected":""}}>Category</option> 
                                </select>
								@if ($errors->has('type'))
                                <div class="error">
                                    {{ $errors->first('type') }}	
                                </div>
                                @endif   
                            </div>
							
							<div class="form-group">
                                <label for="name">Sort Order</label>   
                                <input type="number" class="form-control" name="sort_order" value="{{$info->sort_order}}" id="sort_order" min="0">                              
								@if ($errors->has('sort_order'))
                                <div class="error">
                                    {{ $errors->first('sort_order') }}     
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Description</label>                                
                                <textarea name="description" class="form-control" id="" cols="30" rows="10">{{$info->description}}</textarea>
								@if ($errors->has('description'))
                                <div class="error">
                                    {{ $errors->first('description') }}  
                                </div>
                                @endif  
                            </div>  
                          
                        <div class="form-group">                             
                            <div class="custom-file">
								<input type="file" class="custom-file-input" name="image" id="customFile">
								<label class="custom-file-label" for="customFile">Choose file</label>   
								<img src="{{asset("public/uploads/category/".$info->image)}}" style="width: 50px;height:50px;">
                            </div>
							@if ($errors->has('image'))
							<div class="error">
								{{ $errors->first('image') }}  
							</div>
							@endif
                        </div>   
                            
                            <div class="form-group">
                                <label for="institute">Status</label>
                                <select class="js-example-basic-single" name="status">   
								    <option selected disabled>--Select--</option>    
                                    <option value="1" {{($info->status=='1')?"selected":""}}>Active</option>
                                    <option value="0" {{($info->status=='0')?"selected":""}}>Inactive</option>    	
                                </select>
								@if ($errors->has('status'))
                                <div class="error">
                                    {{ $errors->first('status') }}  
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