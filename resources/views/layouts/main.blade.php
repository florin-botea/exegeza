<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"-->
	
	<link rel="icon" href="/logo.jpeg">
	<meta name="description" content="{{ $page_description ?? 'config description' }}"/>
	<title>{{ $page_title ?? 'config title' }}</title>

	<script src="https://kit.fontawesome.com/f669d10aec.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href='/css/app.css'>
	
	<script>

	</script>
</head>
<body class="bg-gray-200">
	<header>
		@include('sections.navbar')
		
	</header>
	<div class="container mx-auto px-4 lg:px-32">
		<div class="flex flex-wrap bg-white mt-8 shadow-md" style="border: 1px solid purple;">
			@include('sections.breadcrumb')
			<div class="w-1/4"></div>
			<main class="w-3/4">
				@yield('content')
			</main>
		</div>
	</div>
	@guest
		@include('auth.login-modal')
	@endguest
	<!--script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script-->
	<script src="/js/app.js"></script>
	@foreach (($scripts??[]) as $script)
		<script src="/js/{{$script}}"></script>
	@endforeach
</body>
</html>