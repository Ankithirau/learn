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
    <li class="breadcrumb-item"><a href="{{route('bus.index')}}">Bus List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Bus</li>
  </ol>
  <!-- End breadcrumb -->
</div>
<!-- End page-header -->
<!-- row opened -->
{{-- {{print_r($points)}} --}}
{{-- {{die()}} --}}
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body pt-4">
        <form name="ajax_form" method="post" action="{{route('assign-bus.store')}}" enctype="multipart/form-data"
          novalidate>
          @csrf
          @method('post')
          <table class="table table-bordered table-striped table-highlight text-center">
            <thead>
              <tr>
                <th>S no</th>
                <th>Route Name</th>
                <th>County</th>
                <th>Pickup Point</th>
                <th>Seat Booked</th>
                <th>Concert Date</th>
                <th>Allot Bus</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i=1;
              $num=0;
              @endphp
              @foreach ($points as $item)
              <tr>
                <td>{{$i++}}</td>
                <td>
                  <input type="text" name="route_name[]" class="form-control route_name" id="route_name_{{$item->id}}"
                    value="{{(isset($item->bus_assign[0]->route_name))?$item->bus_assign[0]->route_name:""}}"
                    autocomplete="off">
                  <div class="route_name {{$num}} text-danger error-inline"></div>
                </td>
                <td>
                  {{$item->county_name}}
                  <input type="hidden" name="counties_id[]" class="counties_id" value="{{$item->counties_id}}"
                    id="counties_id">
                  <input type="hidden" name="product_id" class="product_id" value="{{$item->product_id}}"
                    id="product_id">
                </td>
                <td>
                  {{$item->name}}
                  <input type="hidden" name="pickup_point_id[]" class="pickup_point_id" value="{{$item->id}}"
                    id="pickup_point_id">
                </td>
                <td>
                  {{$item->seat_count}}
                  <input type="hidden" name="seat_count[]" class="seat_count" value="{{$item->seat_count}}"
                    id="seat_count">
                </td>

                <td>
                  <select name="date_concert[]" class="form-control date_concert" id="date_concert_{{$item->id}}">
                    <option value="" selected>Select Concert Date</option>
                    @foreach ($item->date_concert as $date)
                    @if(isset(($item->bus_assign[0]->schedule_date))?$item->bus_assign[0]->schedule_date:0
                    ==trim($date))
                    <option value="{{$date}}" selected>{{date("d/m/Y", strtotime($date))}}</option>
                    @else
                    <option value="{{$date}}">{{date("d/m/Y", strtotime($date))}}</option>
                    @endif
                    @endforeach
                  </select>
                  <div class="date_concert {{$num}} text-danger error-inline"></div>
                </td>
                <td>
                  <select name="buses[]" class="form-control buses" id="buses_{{$item->id}}">
                    <option value="" selected>Select Bus</option>
                    @foreach ($buses as $bus)
                    @if (isset(($item->bus_assign[0]->bus_id))?$item->bus_assign[0]->bus_id:0==$bus->id)
                    <option value="{{$bus->id}}" selected>{{$bus->bus_number}}</option>
                    @else
                    <option value="{{$bus->id}}">{{$bus->bus_number}}</option>
                    @endif
                    @endforeach
                  </select>
                  <div class="buses {{$num}} text-danger error-inline"></div>
                </td>
                <td>
                  <input type="button" class="btn btn-primary schedule_update" value="update"
                    data-action="{{route('bus.add_schedule',isset($item->id)?$item->id:0)}}" />
                </td>
              </tr>
              @php
              $num++;
              @endphp
              @endforeach
            </tbody>
          </table>
          <input value="Submit" type="submit" id="form-button" class="btn btn-primary">
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