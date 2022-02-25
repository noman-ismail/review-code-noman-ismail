@php
	$cnic = Auth::user()->cnic;
	$user = DB::table('users')->where('cnic',$cnic)->first();
	$user_info = DB::table('user_info')->where('user_id',$user->id)->first();
@endphp
					<ul class="sidebar-nav">
						<li class="head"><h3 class="rounded-top">Dashboard</h3></li>
						<li class="{{ (Request::segment('2') == 'dashboard')?"active":"" }}">
							<a href="{{ route('user-dashboard') }}"><i class="icon-home"></i> Home
							</a>
						</li>
						<li class="{{ (Request::segment('2') == 'personal-information')?"active":"" }}">
							<a href="{{ route('personal-information') }}"><i class="icon-user-check"></i> Personal Information</a>
						</li>
						<li class="{{ (Request::segment('2') == 'nominee-information')?"active":"" }}">
							<a href="{{ route('nominee-information') }}"><i class="icon-user"></i> Nominee Information</a>
						</li>
						<li class="{{ (Request::segment('2') == 'family-information')?"active":"" }}">
							<a href="{{ route('family-information') }}"><i class="icon-users"></i> Family Information</a>
						</li>
						<li class="{{ (Request::segment('2') == 'amount-history')?"active":"" }}">
							<a href="{{ route('amount-history') }}"><i class="icon-coin-dollar"></i> Amount History</a>
						</li>
						@if (!empty($user_info) and $user_info->collector == 'yes')

							@if (!empty($user_info) and $user_info->status == 'on')
								<li class="{{ (Request::segment('2') == 'add-funds')?"active":"" }}">
									<a href="{{ route('add-funds') }}"><i class="icon-money"></i> Add Funds</a>
								</li>
							@endif
							<li class="{{ (Request::segment('2') == 'funds-history')?"active":"" }}">
								<a href="{{ route('funds-history') }}"><i class="icon-credit-card"></i> Funds History</a>
							</li>
						@endif
						<li class="{{ (Request::segment('2') == 'account-setting')?"active":"" }}">
							<a href="{{ route('account-setting') }}"><i class="icon-profile"></i> Account Setting</a>
						</li>
						<li class="">
							<a href="{{ route('user-logout') }}"><i class="icon-exit"></i> Logout</a>
						</li>
					</ul>