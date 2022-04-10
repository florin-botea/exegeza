@php
    use \App\Helpers\Form;
@endphp
]
<div class="js-hasTabs modal" id="authModal" tabindex="-1">
    <div class="">
        <div role="tab-group" class="">
            <input type="radio" id="login-radio" name="login-modal" class="checked:next-hiddens-show" checked hidden>
            <div class="hidden" id="nav-login">
                <ul class="bg-gray-400 flex mb-4 pt-2">
                    <li> <label for="login-radio" class="mx-1 px-2 py-1 font-bold rounded-t-md text-lg bg-white"> Login </label> </li>
                    <li> <label for="register-radio" class="px-2 py-1 font-medium rounded-t-md bg-gray-200"> Register </label> </li>
                </ul>
                <form action="/login" method="post" class="prevent-multi-submit">
                    @csrf
                    <input name="_auth" value="login" hidden>
                    <input name="form_id" value="login" hidden>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label for="login-email" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Email
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="email" value="{{ Form::value('login','email') }}" id="login-email" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="email">
                            <p class="text-error">{{ Form::error('login','email') }}</p>
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label for="login-password" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Password
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="password" value="{{ Form::value('login','password') }}" id="login-password" class="bg-gray-200 border-gray-200 text-gray-700 focus:bg-white focus:border-purple-500" type="text">
                            <p class="text-error">{{ Form::error('login','password') }}</p>
                            <button type="submit" class="p-0 border-0 text-sm leading-none text-blue-500 hover:text-blue-300 focus:outline-none" style="background-color:initial"
                            formaction="{{ route('password.email') }}">
                                parola uitata?
                            </button>
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
                            <button class="bg-purple-800 hover:bg-purple-600 text-white font-bold rounded-md shadow-md hover:shadow-inset border-b-2 border-r-2 hover:border-0" type="submit">
                            Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div role="tab-group" class="">
            <input type="radio" id="register-radio" name="login-modal" class="checked:next-hiddens-show" hidden>
            <div class="hidden" id="nav-register">
                <ul class="bg-gray-400 flex mb-4 pt-2">
                    <li> <label for="login-radio" class="mx-1 px-2 py-1 rounded-t-md font-medium bg-gray-200"> Login </label> </li>
                    <li> <label for="register-radio" class="px-2 py-1 rounded-t-md font-bold text-lg bg-white"> Register </label> </li>
                </ul>
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
                            <button class="bg-green-600 hover:bg-green-400 text-white font-bold rounded-md shadow-md hover:shadow-inset border-b-2 border-r-2 hover:border-0" type="submit">
                            Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>