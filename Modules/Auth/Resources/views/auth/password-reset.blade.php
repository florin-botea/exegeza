@extends('layouts.main')

@section('content')
    <div role="row" class="">
        <div class="">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input name="token" type="text" value="{{ $token }}" hidden>
                <div class="mb-4">
                    <input name="email" type="email" value="{{ request()->query('email') }}" disabled>
                    <input name="email" type="email" value="{{ request()->query('email') }}" hidden>
                    <p class="text-error">{{ $errors->first('email') }}</p>
                </div>
                <div class="mb-4">
                    <label for="" class="block"> Parola noua </label>
                    <input name="password">
                    <p class="text-error">{{ $errors->first('password') }}</p>
                </div>
                <div class="mb-4">
                    <label for="" class="block"> Parola noua (confirmare) </label>
                    <input name="password_confirmation">
                    <p class="text-error">{{ $errors->first('password_confirmation') }}</p>
                </div>
                <div class="">
                    <button type="submit"> Change password </button>
                </div>
            </form>
        </div>
    </div>
@endsection