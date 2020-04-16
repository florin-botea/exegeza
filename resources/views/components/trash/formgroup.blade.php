@php
	$count_field = $count_field ?? false;
@endphp

@if ($type === 'text')
	<div class="form-group {{ $class ?? '' }}">
		<label for="{{ $id ?? $name ?? '' }}" class="">{{ $label ?? '' }}</label>
		<input name="{{ $name ?? '' }}" type="text" value="{{ $value ?? '' }}" class="form-control {{ $count_field ? 'countMe' : '' }} {{ $count_field ? 'data-count=count-'.($id ?? $name) : '' }} id="{{ $id ?? $name ?? '' }}"
			placeholder="{{ $placeholder ?? '' }}"
			
			@foreach( ($attrs??[]) as $attr => $val)
				{{$attr}}="{{$val}}"
			@endforeach
		>
		@foreach ( ($helpers??[]) as $helper)
			<small>{{ $helper }}</small>
		@endforeach
		@if ( $invalid??false )
			<p class="text-danger font-weight-bold validation-message">
				{{ $invalid }}
			</p>
		@endif
	</div>
	@elseif ($type === 'textarea')
	<div class="form-group {{ $class ?? '' }}">
		<label for="{{ $id ?? $name ?? '' }}" class="">{{ $label ?? '' }}</label>
		<textarea name="{{ $name ?? '' }}" class="form-control {{ $count_field ? 'countMe' : '' }} {{ $count_field ? 'data-count=count-'.($id ?? $name) : '' }}" id="{{ $id ?? $name ?? '' }}"
			placeholder="{{ $placeholder ?? '' }}"
			@foreach( ($attrs??[]) as $attr => $val)
				{{$attr}}="{{$val}}"
			@endforeach
		>{{ $value ?? '' }}</textarea>
		@foreach ( ($helpers??[]) as $helper)
			<small>{{ $helper }}</small>
		@endforeach
		@if ( $invalid??false )
			<p class="text-danger font-weight-bold validation-message">
				{{ $invalid }}
			</p>
		@endif
	</div>
	@elseif ($type === 'select')
		<div class="form-group {{ $class ?? '' }}">
			<label>{{ $label ?? '' }}</label>
			<select class="form-control" name="{{ $name ?? '' }}">
				@foreach($options??[] as $option => $val)
					<option value="{{$val}}" {{ $value==$val ? 'selected' : '' }}>{{ $option }}</option>
				@endforeach
			</select>
			@foreach ( ($helpers??[]) as $helper)
				<small>{{ $helper }}</small>
			@endforeach
			@if ( $invalid??false )
				<p class="text-danger font-weight-bold validation-message">
					{{ $invalid }}
				</p>
			@endif
		</div>
	@elseif ($type === 'checkbox')
		<div class="form-check {{$class ?? ''}}">
			<div class="custom-control custom-checkbox mr-sm-2">
				<input class="form-check-input" type="checkbox"  name="{{ $name ?? '' }}" value="{{ $value ?? '' }}" id="{{ $id ?? $name ?? '' }}" {{ ($checked??null) ? 'checked' : '' }}
				@foreach ($data??[] as $dk => $dv)
					data-{{$dk}}={{$dv}}
				@endforeach
				>
				<label class="form-check-label" for="{{ $id ?? $name ?? '' }}">{{$label ?? ''}}</label>
			</div>
		</div>
	@elseif ($type === 'number')
		<div class="form-group {{ $class ?? '' }}">
			<label for="{{ $id ?? $name ?? '' }}">{{ $label ?? '' }}</label>
			<input name="{{ $name ?? '' }}" type="number" value="{{ $value ?? '' }}" class="form-control" id="{{ $id ?? $name ?? '' }}" placeholder="{{ $placeholder ?? '' }}"
				@foreach( ($attrs??[]) as $attr => $val)
					{{$attr}}="{{$val}}"
				@endforeach
			>
			@foreach ( ($helpers??[]) as $helper)
				<small>{{ $helper }}</small>
			@endforeach
			@if ( $invalid??false )
				<p class="text-danger font-weight-bold validation-message">
					{{ $invalid }}
				</p>
			@endif
		</div>
	@elseif ($type === 'submit')
		<button class="btn {{ $class ?? '' }}" type="submit" name="submit" value="{{$value??''}}">
			<!--div class="spinner spinner-border spinner-border-sm text-light" role="status">
				<span class="sr-only">Loading...</span>
			</div-->
			<span class="">{{$text}}</span>
		</button>
@endif