@extends('layouts.app')

@section('styles')

<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<script src="https://cdn.tiny.cloud/1/9rzt1ee962ipuoijl24sevk0vp5yt5tflc9hooynbmq49wfw/tinymce/5/tinymce.min.js"
  referrerpolicy="origin"></script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

<!-- page-header -->
<div class="page-header">
  <ol class="breadcrumb">
    <!-- breadcrumb -->
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('product.index')}}">Product List</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Product</li>
  </ol><!-- End breadcrumb -->
</div>
<!-- End page-header -->
<!-- row opened -->
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body pt-4">
        <div class="row">
          <div class="col-md-12 col-lg-12">
            <div class="form-group">
              <label for="name" class="col-form-label">Product Name :<span class="text-danger">*</span>:</label>
              <input type="text" class="form-control" id="name" autocomplete="off" value="{{$result->name}}" readonly />
            </div>
            <div class="form-group">
              <label for="price" class="col-form-label">Product Price :<span class="text-danger">*</span>:</label>
              <input type="text" class="form-control" id="price" autocomplete="off" value="{{$result->price}}"
                readonly />
            </div>
            <div class="form-group">
              <label for="shortdesc" class="col-form-label">Short Description :<span
                  class="text-danger">*</span></label>
              <textarea class="form-control" id="shortdesc" autocomplete="off" cols="30" rows="5"
                readonly>{{$result->shortdesc}}</textarea>
            </div>
            <div class="form-group">
              <label for="pick_point_id" class="col-form-label">Pick up Points & Departure Times:
                <span class="text-danger">*</span>
              </label>
              <select class="form-control selectpicker" aria-label="size 3 select example" id="pick_point_id" disabled>
                @if(!empty($points))
                @foreach($points as $point)
                <option value="{{$point->id}}" selected>{{$point->name}}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="image" class="col-form-label">Product Image :<span class="text-danger">*</span></label>
              <br>
              <img src="{{asset('uploads/event_image/').'/'.$result->image}}"
                class="img-thumbnail rounded mx-auto float-start" alt="" srcset="" height="100" width="100">
            </div>
            <div class="form-group">
              <label for="date_concert" class="col-form-label">Date of Concert:<span
                  class="text-danger">*</span></label>
              <input type="text" class="form-control" id="date_concert" value="{{$result->date_concert}}">
            </div>
            <div class="form-group">
              <label for="counties_id" class="col-form-label">County you wish to travel from: <span
                  class="text-danger">*</span>:</label>
              <select class="form-control selectpicker" aria-label="size 3 select example" multiple disabled>
                @if(!empty($county))
                @foreach($county as $county)
                <option value="{{$county->id}}" selected>{{$county->name}}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="status" class="col-form-label">Status :<span class="text-danger">*</span></label>
              <select name="status" class="form-control" disabled>
                @if ($result->status==1)
                <option selected>Active</option>
                @else
                <option selected>Disabled</option>
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="sku" class="col-form-label">Sku :<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="sku" autocomplete="off" value="{{$result->sku}}">
            </div>
            <div class="form-group">
              <label for="event_id" class="col-form-label">Event :<span class="text-danger">*</span></label>
              <select name="event_id" class="form-control" disabled>
                @if(!empty($events))
                @foreach($events as $event)
                <option value="{{$event->id}}" selected>{{$event->name}}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="check_in_per_ticket" class="col-form-label">Check-ins per ticket :<span
                  class="text-danger">*</span></label>
              <input type="number" name="check_in_per_ticket" class="form-control" id="check_in_per_ticket"
                autocomplete="off" value="{{$result->check_ins_per_ticket}}" readonly>
            </div>
            <div class="form-group">
              <label for="category_id" class="col-form-label">Category :<span class="text-danger">*</span></label>
              <select name="category_id" class="form-control" disabled>
                @if(!empty($category))
                @foreach($category as $category)
                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="Allow_ticket_check_out" checked
                  name="Allow_ticket_check_out" value="{{$result->allow_ticket_check_out}}">
                <label class="form-check-label" for="flexCheckChecked">
                  Allow ticket check-out :<span class="text-danger">*</span>
                </label>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-12">
            <div class="form-group">
              
              <label for="description" class="col-form-label">Description :<span class="text-danger">*</span></label>
              <textarea class="form-control" id="description" autocomplete="off" cols="30" rows="40" disabled
                readonly>{{$result->description}}</textarea>
            </div>
          </div>
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection