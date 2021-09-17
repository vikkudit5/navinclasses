@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Map Mcq</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Add Mcq</li>
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
                        <form action="{{asset('admin/map-mcq-question/'.Request::segment(3))}}" method="post">
                            @csrf

                            
                            <div class="form-group">
                                <label for="institute">Select Question <span class="error">*</span></label>
                                <select class="js-example-basic-single" required name="mcq_ques_id[]" multiple>
                                    <option disabled>Select Question</option>
                                    @if(!empty($questions))
                                    @foreach($questions as $question)
                                    <option value="{{$question->id}}">{{$question->code}}</option>
                                    @endforeach
                                    @endif
                                   
                                    
                                   
                                </select>
                
                                @if ($errors->has('mcq_ques_id'))
                                <div class="error">
                                    {{ $errors->first('mcq_ques_id') }}
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
<link rel="stylesheet" href="{{asset('public/admin/vendors/select2/css/select2.min.css')}}" type="text/css">     <!-- end::select2 -->
  
<script src="{{asset('public/admin/vendors/select2/js/select2.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>

<!-- end::select2 -->
@endpush