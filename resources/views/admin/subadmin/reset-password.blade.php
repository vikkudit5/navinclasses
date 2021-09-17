@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Reset Password</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/subadmin-user-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Admin User List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Reset password</h6>
                        <form action="{{asset('admin/reset-user-password/'.Request::segment(3))}}" method="post">
                            @csrf
                           

                         <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" value="{{old('password')}}" id="password" placeholder="Enter Password">
                               
                                @if ($errors->has('password'))
                                <div class="error">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Confirm Password</label>
                                <input type="password" class="form-control" name="cpassword" value="{{old('cpassword')}}" id="cpassword" placeholder="Enter Confirm Password">
                               
                                @if ($errors->has('cpassword'))
                                <div class="error">
                                    {{ $errors->first('cpassword') }}
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