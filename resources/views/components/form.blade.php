<form class="prevent-multi-submit {{ $class ?? '' }}" action="{{ $action ?? '#' }}" method="post" 
	@foreach (($attrs??[]) as $attr)
		{{ $attr }}
	@endforeach
>
	@csrf
	{{ $slot }}
</form>