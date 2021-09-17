@extends('admin.layout')

@section('content')
    
@php
	$i=0  
@endphp 

<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>Demo Content List</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">   				
                    <li class="breadcrumb-item"><a href="{{URL::to('admin/product-list')}}">Dashboard</a></li>      
					{{-- <li class="breadcrumb-item"><a href="{{URL::to('admin/category-list/')}}">Content List</a></li>	 --}}
					 
					@if(isset($nav_links))	
						@foreach($nav_links as $key=>$value)   
							@if ($i==count($nav_links)-1)
								<li class="breadcrumb-item active" aria-current="page">{{$value}}</li> 		  			
							@else
								<li class="breadcrumb-item" aria-current="page"><a href="{{URL::to('admin/main-category-list/'.$key)}}">{{$value}}</a></li> 
							@endif
							@php
								++$i  
							@endphp 							 
						@endforeach   	
					@endif 
					
                </ol> 
            </nav>
        </div>
        <!-- end::page header -->
		<div class="container">
			<form action="" method="GET">
				<div class="row">
                    <div class="col-md-6">
                        
                
                            <div class="form-group col-md-8">
                               
                               <input type="text" class="form-control" name="query" placeholder="Search here....." value="{{ request()->input('query') }}">
                               <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                              
                            </div>
                            
                            
                        
                    </div>
					<div class="col-md-4">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp; Search</button>
						<a href="{{asset('admin/main-category-list/'.Request::segment(3))}}"  class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp; Reset</a>
					</div>     
				</div>
			</form>
		</div>  

        <div class="card">
           
            <div class="card-body">
			<x-flashMessage/>
                <a href="{{asset('admin/add-demo-content/'.Request::segment(3).'/'.Request::segment(4))}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Content</a>
        
                @if(isset($contents))
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>                       
                          
                        <th>Sort Order</th>
					
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($contents))
                        @foreach($contents as $content)   
                    <tr>
                        <td>{{$content->id}}</td>
                        <td>
						{{$content->filename}}    
						</td>
                        
                        
                        <td>{{$content->sort_order}}</td>
						  
                    
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],6);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            {{-- <a  href="{{asset('admin/view-category/'.$content->content_id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                           
                            @endif

                            @if($permission == 'write')
                            {{-- <a  href="{{asset('admin/view-category/'.$content->content_id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                            {{-- <a  href="{{asset('admin/edit-category/'.$content->content_id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            
                            @endif

                            @if($permission == 'delete')
                            {{-- <a  href="{{asset('admin/view-category/'.$content->content_id)}}"><i class="fa fa-eye text-primary"></i></a> --}}
                            {{-- <a  href="{{asset('admin/edit-category/'.$content->content_id)}}"><i class="fa fa-edit text-success"></i></a> --}}
                            <a  href="{{asset('admin/delete-content/'.$content->content_id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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

                    @if(request()->input('search'))
                        {{ $contents->appends(['search' => request()->input('search')])->links('admin.includes.paginationlinks') }}
                    @else
						{{ $contents->links('admin.includes.paginationlinks') }}      		
                    @endif
                    
                    <label>Total Record Found- <?php echo count($contents) ?></label>    
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
<script src="{{asset('public/admin/js/examples/datatable.js')}}"></script>
<!-- end::dataTable -->
@endpush