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
                        <a href="{{asset('admin/subadmin-user-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Admin User List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Admin User</h6>
                        <form action="{{asset('admin/add-admin-user')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="username">User Name</label>
                                <input type="text" class="form-control" name="username" value="{{old('username')}}" id="username" placeholder="Enter User Name">
                               
                                @if ($errors->has('username'))
                                <div class="error">
                                    {{ $errors->first('username') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" id="email" placeholder="Enter Email Name">
                               
                                @if ($errors->has('email'))
                                <div class="error">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="phone">Mobile</label>
                                <input type="number" class="form-control" name="phone" value="{{old('phone')}}" id="phone" placeholder="Enter Phone">
                               
                                @if ($errors->has('phone'))
                                <div class="error">
                                    {{ $errors->first('phone') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Institute</label>
                                <input type="text" class="form-control" name="institute" value="{{old('institute')}}" id="institute" placeholder="Enter Institute">
                               
                                @if ($errors->has('institute'))
                                <div class="error">
                                    {{ $errors->first('institute') }}
                                </div>
                                @endif

                            </div>

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
                                <label for="institute">Role</label>
                                <select class="js-example-basic-single" name="adminRole">
                                    <option></option>
                                    @if(!empty($roles))
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->role}}</option>
                                    @endforeach
                                    @endif
                                   
                                </select>

                                @if ($errors->has('adminRole'))
                                <div class="error">
                                    {{ $errors->first('adminRole') }}
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