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
    <li class="breadcrumb-item active" aria-current="page">Buses List</li>
  </ol><!-- End breadcrumb -->
  <div class="ml-auto">
    <div class="input-group">
      <a href="javascript:void(0);" class="btn btn-primary text-white mr-2 btn-sm" data-toggle="modal"
        data-target="#modalBus" title="Add Bus">
        <span>
          <i class="fa fa-plus"></i>
        </span>
        Add Buses
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
                <th class="border-bottom-0 bg-primary">Operator Name</th>
                <th class="border-bottom-0 bg-primary">Bus No.</th>
                <th class="border-bottom-0 bg-primary">Bus Capacity</th>
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
                @foreach ($operators as $operator)
                @if ($operator->id==$result->operator_name)
                <td>{{$operator->name}}</td>
                @endif
                @endforeach
                <td>{{$result->bus_number}}</td>
                <td>{{$result->capacity}}</td>
                <td>
                  <input type="button"
                    class="btn  @if($result->status==0) btn-danger @else btn-success @endif  updateStatus"
                    data-url="{{route('bus.status', $result->id)}}"
                    value="@if($result->status==0) Inactive @else Active @endif">
                </td>
                <td>
                  <div class="d-flex">
                    <input type="button" class="btn  btn-warning  editRecord" data-title="Bus"
                      data-url="{{route('bus.edit', $result->id)}}" data-action="{{route('bus.update', $result->id)}}"
                      value="Edit">&nbsp;
                    <input type="button" class="btn  btn-danger  deleteRecord"
                      data-url="{{route('bus.destroy', $result->id)}}" value="Delete">
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
  <div class="modal fade" id="modalBus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Buses</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="ajax_form" method="post" action="{{route('bus.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="operator_name" class="col-form-label">Operator Name *:</label>
              <select name="operator_name" class="form-control" id="operator_name">
                <option value="" selected>Select Operator</option>
                @foreach ($operators as $operator)
                <option value="{{$operator->id}}">{{$operator->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="bus_number" class="col-form-label">Bus Number *:</label>
                  <input type="text" name="bus_number" class="form-control" id="bus_number" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="bus_registration_number" class="col-form-label">Bus Registration Number *:</label>
                  <input type="text" name="bus_registration_number" class="form-control" id="bus_registration_number"
                    autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="bus_type" class="col-form-label">Bus Type *:</label>
                  <select name="bus_type" class="form-control">
                    <option value="" selected>Select Bus Type</option>
                    <option value="AC">AC</option>
                    <option value="Non-AC">No AC</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="capacity" class="col-form-label">Bus Capacity *:</label>
                  <input type="text" name="capacity" class="form-control" id="capacity" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="status" class="col-form-label">Bus Status *:</label>
              <select name="status" class="form-control">
                <option value="" selected>Select Bus Status</option>
                <option value="1">Active</option>
                <option value="0">Disable</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <input value="Close" type="button" class="btn btn-secondary" data-dismiss="modal">
            <input value="Submit" type="submit" id="form-button" class="btn btn-primary">
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

@endsection