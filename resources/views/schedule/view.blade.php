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
    <li class="breadcrumb-item"><a href="{{route('operator.index')}}">Operators List</a></li>
    <li class="breadcrumb-item active" aria-current="page">View Operator</li>
  </ol><!-- End breadcrumb -->
</div>
<!-- End page-header -->
<!-- row opened -->
{{-- {{dd($results)}} --}}
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body pt-4">
        <form>
          <div class="row">
            <div class="col-md-6 col-lg-6">
            <div class="form-group">
              <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" id="name" autocomplete="off" value="{{$result->name}}" readonly>
            </div>
            <div class="form-group">
              <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control" id="email" autocomplete="off" value="{{$result->email}}" readonly>
            </div>
            <div class="form-group">
              <label for="password" class="col-form-label">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" id="password" autocomplete="off" value="{{$result->password}}" readonly>
            </div>

            <div class="form-group">
              <label for="mobile" class="col-form-label">Mobile <span class="text-danger">*</span></label>
              <input type="text" name="mobile" class="form-control" id="mobile" autocomplete="off" value="{{$result->status}}" readonly>
            </div>
            <div class="form-group">
              <label for="status" class="col-form-label">Status <span class="text-danger">*</span>:</label>
              <select name="status" class="form-control" >
                  <option value="{{$result->status}}" selected disabled>{{$result->status}}</option>
              </select>
          </div>
            </div>
            <div class="col-md-6 col-lg-6">
              <div class="form-group">
                <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
                <input type="text" name="address" class="form-control" id="address" autocomplete="off" value="{{$result->address}}" readonly>
                              </div>
              <div class="form-group">
                <label for="country" class="col-form-label">Country <span class="text-danger">*</span></label>
                <input type="text" name="country" value="{{$result->country}}" class="form-control" id="country" autocomplete="off" readonly>
              </div>
            <div class="form-group">
              <label for="state" class="col-form-label">State <span class="text-danger">*</span></label>
              <input type="text" name="state" value="{{$result->state}}" class="form-control" id="state" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="city" class="col-form-label">City <span class="text-danger">*</span></label>
              <input type="text" name="city" value="{{$result->city}}" class="form-control" id="city" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="pincode" class="col-form-label">Zipcode <span class="text-danger">*</span></label>
              <input type="text" name="pincode" value="{{$result->pincode}}" class="form-control" id="pincode" autocomplete="off" readonly>
            </div>
          </div>
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