<div class="form-group {{$class ?? ''}}">
	<div class="custom-control custom-checkbox">
		<input class="form-check-input {{$inputClass??''}}" type="checkbox"  name="{{ $name ?? '' }}" value="1" id="{{ $id??$name??'' }}" {{ ($checked??false) ? 'checked' : ''	}}
			@foreach($attrs??[] as $attr)
				{{$attr}}
			@endforeach
		>
	@isset($label)
		<label for="{{ $id ?? $name ?? '' }}">{{ $label }}</label>
	@endisset
	</div>
</div>