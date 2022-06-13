@extends('layouts.customapp')

@section('custom-styles')

@endsection

@section('content')

			<!-- page-content -->
			<div class="page-content">
				<div class="container text-center text-dark">
					<div class="row">
						<div class="col-lg-4 d-block mx-auto">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-md-12">
									<div class="card">
										<div class="card-body">
											<div class="text-center mb-6">
												<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="" alt="">
											</div>
											<h3>Forgot password</h3>
											<div class="input-group  mr-auto ml-auto mb-4">
												<span class="input-group-addon bg-white"><i class="fa fa-envelope"></i></span>
												<input type="password" class="form-control" placeholder="Email address">
											</div>
											<div class="text-center">
												<button type="button" class="btn btn-primary btn-block">Send</button>
											</div>
										
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- page-content end -->

@endsection('content')

@section('custom-scripts')

@endsection