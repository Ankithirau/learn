			<!-- Modal -->
			<div class="modal fade" id="changePasswordmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Change Password - <span class="text-primary">{{Auth::user()->name}}</span></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form name="ajax_form" method="post" action="{{route('user.update-password',Auth::user()->id)}}" enctype="multipart/form-data">
							<input type="hidden" name="id" value="{{Auth::user()->id}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="modal-body">
								<div class="form-group">
									<label class="form-label">Current Password</label>
									<input type="password" name="current_password" id="current_password" class="form-control" value="" placeholder="Current Password">
								</div>
								<div class="form-group">
									<label class="form-label"> New Password</label>
									<input type="password" name="password" id="password" class="form-control" value="" placeholder="New Password">
									<span class="text-dark" style="font-size: 12px;line-height: 1.3;font-weight: 100;margin-top: 5px;" role="alert">
										<strong>Password should be at least 10 characters, contain upper case, lower case, numbers and special characters (!@£$%^&amp;)</strong>
									</span>
								</div>
								<div class="form-group">
									<label class="form-label">Confirm Password</label>
									<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" placeholder="Confirm Password">
								</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save Password</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--footer-->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-lg-12 col-sm-12   text-center">
							Copyright © <?= date('Y'); ?> <a href="#">Travel Master</a>.
						</div>
					</div>
				</div>
			</footer>
			<!-- End Footer-->