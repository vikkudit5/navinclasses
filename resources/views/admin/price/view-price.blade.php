@extends('admin.layout')
@section('content')
    


<!-- begin::main content -->

<main class="main-content">

    <div class="container">

        <!-- begin::page header -->
        <div class="page-header">
            <h3>{{(!empty($product->name))?$product->name:""}}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">Price</li>
                </ol>
            </nav>
        </div>
        <!-- end::page header -->

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <a href="{{asset('admin/price-list/'.Request::segment(4))}}" class="btn btn-primary pull-right"><i class="fa fa-list"></i>&nbsp; Price List</a>
                        <x-flashMessage/>
                        <h6 class="card-title">Add Price</h6>
                        <form action="{{asset('admin/edit-price/'.Request::segment(3)."/".Request::segment(4))}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <span id="msg" ></span>
                            <div class="form-group">
                                <label for="institute">Select Mode</label>
                                
                                {{-- <a href="javascript:;" class="btn btn-success btn-sm pull-right add-sub-inp-box">Sub</a> --}}
                                {{-- <a href="javascript:;" class="btn btn-primary btn-sm pull-right add-input-box" style="margin-right: 3px;"><i class="fa fa-plus"></i></a> --}}

                                <select class="js-example-basic-single category" readonly name="mode" id="mode">
                                    <option value="">Select Mode</option>
                                    <option value="online" {{($price->mode == 'online')?"selected":""}}>Online</option>
                                    <option value="google_drive" {{($price->mode == 'google_drive')?"selected":""}}>Google Drive</option>
                                    <option value="pendrive" {{($price->mode == 'pendrive')?"selected":""}}>Pendrive</option>
                                    <option value="offline" {{($price->mode == 'offline')?"selected":""}}>Offline</option>
                                  
                                    
                                   
                                </select>

                                

                                @if ($errors->has('mode'))
                                <div class="error">
                                    {{ $errors->first('mode') }}
                                </div>
                                @endif
                            </div>
                          

                            <div class="form-group">
                                <label for="name">Duration (in days)</label>
                                <input type="number" class="form-control" readonly value="{{$price->duration}}" min="1" name="duration"  id="duration" placeholder="Enter Duration">
                               
                                @if ($errors->has('duration'))
                                <div class="error">
                                    {{ $errors->first('duration') }}
                                </div>
                                @endif

                            </div>

                            



                            <div class="form-group">
                                <label for="phone">Price (in rupees)</label>
                                <input type="number" class="form-control" readonly value="{{$price->price}}" min="1" name="price" id="price" placeholder="Enter price">
                               
                                @if ($errors->has('price'))
                                <div class="error">
                                    {{ $errors->first('price') }}
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="phone">Sort Order</label>
                                <input type="number" class="form-control" readonly value="{{$price->sort_order}}" min="1" name="sort_order"  id="sort_order" placeholder="Enter Sort order">
                               
                                @if ($errors->has('sort_order'))
                                <div class="error">
                                    {{ $errors->first('sort_order') }}
                                </div>
                                @endif

                            </div>


                          
                           
                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
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


<!-- end::select2 -->
@endpush