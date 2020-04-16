@php
    $bible = $bible ?? new \App\BibleVersion();
    $bible->index = $bible->index ?? $next_index ?? 1;
    $bible->language = $bible->language ? $bible->language->value : null;
    $form = new \App\Helpers\Form('bible', $bible);
@endphp
<div class="modal" id="{{ $as }}" tabindex="-1">
    <form method="POST">
        @csrf
        <p>{{ $bible['id'] ? 'Edit version' : 'Add version' }}</p>
        <input name="form_id" value="bible" hidden>
        
        <div class="mb-2">
            <label for="{{$as}}-index" class="block text-gray-600"> Index </label>
            <input name="index" value="{{ $form->value('index') }}" id="{{$as}}-index" type="number">
            <p class="text-error">{{ $errors->bible->first('index') }}</p>
        </div>

        <div class="mb-2">
            <label for="{{$as}}-name" class="block text-gray-600"> Name </label>
            <input name="name" value="{{ $form->value('name') }}" id="{{$as}}-name" type="text">
            <p class="text-error">{{ $errors->bible->first('name') }}</p>
        </div>

        <div class="mb-2">
            <label for="{{$as}}-alias" class="block text-gray-600"> Alias </label>
            <input name="alias" value="{{ $form->value('alias') }}" id="{{$as}}-alias" type="text">
            <p class="text-error">{{ $errors->bible->first('alias') }}</p>
        </div>

        <div class="mb-2">
            <label for="{{$as}}-language" class="block text-gray-600"> Language </label>
            <input name="language" value="{{ $form->value('language') }}" id="{{$as}}-language" type="text">
            <p class="text-error">{{ $errors->bible->first('language') }}</p>
        </div>

        <div class="mb-2 flex justify-end">
            <input name="public" value="1" {{ $form->value('public') ? 'checked' : null }} id="{{$as}}-public" class="self-center" type="checkbox">
            <label for="{{$as}}-public" class="text-gray-600"> Public </label>
        </div>

        <div class="flex justify-end">
            @isset ($bible['id'])
                <button name="_method" value="delete" formaction="{{ route('bible-versions.destroy', [$bible->id]) }}" type="submit"> Delete </button>
                <button name="_method" value="put" formaction="{{ route('bible-versions.update', [$bible->id]) }}" type="submit"> Update </button>
                @else
                    <button name="_method" value="post" formaction="{{ route('bible-versions.store') }}" type="submit"> Add </button>
            @endisset
        </div>
    </form>
</div>