@extends('superadmin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Admin User</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Admin User</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="card">
            <div class="card-body">
                <a href="{{asset('superadmin/add-admin-user')}}" class="btn btn-primary">Add User</a>
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Role</th>                       
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Institute</th>
                        <th>Module Permission</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($admin_users))
                        @foreach($admin_users as $admin_user)
                    <tr>
                        <td>{{$admin_user->id}}</td>
                        <td>{{$admin_user->role}}</td>
                        <td>{{$admin_user->username}}</td>
                        <td>{{$admin_user->email}}</td>
                        <td>{{$admin_user->phone}}</td>
                        <td>{{$admin_user->institute}}</td>
                        <td><a href="{{asset('superadmin/module-permission/'.$admin_user->id."/".$admin_user->role_id)}}"><i class="fa fa-plus"></i></a></td>
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],5);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('superadmin/view-admin-user/'.$admin_user->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('superadmin/view-admin-user/'.$admin_user->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('superadmin/edit-admin-user/'.$admin_user->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('superadmin/view-admin-user/'.$admin_user->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('superadmin/edit-admin-user/'.$admin_user->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a  href="{{asset('superadmin/delete-admin-user/'.$admin_user->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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