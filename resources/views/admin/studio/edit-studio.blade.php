@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Edit Studio</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Edit Studio List</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/studio-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Studio List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Edit Studio</h6>
                        <form action="{{asset('admin/edit-studio/'.Request::segment(3))}}" method="post" >
                            @csrf
                            <span id="msg" ></span>
                           

                            <div class="form-group">
                                <label for="std_id">Studio Id</label>
                                <input type="text" class="form-control" name="std_id" value="{{(!empty($studio->std_id))?$studio->std_id:""}}" id="std_id" placeholder="Enter Studio Id">
                               
                                @if ($errors->has('std_id'))
                                <div class="error">
                                    {{ $errors->first('std_id') }}
                                </div>
                                @endif

                            </div>



                            <div class="form-group">
                                <label for="phone">Studio Name</label>
                                <input type="text" class="form-control" name="std_name" value="{{(!empty($studio->std_id))?$studio->std_id:""}}" id="std_name" placeholder="Enter Studio Name">
                               
                                @if ($errors->has('std_name'))
                                <div class="error">
                                    {{ $errors->first('std_name') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Embed</label>
                                <input type="text" class="form-control" name="embed" value="{{(!empty($studio->embed))?$studio->embed:""}}" id="embed" placeholder="Enter Embed">
                               
                                @if ($errors->has('embed'))
                                <div class="error">
                                    {{ $errors->first('embed') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Studio Embed Video</label>
                                <input type="text" class="form-control" name="std_embed_video" value="{{(!empty($studio->std_embed_video))?$studio->std_embed_video:""}}" id="std_embed_video" placeholder="Enter Embed">
                               
                                @if ($errors->has('std_embed_video'))
                                <div class="error">
                                    {{ $errors->first('std_embed_video') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">RTMP Url</label>
                                <input type="text" class="form-control" name="std_rtmp_url" value="{{(!empty($studio->std_rtmp_url))?$studio->std_rtmp_url:""}}" id="std_rtmp_url" placeholder="Enter rtmp url">
                               
                                @if ($errors->has('std_rtmp_url'))
                                <div class="error">
                                    {{ $errors->first('std_rtmp_url') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">RTMP Key</label>
                                <input type="text" class="form-control" name="std_rtmp_key" value="{{(!empty($studio->std_rtmp_key))?$studio->std_rtmp_key:""}}" id="std_rtmp_key" placeholder="Enter rtmp key">
                               
                                @if ($errors->has('std_rtmp_key'))
                                <div class="error">
                                    {{ $errors->first('std_rtmp_key') }}
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


@endpush