<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="icon" href="/logo.jpeg">
	<meta name="description" content="{{ $page_description ?? 'config description' }}"/>
	<title>{{ $page_title ?? 'config title' }}</title>
	
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/f669d10aec.js" crossorigin="anonymous"></script>
	
	<!-- Main Quill library -->
    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


	<!-- <link rel="stylesheet" href='/css/app.css'> -->

	<!-- <script>
		var csrfToken = "{{ csrf_token() }}";
		var currentUserIsAdmin = Boolean({{ auth()->user() && auth()->user()->hasRole('comments admin') ? 1 : 0 }});
		var authUserPhotoUrl = "{{ auth()->user() ? auth()->user()->getPhotoUrl() : null }}";
	</script> -->

	<style>
		body {
			background-color: #fff9ec;
		}
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

		#awn-toast-container {
			z-index: 99999999;
		}

		.card {
			margin: 1rem 0rem;
		}

		.card.card-breadcrumb .card-body {
			padding: 0.4rem 1rem;
		}

		.card.p-0 .card-body {
			padding: 0px;
		}
	</style>
</head>
<body>
    @php
    	$isAcceptingArticles = in_array(request()->route()->getName(), ['bible-versions.books.show', 'bible-versions.books.chapters.show']);
    	$hasArticles = in_array(request()->route()->getName(), ['articles.show', 'bible-versions.show', 'articles.index', 'users.show', 'bible-versions.books.show', 'bible-versions.books.chapters.show']);
    @endphp
	<header>
		<template is="partials/navbar"></template>
	</header>

	<div class="container">
		<div p-if="auth()->check() && !auth()->user()->hasVerifiedEmail()" class="px-4 py-2 bg-yellow-300 rounded-md border shadow-md">
			<p> Adresa de mail nu a fost verificata. Click <a href="/email/resend" class="text-blue-600 hover:text-blue-400 font-bold">aici</a> pentru a retrimite email de confirmare. </p>
		</div>

		<div class="row">
			<div role="left" class="col-sm-3 order-2 order-sm-1">
				<card class="p-0">
					<table width="100%" class="doxo-table border-2 border-blue-900"><tr><td ><div  class=""><script type="text/javascript">widgetContext_417c8830427f = {"widgetid":"web_widgets_inline_602b4679437414a28c163b73154c8142"};</script><script src="https://doxologia.ro/doxowidgetcalendar"></script><div class="doxowidgetcalendar" id="web_widgets_inline_602b4679437414a28c163b73154c8142"></div></td></tr></table>
				</card>
			</div>
			<div role="main" class="col-sm-9 order-1">
				<card class="card-breadcrumb">
					<template is="partials/breadcrumb" :links="$breadcrumbs"></template>
				</card>

				<slot></slot>

                <template p-if="$hasArticles && isset($last_articles) && isset($popular_articles) && count($last_articles) && count($popular_articles)">
                    <section class="bg-gray-300">
                        <div class="lg:pr-2 flex flex-wrap">
                            <section role="last-articles-list" class="w-full lg:w-2/3 sm:pr-4 bg-gray-200">
                                <h2 class="text-lg font-bold bg-pink-800 font-serif text-white px-2"> Articole recente </h2>
                                <ul class="text-justify leading-tight p-1">
                                    <template p-foreach="$last_articles as $article">
                                        <li class="pr-2" >
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
                                    </template>
                                </ul>
                            </section>
                            <section class="w-full lg:w-1/3 bg-gray-300">
                                <h2 class="text-lg font-bold bg-pink-800 font-serif text-white px-2"> Articole populare </h2>
                                <ul class="text-justify leading-tight p-1">
                                    <template p-foreach="$popular_articles as $article">
                                        <li class="">
                                            <a href="{{ route('articles.show', [$article->slug, 'user' => $article->author->id]) }}" class="font-semibold text-base hover:underline font-bold text-blue-900 hover:text-blue-600">{{ $article->title }}</a>
                                            <a href="{{ route('users.show', [$article->author->id]) }}" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
                                            <span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
                                        </li>
                                        <hr class="my-2">
                                    </template>
                                </ul>
                            </section>
                        </div>
                    </section>

					<div p-if="in_array(request()->route()->getName(), [null, 'bible-versions.show', 'bible-versions.books.show', 'bible-versions.books.chapters.show', 'articles.show'])" class="mt-4">
						<template is="partials/subscribe-form"></template>
						<hr>
					</div>
				</template>
			</div>
		</div>
	</div>

	<div class="" id="return-to-top"></div>

	<slot name="modals"></slot>
	<!--
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script-->
	
    <div class="html-editor"></div>
    
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <!-- Initialize Quill editor -->
    <script p-guest>
        $('.html-editor').each((i, el) => {
			new Quill(el, {
				theme: 'snow'
			});
		});
    </script>


	<script>
		var message = null;
		<?php
            if (isset($message) || session()->has('message')) {
                echo 'message = ' . json_encode($message ?? session()->get('message'));
            }
        ?>

		console.log(message)
		{{ $errors && old('form_id') == 'login' ? 'loginModal();' : '' }}
		{{ $errors && old('form_id') == 'register' ? 'registerModal();' : '' }}

		if (message) {
			try {
				let awn = new AWN({
					durations: {warning: 0}
				});
				awn[message.status](message.text)
			} catch(e) {}
		}

		// @route(['bible-versions.show', 'bible-versions.books.show'])
		// 	@if (request()->query('search-word'))
		// 		$('.-verse_text').each(function(i, el) {
		// 			let verse = $(el);
		// 			let highlighted = verse.html().replace(/{{request()->query('search-word')}}/g, '<span class="bg-yellow-300">{{request()->query("search-word")}}</span>');
		// 			verse.html(highlighted);
		// 		});
		// 	@endif
		// @endroute
	</script>

	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5dc07d5c1954dce7"></script>
</body>
</html>
