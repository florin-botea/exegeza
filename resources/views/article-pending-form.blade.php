@extends('layouts.main')

@php
    $scripts = ['ckeditor-classic.js'];
    $m = $article ?? [];
@endphp

@section('content')
	<div class="row">
		<div class="col">
			@include('components.faded-verses', ['bible'=>$bible])
			<hr>
			<div class="">
                @isset($article)
                @else
                <h1>Adauga un articol</h1>
                @endisset
                <article>
                    @form(['action'=> (isset($article) ? route('pending-articles.update', $article->id) : route('pending-articles.store')) ])
                        <input type="text" name="bible_version_id" value="{{$bible->id}}">
                        <input type="text" name="book_index" value="{{$bible->book->index}}">
                        @if ($bible->book->chapter)
                            <input type="text" name="chapter_index" value="{{$bible->book->chapter->index}}">
                        @endif
                        @text(['name'=>'title', 'label'=>'Title', 'value'=>old('title')??$m['title']??'', 'error'=>$errors->first('title')])
                        <div class="form-group">
                            <textarea class="ckeditor-classic" name="content" hidden>{{old('content') ?? $m['content'] ?? ''}}</textarea>
                        </div>
                        <hr>
                        @text(['name'=>'tags', 'label'=>'Tags:', 'inputClass'=>'tagify-input', 'data'=>['endpoint'=>'/api/tags'],
                            'value' => old('tags') ?? json_encode($m['tags'] ?? ''),
                            'error' => $errors->first('tags')
                        ])

                        @if(isset($article))
                            @can('update', $article)
                                @submit(['name'=>'_method', 'value'=>'put', 'class'=>'btn-success', 'text'=>'Update' ])
                            @endcan
                            @can('delete', $article)
                                @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'ml-2 btn-danger', 'text'=>'Delete' ])
                            @endcan
                        @else
                            @submit(['name'=>'_method', 'value'=>'post', 'class'=>'btn-primary', 'text'=>'Post'])
                        @endif
                    @endform
                </article>
			</div>
		</div>
	</div>
@endsection