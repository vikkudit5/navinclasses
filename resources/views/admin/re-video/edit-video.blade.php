@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Edit Video</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Video</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/re-video-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Video List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Edit Video</h6>
                        <form action="{{asset('admin/edit-re-video/'.Request::segment(3))}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="username">public Name</label>
                                <input type="text" class="form-control" name="public_name" value="{{$video->public_name}}" id="public_name" placeholder="Enter Public Name">
                               
                                @if ($errors->has('public_name'))
                                <div class="error">
                                    {{ $errors->first('public_name') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Time</label>
                                <input type="time" class="form-control" name="time" value="{{$video->duration}}" id="time" placeholder="Enter Time">
                               
                                @if ($errors->has('time'))
                                <div class="error">
                                    {{ $errors->first('time') }}
                                </div>
                                @endif

                            </div>

                            <button type='submit' class="btn btn-info">
                                <i class="fa fa-submit"></i>&nbsp;Submit
                            </button>


                       
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