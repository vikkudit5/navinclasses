@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Admin User</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Admin User</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/module-permission')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Admin User List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Module Permission</h6>
                        <form action="{{asset('admin/add-module-permission/'.Request::segment(3))}}" method="post">
                            @csrf

                           

                            <div class="form-group">
                                <label for="institute">Admin Module</label>
                                <select class="js-example-basic-single" multiple name="adminModuleId[]">
                                    <option></option>
                                    @if(!empty($modules))
                                    @foreach($modules as $module)
                                    <option value="{{$module->id}}">{{$module->module}}</option>
                                    @endforeach
                                    @endif
                                   
                                </select>

                                @if ($errors->has('adminModuleId'))
                                <div class="error">
                                    {{ $errors->first('adminModuleId') }}
                                </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="institute">Permission</label>
                                <select class="js-example-basic-single"  name="permission">
                                    <option value="">Select Permission</option>
                                    <option value="read">Read</option>
                                    <option value="write">Write</option>
                                    <option value="delete">Delete</option>
                                   
                                   
                                </select>

                                @if ($errors->has('permission'))
                                <div class="error">
                                    {{ $errors->first('permission') }}
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
    <!-- begin::select2 -->
      <!-- begin::select2 -->
<link rel="stylesheet" href="{{asset('public/admin/vendors/select2/css/select2.min.css')}}" type="text/css">
      <!-- end::select2 -->
  
<script src="{{asset('public/admin/vendors/select2/js/select2.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>
<!-- end::select2 -->
@endpush