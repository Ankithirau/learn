@extends('layouts.app')

@section('styles')

<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

<!-- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

<!-- page-header -->
<div class="page-header">
  <ol class="breadcrumb">
    <!-- breadcrumb -->
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Product List</li>
  </ol><!-- End breadcrumb -->
</div>
<!-- End page-header -->
<!-- row opened -->
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body pt-4">
        <div class="table-responsive">
          <table id="fileexport-datatable" class="mt-2 table table-bordered key-buttons text-nowrap">
            <thead>
              <tr>
                <th class="border-bottom-0 bg-primary">S.No.</th>
                <th class="border-bottom-0 bg-primary">Name</th>
                <th class="border-bottom-0 bg-primary">Price</th>
                <th class="border-bottom-0 bg-primary">Status</th>
                <th class="border-bottom-0 bg-primary">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($results))
              @php
              $i=1
              @endphp
              @foreach($results as $result)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$result->name}}</td>
                @php

                $variation = App\Models\Product_variation::where(['product_id' => $result->id])->get();

                $min_price = ($variation->min('price')) ? $variation->min('price') : 'N/A';

                $max_price = ($variation->max('price')) ? $variation->max('price') : 'N/A';
                @endphp

                <td>&euro; {{$min_price .'-'.$max_price}}</td>
                <td>
                  <input type="button"
                    class="btn  @if($result->status==0) btn-danger @else btn-success @endif  updateStatus"
                    data-url="{{route('product.status', $result->id)}}"
                    value="@if($result->status==0) Inactive @else Active @endif">
                </td>
                <td>
                  <div class="d-flex">
                    <div class="dropdown">
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1s"
                        data-bs-toggle="dropdown" aria-expanded="false" type="button">
                        Action &nbsp;&nbsp;<i class="fa fa-chevron-down"></i>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1s">
                        <li>
                          <a class="dropdown-item" href="{{route('product.variation',$result->id)}}">Add
                            Variations</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{route('bus.create', $result->id)}}">
                            Assign Bus</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{route('product.show', $result->id)}}">View</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{route('product.edit', $result->id)}}">Edit</a>
                        </li>
                        <li>
                          <a class="dropdown-item deleteRecord" href="javascript:void(0)"
                            data-url="{{route('product.destroy', $result->id)}}">Delete</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalState" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Variations</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="ajax_form" method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body table-responsive">
            <table class="table table-bordered table-striped table-highlight">
              <thead>
                <tr>
                  <th>Date of Concert</th>
                  <th>County</th>
                  <th>Pickup Point</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="date" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="button" name="name" class="btn btn-primary" value="update">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="button" name="name" class="btn btn-primary" value="update">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="button" name="name" class="btn btn-primary" value="update">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" id="name" autocomplete="off">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="button" name="name" class="btn btn-primary" value="update">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <input value="Close" type="button" class="btn btn-secondary" data-dismiss="modal">
            <input value="Update All" type="submit" id="form-button" class="btn btn-primary">
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<!-- row closed -->

@endsection('content')

@section('scripts')

<!--Jquery Sparkline js-->
<script src="{{URL::asset('assets/plugins/vendors/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle js-->
<script src="{{URL::asset('assets/plugins/vendors/circle-progress.min.js')}}"></script>

<!--Time Counter js-->
<script src="{{URL::asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
<script src="{{URL::asset('assets/plugins/counters/counter.js')}}"></script>

<!-- INTERNAL Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/datatable-2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

@endsection