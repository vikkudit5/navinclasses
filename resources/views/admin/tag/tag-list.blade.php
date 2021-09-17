@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>{{$video->filename}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('dashboard')}}">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Tag List</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->
        
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
                <a href="{{asset('admin/tag-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

        <div class="card">
           
            <div class="card-body">


                <a href="{{asset('admin/add-tag/'.Request::segment(3))}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Tags</a>
               
               

                @if(isset($tags))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Video id</th>                       
                        <th>Name</th>
                        
                        <th>Time</th>
                        <th>Sort Order</th>
                     
                      
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($tags))
                        @foreach($tags as $tag)
                    <tr>
                        <td>{{$tag->id}}</td>
                        <td>{{$tag->video_id}}</td>
                        <td>{{$tag->name}}</td>
                        {{-- <td><img src="{{asset("public/uploads/products/".$product->image)}}" style="width:50px;height:50px;"></td> --}}
                        <td>{{$tag->time}}</td>
                        <td>{{$tag->sort_order}}</td>
                      
                        
                       
                       
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],11);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            {{-- <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                           
                            @endif

                            @if($permission == 'write')
                            {{-- <a  href="{{asset('admin/edit-re-video/'.$product->etag)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            
                            @endif

                            @if($permission == 'delete')
                            {{-- <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                            <a  href="{{asset('admin/edit-tag/'.Request::segment(3)."/".$tag->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a  href="{{asset('admin/delete-tag/'.Request::segment(3)."/".$tag->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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

                         {{ $tags->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $tags->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($tags) ?></label>
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

<script src="{{asset('public/admin/js/examples/datatable.js')}}"></script>

<script>
    $('#sync_video').click(function() {

        $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                });

			var foldername = $(this).data("foldername");

            // alert(foldername);
			// var type = $(this).data("type");


			$.ajax({
				type: "get",
				data: {
					'foldername': foldername,
					// 'type': type
				},
				url:  "{{asset('admin/listobjects')}}",
				beforeSend: function() {
					$('#sync_video').html('<i class="fa fa-refresh"></i> Please Wait....');
				},
				success: function(result) {

                    // console.log(result);
                    // return false;
					$('#sync_video').html('<i class="fa fa-refresh"></i> Sync Video');
					location.reload();
				}
			});
		});
</script>
<!-- end::dataTable -->
@endpush