@extends('layouts.main')

@php
    $scripts = ['ckeditor-classic.js'];
    $m = $article ?? ['language'=>['value'=>'user language']];
    $article = $article ?? new \App\Article();
    $form = new \App\Helpers\Form('article', $article);
    $language = $article->language ? $article->language->value : null;
@endphp

@section('content')
	<div class="row">
		<div class="col">
			@include('components.faded-verses', ['bible'=>$bible])
			<hr>
			<div class="">
                @form(['action'=>''])
                    <input name="bible_version_id" value="{{ $article->bible_version_id ?? $bible->id }}" hidden>
                    <input name="book_index" value="{{ $article->book_index ?? $bible->book->index }}" hidden>
                    @if ($bible->book->chapter)
                    <input name="chapter_index" value="{{ $article->chapter_index ?? $bible->book->chapter->index }}" hidden>
                    @endif
                    @text(['name'=>'language', 'label'=>'Language:',
                        'value' => $form->value('language', $language),
                        'error' => $errors->first('language')
                    ])
                    <!-- IF CAN PUBLISH ARTICLE, ADD THIS TOO -->
                    @can('publish', $article??\App\Article::class)
                    @text(['name'=>'meta', 'label'=>'Meta:',
                        'value' => $form->value('meta'),
                        'error' => $errors->first('meta')
                    ])
                    @text(['name'=>'title', 'label'=>'Title:',
                        'value' => $form->value('title'),
                        'error' => $errors->first('title')
                    ])
                    @textarea(['name'=>'sample', 'label'=>'Sample:',
                        'value' => $form->value('sample'),
                        'error' => $errors->first('sample')
                    ])
                    @endcan
                    <!-- -->
                    <div class="form-group">
                        <textarea class="ckeditor-classic" name="content" hidden>{{ $form->value('content') }}</textarea>
                    </div>
                    <hr>
                    @text(['name'=>'tags', 'label'=>'Tags:', 'inputClass'=>'tagify-input', 'data'=>['endpoint'=>'/api/tags'],
                        'value' => json_encode($form->value('tags')),
                        'error' => $errors->first('tags')
                    ])

                    <div class="d-flex justify-content-end">
                    @if($article->id)
                        @can('delete', $article)
                        @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'mr-2 btn-danger', 'text'=>'Delete', 'attrs'=>['formaction'=>''] ])
                        @endcan
                        @can('unpublish', $article)
                        @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'mr-2 btn-warning', 'text'=>'Unpublish', 'attrs'=>['formaction'=>''] ]) 
                        @endcan
                        @can('update', $article)
                        @submit(['name'=>'_method', 'value'=>'put', 'class'=>'mr-2 btn-success', 'text'=>'Update', 'attrs'=>['formaction='.route('pending-articles.update', $article->id)] ]) 
                        @endcan
                        @can('publish', $article)
                        @submit(['name'=>'_method', 'value'=>'put', 'class'=>'mr-2 btn-primary', 'text'=>'Publish', 'attrs'=>['formaction='.route('articles.update', $article->id)] ]) 
                        @endcan
                    @endif
                    @if(!$article->id)
                        @can('create', \App\Article::class)
                        @submit(['name'=>'_method', 'value'=>'post', 'class'=>'mr-2 btn-success', 'text'=>'Add', 'attrs'=>['formaction='.route('pending-articles.store')] ]) 
                        @endcan
                        @can('publish', \App\Article::class)
                        @submit(['name'=>'_method', 'value'=>'post', 'class'=>'mr-2 btn-primary', 'text'=>'Publish', 'attrs'=>['formaction='.route('articles.store')] ]) 
                        @endcan
                    @endif
                    </div>
                @endform
			</div>
		</div>
	</div>
@endsection