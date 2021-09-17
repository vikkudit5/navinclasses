@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Create Order </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Create Order</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/order-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; order List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Create Order</h6>
                        <form action="{{asset('admin/create-order')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span id="msg" ></span>
                            <div class="form-group">
                                <label for="institute">User</label>                   
                                <select class="js-example-basic-single category" name="user_id" id="user_id">
                                    <option value="">Select User</option>
                                    @if(!empty($users))
                                    @foreach($users as $user)
                                    <option value="{{$user->user_unique_id}}">{!! $user->email."-".$user->phone !!}</option>
                                    @endforeach
                                   @endif
                                    
                                   
                                </select>

                                @if ($errors->has('user_id'))
                                <div class="error">
                                    {{ $errors->first('user_id') }}
                                </div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="institute">Product</label>
                                <select class="js-example-basic-single category" name="prod_id" id="prod_id">
                                    <option value="">Select Product</option>
                                    @if(!empty($products))
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}">{!! $product->name."-(".$product->type.")" !!}</option>
                                    @endforeach
                                   @endif
                                    
                                   
                                </select>

                                

                                @if ($errors->has('prod_id'))
                                <div class="error">
                                    {{ $errors->first('prod_id') }}
                                </div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="institute">Mode</label>
                                <select class="js-example-basic-single category" name="mode" id="mode">
                                    <option value="">Select Mode</option>
                                  
                                </select>

                                

                                @if ($errors->has('mode'))
                                <div class="error">
                                    {{ $errors->first('mode') }}
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="price">Duration</label>
                                <input type="text" readonly class="form-control" name="duration" value="{{old('duration')}}" id="duration" placeholder="Enter duration">
                               
                                @if ($errors->has('duration'))
                                <div class="error">
                                    {{ $errors->first('duration') }}
                                </div>
                                @endif

                            </div>

                            <input type="text" readonly class="form-control" name="select_mode" value="{{old('select_mode')}}" id="select_mode">


                           

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" value="{{old('price')}}" id="price" placeholder="Enter Price">
                               
                                @if ($errors->has('price'))
                                <div class="error">
                                    {{ $errors->first('price') }}
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
    $(document).ready(function(){
     

     
        /* get product mode */
        $(document).on('change','#prod_id',function(){
            var prod_id = $(this).val();
            
            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });


            $.ajax({

                type:"post",
                data:{"prod_id":prod_id},
                url:"{{ asset('admin/get-product-price') }}",
                dataType:"html",
                success:function(result)
                {
                  
                    $('#mode').html(result);
                    
                }


            });
        });

/* get price by product Mode */
        $(document).on('change','#mode',function(){
            var mode_id = $(this).val();
            // alert(mode_id);
            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });


            $.ajax({

                type:"post",
                data:{"mode_id":mode_id},
                url:"{{ asset('admin/get-price-duration') }}",
                dataType:"json",
                success:function(result)
                {
                    // var obj = JSON.parse(result);
                    $('#price').val(result.price);
                    $('#duration').val(result.duration);
                    $('#select_mode').val(result.mode);
                    // console.log(result);
                    
                    // $('#mode').html(result);
                    
                }


            });
        });


    });
</script>
<!-- end::select2 -->
@endpush