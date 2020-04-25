@extends('user-page')

@section('tab')
<main class="p-4">
    <form action="{{ route('users.change-password', [$user->id]) }}" method="POST" class="inline-block">
        <input name="password" type="password" id="password" class="h-0 w-0 border-0 m-0 p-0">
        <input name="current_password" type="password" id="password" class="h-0 w-0 border-0 m-0 p-0">
        <h2 class="font-bold text-lg"> Change password </h2>
        @csrf
        @method('put')
        <div class="">
            <label for="" class="block"> Parola actuala </label>
            <input name="current_password" type="password">
            <p class="text-error">{{ $errors->first('current_password') }}</p>
        </div>
        <hr class="my-2">
        <div class="">
            <label for="" class="block"> Parola noua </label>
            <input name="new_password" type="password">
            <p class="text-error">{{ $errors->first('new_password') }}</p>
        </div>
        <div class="mb-4">
            <label for="" class="block"> Parola noua (confirmare) </label>
            <input name="new_confirm_password" type="password">
            <p class="text-error">{{ $errors->first('new_confirm_password') }}</p>
        </div>
        <div class="">
            <button class=""> Change password </button>
        </div>
    </form>
    <hr class="my-4">
    <div class="flex flex-wrap">
        @if (!$user->deletionRequest)
            <div class="w-full sm:w-auto">
                <form action="{{ route('users.destroy', [$user->id]) }}" method="POST" class="">
                    <input name="password" type="password" class="h-0 w-0 border-0 m-0 p-0">
                    <h2 class="font-bold text-lg"> Delete account </h2>
                    @csrf
                    @method('delete')
                    <div class="mb-4">
                        <label for="" class="block"> Parola </label>
                        <input name="password" type="password">
                        <p class="text-error">{{ $errors->first('password') }}</p>
                    </div>
                    <div class="">
                        <button class=""> Stergere </button>
                    </div>
                </form>
            </div>
            <div class="w-32 hidden sm:block"></div>
            <div class="sm:px-4 w-full sm:w-auto">
                info about delete
            </div>

            @else
            <form action="{{ route('users.abort-destroy', [$user->id]) }}" method="POST">
                @csrf
                @method('delete')
                <p class="text-red-400">
                    S-a solicitat stergerea acestui cont. Ca urmare, bla bla
                </p>
                <button type="submit"> Anulare stergere </button>
            </form>
        @endif
    </div>

</main>
@endsection