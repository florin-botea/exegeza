<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"-->
	<link rel="icon" href="/logo.jpeg">
	<script src="https://kit.fontawesome.com/f669d10aec.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href='/css/app.css'>
</head>
<body>
	<header>

	</header>
	@json($errors->all())
	<main class="container mx-auto px-4 lg:px-32">
		@yield('content')
	</main>
	<script src="/js/app.js"></script>
	@foreach (($scripts??[]) as $script)
		<script src="/js/{{$script}}"></script>
	@endforeach
</body>
</html>