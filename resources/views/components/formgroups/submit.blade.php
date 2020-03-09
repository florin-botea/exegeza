<div class="form-group {{$class??''}}">
	<button class="single-submit-btn btn" name="{{$name??''}}" value="{{$value??''}}" type="submit"
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