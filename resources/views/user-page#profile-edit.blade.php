@extends('user-page')

@php
    use \App\Helpers\Form;

    $scripts = ['ckeditor-classic.js'];
@endphp

@section('tab')
<main class="p-4">
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input name="form_id" value="user" hidden>
        <div class="flex flex-wrap mb-4">
            <div class="w-1/3">
                <div class="">
                    <label for="upload-profile-photo">
                        <img src="{{ $user->getPhotoUrl() }}" class="" id="preview">
                    </label>
                    <br>
                    <input id="upload-profile-photo" type="file" name="photo" class="upload-on-change input-w-full" data-progress_bar="#progressBar" data-url="foo" data-preview="#preview">
                    <p class="text-danger font-weight-bold validation-message">
                        {{ $errors->first('photo') }}
                    </p>
                </div>
            </div>
            <div class="w-2/3 px-4 flex flex-col">
                <div class="mb-2">
                    <label for="name" class="label-base"> Name </label>
                    <input name="name" value="{{ Form::value('user','name',$user->name) }}" class="input-base" id="name" type="text">
                    <p class="text-error">{{ Form::error('user', 'name') }}</p>
                </div>
                <div class="mb-2">
                    <label for="email" class="label-base"> Email </label>
                    <input name="email" value="{{ Form::value('user','email',$user->email) }}" class="input-base" id="email" type="email">
                    <p class="text-error">{{ Form::error('user', 'name') }}</p>
                </div>
                <div class="flex-1 flex flex-col">
                    <label for="bio" class="label-base"> Bio </label>
                    <textarea name="bio" class="input-base flex-1" id="bio">{{ Form::value('user','bio',$user->getBio()) }}</textarea>
                    <p class="text-error">{{ Form::error('user', 'bio') }}</p>
                </div>
            </div>
        </div>

        <div class="w-full">
            <label class="label-base"> From user </label>
            <textarea class="ckeditor-classic" name="content" id="content" hidden>{{ Form::value('user','content',$user->getDescription()) }}</textarea>
        </div>

        <div class="w-full flex justify-end py-2">
            <button type="submit" class="rounded px-2 py-1 font-bold text-white hover:text-black bg-green-600 hover:bg-green-400"> Update </button>
        </div>
    </form>
</main>
@endsection