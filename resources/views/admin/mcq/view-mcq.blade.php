@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>View Mcq</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">View Mcq</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/mcq-list')}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Mcq List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Mcq</h6>
                        <form action="{{asset('admin/edit-mcq/'.Request::segment(3))}}" method="post">
                            @csrf

                            
                            <div class="form-group">
                                <label for="username">Name</label>
                              
                                <input type="text" name="name" id="name" readonly value="{{$mcq->name}}" class="form-control" value="">
                               
                                @if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif

                            </div>


                            <div class="form-group">
                                <label for="username">Instruction</label>
                              
                                <textarea name="instruction" id="instruction"  readonly class="form-control" cols="30" rows="10" placeholder="instruction">{{$mcq->instruction}}</textarea>
                               
                                @if ($errors->has('instruction'))
                                <div class="error">
                                    {{ $errors->first('instruction') }}
                                </div>
                                @endif

                            </div>

                         


                            <div class="form-group">
                                <label for="username">Time Limit</label>
                              
                                <input type="text" name="time_limit" id="" readonly class="form-control" value="{{$mcq->time_limit}}">
                               
                                @if ($errors->has('time_limit'))
                                <div class="error">
                                    {{ $errors->first('time_limit') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Retake Attempt</label>
                              
                                <input type="text" name="retake_attempt" readonly id="" class="form-control" value="{{$mcq->retake_attempt}}">
                               
                                @if ($errors->has('retake_attempt'))
                                <div class="error">
                                    {{ $errors->first('retake_attempt') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Minimum Time Submit</label>
                              
                                <input type="number" name="minimum_time_submit" readonly id="" class="form-control" value="{{$mcq->minimum_time_submit}}">
                               
                                @if ($errors->has('minimum_time_submit'))
                                <div class="error">
                                    {{ $errors->first('minimum_time_submit') }}
                                </div>
                                @endif

                            </div>

                            
                            <div class="form-group">
                                <label for="username">Passing %</label>
                              
                                <input type="number" name="passing_percent" readonly id="passing_percent" class="form-control" value="{{$mcq->passing_percentage}}">
                               
                                @if ($errors->has('passing_percent'))
                                <div class="error">
                                    {{ $errors->first('passing_percent') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Correct Marks</label>
                              
                                <input type="number" name="correct_marks" readonly id="correct_marks" class="form-control" value="{{$mcq->correct_marks}}">
                               
                                @if ($errors->has('correct_marks'))
                                <div class="error">
                                    {{ $errors->first('correct_marks') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="username">Negative Marks</label>
                              
                                <input type="number" name="negative_marks" readonly id="negative_marks" class="form-control" value="{{$mcq->negative_marks}}">
                               
                                @if ($errors->has('negative_marks'))
                                <div class="error">
                                    {{ $errors->first('negative_marks') }}
                                </div>
                                @endif

                            </div>



                          
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

<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>

<script type="text/javascript"> 
    
    CKEDITOR.replace('instruction');  
    
        
    </script>

<!-- end::select2 -->
@endpush