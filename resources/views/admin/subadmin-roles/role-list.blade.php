@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Admin Roles</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Admin Roles</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="card">
            <div class="card-body">
                <a href="{{asset('admin/add-roles')}}" class="btn btn-primary">Add Roles</a>
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Role</th>                       
                        <th>Module</th>                       
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($roles))
                        @foreach($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->role}}</td>
                        <td><a href="{{asset('admin/subadmin-module/'.$role->id)}}"><i class="fa fa-plus"></i></a></td>
                        <td>

                            <?php 
                            $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],11);                                                          
                            
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-admin-role/'.$role->id)}}"><i class="fa fa-eye text-success"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-admin-role/'.$role->id)}}"><i class="fa fa-eye text-success"></i></a>
                            <a  href="{{asset('admin/edit-admin-role/'.$role->id)}}"><i class="fa fa-edit text-success"></i></a>
                           
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('admin/view-admin-role/'.$role->id)}}"><i class="fa fa-eye text-success"></i></a>
                            <a  href="{{asset('admin/edit-admin-role/'.$role->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a class="delete-confirm" href="{{asset('admin/delete-admin-role/'.$role->id)}}"><i class="fa fa-trash text-danger"></i></a>
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