@php
    $login_form = new \App\Helpers\Form('login_form');
    $register_form = new \App\Helpers\Form('register_form');
@endphp

<div class="js-hasTabs" id="authModal" tabindex="-1">
    <ul>
        <li><a class="" id="login-tab" href="#nav-login">Login</a></li>
        <li><a class="" id="register-tab" href="#nav-register">Register</a></li>
    </ul>
    <div class="" id="nav-login">
        <form action="/login" method="post" class="prevent-multi-submit">
            @csrf
            <input name="_auth" value="login" hidden>
            <input name="form_id" value="login_form" hidden>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="email" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="email" value="{{ $login_form->value('email') }}" id="email" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                    <p class="text-error">{{ $login_form->error('email') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="password" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password" value="{{ $login_form->value('password') }}" id="password" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                    <p class="text-error">{{ $login_form->error('password') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div role="distantier" class="md:w-1/3"></div>
                <label class="md:w-2/3 block text-gray-500 font-bold">
                    <input name="remember_me" {{ $login_form->value('remember_me') ? 'checked' : '' }}  class="mr-2 leading-tight" type="checkbox">
                    <span class="text-sm">
                    Remember me
                    </span>
                </label>
            </div>

            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button class="bg-purple-800 hover:bg-purple-600 text-white" type="submit">
                    Login
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="" id="nav-register">
        <form action="/register" method="post" class="prevent-multi-submit">
            @csrf
            <input name="_auth" value="register" hidden>
            <input name="form_id" value="register_form" hidden>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="name" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Name
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="name" id="name" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="text">
                    <p class="text-error">{{ $register_form->error('name') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="email" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="email" id="email" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                    <p class="text-error">{{ $register_form->error('email') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="password" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password" id="password" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="password">
                    <p class="text-error">{{ $register_form->error('password') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="password_confirmation" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Re-type password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password_confirmation" id="password_confirmation" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="password">
                    <p class="text-error">{{ $register_form->error('password_confirmation') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button class="bg-green-600 hover:bg-green-400 text-white" type="submit">
                    Register
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>