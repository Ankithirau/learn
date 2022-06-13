@extends('layouts.app')

@section('styles')

@endsection

@section('content')

<!-- page-header -->
<div class="page-header">
	<ol class="breadcrumb">
		<!-- breadcrumb -->
		<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Profile</li>
	</ol><!-- End breadcrumb -->
</div>
<!-- End page-header -->

<!-- row -->
<div class="row">
	<div class="col-md-12">
		<div class="card card-profile  overflow-hidden">
			<div class="card-body text-center profile-bg">
				<div class=" card-profile">
					<div class="row justify-content-center">
						<div class="">
							<div class="">
								<a href="#">
									<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="avatar-xxl rounded-circle" alt="profile">
								</a>
							</div>
						</div>
					</div>
				</div>
				<h3 class="mt-3">Travel Master</h3>

				<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changePasswordmodal"><i class="fa fa-pencil" aria-hidden="true"></i> Change password</a>
			</div>
			<div class="card-body">
				<div class="nav-wrapper p-0">
					<ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">

					</ul>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body pb-0">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade active show" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
						<div class="table-responsive mb-3">
							<table class="table row table-borderless w-100 m-0 border">
								<tbody class="col-lg-12 p-0">
									<tr>
										<td style="width:200px"><strong>Company Name -</strong> </td>
										<td>Travel Master</td>
									</tr>
									<tr>
										<td><strong>Email Id -</strong> </td>
										<td>info@travelmaster.ie</td>
									</tr>
									<tr>
										<td><strong>Mobile Number -</strong> </td>
										<td>+91-9090909090</td>
									</tr>
									<tr>
										<td><strong>Address -</strong> </td>
										<td>Indore MP, India</td>
									</tr>
								</tbody>

							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- row end -->



@endsection('content')

@section('scripts')

<!--Jquery Sparkline js-->
<script src="{{URL::asset('assets/plugins/vendors/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle js-->
<script src="{{URL::asset('assets/plugins/vendors/circle-progress.min.js')}}"></script>

<!--Time Counter js-->
<script src="{{URL::asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
<script src="{{URL::asset('assets/plugins/counters/counter.js')}}"></script>

@endsection