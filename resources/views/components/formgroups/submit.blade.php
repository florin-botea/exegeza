<div class="form-group {{$formGroupClass??''}}">
	<button class="single-submit-btn btn {{ $class ?? '' }}" name="{{$name??''}}" value="{{$value??''}}" type="submit"
	@foreach ($attrs??[] as $key)
		{{ $key }}
	@endforeach
	>
		<div class="spinner spinner-border spinner-border-sm text-light" role="status">
			<span class="sr-only">Loading...</span>
		</div>
		<span class="">{{$text}}</span>
	</button>
</div>