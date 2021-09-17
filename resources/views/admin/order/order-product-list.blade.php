@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Order</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Order product List</li>
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
                <a href="{{asset('admin/order-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

        <div class="card">
           
            <div class="card-body">
                <a href="{{asset('admin/order-list')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Order List</a>
               
               

                @if(isset($billings))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>                       
                        <th>Mode</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>No. Of Days</th>
                        
                        <th>Duration</th>
                        <th>Expire status</th>                        
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($billings))
                        @foreach($billings as $billing)
                    <tr>
                        <td>{{$billing->id}}</td>
                        <td>{{$billing->product_name}}</td>
                        <td>
                            {{$billing->product_mode}}
                           
                        </td>
                        <td>{{$billing->product_type}}</td>                 
                       
                     
                        <td>{{$billing->qty}}</td>
                        <td>{{$billing->days}}</td>
                        <td>{{date('d/m/Y',strtotime($billing->start_date))."-".date('d/m/Y',strtotime($billing->expire_date))}}</td>
                       
                        <td>
                            @if($billing->expired == 0)
                                <label for="" class="text-success">Active</label>
                            @endif

                            @if($billing->expired == 1)
                            <label for="" class="text-danger">Expired</label>
                            @endif

                        </td>
                       
                        
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],6);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-product/'.$billing->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-product/'.$billing->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-product/'.$billing->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif
 
                            @if($permission == 'delete')
                                <select class="form-control changeStatus" data-id="{{$billing->id}}">
                                    <option value="">Select Status</option>
                                    <option value="0" {{($billing->expired == 0)?"selected":""}}>Active</option>
                                    <option value="1" {{($billing->expired == 1)?"selected":""}}>Expired</option>
                                </select>
                            {{-- <a  href="{{asset('admin/view-product/'.$billing->id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                            {{-- <a  href="{{asset('admin/edit-product/'.$billing->id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            {{-- <a  href="{{asset('admin/delete-product/'.$billing->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a> --}}
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

                         {{ $billings->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $billings->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($billings) ?></label>
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
<script>
    
    $(document).on('change','.changeStatus',function(){
            var status = $(this).val();
            var id = $(this).data('id');
            // alert(id);

            $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                      });


            $.ajax({

                type:"post",
                data:{"status":status,"id":id},
                url:"{{ asset('admin/change-order-status') }}",
                
                success:function(result)
                {
                    // console.log(result);
                    

                    location.reload();
                }


            });
        });
</script>
@endpush