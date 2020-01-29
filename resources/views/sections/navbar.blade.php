<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#">Navbar w/ text</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarText">
		<ul class="navbar-nav mr-auto">
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