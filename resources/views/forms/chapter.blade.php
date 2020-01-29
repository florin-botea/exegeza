@php
	$m = $model??['id'=>0];
	$id = $m['id'];
	$values = [
		'index' => old('id') == $id ? (old('index')) : $m['index']??'',
		'name' => old('id') == $id ? (old('name')) : $m['name']??'',
		'regex' => old('id') == $id ? (old('regex')) : '',
		'verses' => old('id') == $id ? (old('type')) : '',
		'add_verses' => old('id') == $id ? (old('add_verses')) : false,
	];
	$invalidErr = [
		'index' => old('id') == $id ? $errors->first('index') : null,
		'name' => old('id') == $id ? $errors->first('name') : null,
		'regex' => old('id') == $id ? $errors->first('regex') : null,
		'verses' => old('id') == $id ? $errors->first('verses') : null,
	];
@endphp

@form(['action'=>$action ])
	<div class="form-row align-items-center" id="form_{{$id}}">
		@isset($model_url)
			<div class="mx-2">
				<a href="{{ $model_url }}"><i class="fas fa-external-link-alt"></i></a>
			</div>
		@endisset
		@number(['name'=>'index', 'placeholder'=>'index', 'class'=>'col-md-2',
			'value'=> $values['index'],
			'error'=> $invalidErr['index']
		])
		@text(['name'=>'name', 'placeholder'=>'name', 'class'=>'col-md',
			'value'=> $values['name'],
			'error'=> $invalidErr['name']
		])
		<label for="_{{$id}}" class="m-0 align-self-start">Adauga si versete</label>
		<input type="checkbox" name="add_verses" id="_{{$id}}" class="mx-2 align-self-start checked:next-hidden-show" {{$values['add_verses'] ? 'checked' : ''}}>
		<div class="w-100 hidden">
			@text(['name'=>'regex', 'placeholder'=>'regex',
				'value'=> $values['regex'],
				'error'=> $invalidErr['regex']
			])
			@textarea(['name'=>'verses', 'placeholder'=>'verses', 'attrs'=>['rows=5'],
				'value'=> $values['verses'],
				'error'=> $invalidErr['verses']
			])
			<button type="button" class="preview-verses-insertion btn btn-secondary float-right" data-targetform="#form_{{$id}}">
				Previzualizeaza
			</button>
			<section class="previewForVerses" id="preview_verses_for_{{$id}}">
				
			</section>
		</div>
		@if(isset($model))
			@submit(['name'=>'_method', 'value'=>'put', 'class'=>'btn-success', 'formGroupClass'=>'align-self-start', 'text'=>'Update' ])
			@submit(['name'=>'_method', 'value'=>'delete', 'class'=>'ml-2 btn-danger', 'formGroupClass'=>'align-self-start', 'text'=>'Delete' ])
			@else
				@submit(['class'=>'ml-2 btn-primary', 'formGroupClass'=>'align-self-start', 'text'=>'Add'])
		@endif
	</div>
@endform