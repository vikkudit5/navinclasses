@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Studio List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Studio List</li>
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
                <a href="{{asset('admin/studio-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

        <div class="card">
           
            <div class="card-body">
                <a href="{{asset('admin/add-studio')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Studio</a>
               
               

                @if(isset($studios))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>std_id</th>                       
                        <th>std_name</th>
                        {{-- <th>embed</th> --}}
                        {{-- <th>std_embed_video</th> --}}
                        <th>std_rtmp_url</th>
                        
                        
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($studios))
                        @foreach($studios as $studio)
                    <tr>
                        <td>{{$studio->id}}</td>
                        <td>{{$studio->std_id}}</td>
                        <td>{{$studio->std_name}}</td>
                        
                        {{-- <td>{{$studio->embed}}</td> --}}
                        {{-- <td>{{$studio->std_embed_video}}</td> --}}
                        <td>{{$studio->std_rtmp_url}}</td>
                     
                       
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],14);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-studio/'.$studio->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-studio/'.$studio->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            {{-- <a  href="{{asset('admin/edit-studio/'.$studio->id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('admin/view-studio/'.$studio->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            {{-- <a  href="{{asset('admin/edit-studio/'.$studio->id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            <a  href="{{asset('admin/delete-studio/'.$studio->std_id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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

                         {{ $studios->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $studios->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($studios) ?></label>
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