<div class="d-flex">
	<a class="header-brand" href="{{url('home')}}">
		<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img main-logo bg-theme" alt="Logo">
		<img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img darklogo bg-theme" alt="Logo">
		<img src="{{URL::asset('assets/images/brand/icon.png')}}" class="header-brand-img icon-logo bg-theme" alt="Logo">
	</a><!-- logo-->
	<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
	<a href="#" data-toggle="search" class="nav-link nav-link  navsearch"><i class="fa fa-search"></i></a><!-- search icon -->

	<div class="d-flex order-lg-2 ml-auto header-rightmenu">


		<!-- notifications -->
		<div class="dropdown header-user">
			<a class="nav-link leading-none siderbar-link" data-toggle="dropdown" aria-expanded="false">
				<span class="mr-3 d-none d-lg-block ">
					<span class="text-gray-white"><span class="ml-2">Travel Master</span></span>
				</span>
				<span class="avatar avatar-md brround"><img src="{{URL::asset('assets/images/brand/logo.png')}}" alt="Profile-img" class="avatar avatar-md brround bg-theme"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
				<div class="header-user text-center mt-4 pb-4">
					<span class="avatar avatar-xxl brround"><img src="{{URL::asset('assets/images/brand/logo.png')}}" alt="Profile-img" class="avatar avatar-xxl brround bg-theme"></span>
					<a href="#" class="dropdown-item text-center font-weight-semibold user h3 mb-0">Travel Master</a>
					<!-- <small>Developer</small> -->
				</div>
				<a class="dropdown-item" href="{{route('users.show',Auth::user()->id)}}">
					<i class="dropdown-icon mdi mdi-account "></i> Profile
				</a>
				<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#changePasswordmodal">
					<i class="dropdown-icon  mdi mdi-account-key"></i> Change Password
				</a>
				<a class="dropdown-item" href="javascript:void();" onclick="logout()">
					<i class="dropdown-icon  mdi mdi-arrow-left-bold-circle-outline"></i> Logout
				</a>
				<form class="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>

			</div>
		</div><!-- profile -->

		<!-- Right-siebar-->
	</div>
</div>