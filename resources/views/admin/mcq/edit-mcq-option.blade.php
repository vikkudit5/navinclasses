@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Edit Question</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Mcq Question</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/mcq-option-list/'.$Mcq_option->question_id)}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Mcq Option List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Edit Question</h6>
                        <form action="{{asset('admin/edit-mcq-option/'.Request::segment(3))}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="username">Option</label>
                              
                                <textarea name="option" id="option" class="form-control" cols="30" rows="10">{!! $Mcq_option->options !!}</textarea>
                               
                                @if ($errors->has('option'))
                                <div class="error">
                                    {{ $errors->first('option') }}
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
      <script src="{{asset('public/ckeditor/ckeditor.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/admin/vendors/select2/css/select2.min.css')}}" type="text/css">     <!-- end::select2 -->
  
<script src="{{asset('public/admin/vendors/select2/js/select2.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>

<script type="text/javascript"> 
    
    CKEDITOR.replace('option');  
    
 
        
    </script>

<!-- end::select2 -->
@endpush