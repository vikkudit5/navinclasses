@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Add Schedule</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Schedule list</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/live-schedule-list/'.Request::segment(3))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Live Schedule  List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Schedule</h6>
                        <form action="{{asset('admin/add-schedule/'.Request::segment(3))}}" method="post">
                            @csrf
                            <span id="msg" ></span>
                            <div class="form-group">
                                <label for="institute">Select Studio</label>
                                
                                {{-- <a href="javascript:;" class="btn btn-success btn-sm pull-right add-sub-inp-box">Sub</a> --}}
                                {{-- <a href="javascript:;" class="btn btn-primary btn-sm pull-right add-input-box" style="margin-right: 3px;"><i class="fa fa-plus"></i></a> --}}

                                <select class="js-example-basic-single" name="std_id" id="std_id">
                                    <option value="">Select Studio</option>
                                    @if(!empty($studios))
                                    @foreach($studios as $studio)
                                    <option value="{{$studio->std_id}}">{!! $studio->std_name !!}</option>
                                    @endforeach
                                   @endif
                                    
                                   
                                </select>

                                

                                @if ($errors->has('std_id'))
                                <div class="error">
                                    {{ $errors->first('std_id') }}
                                </div>
                                @endif
                            </div>
                            

                            <div class="form-group">
                                <label for="program_name">Program Name</label>
                                <input type="text" class="form-control" name="program_name" value="{{old('program_name')}}" id="program_name" placeholder="Enter Program Name">
                               
                                @if ($errors->has('program_name'))
                                <div class="error">
                                    {{ $errors->first('program_name') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="institute">Date Range</label>
                                <select class="js-example-basic-single" id="seldate" name="seldate">
                                    <option>Select Date range</option>
                                    <option value="0">One Time</option>
                                    <option value="1">Recursive</option>
                                    
                                    
                                   
                                </select>

                                @if ($errors->has('seldate'))
                                <div class="error">
                                    {{ $errors->first('seldate') }}
                                </div>
                                @endif
                            </div>

                            <div  id="daterange" style="display: none;">

                                
                                   <div class="form-group" >
                                      <label for="email"> Start Date<span class="error">*</span>:</label>
                                        <input type="date" placeholder="from Date" name="star_date" type="text" id="input_starttime" class="form-control ">
                                      </div>
    
                        
                                
                                  <div class="form-group" >
                                      <label for="email"> End Date<span class="error">*</span>:</label>
                                    <input type="date" placeholder="To Date" name="end_date" type="text" id="input_starttime" class="form-control ">
                                  </div>
    
                                
                            </div>
    
    
    
                              <div class="form-group" id="singledate" style="display: none;">
                                  
                                      <label class="col-form-label">Date</label>
                                      <input type="date" name="datesingle" placeholder="Filter By Date Range" id="datesingle" value="" class="form-control" />
                                      {{-- <span style="color: #FF0000"><?php echo form_error('datesingle'); ?></span> --}}
                                  
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form">
                                        <input type="time" placeholder="00:00:00" name="starttime" type="text" id="input_starttime" class="form-control wtimepicker">
                                        @if ($errors->has('starttime'))
                                        <div class="error">
                                            {{ $errors->first('starttime') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="time" placeholder="00:00:00" name="endtime" type="text" id="input_starttime" class="form-control wtimepicker">
                                    @if ($errors->has('endtime'))
                                    <div class="error">
                                        {{ $errors->first('endtime') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <br>
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
<link rel="stylesheet" href="{{asset('public/admin/vendors/select2/css/select2.min.css')}}" type="text/css">     <!-- end::select2 -->
  
<script src="{{asset('public/admin/vendors/select2/js/select2.min.js')}}"></script>
<script src="{{asset('public/admin/js/examples/select2.js')}}"></script>

<script>
   $(document).on('change', '#seldate', function () {
            
            var seldatevalue = $(this).val();
            if (seldatevalue == 0) {
                $('#singledate').css('display', 'block');
                $('#daterange').css('display', 'none');
            } else {
                $('#singledate').css('display', 'none');
                $('#daterange').css('display', 'block');

            }
        });
</script>
<!-- end::select2 -->
@endpush