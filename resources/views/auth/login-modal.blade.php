<div class="js-hasTabs" id="authModal" tabindex="-1">
    <ul>
        <li><a class="" id="login-tab" href="#nav-login">Login</a></li>
        <li><a class="" id="register-tab" href="#nav-register">Register</a></li>
    </ul>
    <div class="" id="nav-login">
        @form(['action'=>'/login', 'class'=>'w-full max-w-sm'])
            <input name="_auth" value="login" hidden>
            @text(['name'=>'email', 'label'=>'Email', 'value'=>old('email'), 'error'=>$errors->first('email')])
            @text(['name'=>'password', 'label'=>'Password', 'value'=>old('password'), 'error'=>$errors->first('password')])
            <div class="form-group">
                <label></label>
                <div class="w-full flex">
                    <input name="remember" id="rememberMe" class="mr-2 leading-tight" type="checkbox">
                    <label for="rememberMe" class="text-sm" style="width:100%; text-align: left;">Remember me</label>
                </div>
            </div>
            <div class="form-group">
                <label></label>
                @submit(['class'=>'submit login w-full', 'text'=>'Login'])
            </div>
        @endform
    </div>
    <div class="" id="nav-register">
        @form(['action'=>'/register'])
            <input name="_auth" value="register" hidden>
            @text(['name'=>'name', 'label'=>'Username'])
            @text(['name'=>'email', 'label'=>'Email'])
            @text(['name'=>'password', 'label'=>'Password'])
            @text(['name'=>'password_confirmation', 'label'=>'Re-type password'])
            <div class="form-group">
                <label></label>
                @submit(['class'=>'submit register', 'text'=>'Register'])
            </div>
        @endform
    </div>
</div>