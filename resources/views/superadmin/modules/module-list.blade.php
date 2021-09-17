@extends('superadmin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>{{(!empty($role))?$role->role:"Admin Module"}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Admin Modules</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="card">
            <div class="card-body">
                <a href="{{asset('superadmin/add-module/'.Request::segment(3))}}" class="btn btn-primary">Add Module</a>
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Module</th>                       
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($modules))
                        @foreach($modules as $module)
                    <tr>
                        <td>{{$module->id}}</td>
                        <td>{{$module->module}}</td>
                        <td>
                            <?php 
                            $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],5);                                                          
                            
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('superadmin/view-admin-module/'.$module->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('superadmin/view-admin-module/'.$module->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('superadmin/edit-admin-module/'.$module->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('superadmin/view-admin-module/'.$module->id."/".Request::segment(3))}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('superadmin/edit-admin-module/'.$module->id."/".Request::segment(3))}}"><i class="fa fa-edit text-success"></i></a>
                            <a class="delete-confirm" href="{{asset('superadmin/delete-admin-module/'.$module->id)}}"><i class="fa fa-trash text-danger"></i></a>
                            @endif

                            
                        </td>
                       
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