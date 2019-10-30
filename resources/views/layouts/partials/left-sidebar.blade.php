<div class="left-sidebar-section">
	<div class="sidebar-container">
		<ul>
		    <li>
		        <a href="{{url('/dashboard')}}"><i class="fa fa-home fa-fw"></i> Dashboard</a>
		    </li>
		    @if(auth()->user()->level == 'admin')
		    <li>
		        <a href="{{route('admin.product.index')}}"><i class="fa fa-archive fa-fw"></i> Products</a>
		    </li>
		    <li>
		        <a href="{{route('admin.customer.index')}}"><i class="fa fa-user fa-fw"></i> Customers</a>
		    </li>
		    <li>
		        <a href="{{route('admin.router.index')}}"><i class="fa fa-cubes fa-fw"></i> Routers</a>
		    </li>
		    <li>
		        <a href="{{route('admin.payment.index')}}"><i class="fa fa-paypal fa-fw"></i> Payments</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> Subscriptions</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-vcard fa-fw"></i> Coupons</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-users fa-fw"></i> Users</a>
		    </li>
		    <!-- <li>
		        <a href="#"><i class="fa fa-bell fa-fw"></i> Requests</a>
		    </li> -->
		    @else
		    <li>
		        <a href="{{route('user.router.index')}}"><i class="fa fa-cubes fa-fw"></i> Routers</a>
		    </li>
		    <!-- <li>
		        <a href="#"><i class="fa fa-building fa-fw"></i> Bridges</a>
		    </li> -->
		    <!-- <li>
		        <a href="#"><i class="fa fa-child fa-fw"></i> Hotspot Profiles</a>
		    </li> -->
		    <!-- <li>
		        <a href="#"><i class="fa fa-users fa-fw"></i> Hotspot Users</a>
		    </li> -->
		    <li>
		        <a href="#"><i class="fa fa-vcard fa-fw"></i> Voucher Templates</a>
		    </li>
		    <li>
		        <a href="{{route('user.payment.index')}}"><i class="fa fa-paypal fa-fw"></i> Payments</a>
		    </li>
		    <li>
		        <a href="#"><i class="fa fa-cogs fa-fw"></i> Setting</a>
		    </li>
		    @endif
		    <li>
		    	<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
		    		<i class="fa fa-sign-out fa-fw"></i>  {{ __('Logout') }}
		    	</a>

		    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		    		{{csrf_field()}}
		    	</form>
		    </li>
		</ul>
	</div>
</div>