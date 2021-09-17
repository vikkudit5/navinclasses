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
                  
                    <li class="breadcrumb-item active" aria-current="page">Order</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->
        
        <div class="row">
            <div class="col-md-6">
                <form action="" method="GET">
        
                    <div class="form-group col-md-6">
                       
                       <input type="text" class="form-control" name="query" placeholder="Search here....." value="{{ request()->input('query') }}">
                       <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                    </div>

                    
                    <div class="form-group col-md-4">
                       
                        <select class="form-control" name="course">
                            <option value="" disabled>Select product</option>
                            @if(!empty($main_categories))
                            @foreach($main_categories as $main_categ)
                                <option value="{{$main_categ->name }}">{{ $main_categ->name }}</option>
                                @endforeach
                            @endif
                           
                        
                        </select>
                     </div>

                     <div class="form-group col-md-4">
                       
                        <select class="form-control" name="amount">
                            <option value="cs">CS</option>
                            <option value="">CS</option>
                        </select>
                     </div>

                     <div class="form-group col-md-4">
                       
                        <select class="form-control" name="status">
                            <option value="cs">Pending</option>
                            <option value="">Credit</option>
                            <option value="">Refunds</option>
                        </select>
                     </div>



                    <label>
                        Range
                        <input id="demo-one-input" mbsc-input data-input-style="outline"  name="daterange" data-label-style="stacked" placeholder="Please select..." />
                    </label>

                    
                    
                
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp; Search</button>
                <a href="{{asset('admin/order-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

        <div class="card">
           
            <div class="card-body">
                <a href="{{asset('admin/create-order')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Create Order</a>
               
               

                @if(isset($billings))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Trans Id</th>                       
                        <th>User Details</th>
                        <th>Order No</th>
                        <th>Amount</th>
                        
                        <th>Quantity</th>
                        <th>Instrument Type</th>                        
                        <th>Payment Status</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($billings))
                        @foreach($billings as $billing)
                    <tr>
                        <td>{{$billing->id}}</td>
                        <td>{{$billing->trans_id}}</td>
                        <td>
                            {{$billing->name}}
                            {{$billing->email}}
                            {{$billing->phone}}
                        </td>
                        <td>{{$billing->order_no}}</td>
                        
                        <td><i class="fa fa-rupee"></i>{{$billing->grandtotal}}</td>
                     
                        <td>{{$billing->quantity}}</td>
                        <td>{{$billing->instrument_type	}}</td>
                       
                        <td>
                            @if($billing->paymentstatus == 'Credit')
                                <label for="" class="text-success">Credit</label>
                            @endif

                            @if($billing->paymentstatus == 'Pending')
                            <label for="" class="text-danger">Pending</label>
                            @endif

                        </td>
                        <td>{{$billing->created_at	}}</td>
                        
                       
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
                            <a  href="{{asset('admin/view-order-product-list/'.$billing->id)}}"><i class="fa fa-eye text-primary"></i></a>
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


{{-- <link href="{{asset('public/admin/css/mobiscroll.jquery.min.css')}}" rel="stylesheet" /> --}}
{{-- <script src="{{asset('public/admin/js/mobiscroll.jquery.min.js')}}"></script> --}}

{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    });
    </script> --}}



<!-- end::dataTable -->
@endpush