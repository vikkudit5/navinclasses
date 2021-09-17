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
            <h3>Category</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">   				
                    <li class="breadcrumb-item"><a href="{{URL::to('admin/product-list')}}">Dashboard</a></li>      
					<li class="breadcrumb-item"><a href="{{URL::to('admin/category-list/')}}"></a></li>	
					 
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
			<form action="{{URL::to('admin/category-list/'.Request::segment(3).'/'.Request::segment(4))}}" method="get">  
				<div class="row">
					<div class="col-md-6">  
						<div class="form-group col-md-8">						   
						   <input type="text" class="form-control" name="search" placeholder="Search here....." value="{{ request()->input('search') }}">
						   <span class="text-danger">@error('search'){{ $message }} @enderror</span> 						  
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
                <a href="{{asset('admin/add-main-category/'.Request::segment(3).'/'.Request::segment(4))}}" class="form-group btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Category</a>
        
                @if(isset($categories))
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>                       
                        <th>Type</th>
                        <th>Image</th>   
                        <th>Sort Order</th>
						<th>Category</th>
                        {{-- <th>Status</th> --}}
                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($categories))
                        @foreach($categories as $category)   
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>
						{{$category->name}}    
						</td>
                        <td>{{$category->type}}</td>
                        <td><img src="{{asset("public/uploads/category/".$category->image)}}" style="width:50px;height:50px;"></td> 
                        <td>{{$category->sort_order}}</td>
						<td><a href="{{asset('admin/main-category-list/'.$category->id)}}"><i class="fa fa-plus"></i></a></td>    
                        {{-- <td>
							<div class="custom-control custom-switch custom-checkbox-success"> 
								<input type="checkbox" class="custom-control-input {{($category->status == 1)?"text-success":"text-danger"}} status-change" id="switch{{$category->id}}" data-id="{{$category->id}}" value="1" {{($category->status == 1)?"checked":""}}>  
								<label class="custom-control-label {{($category->status == 1)?"text-success":"text-danger"}}" for="switch{{$category->id}}">{{($category->status == 1)?"Active":"Inactive"}}</label>	
							</div>  
                        </td> --}}
                       
                        <td>
                            <?php 
                                 $permission = App\Helpers\PermissionActivity::getPermissionByAdminId(session('loggedIn')['id'],6);                                                          
                                 
                            ?>

                            @if($permission == 'read')
                            <a  href="{{asset('admin/view-category/'.$category->id)}}"><i class="fa fa-eye text-primary"></i></a>
                           
                            @endif

                            @if($permission == 'write')
                            <a  href="{{asset('admin/view-category/'.$category->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-category/'.$category->id)}}"><i class="fa fa-edit text-success"></i></a>
                            
                            @endif

                            @if($permission == 'delete')
                            <a  href="{{asset('admin/view-main-category/'.$category->id)}}"><i class="fa fa-eye text-primary"></i></a>
                            <a  href="{{asset('admin/edit-main-category/'.$category->id)}}"><i class="fa fa-edit text-success"></i></a>
                            <a  href="{{asset('admin/delete-main-category/'.$category->id)}}" class="delete-confirm"   ><i class="fa fa-trash text-danger"></i></a>
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
                        {{ $categories->appends(['search' => request()->input('search')])->links('admin.includes.paginationlinks') }}
                    @else
						{{ $categories->links('admin.includes.paginationlinks') }}      		
                    @endif
                    
                    <label>Total Record Found- <?php echo count($categories) ?></label>    
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