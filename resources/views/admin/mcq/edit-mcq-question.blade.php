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
                        <a href="{{asset('admin/mcq-question-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Product List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Edit Question</h6>
                        <form action="{{asset('admin/edit-mcq-question/'.Request::segment(3))}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="username">Question</label>
                              
                                <textarea name="question" id="question" class="form-control" cols="30" rows="10">{!! $mcq_questions->question !!}</textarea>
                               
                                @if ($errors->has('question'))
                                <div class="error">
                                    {{ $errors->first('question') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Solution</label>
                              
                                <textarea name="solution" id="solution" class="form-control" cols="30" rows="10">{!! $mcq_questions->solution !!}</textarea>
                               
                                @if ($errors->has('solution'))
                                <div class="error">
                                    {{ $errors->first('solution') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Conceptual type</label>
                              
                                <input type="text" name="conceptual_type" id="" class="form-control" value="{{ $mcq_questions->conceptual_type }}">
                               
                                @if ($errors->has('conceptual_type'))
                                <div class="error">
                                    {{ $errors->first('conceptual_type') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Level</label>
                              
                                <input type="text" name="level" id="" class="form-control" value="{{ $mcq_questions->level }}">
                               
                                @if ($errors->has('level'))
                                <div class="error">
                                    {{ $errors->first('level') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Code</label>
                              
                                <input type="text" name="code" id="" class="form-control" value="{{ $mcq_questions->code }}">
                               
                                @if ($errors->has('code'))
                                <div class="error">
                                    {{ $errors->first('code') }}
                                </div>
                                @endif

                            </div>



                            <div class="form-group">
                                <label for="institute">Correct Option</label>
                                <select class="js-example-basic-single" name="correct_option">
                                    <option>Select Option</option>
                                    @if(!empty($mcq_options))
                                        @foreach($mcq_options as $mcq_option)

                                        <option value="{{$mcq_option->id}}" {{($mcq_option->id==$mcq_questions->correct_option_id)?"selected":""}}>{{$mcq_option->options}}</option>
                                        @endforeach

                                    @endif
                                   
                                    
                                   
                                </select>

                                @if ($errors->has('correct_option'))
                                <div class="error">
                                    {{ $errors->first('correct_option') }}
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
    
    CKEDITOR.replace('solution');  
    
    CKEDITOR.replace('question');
        
    </script>

<!-- end::select2 -->
@endpush