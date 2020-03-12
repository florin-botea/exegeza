@php
    use \App\Helpers\Form;
@endphp
]
<div class="js-hasTabs modal" id="authModal" tabindex="-1">
    <ul>
        <li><a class="" id="login-tab" href="#nav-login">Login</a></li>
        <li><a class="" id="register-tab" href="#nav-register">Register</a></li>
    </ul>
    <div class="" id="nav-login">
        <form action="/login" method="post" class="prevent-multi-submit">
            @csrf
            <input name="_auth" value="login" hidden>
            <input name="form_id" value="login" hidden>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="email" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="email" value="{{ Form::value('login','email') }}" id="email" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                    <p class="text-error">{{ Form::error('login','email') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="password" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password" value="{{ Form::value('login','password') }}" id="password" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                    <p class="text-error">{{ Form::error('login','password') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div role="distantier" class="md:w-1/3"></div>
                <label class="md:w-2/3 block text-gray-500 font-bold">
                    <input name="remember_me" {{ Form::checked('login','remember_me') }}  class="mr-2 leading-tight" type="checkbox">
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
            <input name="form_id" value="register" hidden>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="name" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Name
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="name" value="{{ Form::value('register','name') }}" id="name" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="text">
                    <p class="text-error">{{ Form::error('register','name') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="email" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="email" value="{{ Form::value('register','email') }}" id="email" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                    <p class="text-error">{{ Form::error('register','email') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="password" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password" value="{{ Form::value('register','password') }}" id="password" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="password">
                    <p class="text-error">{{ Form::error('register','password') }}</p>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="password_confirmation" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Re-type password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password_confirmation" value="{{ Form::value('register','password_confirmation') }}" id="password_confirmation" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="password">
                    <p class="text-error">{{ Form::error('register','password_confirmation') }}</p>
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