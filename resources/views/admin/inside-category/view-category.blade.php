@extends('admin.layout')
@section('content')

<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>View Category</h3>
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
                        <h6 class="card-title">View Category</h6>   						
                            <div class="form-group">
                                <label for="name">Name</label>  
                                <input type="text" class="form-control" name="name" value="{{$info->name}}" id="name" readonly>                                
                            </div>

                            <div class="form-group">
                                <label for="institute">Type</label>
                                <select class="form-control" name="type" readonly>
                                    <option selected disabled>--Select--</option> 
                                    <option value="content" {{($info->type=='content')?"selected":""}}>Content</option>                                     
                                    <option value="category" {{($info->type=='category')?"selected":""}}>Category</option> 
                                </select>
                            </div>
							
							<div class="form-group">
                                <label for="name">Sort Order</label>   
                                <input type="number" class="form-control" name="sort_order" value="{{$info->sort_order}}" id="sort_order" min="0" readonly>                              
                            </div>

                            <div class="form-group">
                                <label for="email">Description</label>                                
                                <textarea name="description" class="form-control" id="" cols="30" rows="10" readonly>{{$info->description}}</textarea>
                            </div>  
                          
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="custom-file">
								<img src="{{asset("public/uploads/category/".$info->image)}}" style="width: 50px;height:50px;">

                            </div>
                        </div>   
                            
                            <div class="form-group">
                                <label for="institute">Status</label>
                                <select class="form-control" name="status" readonly> 
								    <option selected disabled>--Select--</option>    
                                    <option value="1" {{($info->status=='1')?"selected":""}}>Active</option>
                                    <option value="0" {{($info->status=='0')?"selected":""}}>Inactive</option>    	
                                </select>  
                            </div>                                  
							<a href="{{asset('admin/category-list/'.$info->product_id)}}" class="btn btn-primary pull-right"><i class="fa fa-long-arrow-left">&nbsp;</i>Back</a>                        
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