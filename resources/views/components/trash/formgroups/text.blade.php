@php
	$count = $count??false;
@endphp

<div class="form-group {{ $class ?? '' }} {{$count ? 'count-input' : ''}}">
	@isset($label)
		<label class="font-semibold" for="{{ $id ?? $name ?? '' }}">{{ $label }}</label>
	@endisset
	@if($count)
		<div class="relative" style="height:0">
			<div class="input-char-count absolute text-sm" style="right:0px;"></div>
		</div>
	@endif
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
