@php
	$m = $model??['id'=>0];
	$id = $m['id'];
	$values = [
		'index' => old('id') == $id ? (old('index')) : $m['index']??'',
		'name' => old('id') == $id ? (old('name')) : $m['name']??'',
		'alias' => old('id') == $id ? (old('alias')) : $m['alias']??'',
		'type' => old('id') == $id ? (old('type')) : $m['type']??'',
	];
	$invalidErr = [
		'index' => old('id') == $id ? $errors->first('index') : null,
		'name' => old('id') == $id ? $errors->first('name') : null,
		'alias' => old('id') == $id ? $errors->first('alias') : null,
		'type' => old('id') == $id ? $errors->first('type') : null,
	];
@endphp

@form(['action'=>$action??'#'])
	<div class="form-row">
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
		@text(['name'=>'alias', 'placeholder'=>'alias', 'class'=>'col-md',
			'value'=> $values['alias'],
			'error'=> $invalidErr['alias']
		])
		@select(['name'=>'type', 'name'=>'type', 'class'=>'col-md-2', 'options'=>['tip'=>null, 'VT'=>'vt', 'NT'=>'nt', 'altele'=>'altele'], 
			'value'=> $values['type'],
			'error'=> $invalidErr['type']
		])
		@if(isset($model))
			@submit(['name'=>'_method', 'value'=>'put', 'class'=>'btn-success', 'text'=>'Update' ])
			@submit(['name'=>'_method', 'value'=>'delete', 'class'=>'ml-2 btn-danger', 'text'=>'Delete' ])
			@else
				@submit(['class'=>'ml-2 btn-primary', 'text'=>'Add'])
		@endif
	</div>
@endform