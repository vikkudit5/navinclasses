@extends('superadmin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Module</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Admin Module</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('superadmin/admin-modules/'.Request::segment(3))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Module-List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Module</h6>
                        <form action="{{asset('superadmin/add-module/'.Request::segment(3))}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="moduleName">Module Name</label>
                                <input type="text" class="form-control" name="moduleName" value="{{old('moduleName')}}" id="moduleName" placeholder="Enter module Name">
                               
                                @if ($errors->has('moduleName'))
                                <div class="error">
                                    {{ $errors->first('moduleName') }}
                                </div>
                                @endif

                            </div>

                            <input type="hidden" name="role_id" value="{{Request::segment(3)}}">
                           
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