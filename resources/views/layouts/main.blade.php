<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/f669d10aec.js" crossorigin="anonymous"></script>
	
	 <link rel="icon" href="/logo.jpeg">
	<meta name="description" content="{{ $page_description ?? 'config description' }}"/>
	<title>{{ $page_title ?? 'config title' }}</title>
	<link rel="stylesheet" href='/css/app.css'>
	<style>
		form.labels-top label {
			display: block;
			width: 100%;
		}
		form .form-inline button[type=submit] {
			align-self: flex-center;
		}
	</style>
</head>
<body>
	<header>
		{{-- @include('sections.admin-navbar') --}}
		@include('sections.navbar')
	</header>
	<main class="container my-5" id="vue-app-layer">
		@yield('content')
	</main>
	@include('auth.login-modal')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/js/app.js"></script>
@foreach (($scripts??[]) as $script)
	<script src="/js/{{$script}}"></script>
@endforeach
<script>
	@if ($errors->any() && old('_auth', null) === 'login')
		loginModal();
	@elseif($errors->any() && old('_auth', null) === 'register')
		registerModal();
	@endif
</script>
</body>
</html>