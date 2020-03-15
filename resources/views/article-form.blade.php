@extends('layouts.main')

@php
    use App\Helpers\Form;

    $scripts = ['ckeditor-classic.js'];

    $article = $article ?? new \App\Article();
    $article->language = $article->language ? $article->language->value : null;
@endphp

@section('content')
	<div class="row">
		<div class="col">
			@include('components.faded-verses', ['bible'=>$bible])
            <hr class="mb-8">
			<div class="">
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

                    <div class="mb-2">
                        <label for="language" class="label-base"> Language </label>
                        <input name="language" value="{{ Form::value('article','language',$article->language) }}" class="autocomplete-input input-base" data-endpoint="/api/languages" id="language" type="text">
                        <p class="text-error">{{ Form::error('article', 'language') }}</p>
                    </div>
                    @can('publish', $article??\App\Article::class)
                        <div class="mb-2">
                            <label for="meta" class="label-base"> Meta </label>
                            <input name="meta" value="{{ Form::value('article','meta',$article->meta) }}" class="input-base" id="meta" type="text">
                            <p class="text-error">{{ Form::error('article', 'meta') }}</p>
                        </div>
                        <div class="mb-2">
                            <label for="sample" class="label-base"> Sample </label>
                            <textarea name="sample" class="input-base" id="sample">{{ Form::value('article','sample',$article->sample) }}</textarea>
                            <p class="text-error">{{ Form::error('article', 'sample') }}</p>
                        </div>
                    @endcan
                    <div class="mb-2">
                        <label for="title" class="label-base"> Title </label>
                        <input name="title" value="{{ Form::value('article','title',$article->title) }}" class="input-base" id="title">
                        <p class="text-error">{{ Form::error('article', 'title') }}</p>
                    </div>
                    <div class="mb-2">
                        <label for="cite_from" class="label-base"> Citat din </label>
                        <input name="cite_from" value="{{ Form::value('article','cite_from',$article->cite_from) }}" class="input-base" id="cite_from">
                        <p class="text-error">{{ Form::error('article', 'cite_from') }}</p>
                    </div>        
                    <div class="mb-2">
                        <label for="cite_from" class="label-base"> Citat din </label>
                        <input name="cite_from" value="{{ Form::value('article','cite_from',$article->cite_from) }}" class="input-base" id="cite_from">
                        <p class="text-error">{{ Form::error('article', 'cite_from') }}</p>
                    </div> 
                    <div class="mb-2">
                        <textarea class="ckeditor-classic" name="content" hidden>{{ Form::value('article','content',$article->content) }}</textarea>
                    </div>
                    <hr> 
                    <div class="mb-2">
                        <label for="tags" class=""> Tags </label>
                        <input name="tags" value="{{ Form::value('article','tags',$article->tags) }}" class="tagify-input input-base" data-endpoint="/api/tags" id="tags">
                        <p class="text-error">{{ Form::error('article', 'tags') }}</p>
                    </div>
                    <div class="flex justify-content-end">
                        @if($article->id)
                            @can('delete', $article)
                                <button name="_method" value="delete" formaction="" class="">
                                    Delete
                                </button>
                            @endcan
                            @can('unpublish', $article)
                                <button name="_method" value="put" formaction="" class="">
                                    Unpublish
                                </button>
                            @endcan
                            @can('update', $article)
                                <button name="_method" value="put" formaction="{{ route('articles.update', $article->id) }}" class="">
                                    Update
                                </button>
                            @endcan
                            @can('publish', $article)
                                <button name="_method" value="put" formaction="{{ route('articles.publish', $article->id) }}" class="">
                                    Publish
                                </button>
                            @endcan
                        @endif
                        @if(!$article->id)
                            @can('create', \App\Article::class)
                                <button name="_method" value="post" formaction="{{ route('articles.store') }}" class="">
                                    Create
                                </button>
                            @endcan
                            @can('publish', \App\Article::class)
                                <button name="_method" value="put" formaction="{{ route('articles.publish', 0) }}" class="">
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