<nav role="navbar" class="flex flex-wrap px-2 sm:px-4 md:px-8 py-4 bg-gray-900 text-yellow-200 font-bold">
	<div role="navbar-menuContainer" class="">
		<ul role="navbar-menuList" class="flex">
			<li class="mx-1">
				<a class="" href="/"> Home </a>
			</li>
			<li class="mx-1">
				<a class="" href="#"> Predici </a>
			</li>
			<li class="mx-1">
				<a class="" href="#"> Pilde </a>
			</li>
			<li class="mx-1">
				<a class="" href="#"> Cantari </a>
			</li>
			<li class="mx-1">
				<a class="" href="#"> Biblioteca </a>
			</li>
			<li class="mx-1">
				<a class="" href="#"> Note </a>
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
	<div class="ml-auto flex">
		<div class="h-6">
			<img src="{{ auth()->user()->getPhotoUrl() }}" class="h-full w-auto rounded" id="authenticated-user-image">
		</div>
		<div class="pl-2 hidden sm:block">
			<a href="/users/{{ auth()->user()->id }}">{{ auth()->user()->name }}</a>
		</div>
		<form class="pl-2 m-0" action="/logout" method="POST">
			@csrf
			<button type="submit" class="px-2 py-1 bg-transparent text-white rounded"><i class="fas fa-sign-out-alt"></i></button>
		</form>
	</div>
	@endauth
</nav>