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
                        <h6 class="card-title">Add Product</h6>
                        <form action="{{asset('admin/add-product')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span id="msg" ></span>
                            <div class="form-group">
                                <label for="institute">Category <span class="error">*</span></label>
                                
                                {{-- <a href="javascript:;" class="btn btn-success btn-sm pull-right add-sub-inp-box">Sub</a> --}}
                                {{-- <a href="javascript:;" class="btn btn-primary btn-sm pull-right add-input-box" style="margin-right: 3px;"><i class="fa fa-plus"></i></a> --}}

                                <select class="js-example-basic-single category" name="category" id="category">
                                    <option value="">Select Category</option>
                                    @if(!empty($categories))
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{!! $category->name !!}</option>
                                    @endforeach
                                   @endif
                                    
                                   
                                </select>

                                

                                @if ($errors->has('category'))
                                <div class="error">
                                    {{ $errors->first('category') }}
                                </div>
                                @endif
                            </div>
                            <input type="hidden" name="selectCatId" id="selectCatId">
                            <div class="form-group input-box"></div>
                            <div class="form-group select-box"></div>

                            <div class="form-group">
                                <label for="name">Product Name</label>
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
                                    <option>Select Type</option>
                                    <option value="course">Course</option>
                                    <option value="testseries">Testseries</option>
                                    <option value="book">Book</option>
                                    
                                   
                                </select>

                                @if ($errors->has('type'))
                                <div class="error">
                                    {{ $errors->first('type') }}
                                </div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="email">Short Description <span class="error">*</span></label>
                                
                                <textarea name="short_desc" placeholder="Enter Short desc.." class="form-control" id="" cols="30" rows="10"></textarea>
                               
                                @if ($errors->has('short_desc'))
                                <div class="error">
                                    {{ $errors->first('short_desc') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="email">Description <span class="error">*</span></label>
                                
                                <textarea name="description" placeholder="Enter Short desc.." class="form-control" id="" cols="30" rows="10"></textarea>
                               
                                @if ($errors->has('description'))
                                <div class="error">
                                    {{ $errors->first('description') }}
                                </div>
                                @endif

                            </div>


                            <div class="form-group">
                                <label for="phone">Youtube Url <span class="error">*</span></label>
                                <input type="text" class="form-control" name="videoUrl" value="{{old('videoUrl')}}" id="videoUrl" placeholder="Enter Video Url">
                               
                                @if ($errors->has('videoUrl'))
                                <div class="error">
                                    {{ $errors->first('videoUrl') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Features <span class="error">*</span></label>
                                <input type="text" class="form-control" name="features" value="{{old('features')}}" id="features" placeholder="Enter Features">
                               
                                @if ($errors->has('features'))
                                <div class="error">
                                    {{ $errors->first('features') }}
                                </div>
                                @endif

                            </div>


                            <div class="form-group">
                                <label for="institute">Author <span class="error">*</span></label>
                                
                              

                                <select class="js-example-basic-single" name="teacher_id" id="teacher_id">
                                    <option value="">Select Author</option>
                                    @if(!empty($teachers))
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{!! $teacher->username !!}</option>
                                    @endforeach
                                   @endif
                                    
                                   
                                </select>

                                

                                @if ($errors->has('teacher_id'))
                                <div class="error">
                                    {{ $errors->first('teacher_id') }}
                                </div>
                                @endif
                            </div>


                          
                        <div class="form-group">
                            <label for="image">Image <span class="error">*</span></label>
                            <div class="form-group">
                              
                                <input type="file" class="form-control" name="image" id="customFile">
                                {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}

                                @if ($errors->has('image'))
                                <div class="error">
                                    {{ $errors->first('image') }}
                                </div>
                                @endif

                            </div>
                            </div>

                            
                            {{-- <div class="form-group">
                                <label for="institute">Status</label>
                                <select class="js-example-basic-single" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>                                   
                                   
                                </select>

                                @if ($errors->has('status'))
                                <div class="error">
                                    {{ $errors->first('status') }}
                                </div>
                                @endif
                            </div> --}}
                           
                           
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
    $(document).ready(function(){
        $(document).on('change','.category',function(){

            // alert();
            // e.preventDefault();
            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });

            var catId = $(this).val();
            $('#selectCatId').val(catId);
          
            $.ajax({
                type:"post",
                data:{"catId":catId},
                url:"{{ asset('admin/get-sub-category') }}",
                dataType:"json",              
                success:function(result)
                {
                    // console.log(result);
                    // return false;
                    $('.select-box').html(result);
                    // console.log(result);
                }
            });
        });


        $(document).on('click','.add-input-box',function(){
            $('.input-box').append(`<input type="text" class="form-control" id="catName" placeholder="Add Category Name"><button class="btn btn-primary btn-sm cat-save"><i class="fa fa-save"></i></button>`);

            $('.add-input-box').prop('disabled',true);
            
        });
       

        $(document).on('click','.cat-save',function(e){
            
            e.preventDefault();
            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });

            var catName = $('#catName').val();
            // alert(catName);
            $.ajax({
                type:"post",
                data:{"catName":catName},
                url:"{{ asset('admin/save-main-category') }}",
                // dataType:"html",              
                success:function(result)
                {
                    
                    $('#category').html(result);
                    $('#catName').val('');
                    // console.log(result);
                }
            });
        });


        /* add sub category */

        $(document).on('click','.add-sub-inp-box',function(){
            $('.input-box').append(`<input type="text" class="form-control" id="subcatName" placeholder="Add Sub Category Name"><button class="btn btn-primary btn-sm sub-cat-save"><i class="fa fa-save"></i></button>`);

            $('.add-sub-inp-box').prop('disabled',true);
            
        });

        $(document).on('click','.sub-cat-save',function(e){
            e.preventDefault();
            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });

            var subcatName = $('#subcatName').val();
            var catId = $('#category').val();
            if(catId=='' || catId=='undefined')
            {
               $('#msg').html('<div class="alert alert-danger">Please Select Category</div>');
               return false;
            }

            $.ajax({
                type:"post",
                data:{"subcatName":subcatName,"catId":catId},
                url:"{{ asset('admin/save-sub-category') }}",
                
              
                success:function(result)
                {
                    if(result == 1)
                    {
                        $('#msg').html('<div class="alert alert-success">Sub category Added Successfully!</div>')
                    }

                    if(result == -1)
                    {
                        $('#msg').html('<div class="alert alert-danger">Sub category Not Added Successfully!</div>')
                    }

                    // location.reload();
                }
            });
        });

        $(document).on('change','#category',function(){
            var catId = $(this).val();

            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });


            $.ajax({

                type:"post",
                data:{"catId":catId},
                url:"{{ asset('admin/get-sub-category') }}",
                dataType:"html",
                success:function(result)
                {
                    console.log(result);
                    

                    // location.reload();
                }


            });
        });


    });
</script>
<!-- end::select2 -->
@endpush