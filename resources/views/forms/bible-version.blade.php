@php
	$m = $model??['id'=>0];
	$id = $m['id'];
	$values = [
		'index' => old('id') == $id ? (old('index')) : $m['index']??'',
		'name' => old('id') == $id ? (old('name')) : $m['name']??'',
		'alias' => old('id') == $id ? (old('alias')) : $m['alias']??'',
		'lang' => old('id') == $id ? (old('lang')) : ($m['language'] ? $m['language']['language'] : ''),
		'public' => old('id') == $id ? (old('public')) : $m['public']??'',
	];
	$invalidErr = [
		'index' => old('id') == $id ? $errors->first('index') : null,
		'name' => old('id') == $id ? $errors->first('name') : null,
		'alias' => old('id') == $id ? $errors->first('alias') : null,
		'lang' => old('id') == $id ? $errors->first('lang') : null,
	];
@endphp

@form(['action'=>$action??'#'])
	<div class="form-row">
		@isset($model)
			<div class="mx-2">
				<a href="{{ route('bible-versions.books.index', [$model->slug]) }}"><i class="fas fa-external-link-alt"></i></a>
			</div>
		@endisset
		<input name="id" value="{{$id}}" type="hidden">
		@number(['name'=>"index", 'placeholder'=>'index', 'class'=>'col-md-2', 
			'value'=> $values['index'],
			'error'=> $invalidErr['index']
		])
		@text(['name'=>"name", 'placeholder'=>'name', 'class'=>'col-md',
			'value'=> $values['name'],
			'error'=> $invalidErr['name']
		])
		@text(['name'=>"alias", 'placeholder'=>'alias', 'class'=>'col-md',
			'value'=> $values['alias'],
			'error'=> $invalidErr['alias']
		])
		@text(['name'=>"lang", 'placeholder'=>'language', 'class'=>'col-md', 'inputClass'=>'autocomplete-input', 'attrs'=>["data-endpoint=/languages"],
			'value'=> $values['lang'],
			'error'=> $invalidErr['lang']
		])
		@checkbox(['name'=>"public", 'label'=>'public', 'class'=>'col-auto my-1',
			'id' => '_'.$id,
			'checked'=> $values['public'],
		])
		@if(isset($model))
			@submit(['name'=>'_method', 'value'=>'put', 'class'=>'btn-success', 'text'=>'Update' ])
			@submit(['name'=>'_method', 'value'=>'delete', 'class'=>'ml-2 btn-danger', 'text'=>'Delete' ])
			@else
				@submit(['class'=>'ml-2 btn-primary', 'text'=>'Add'])
		@endif
	</div>
@endform