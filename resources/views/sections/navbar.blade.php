<nav role="navbar" class="flex flex-wrap px-2 sm:px-4 md:px-8 py-4 bg-gray-900 text-yellow-200 font-bold">
	<div role="navbar-menuContainer" class="">
		<ul role="navbar-menuList" class="flex">
			<li class="mx-1">
				<a class="" href="/"> Home </a>
			</li>
		<!--
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
		-->
			<li class="mx-1">
				<a class="" href="/opinions"> Pareri/Sugestii </a>
			</li>
		</ul>
	</div>
	@guest
	<div class="ml-auto d-flex">
		<!-- <a class="bg-blue-600 hover:bg-blue-400 hover:underline font-bold text-white px-2 rounded shadow cursor-pointer shadow-inner" id="registerBtn">
			Register
		</a> -->
		<a class="bg-green-600 hover:bg-green-400 hover:underline font-bold text-white px-2 rounded shadow cursor-pointer shadow-inner" id="loginBtn">
			Login
		</a>
	</div>
	@endguest

	@auth
	<div class="ml-auto flex">
		<a class="block self-stretch w-8 bg-center bg-contain rounded bg-no-repeat" style="background-image: url('{{ auth()->user()->getPhotoUrl() }}')"
		href="/users/{{ auth()->user()->id }}"></a>

		<div class="pl-2 hidden sm:block">
			<a href="/users/{{ auth()->user()->id }}">{{ auth()->user()->name }}</a>
		</div>
		<form class="self-stretch pl-2 m-0" action="/logout" method="POST">
			@csrf
			<button type="submit" class="h-full px-2 bg-transparent text-white rounded"><i class="fas fa-sign-out-alt"></i></button>
		</form>
	</div>
	@endauth
</nav>