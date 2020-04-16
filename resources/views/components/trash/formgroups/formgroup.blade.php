<div class="form-group {{ $class ?? '' }}">
	<label for="{{ $id ?? $name ?? '' }}">{{ $label ?? '' }}</label>
	{{$slot}}
	@foreach ( ($helpers??[]) as $helper)
		<small>{{ $helper }}</small>
	@endforeach
	@if ( isset($name) && old('_form_id') == $form_id && $errors->first($name) )
		<p class="text-danger font-weight-bold validation-message">
			{{ $errors->first($name) }}
		</p>
	@endif
</div>