@extends('layouts.app')

@section('styles')

<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

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
    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
  </ol><!-- End breadcrumb -->
</div>
<!-- End page-header -->
<!-- row opened -->
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body pt-4">
        <form name="ajax_form" method="post" action="{{route('product.update',$result->id)}}"
          enctype="multipart/form-data" novalidate>
          @csrf
          @method('put')
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="form-group">
                <label for="name" class="col-form-label">Product Name :<span class="text-danger">*</span>:</label>
                <input type="text" name="name" class="form-control" id="name" autocomplete="off"
                  value="{{$result->name}}" />
              </div>
              <div class="form-group">
                <label for="price" class="col-form-label">Product Price :<span class="text-danger">*</span>:</label>
                <input type="text" name="price" class="form-control" id="price" autocomplete="off"
                  value="{{$result->price}}">
              </div>
              <div class="form-group">
                <label for="shortdesc" class="col-form-label">Short Description :<span
                    class="text-danger">*</span></label>
                <textarea class="form-control" name="shortdesc" id="shortdesc" autocomplete="off" cols="30"
                  rows="5">{{$result->shortdesc}}</textarea>
              </div>
              <div class="form-group">
                <label for="pick_point_id" class="col-form-label">Pick up Points & Departure Times:
                  <span class="text-danger">*</span>
                </label>
                {{-- {{print_r($other_point)}} --}}
                {{--
                <pre> --}}


                  {{-- @if(!empty($other_point))
                  @foreach($other_point as $key=> $pickpoints)
                  {{print_r($pickpoints->name)}}
                  @endforeach
                  @endif --}}
                {{-- </pre> --}}
                <select name="pick_point_id[]" class="form-control selectpicker" aria-label="size 3 select example"
                  multiple id="pick_point_id">
                  @if(!empty($pickup_points))
                  @php
                  $selected_points=explode(',',$result->pickup_point_id);
                  @endphp
                  @foreach($pickup_points as $key=> $points)
                  <option value="{{$points->id}}" @if (in_array($points->id,$selected_points)) selected

                    @endif>{{$points->name}}</option>
                  @endforeach
                  @endif


                  {{-- @if(!empty($other_point))
                  @foreach($other_point as $key => $pickpoints)
                  <option value="{{$pickpoints[0]->id}}">{{$pickpoints[0]->name}}</option>
                  @endforeach
                  @endif --}}
                </select>
              </div>
              {{-- {{die()}} --}}
              <div class="form-group">
                <label for="image" class="col-form-label">Product Image :<span class="text-danger">*</span></label>
                <input type="file" name="image" id="image" class="form-control">
              </div>
              <div class="form-group">
                <img src="{{asset('uploads/event_image/').'/'.$result->image}}"
                  class="img-thumbnail rounded mx-auto float-start" alt="" srcset="" height="100" width="100">
              </div>
              <div class="form-group">
                <label for="date_concert" class="col-form-label">Date of Concert:<span
                    class="text-danger">*</span></label>
                <input type="text" name="date_concert" class="form-control" id="date_concert"
                  value="{{$result->date_concert}}">
              </div>
              <div class="form-group">
                <label for="counties_id" class="col-form-label">County you wish to travel from: <span
                    class="text-danger">*</span>:</label>
                <select name="counties_id[]" class="form-control selectpicker" aria-label="size 3 select example"
                  multiple id="counties_id">
                  @if(!empty($counties))
                  @php
                  $selected_counties=explode(',',$result->counties_id);
                  @endphp
                  @foreach($counties as $key=> $county)
                  <option value="{{$county->id}}" @if (in_array($county->id,$selected_counties)) selected

                    @endif>{{$county->name}}</option>
                  @endforeach
                  @endif
                  {{-- @if(!empty($county))
                  @foreach($county as $key=> $county)
                  <option value="{{$county[0]->id}}" selected>{{$county[0]->name}}</option>
                  @endforeach
                  @endif
                  @if(!empty($counties))
                  @foreach($counties as $key => $counties)
                  <option value="{{$counties[0]->id}}">{{$counties[0]->name}}</option>
                  @endforeach
                  @endif --}}
                </select>
              </div>
              <div class="form-group">
                <label for="status" class="col-form-label">Status :<span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                  @if ($result->status==1)
                  <option value="1" selected>Active</option>
                  <option value="0">Disabled</option>
                  @else
                  <option value="1">Active</option>
                  <option value="0" selected>Disabled</option>
                  @endif
                </select>
              </div>
              <div class="form-group">
                <label for="sku" class="col-form-label">Sku :<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="sku" autocomplete="off" value="{{$result->sku}}" name="sku">
              </div>
              <div class="form-group">
                <label for="event_id" class="col-form-label">Event :<span class="text-danger">*</span></label>
                <select name="event_id" class="form-control">
                  @if(!empty($events))
                  @foreach($events as $event)
                  @if ($event->id==$result->event_id)
                  <option value="{{$event->id}}" selected>{{$event->name}}</option>
                  @else
                  <option value="{{$event->id}}">{{$event->name}}</option>
                  @endif
                  @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group">
                <label for="check_in_per_ticket" class="col-form-label">Check-ins per ticket :<span
                    class="text-danger">*</span></label>
                <input type="number" name="check_ins_per_ticket" class="form-control" id="check_in_per_ticket"
                  autocomplete="off" value="{{$result->check_ins_per_ticket}}">
              </div>
              <div class="form-group">
                <label for="category_id" class="col-form-label">Category :<span class="text-danger">*</span></label>
                <select name="category_id" class="form-control selectpicker" aria-label="size 3 select example"
                  multiple>
                  {{-- @if(!empty($category))
                  @foreach($category as $key=> $category)
                  <option value="{{$category[0]->id}}" selected>{{$category[0]->name}}</option>
                  @endforeach
                  @endif
                  @if(!empty($categories))
                  @foreach($categories as $key => $categories)
                  <option value="{{$categories[0]->id}}">{{$categories[0]->name}}</option>
                  @endforeach
                  @endif --}}
                  @if(!empty($categories))
                  @php
                  $selected_categories=explode(',',$result->category_id);
                  @endphp
                  @foreach($categories as $key=> $category)
                  <option value="{{$category->id}}" @if (in_array($category->id,$selected_categories)) selected

                    @endif>{{$category->name}}</option>
                  @endforeach
                  @endif
                </select>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="Allow_ticket_check_out"
                    name="allow_ticket_check_out" value="{{$result->allow_ticket_check_out}}"
                    {{($result->allow_ticket_check_out==1)?"checked":""}}>
                  <label class="form-check-label" for="flexCheckChecked">
                    Allow ticket check-out :<span class="text-danger">*</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12">
              <div class="form-group">
                <label for="description" class="col-form-label">Description :<span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" autocomplete="off" cols="30" rows="40"
                  name="description">{{$result->description}}</textarea>
              </div>
            </div>
          </div>
          <input value="Send Request" type="submit" id="form-button" class="btn btn-primary">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection