@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Schedule List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Schedule List</li>
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
                <a href="{{asset('admin/add-schedule/'.Request::segment(3))}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Schedule</a>
               
               

                @if(isset($liveSchedules))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>live Status</th>                       
                        <th>Program Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>                  
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($liveSchedules))
                        @foreach($liveSchedules as $liveSchedule)
                    <tr>
                        <td>{{$liveSchedule->id}}</td>

                        <td>
                        <?php

                                $live = "width: 15px; height: 15px; border-radius: 15px; top: -2px; left: -1px; position: relative; background-color: green; content: ''; display: inline-block; visibility: visible; border: 2px solid #f55152;";

                                $notlive = "width: 15px; height: 15px; border-radius: 15px; top: -2px; left: -1px; position: relative; background-color: grey; content: ''; display: inline-block; visibility: visible; border: 2px solid white;";

                            $current_date   = date('Y-m-d');
                            $sch_start_date = $liveSchedule->start_date;
                            $sch_end_date   = $liveSchedule->end_date;

                            $big_date1 = DateTime::createFromFormat('Y-m-d', $current_date);

                            // print_r($big_date1);
                            $big_date2 = DateTime::createFromFormat('Y-m-d', $sch_start_date);
                            $big_date3 = DateTime::createFromFormat('Y-m-d', $sch_end_date);

                            $current_time   = date('H:i:s');
                            $sch_start_time = $liveSchedule->start_time;
                            $sch_end_time   = $liveSchedule->end_time;

                            $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                            $date2 = DateTime::createFromFormat('H:i:s', $sch_start_time);
                            $date3 = DateTime::createFromFormat('H:i:s', $sch_end_time);

                            if ($big_date1 >= $big_date2 && $big_date1 <= $big_date3) {
                                if ($date1 >= $date2 && $date1 <= $date3) {
                                        echo  "<div style='" . $live . "'></div>";
                                } else {
                                    echo "<div style='" . $notlive . "'></div>";
                                }
                            } else {
                                echo  "<div style='" . $notlive . "'></div>";
                            }
                        ?>

                        </td>
                        <td>{{$liveSchedule->program_name}}</td>
                        <td>{{$liveSchedule->start_date."-".$liveSchedule->end_date}}</td>
                        <td>{{$liveSchedule->start_time."-".$liveSchedule->end_time}}</td>
                       

                       

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
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],14);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            {{-- <a  href="{{asset('admin/view-product/'.$liveSchedule->id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                           
                            @endif

                            @if($permission == 'write')
                            {{-- <a  href="{{asset('admin/view-product/'.$liveSchedule->id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                            {{-- <a  href="{{asset('admin/edit-product/'.$liveSchedule->id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            
                            @endif

                            @if($permission == 'delete')
                            {{-- <a  href="{{asset('admin/view-product/'.$liveSchedule->id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                            {{-- <a  href="{{asset('admin/edit-product/'.$liveSchedule->id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            <a  href="{{asset('admin/delete-liveschedule/'.$liveSchedule->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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

                         {{ $liveSchedules->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $liveSchedules->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($liveSchedules) ?></label>
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