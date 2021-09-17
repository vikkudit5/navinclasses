@extends('superadmin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Edit Roles</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Admin Roles</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('superadmin/admin-roles')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Role-List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Edit Role</h6>
                        <form action="{{asset('superadmin/edit-admin-role/'.Request::segment(3))}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="rollName">Roll Name</label>
                                <input type="text" class="form-control" name="rollName" value="{{(!empty($role->role))?$role->role:""}}" id="rollName" placeholder="Enter Roll Name">
                               
                                @if ($errors->has('rollName'))
                                <div class="error">
                                    {{ $errors->first('rollName') }}
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
    
@endpush