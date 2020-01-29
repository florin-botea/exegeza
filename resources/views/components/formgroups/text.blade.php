<div class="form-group {{ $class ?? '' }}">
	@isset($label)
		<label for="{{ $id ?? $name ?? '' }}">{{ $label }}</label>
	@endisset
	<input name="{{ $name ?? '' }}" type="text" value="{{ $value??null }}" class="form-control {{ $inputClass??'' }}" id="{{ $id ?? $name ?? '' }}"
		placeholder="{{ $placeholder ?? '' }}"
		@foreach( ($attrs??[]) as $attr)
			{{ $attr }}
		@endforeach
		@foreach( ($data??[]) as $key => $value)
			{{ 'data-'.$key.'='.$value }}
		@endforeach
	>
	@foreach ( ($helpers??[]) as $helper)
		<small>{{ $helper }}</small>
	@endforeach
	@isset ( $error )
		<p class="text-danger font-weight-bold validation-message">
			{{ $error }}
		</p>
	@endisset
</div>