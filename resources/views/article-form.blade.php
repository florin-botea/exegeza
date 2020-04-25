@extends('layouts.main')

@php
    use App\Helpers\Form;

    $scripts = ['ckeditor-classic.js'];

    $article = $article ?? new \App\Article();
    $article->language = $article->language ? $article->language->value : null;
@endphp

@section('content')
	<div class="mb-8 md:mb-4">
		<div class="col">
            <section class="p-2">
                @if ($bible->book->chapter)
                    <section class="verses-section">
                        @foreach($bible->book->chapter->verses as $verse)
                            <p class="mb-2 text-blue-900 text-lg font-serif">{{ $verse->index.' '.$verse->text }}</p>
                        @endforeach
                    </section>
                @endif
            </section>

            <hr class="mb-8">
			<div class="" id="add-article">
                <form method="POST">
                    @csrf
                    <input name="form_id" value="article" hidden>
                    <input name="bible_version_id" value="{{ $article->bible_version_id ?? $bible->id }}" hidden>
                    <input name="book_index" value="{{ $article->book_index ?? $bible->book->index }}" hidden>
                    <input name="book_id" value="{{ $article->book_id ?? $bible->book->id }}" hidden>
                    @if ($bible->book->chapter)
                        <input name="chapter_index" value="{{ $article->chapter_index ?? $bible->book->chapter->index }}" hidden>
                        <input name="chapter_id" value="{{ $article->chapter_id ?? $bible->book->chapter->id }}" hidden>
                    @endif
                    <input name="language" type="text" class="h-0 w-0 p-0 border-0 m-0">
                    <div class="mb-2">
                        <label for="language" class="label-base"> Language </label>
                        <input name="language" value="{{ Form::value('article','language',$article->language) }}" class="autocomplete-input input-base" data-endpoint="/api/languages" id="language" type="text">
                        <p class="text-error">{{ Form::error('article', 'language') }}</p>
                    </div>
                    @can('publish', $article??\App\Article::class)
                        <div class="mb-2">
                            <label for="meta" class="label-base"> Meta </label>
                            <div class="relative">
                                <input name="meta" value="{{ Form::value('article','meta',$article->meta) }}" class="input-base" id="article-meta" type="text">
                                <input-char-count for="article-meta"></input-char-count>
                            </div>
                            <p class="text-error">{{ Form::error('article', 'meta') }}</p>
                        </div>
                        <div class="mb-2">
                            <label for="sample" class="label-base"> Sample </label>
                            <div class="relative">
                                <textarea name="sample" class="input-base" id="article-sample">{{ Form::value('article','sample',$article->sample) }}</textarea>
                                <input-char-count for="article-sample" style="top:0"></input-char-count>
                            </div>
                            <p class="text-error">{{ Form::error('article', 'sample') }}</p>
                        </div>
                    @endcan
                    <div class="mb-2">
                        <label for="title" class="label-base"> Title </label>
                        <div class="relative">
                            <input name="title" value="{{ Form::value('article','title',$article->title) }}" class="input-base" id="article-title">
                            <input-char-count for="article-title"></input-char-count>
                        </div> 
                        <p class="text-error">{{ Form::error('article', 'title') }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="cite_from" class="label-base"> Citat din </label>
                        <input name="cite_from" value="{{ Form::value('article','cite_from',$article->cite_from) }}" class="input-base" id="cite_from">
                        <p class="text-sm leading-tight text-gray-600"> ? Numele autorului in cazul in care este vorba despre un citat </p>
                        <p class="text-error">{{ Form::error('article', 'cite_from') }}</p>
                    </div>        
                    <div class="mb-2 relative">
                        <textarea class="ckeditor-classic" name="content" id="article-content" hidden>{{ Form::value('article','content',$article->content) }}</textarea>
                    </div>
                    <hr> 
                    <div class="mb-2">
                        <label for="tags" class="label-base"> Tags </label>
                        <input name="tags" value="{{ Form::value('article','tags',$article->tags) }}" class="tagify-input" data-endpoint="/api/tags" id="tags">
                        <p class="text-error">{{ Form::error('article', 'tags') }}</p>
                    </div>
                    <div class="flex justify-end">
                        @if($article->id)
                            @can('delete', $article)
                                <button name="_method" value="delete" formaction="" class="rounded mx-1 px-2 py-1 font-bold text-white hover:text-black bg-red-600 hover:bg-red-400">
                                    Delete
                                </button>
                            @endcan
                            @can('unpublish', $article)
                                <button name="_method" value="put" formaction="" class="rounded mx-1 px-2 py-1 font-bold text-white hover:text-black bg-yellow-600 hover:bg-yellow-400">
                                    Unpublish
                                </button>
                            @endcan
                            @can('update', $article)
                                <button name="_method" value="put" formaction="{{ route('articles.update', $article->id) }}" class="rounded mx-1 px-2 py-1 font-bold text-white hover:text-black bg-green-600 hover:bg-green-400">
                                    Update
                                </button>
                            @endcan
                            @can('publish', $article)
                                <button name="_method" value="put" formaction="{{ route('articles.publish', $article->id) }}" class="rounded mx-1 px-2 py-1 font-bold text-white hover:text-black bg-blue-300 hover:bg-blue-100">
                                    Publish
                                </button>
                            @endcan
                        @endif
                        @if(!$article->id)
                            @can('create', \App\Article::class)
                                <button name="_method" value="post" formaction="{{ route('articles.store') }}" class="rounded mx-1 px-2 py-1 font-bold text-white hover:text-black bg-blue-600 hover:bg-blue-400">
                                    Create
                                </button>
                            @endcan
                            @can('publish', \App\Article::class)
                                <button name="_method" value="put" formaction="{{ route('articles.publish', 0) }}" class="rounded mx-1 px-2 py-1 font-bold text-white hover:text-black bg-blue-300 hover:bg-blue-100">
                                    Publish
                                </button>
                            @endcan
                        @endif
                    </div>
                </form>
			</div>
           {{--     
                @form(['action'=>''])
                    <div class="d-flex justify-content-end">
                        @if($article->id)
                            @can('delete', $article)
                                @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'mr-2 btn-danger', 'text'=>'Delete', 'attrs'=>['formaction'=>''] ])
                            @endcan
                            @can('unpublish', $article)
                                @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'mr-2 btn-warning', 'text'=>'Unpublish', 'attrs'=>['formaction'=>''] ]) 
                            @endcan
                            @can('update', $article)
                                @submit(['name'=>'_method', 'value'=>'put', 'class'=>'mr-2 btn-success', 'text'=>'Update', 'attrs'=>['formaction='.route('articles.update', $article->id)] ]) 
                            @endcan
                            @can('publish', $article)
                                @submit(['name'=>'_method', 'value'=>'put', 'class'=>'mr-2 btn-primary', 'text'=>'Publish', 'attrs'=>['formaction='.route('articles.publish', $article->id)] ]) 
                            @endcan
                        @endif
                        @if(!$article->id)
                            @can('create', \App\Article::class)
                                @submit(['name'=>'_method', 'value'=>'post', 'class'=>'mr-2 btn-success', 'text'=>'Add', 'attrs'=>['formaction='.route('articles.store')] ]) 
                            @endcan
                            @can('publish', \App\Article::class)
                                @submit(['name'=>'_method', 'value'=>'put', 'class'=>'mr-2 btn-primary', 'text'=>'Publish', 'attrs'=>['formaction='.route('articles.publish', 0)] ]) 
                            @endcan
                        @endif
                    </div>
                @endform
                --}}                

			</div>
		</div>
	</div>
@endsection