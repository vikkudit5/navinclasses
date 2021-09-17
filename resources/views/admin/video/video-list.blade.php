@extends('admin.layout')

@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Original Video List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('dashboard')}}">Dashboard</a></li>
                  
                    <li class="breadcrumb-item active" aria-current="page">Original Video List</li>
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
                <a href="{{asset('admin/product-list')}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
            </div>

        </form>
    </div>

        <div class="card">
           
            <div class="card-body">

                <a href="javascript:;" id="sync_video" class="btn btn-info" data-type="video" data-foldername="{{ $folder_name }}"><i class="fa fa-refresh"></i> Sync</a>

                <a href="{{asset('admin/upload-video')}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Upload Video</a>
               
               

                @if(isset($products))
                <table  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>                       
                        <th>Type</th>
                        {{-- <th>Imag</th> --}}
                        <th>Path</th>
                        <th>Etag</th>
                        <th>size</th>
                        <th>Date</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($products))
                        @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->filename}}</td>
                        <td>{{$product->type}}</td>
                        {{-- <td><img src="{{asset("public/uploads/products/".$product->image)}}" style="width:50px;height:50px;"></td> --}}
                        <td>{{$product->path}}</td>
                        <td>{{$product->etag}}</td>
                        <td>{{$product->size}}</td>
                        <td>{{$product->date}}</td>
                       
                       
                       
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],11);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-product/'.$product->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('admin/view-product/'.$product->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-product/'.$product->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a  href="{{asset('admin/delete-product/'.$product->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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

                         {{ $products->appends(['query' => $_GET['query']])->links('admin.includes.paginationlinks') }}
                    @else
                     {{ $products->links('admin.includes.paginationlinks') }} 
                     @endif
                    
                    <label>Total Record Found- <?php echo count($products) ?></label>
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