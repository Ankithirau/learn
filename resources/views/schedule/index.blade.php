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
    <li class="breadcrumb-item active" aria-current="page">Category List</li>
  </ol><!-- End breadcrumb -->
  <div class="ml-auto">
    <div class="input-group">
      <a href="{{route('bus.create')}}" class="btn btn-primary text-white mr-2 btn-sm">
        <span>
          <i class="fa fa-plus"></i>
        </span>
        Route Schedule
      </a>

    </div>
  </div>
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
                <th class="border-bottom-0 bg-primary">Status</th>
                <th class="border-bottom-0 bg-primary"> Actions</th>
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
                <td>
                  <input type="button"
                    class="btn  @if($result->status==0) btn-danger @else btn-success @endif  updateStatus"
                    data-url="{{route('category.status', $result->id)}}"
                    value="@if($result->status==0) Inactive @else Active @endif">
                </td>
                <td>
                  <div class="d-flex">
                    <input type="button" class="btn  btn-warning  editRecord" data-title="Edit Schedule"
                      data-url="{{route('category.edit', $result->id)}}"
                      data-action="{{route('category.update', $result->id)}}" value="Edit">&nbsp;
                    <input type="button" class="btn  btn-danger  deleteRecord"
                      data-url="{{route('category.destroy', $result->id)}}" value="Delete">
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
  {{-- <div class="modal fade" id="modalSchedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Route Schedule</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="ajax_form" method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="route_name" class="col-form-label">Route Name *:</label>
              <input type="text" name="route_name" class="form-control" id="route_name" autocomplete="off">
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="starting_point" class="col-form-label">Starting Point *:</label>
                  <input type="text" name="starting_point" class="form-control" id="starting_point" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="destination" class="col-form-label">Destination Point *:</label>
                  <input type="text" name="destination" class="form-control" id="destination" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="schedule_date" class="col-form-label">Schedule Date *:</label>
                  <input type="date" name="schedule_date" class="form-control" id="schedule_date" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="departure_time" class="col-form-label">Departure Time *:</label>
                  <input type="time" name="departure_time" class="form-control" id="add_time">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="bus_lat" class="col-form-label">Bus latitude *:</label>
                  <input type="text" name="bus_lat" class="form-control" id="bus_lat" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="bus_lng" class="col-form-label">Bus Longitude *:</label>
                  <input type="text" name="bus_lng" class="form-control" id="bus_lng">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="pickup_point_id" class="col-form-label">Pickup Point *:</label>
                  <select name="pickup_point_id" class="form-control">
                    <option selected>Select Pickup Point</option>
                    @foreach ($points as $point)
                    <option value="{{$point->id}}">{{$point->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="product_id" class="col-form-label">Event *:</label>
                  <select name="product_id" class="form-control">
                    <option selected>Select Event</option>
                    @foreach ($events as $event)
                    <option value="{{$event->id}}">{{$event->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="bus_id" class="col-form-label">Bus *:</label>
                  <select name="bus_id" class="form-control">
                    <option selected>Select Bus</option>
                    @foreach ($bus as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="status" class="col-form-label">Status *:</label>
                  <select name="status" class="form-control">
                    <option value="" selected>Select Status</option>
                    <option value="1" {{(old('status')=='1' )?"selected":""}}>Active</option>
                    <option value="0" {{(old('status')=='0' )?"selected":""}}>Disabled</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input value="Close" type="button" class="btn btn-secondary" data-dismiss="modal">
            <input value="Submit" type="submit" id="form-button" class="btn btn-primary">
          </div>
        </form>

      </div>
    </div>
  </div> --}}
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

@endsection