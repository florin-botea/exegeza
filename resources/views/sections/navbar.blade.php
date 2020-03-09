<nav role="navbar" class="flex flex-wrap px-8 py-4 bg-gray-900 text-yellow-200 font-bold">
	<div role="navbar-menuContainer" class="">
		<ul role="navbar-menuList" class="flex">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Features</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Pricing</a>
			</li>
		</ul>
	</div>
	@guest
	<div class="ml-auto d-flex">
		<button class="btn btn-success" id="registerBtn">
			Register
		</button>
		<button class="ml-2 btn btn-primary" id="loginBtn">
			Login
		</button>
	</div>
	@endguest

	@auth
	<div class="ml-auto d-flex">
		{{ auth()->user()->name }}
	</div>
	@endauth
</nav>