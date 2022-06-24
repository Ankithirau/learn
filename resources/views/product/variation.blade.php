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
    <li class="breadcrumb-item"><a href="{{route('product.index')}}">Product List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Product</li>
  </ol><!-- End breadcrumb -->
</div>
<!-- End page-header -->
<!-- row opened -->
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body pt-4">
        <form name="ajax_form" method="post" action="{{route('product.add_variation_by_form')}}"
          enctype="multipart/form-data" novalidate>
          @csrf
          @method('POST')
          <table class="table table-bordered table-striped table-highlight">
            <thead>
              <tr>
                <th>Date of Concert</th>
                <th>County</th>
                <th>Pickup Point</th>
                <th>Stock Quantity</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($result as $item=>$val)
              @foreach ($val['pick_point'] as $pick =>$point)
              <tr>
                <td>
                  <p>{{date("d-m-Y", strtotime($val['date_concert']))}}</p>
                  <input type="hidden" name="date[]" class="form-control date_concert" value="{{$val['date_concert']}}">
                  <input type="hidden" name="product_id[]" class="form-control product"
                    value="{{$val['product']['id']}}">
                </td>
                <td>
                  <p>{{$val['county']['name']}}</p>
                  <input type="hidden" name="county_id[]" class="form-control county_id"
                    value="{{$val['county']['id']}}">
                </td>
                <td>
                  <p>{{(isset($point->name))?$point->name:""}}</p>
                  <input type="hidden" name="pickup_id[]" class="form-control pickup_id" value="{{$point->id}}">
                </td>
                @php
                $prices=\App\Models\Product_variation::select('id','price','stock_quantity')->where(['counties_id'=>$val['county']['id'],'pickup_point_id'=>$point->id,'product_id'=>$val['product']['id']])->first();
                @endphp
                @if ($prices)
                <td>
                  <input type="text" name="stock_quantity[]" class="form-control stock_quantity"
                    id="stock_{{$point->id}}" value="{{$prices->stock_quantity}}">
                </td>
                <td>
                  <input type="text" name="price[]" class="form-control price" id="price_{{$point->id}}"
                    value="{{$prices->price}}">
                </td>
                @else
                <td>
                  <input type="text" name="stock_quantity[]" class="form-control stock_quantity"
                    id="stock_{{$point->id}}">
                </td>
                <td>
                  <input type="text" name="price[]" class="form-control price" id="price_{{$point->id}}">
                </td>
                @endif

                <td>
                  <input type="button" value="Update" class="btn btn-primary update_variation"
                    data-action="{{route('product.add_variation',isset($prices->id)?$prices->id:0)}}">
                </td>
              </tr>
              @endforeach
              @endforeach
        </form>
        </tbody>
        </table>
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
@endsection