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
                @form(['action'=>route('articles.update', $article->id)])
                    <input name="bible_version_id" value="{{ $article->bible_version_id }}" hidden>
                    <input name="book_index" value="{{ $article->book_index }}" hidden>
                    <input name="chapter_index" value="{{ $article->chapter_index }}" hidden>
                    @text(['name'=>'meta', 'label'=>'Meta:',
                        'value' => old('meta') ?? $m['meta'] ?? '',
                        'error' => $errors->first('meta')
                    ])
                    @text(['name'=>'title', 'label'=>'Title:',
                        'value' => old('title') ?? $m['title'] ?? '',
                        'error' => $errors->first('title')
                    ])
                    @textarea(['name'=>'sample', 'label'=>'Sample:',
                        'value' => old('sample') ?? $m['sample'] ?? '',
                        'error' => $errors->first('sample')
                    ])
                    <div class="form-group">
                        <textarea class="ckeditor-classic" name="content" hidden>{{old('content') ?? $m['content'] ?? ''}}</textarea>
                    </div>
                    <hr>
                    @text(['name'=>'tags', 'label'=>'Tags:', 'inputClass'=>'tagify-input', 'data'=>['endpoint'=>'/api/tags'],
                        'value' => old('tags') ?? json_encode($m['tags'] ?? ''),
                        'error' => $errors->first('tags')
                    ])
                    @text(['name'=>'lang', 'label'=>'Language:', 'inputClass'=>'autocomplete-input', 'data'=>['endpoint'=>'/api/languages'],
                        'value' => old('lang') ?? ( ($m['lang']??['language'=>null])['language'] ?? '' ),
                        'error' => $errors->first('language')
                    ])

                    <div class="d-flex justify-content-end">
                        @submit(['name'=>'_method', 'value'=>'delete', 'class'=>'mr-2 btn-danger', 'text'=>'Delete' ])
                        @submit(['name'=>'_method', 'value'=>'put', 'class'=>'btn-success', 'text'=>'Publish' ])
                    </div>
                @endform
			</div>
		</div>
	</div>
@endsection