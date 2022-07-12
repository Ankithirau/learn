@extends('layouts.app')

@section('styles')

<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/multipleselect/multiselect.css')}}" rel="stylesheet" />
<script src="{{URL::asset('assets/plugins/multipleselect/multiselect.min.js')}}"></script>
<link href="{{URL::asset('assets/plugins/multidate/styles.css')}}" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{URL::asset('assets/plugins/multidate/multidatespicker.js')}}"></script>
@endsection

@section('content')
<!-- page-header -->
<div class="page-header">
  <ol class="breadcrumb">
    <!-- breadcrumb -->
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Route List</li>
  </ol><!-- End breadcrumb -->
  <div class="ml-auto">
    <div class="input-group">
      <a href="javascript:void(0);" class="btn btn-primary text-white mr-2 btn-sm" data-toggle="modal"
        data-target="#modalRoute" title="Add County">
        <span>
          <i class="fa fa-plus"></i>
        </span>
        Add Route
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
                <td>{{$result->route_name}}</td>
                <td>
                  <input type="button"
                    class="btn  @if($result->status==0) btn-danger @else btn-success @endif  updateStatus"
                    data-url="{{route('county.status', $result->id)}}"
                    value="@if($result->status==0) Inactive @else Active @endif">
                </td>
                <td>
                  <div class="d-flex">
                    <a href="javascript:void(0)" class="btn btn-primary">
                      View</a>&nbsp;
                    <input type="button" class="btn  btn-warning  editRecord" data-title="County"
                      data-url="{{route('county.edit', $result->id)}}"
                      data-action="{{route('county.update', $result->id)}}" value="Edit">&nbsp;
                    <input type="button" class="btn  btn-danger  deleteRecord"
                      data-url="{{route('county.destroy', $result->id)}}" value="Delete">
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
  <div class="modal fade" id="modalRoute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add County</h5>
          <a href="javascript:void(0)" target="_blank" rel="noopener noreferrer" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <form name="ajax_form" method="post" action="{{route('route.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="route_name" class="col-form-label">Route Name :<span class="text-danger">*</span>:</label>
              <input type="text" name="route_name" class="form-control" id="name" autocomplete="off"
                placeholder="Enter Route Name">
            </div>
            <div class="form-group">
              <label for="pickup_point_id" class="col-form-label">Location Name :<span class="text-danger">*</span>:</label>
              <div class="row">
                <div class="col-12">
                <select name="pickup_point_id[]" class="form-control name_s" id="testSelect1" multiple placeholder="Select Pickup Point">
                  @if(!empty($points))
                  @foreach($points as $point)
                  <option value="{{$point->id}}">{{$point->name}}</option>
                  @endforeach
                  @endif
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