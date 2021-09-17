@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Mcq-list</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Mcq-list</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <x-flashMessage/>

     

        
        <div class="row">
            <div class="col-md-6">
                <form action="" method="GET">
        
                    <div class="form-group col-md-8">
                       
                       <input type="text" class="form-control" name="query" placeholder="Search here....." value="{{ request()->input('query') }}">
                       <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                      
                    </div>
                    
                    
                
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp; Search</button>
                <a href="{{asset('admin/mcq-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

   


        <div class="card">
           
            <div class="card-body">

              
                <a href="{{asset('admin/add-mcq')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Mcq</a>
               
               

                @if(isset($mcq_questions))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>                       
                        <th>Time</th>
                        <th>Retake Attempt</th>
                        <th>Minimum Time Submit</th>                    
                        <th>Options</th>                    
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                        @if(!empty($mcq_questions))
                        @foreach($mcq_questions as $mcq_question)
                    <tr>
                       <td>{{$mcq_question->id}}</td>
                       <td>{!! $mcq_question->name !!}</td>
                       <td>{!! $mcq_question->time_limit !!}</td>
                       <td>{{$mcq_question->retake_attempt}}</td>
                       <td>{{$mcq_question->minimum_time_submit}}</td>
                       <td><a href="{{asset('admin/map-mcq-question-list/'.$mcq_question->id)}}"><i class="fa fa-plus text-primary"></i></a></td>
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],7);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-mcq/'.$mcq_question->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-mcq/'.$mcq_question->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-mcq/'.$mcq_question->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('admin/view-mcq/'.$mcq_question->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-mcq/'.$mcq_question->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a  href="{{asset('admin/delete-mcq/'.$mcq_question->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
                            @endif

                            
                        </td>
                       
                    </tr>
                    @endforeach
                    @else
                        <h1>No Record Found!!</h1>
                    @endif
                    
                    </tbody>
                  
                </table>
                <div class="pagination-block">

                    @if(isset($_GET['query']))

                         {{ $mcq_questions->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $mcq_questions->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($mcq_questions) ?></label>
                </div>
 
              @endif

            </div>
        </div>

       

    </div>

</main>
<!-- end::main content -->

@endsection
@push('footer-script')
    <!-- begin::dataTable -->
<script src="{{asset('public/admin/vendors/dataTable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/dataTable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/dataTable/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML"></script>
<script src="{{asset('public/admin/js/examples/datatable.js')}}"></script>
<!-- end::dataTable -->
@endpush