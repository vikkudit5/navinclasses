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
                <h3>add Video</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>

                        <li class="breadcrumb-item active" aria-current="page">video</li>
                    </ol>
                </nav>
            </div>
            <!-- end::page header -->
            <div class="card">
                <div class="card-body">
                    <a href="{{asset('admin/re-video-list')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; video List</a>

                    <x-flashMessage/>
                    <form id='file-catcher' enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="institute">Select Video</label>
                            <select class="js-example-basic-single re-videos select-item" multiple name="videos[]" >
                                <option></option>
                                @if(!empty($videos))
                                @foreach($videos as $video)
                                <option value="{{$video->etag}}" data-filename="{{$video->filename}}">{{$video->filename}}</option>
                                @endforeach
                                @endif
                               
                            </select>

                            @if ($errors->has('videos'))
                            <div class="error">
                                {{ $errors->first('videos') }}
                            </div>
                            @endif
                        </div>

                       
                    </form>
                </div>
            </div>

            <span id="message-text" class="text-danger"></span>

            <div class="card">
                <div  class="card-body">
                    <form method="post" action="{{asset('admin/re-upload-video')}}">
                        @csrf
                        <div class="text-data"></div>
                        <script>
                            $('input.hm').durationspinner({ format: 'hh:mm:ss', step: 1, page: 60 });
                            </script>
                        
                        <button type='submit' class="btn btn-info">
                            <i class="fa fa-submit"></i>&nbsp;Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->

@endsection
@push('footer-script')
    <!-- begin::dataTable -->
    <link rel="stylesheet" href="{{asset('public/admin/vendors/select2/css/select2.min.css')}}" type="text/css">
      <!-- end::select2 -->
  
<script src="{{asset('public/admin/vendors/select2/js/select2.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>


    <script>
        var limit = 5;
        $(document).ready(function(){

            $('.select-item').change(function() {
    
            var  html;
            $('option:selected', $(this)).each(function() {
                // console.log($(this).val());
                videoId = $(this).val();
                filename = $(this).data('filename');

                html = `<div class="row">

                    <div class="col-md-4">
                        <input type="text" value=`+filename+` class="form-control" required name="originalname[]" placeholder="Original Name">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" required name="customname[]" placeholder="custom Name">
                    </div>
                    <div class="col-md-4"> 
                        <input type="text" class="form-control hm" required name="time[]" placeholder="Enter ss">
                        
                    </div>
                    <input type="hidden" name="video_id[]" value=`+videoId+`>
                   </div>`;

            });
                        $('.text-data').append(html);
            // $('#total').val(price);
        });


        });
    </script>

@endpush
