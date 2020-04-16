@php
	$isAcceptingArticles = in_array(request()->route()->getName(), ['bible-versions.books.show', 'bible-versions.books.chapters.show']);
	$hasArticles = in_array(request()->route()->getName(), ['articles.show', 'bible-versions.show', 'articles.index', 'users.show', 'bible-versions.books.show', 'bible-versions.books.chapters.show']);
@endphp
{{request()->route()->getName()}}
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
		var csrfToken = "{{ csrf_token() }}";
	</script>

	<style>
		#filter-published + #filter-published-labels > #unpublished {
			display: none;
		}
		#filter-published + #filter-published-labels > #published {
			display: initial;
		}
		#filter-published:checked + #filter-published-labels > #unpublished {
			display: initial;
		}
		#filter-published:checked + #filter-published-labels > #published {
			display: none;
		}

		._create-form {
			display: none;
		}

		._create-form-shown:checked + ._create-form-block > ._create-form {
			display: block;
		}

		._create-form-shown:checked + ._create-form-block > ._create-form-toggle-on {
			display: none;
		}

		#comments-container {
			display: flex;
			flex-direction: column;
		}

		#comments-container .commenting-field {
			order: 2;
		}

		#comments-container._unauthenticated::before {
			content: "Pentru a participa la dialog, este nevoie sa fiti autentificat.";
			color: orange;
		}

		#comments-container._unauthenticated .commenting-field {
			display: none;
		}

		#comments-container._unauthenticated .actions {
			display: none !important;
		}
	</style>
</head>
<body class="bg-gray-200">
	<header>
		@include('sections.navbar')
	</header>
	<div class="container mx-auto px-0 md:px-0 lg:px-32">
		<div class="flex flex-wrap bg-white mt-8 shadow-md border border-pink-800 p-2" style="border: 1px solid purple;">
			<div role="left" class="w-full sm:w-1/4 sm:pr-8 sm:order-first order-last">
				<table width="100%" class="doxo-table border-2 border-blue-900"><tr><td ><div  class=""><script type="text/javascript">widgetContext_417c8830427f = {"widgetid":"web_widgets_inline_602b4679437414a28c163b73154c8142"};</script><script src="https://doxologia.ro/doxowidgetcalendar"></script><div class="doxowidgetcalendar" id="web_widgets_inline_602b4679437414a28c163b73154c8142"></div></td></tr></table>
			</div>
			<div role="right" class="w-full sm:w-3/4">
				@include('sections.breadcrumb')
				
				@yield('content')

				<div class="mt-4">
					@include('components.subscribe-form')
				</div>

				@if ($hasArticles && isset($last_articles) && isset($popular_articles) && count($last_articles) && count($popular_articles))
				{{-- semi-footer = articole recente, articole populare --}}
				<section class="bg-gray-300">
					<div class="lg:pr-2 flex flex-wrap">
						<section role="last-articles-list" class="w-full lg:w-2/3 sm:pr-4 bg-gray-200">
							<h2 class="text-lg font-bold bg-pink-800 font-serif text-white px-2"> Articole recente </h2>
							<ul class="text-justify leading-tight p-1">
								@foreach ($last_articles as $article)
									<li class="pr-2">
										<a href="{{ route('articles.show', [$article->slug, 'user' => $article->author->id]) }}">
											<h2 class="font-semibold text-lg hover:underline inline text-blue-900 mb-2">{{ $article->title }}</h2>
										</a>
										<a href="" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
										<span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
										<a>
											<p class="px-2 text-blue-900">{{ $article->sample }}</p>
										</a>
									</li>
									<hr class="my-2">
								@endforeach
							</ul>
						</section>
						<section class="w-full lg:w-1/3 bg-gray-300">
							<h2 class="text-lg font-bold bg-pink-800 font-serif text-white px-2"> Articole populare </h2>
							<ul class="text-justify leading-tight p-1">
								@foreach ($popular_articles as $article)
									<li class="">
										<a href="{{ route('articles.show', [$article->slug, 'user' => $article->author->id]) }}" class="font-semibold text-base hover:underline font-bold text-blue-900 hover:text-blue-600">{{ $article->title }}</a>
										<a href="{{ route('users.show', [$article->author->id]) }}" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
										<span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
									</li>
									<hr class="my-2">
								@endforeach
							</ul>
						</section>
					</div>
				</section>
				{{-- end:semi-footer --}}
				@endif
			</div>
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
	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5dc07d5c1954dce7"></script>
</body>
</html>