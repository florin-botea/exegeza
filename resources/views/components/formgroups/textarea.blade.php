<div class="form-group {{ $class ?? '' }}">
	@isset ($label)
		<label for="{{ $id ?? $name ?? '' }}" class="">{{ $label }}</label>
	@endisset
	<textarea name="{{ $name ?? '' }}" class="form-control" id="{{ $id ?? $name ?? '' }}"
		placeholder="{{ $placeholder ?? '' }}"
		@foreach( ($attrs??[]) as $attr)
			{{$attr}}
		@endforeach
	>{{ $value ?? '' }}</textarea>
	@foreach ( ($helpers??[]) as $helper)
		<small>{{ $helper }}</small>
	@endforeach
	@isset ( $error )
		<p class="text-danger font-weight-bold validation-message">
			{{ $error }}
		</p>
	@endisset
</div>