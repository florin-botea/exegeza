@extends('layouts.main')

@php
    $scripts = ['ckeditor-classic.js'];
@endphp

@section('content')
    @form(['action'=>route('users.update', $user->id), 'attrs'=>['enctype=multipart/form-data']])
        {{ json_encode($errors->all()) }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="upload-profile-photo">
                        <img src="{{ $user->details && $user->details->photo ? asset($user->details->photo) : '/assets/default-user-image.png' }}" class="" id="preview">
                    </label>
                    <br>
                    <input id="upload-profile-photo" type="file" name="photo" class="upload-on-change" data-progress_bar="#progressBar" data-url="foo" data-preview="#preview">
                    <p class="text-danger font-weight-bold validation-message">
                        {{ $errors->first('photo') }}
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                @text(['name'=>'name', 'label'=>'Full name', 'value'=>old('name')??$user->name])
                @text(['name'=>'email', 'label'=>'Email', 'value'=>old('email')??$user->email])
                @text(['name'=>'age', 'label'=>'Age', 'value'=>old('age')??$user->age])
                @textarea(['name'=>'bio', 'label'=>'Bio', 'value'=>old('bio')??($user->details ? $user->details->bio : null)])
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <textarea class="ckeditor-classic" name="content" hidden>{{ old('content')??($user->details && $user->details->description ? $user->details->description->content : null) }}</textarea>
                </div>
            </div>
        </div>

        @submit(['name'=>'_method', 'value'=>'put', 'class'=>'mr-2 btn-primary', 'text'=>'Update']) 
    @endform
@endsection