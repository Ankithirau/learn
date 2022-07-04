<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar toggle-sidebar">
	<ul class="side-menu toggle-menu">
		<li>
			<a class="side-menu__item" href="{{route('home')}}">
				<i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Home</span></a>
		</li>
		<li>
			<a class="side-menu__item" href="{{url('slider')}}"><i class="side-menu__icon mdi mdi-file-image"></i><span
					class="side-menu__label">Banner
					Slider</span></a>
		</li>
		<li>
			<a class="side-menu__item" href="{{url('county')}}">
				<i class="side-menu__icon mdi fs-2 mdi-flag-outline"></i><span
					class="side-menu__label">County</span></a>
		</li>
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#">
				<i class="side-menu__icon mdi fs-2 mdi-lan"></i><span class="side-menu__label">Categories</span><i
					class="angle fa fa-angle-right"></i></a>
			<ul class="slide-menu">
				<li><a href="{{url('category')}}" class="slide-item">Category </a></li>
				<li><a href="{{url('subcategory')}}" class="slide-item">Subcategory </a></li>
			</ul>
		</li>
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#">
				<i class="side-menu__icon mdi fs-2 mdi-account-circle"></i><span
					class="side-menu__label">Operator</span><i class="angle fa fa-angle-right"></i></a>
			<ul class="slide-menu">
				<li><a href="{{route('operator.create')}}" class="slide-item">Create </a></li>
				<li><a href="{{route('operator.index')}}" class="slide-item"> Show</a></li>
			</ul>
		</li>
		<li>
			<a class="side-menu__item" href="{{url('coupon')}}">
				<i class="side-menu__icon mdi fs-2 mdi-gift"></i><span class="side-menu__label">Coupon</span></a>
		</li>
		<li>
			<a class="side-menu__item" href="{{url('event')}}">
				<i class="side-menu__icon mdi fs-2 mdi-calendar"></i><span class="side-menu__label">Event</span></a>
		</li>
		<li>
			<a class="side-menu__item" href="{{url('pickup')}}">
				<i class="side-menu__icon mdi fs-2 mdi-map-marker"></i><span class="side-menu__label">Pickup
					Points</span></a>
		</li>
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#">
				<i class="side-menu__icon mdi fs-2 mdi-cart"></i><span class="side-menu__label">Product</span><i
					class="angle fa fa-angle-right"></i></a>
			<ul class="slide-menu">
				<li><a href="{{route('product.create')}}" class="slide-item">Create </a></li>
				<li><a href="{{route('product.index')}}" class="slide-item">Show </a></li>
			</ul>
		</li>
		<li>
			<a class="side-menu__item" href="{{url('bus')}}">
				<i class="side-menu__icon mdi fs-2 mdi-bus"></i><span class="side-menu__label">
					Buses </span></a>
		</li>
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#">
				<i class="side-menu__icon mdi fs-2 mdi-road-variant"></i><span class="side-menu__label">Route
					Schedule</span><i class="angle fa fa-angle-right"></i></a>
			{{-- <ul class="slide-menu">
				<li><a href="{{route('bus.create')}}" class="slide-item">Create </a></li>
				<li><a href="{{route('bus.index')}}" class="slide-item">Lists </a></li>
			</ul> --}}
		</li>
		<li>
			<a class="side-menu__item" href="{{url('seo')}}">
				<i class="side-menu__icon mdi fs-2 mdi-settings"></i><span class="side-menu__label">Seo
					Setting</span></a>
		</li>
		<li>
			<a class="side-menu__item" href="javascript:void(0);" onclick="logout()"><i
					class="side-menu__icon mdi mdi-logout"></i><span class="side-menu__label">Logout</span></a>
		</li>
	</ul>
</aside>
<!--sidemenu end-->