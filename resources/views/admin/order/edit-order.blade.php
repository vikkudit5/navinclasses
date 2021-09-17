@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Product</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/product-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Product List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Edit Product</h6>
                        <form action="{{asset('admin/edit-product/'.Request::segment(3))}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="username">Product Name</label>
                                <input type="text" class="form-control" name="name" value="{{$product->name}}" id="name" placeholder="Enter Product Name">
                               
                                @if ($errors->has('pname'))
                                <div class="error">
                                    {{ $errors->first('pname') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Type</label>
                                <select class="js-example-basic-single" name="type">
                                    <option>Select Type</option>
                                    <option value="course" {{($product->type=='course')?"selected":""}}>Course</option>
                                    <option value="testseries" {{($product->type=='testseries')?"selected":""}}>Testseries</option>
                                    <option value="book" {{($product->type=='book')?"selected":""}}>Book</option>
                                    
                                   
                                </select>

                                @if ($errors->has('type'))
                                <div class="error">
                                    {{ $errors->first('type') }}
                                </div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="email">Short Description</label>
                                
                                <textarea name="short_desc" placeholder="Enter Short desc.." class="form-control" id="" cols="30" rows="10">{{$product->short_desc}}</textarea>
                               
                                @if ($errors->has('short_desc'))
                                <div class="error">
                                    {{ $errors->first('short_desc') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="email">Description</label>
                                
                                <textarea name="description" placeholder="Enter Short desc.." class="form-control" id="" cols="30" rows="10">{{$product->description}}</textarea>
                               
                                @if ($errors->has('description'))
                                <div class="error">
                                    {{ $errors->first('description') }}
                                </div>
                                @endif

                            </div>


                            <div class="form-group">
                                <label for="phone">Youtube Url</label>
                                <input type="text" class="form-control" name="videoUrl" value="{{$product->video_url}}" id="videoUrl" placeholder="Enter Video Url">
                               
                                @if ($errors->has('videoUrl'))
                                <div class="error">
                                    {{ $errors->first('videoUrl') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Features</label>
                                <input type="text" class="form-control" name="features" value="{{$product->features}}" id="features" placeholder="Enter Features">
                               
                                @if ($errors->has('features'))
                                <div class="error">
                                    {{ $errors->first('features') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="{{$product->sort_order}}" id="sort_order" placeholder="Enter Sort Order">
                               
                                @if ($errors->has('sort_order'))
                                <div class="error">
                                    {{ $errors->first('sort_order') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Slug</label>
                                <input type="text" class="form-control" name="slug" value="{{$product->slug}}" id="slug" placeholder="Enter slug">
                               
                                @if ($errors->has('slug'))
                                <div class="error">
                                    {{ $errors->first('slug') }}
                                </div>
                                @endif

                            </div>



                          
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="custom-file">
                              
                                <input type="file" class="custom-file-input" name="image" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <img src="{{asset("public/uploads/products/".$product->image)}}" style="width: 50px;height:50px;">
                                @if ($errors->has('image'))
                                <div class="error">
                                    {{ $errors->first('image') }}
                                </div>
                                @endif

                            </div>
                            </div>

                            
                            <div class="form-group">
                                <label for="institute">Status</label>
                                <select class="js-example-basic-single" name="status">
                                    <option value="1" {{($product->status == '1')?"selected":""}}>Active</option>
                                    <option value="0" {{($product->status == '0')?"selected":""}}>Inactive</option>                                   
                                   
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