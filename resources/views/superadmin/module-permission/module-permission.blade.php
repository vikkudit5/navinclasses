@extends('superadmin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>{{$admin_user->username}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Module Permission</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="card">
            <x-flashMessage/>
            <div class="card-body">
                <a href="{{asset('superadmin/add-module-permission/'.Request::segment(3)."/".Request::segment(4))}}" class="btn btn-primary">Add Module Permission</a>
                <?php 
                $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],5);                                                          
                
                ?>

                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Module Name</th>                       
                        <th>Permission</th>
                        @if($permission == 'delete')
                        <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($admin_modules))
                        @foreach($admin_modules as $admin_module)
                    <tr>
                        <td>{{$admin_module->id}}</td>
                        <td>{{$admin_module->module}}</td>
                        <td>{{$admin_module->permission}}</td>
                       
                       

                        @if($permission == 'delete')
                        <td>
                            {{-- <a  href="{{asset('admin/edit-module-permission/'.$admin_module->id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            <a  href="{{asset('superadmin/delete-module-permission/'.$admin_module->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
                        </td>
                        
                        @endif

                        
                       
                    </tr>
                    @endforeach
                    @endif
                    
                    </tbody>
                  
                </table>
            </div>
        </div>

       

    </div>

</main>
<!-- end::main content -->

@endsection
@push('footer-script')
    <!-- begin::dataTable -->
<script src="{{asset('public/admin/vendors/dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/dataTable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/dataTable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/datatable.js')}}"></script>
<!-- end::dataTable -->
@endpush