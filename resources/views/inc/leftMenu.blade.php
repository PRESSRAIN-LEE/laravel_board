{{-- {{$currenturl = url()->current()->getName()}} --}}
{{-- {{dd($currenturl)}} --}}

{{-- {{$currenturl = Route::current()->getName();}} --}}
{{-- {{$currenturl = url()->full();}} --}}
{{-- {{$fullUrl = request()->url()}} --}}
{{-- {{dd($fullUrl);}} --}}
{{$uri = request()->segment(1)}}
{{-- {{$uri = request()->path()}} --}}
{{-- {{$uri = request()->route()->getName()}} --}}
{{-- {{dd($uri)}} --}}
{{-- {{request()->url()}} --}}
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
	<div class="sidebar-sticky pt-3">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="/admin">
					<span data-feather="home"></span>
					Dashboard <span class="sr-only">(current)</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if($uri === 'board') active @endif " href="{{ url('board') }}">
					<span data-feather="file-text"></span>
					게시판
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if($uri === 'member') active @endif " href="/admin/member">
					<span data-feather="users"></span>
					회원관리
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if($uri === 'order') active @endif " href="/admin/order">
					<span data-feather="shopping-cart"></span>
					
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/admin/inventory/inventoryList.html">
					<span data-feather="package"></span>
					
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/dailybread/admin/inquiry/inquiryList.html">
					<span data-feather="file-text"></span>
					
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/dailybread/admin/requestSupply/requestSupplyList.html">
					<span data-feather="file"></span>
					
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/dailybread/admin/">
					<span data-feather="server"></span>
					
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/dailybread/admin/">
					<span data-feather="bar-chart-2"></span>
					
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if($uri === 'board') active @endif " href="/admin/board">
					<span data-feather="file-text"></span>
					
				</a>
			</li>
		</ul>
	</div>
</nav>