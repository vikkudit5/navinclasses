@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Product</h3>
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
                <form action="" method="GET">
        
                    <div class="form-group col-md-8">
                       
                       <input type="text" class="form-control" name="query" placeholder="Search here....." value="{{ request()->input('query') }}">
                       <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                      
                    </div>
                    
                    
                
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp; Search</button>
                <a href="{{asset('admin/product-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

        <div class="card">
           
            <div class="card-body">
                <a href="{{asset('admin/add-product')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Product</a>
               
               

                @if(isset($products))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>                       
                        <th>Type</th>
                        <th>Imag</th>
                        <th>Sort Order</th>
                        <th>Category</th>
                        <th>Price</th>
                        <?php 
                        $product = App\Helpers\PermissionActivity::getPermission(14) ;
                
                        // print_r($a);
                        if(in_array(session('loggedIn')['id'],$product))
                        {
                
                    ?>

                        <th>Live Schedule</th>

                        <?php } ?>

                        <th>Status</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($products))
                        @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->type}}</td>
                        <td><img src="{{asset("public/uploads/products/".$product->image)}}" style="width:50px;height:50px;"></td>
                        <td>{{$product->sort_order}}</td>
                        <td><a href="{{asset('admin/category-list/'.$product->id)}}"><i class="fa fa-plus"></i></a></td>
                        <td><a href="{{asset('admin/price-list/'.$product->id)}}"><i class="fa fa-plus"></i></a></td>

                        <?php 
                        $productPermission = App\Helpers\PermissionActivity::getPermission(14) ;
                
                        // print_r($a);
                        if(in_array(session('loggedIn')['id'],$productPermission))
                        {
                
                    ?>

                        <td><a href="{{asset('admin/live-schedule-list/'.$product->id)}}"><i class="fa fa-plus"></i></a></td>

                        <?php } ?>

                        <td>
                            @if($product->status == 1)
                                <label for="" class="text-success">Active</label>
                            @endif

                            @if($product->status == 0)
                            <label for="" class="text-danger">Inactive</label>
                            @endif

                        </td>
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],6);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-product/'.$product->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-product/'.$product->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a  href="{{asset('admin/delete-product/'.$product->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
                            @endif

                            
                        </td>
                       
                    </tr>
                    @endforeach
                    @else
                        <h1>No Record Found!!</h1>
                    @endif
                    
                    </tbody>
                  
                </table>
                <div class="pagination-block">

                    @if(isset($_GET['query']))

                         {{ $products->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $products->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($products) ?></label>
                </div>
 
              @endif

            </div>
        </div>

       

    </div>

</main>
<!-- end::main content -->

@endsection
@push('footer-script')
    <!-- begin::dataTable -->

<script src="{{asset('public/admin/js/examples/datatable.js')}}"></script>
<!-- end::dataTable -->
@endpush