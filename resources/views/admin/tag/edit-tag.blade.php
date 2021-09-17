@extends('admin.layout')
@section('content')
    

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-duration-format/2.2.2/moment-duration-format.min.js"></script>
  <script src="{{asset('public/admin/daterange/jquery-ui-durationspinner.js')}}"></script>

<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>{{$video->filename}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Tag</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/tag-list/'.Request::segment(3))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Tag List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Tag</h6>
                        <form action="{{asset('admin/edit-tag/'.Request::segment(3)."/".$tag->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                         

                            <div class="form-group">
                                <label for="name">Tag Name</label>
                                <input type="text" class="form-control" name="name" value="{{$tag->name}}" id="name" placeholder="Enter Tag Name">
                               
                                @if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif

                            </div>

                         



                            <div class="form-group">
                                <label for="phone">Time</label>
                                <input type="text" class="form-control hm" name="time" value="{{{$tag->time}}}" id="time" placeholder="Enter hh:mm:ss">
                               
                                @if ($errors->has('time'))
                                <div class="error">
                                    {{ $errors->first('time') }}
                                </div>
                                @endif

                                <script>
                                    $('input.hm').durationspinner({ format: 'hh:mm:ss', step: 1, page: 60 });
                                    </script>


                            </div>

                            <div class="form-group">
                                <label for="phone">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="{{{$tag->sort_order}}}" id="time" placeholder="Enter Sortorder">
                               
                                @if ($errors->has('sort_order'))
                                <div class="error">
                                    {{ $errors->first('sort_order') }}
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

<!-- end::select2 -->
@endpush