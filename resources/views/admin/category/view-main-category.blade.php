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
                        <a href="{{asset('admin/main-category-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Category List</a> 
                        <x-flashMessage/>  
						<h6 class="card-title">View Category</h6>   
						<form action="{{asset('admin/edit-main-category/'.Request::segment(3))}}" method="post" enctype="multipart/form-data">
						@csrf  
						{{-- <input type="hidden" name="product_id" value="{{ $info->product_id }}" />     --}}
                    	
                            <div class="form-group">
                                <label for="name">Name</label>  
                                <input type="text" class="form-control" readonly name="name" value="{{$category->name}}" id="name" placeholder="Enter Product Name">                                
								@if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="institute">Type</label>
                                <select class="js-example-basic-single" readonly name="type">
                                    <option selected disabled>--Select--</option> 
                                    <option value="content" {{($category->type == 'content')?"selected":""}}>Content</option>                                     
                                    <option value="category" {{($category->type == 'category')?"selected":""}}>Category</option> 
                                    
                                   
                                </select>

                                @if ($errors->has('type'))
                                <div class="error">
                                    {{ $errors->first('type') }}
                                </div>
                                @endif
                            </div>



                        
							
							<div class="form-group">
                                <label for="name">Sort Order</label>   
                                <input type="number" class="form-control" readonly name="sort_order" value="{{$category->sort_order}}" id="sort_order" min="0">                              
								@if ($errors->has('sort_order'))
                                <div class="error">
                                    {{ $errors->first('sort_order') }}     
                                </div>
                                @endif
                            </div>

                                                          
							{{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
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