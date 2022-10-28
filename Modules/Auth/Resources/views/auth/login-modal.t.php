<modal id="AuthModal">
    <tabs :tabs="['login' => 'Login', 'register' => 'Register']" value="login">
        <div slot="tab-pane">
            <l-form action="/login" method="post" class="p-3">
                <input name="form_id" value="login" hidden>
                <form-group type="email" label="Email" id="login-email" name="email" :value="old('email')" :error="$errors->first('email')" ></form-group>
                <form-group type="password" label="Password" id="login-password" name="password" :value="old('password')" :error="$errors->first('password')" ></form-group>
                <form-group type="checkbox" label="Remember me" id="remember-me" name="remember_me" :value="old('remember_me', 0)"></form-group>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </l-form>
        </div>
        <div slot="tab-pane">
            <l-form action="/register" method="post" class="p-3">
                <input name="form_id" value="register" hidden>
                <form-group type="text" label="Name" id="register-name" name="name" :value="old('name')" :error="$errors->first('name')" ></form-group>
                <form-group type="email" label="Email" id="register-email" name="email" :value="old('email')" :error="$errors->first('email')" ></form-group>
                <form-group type="password" label="Password" id="register-password" name="password" :value="old('password')" :error="$errors->first('password')" ></form-group>
                <form-group type="password" label="Re-type password" id="register-password_confirmation" name="password_confirmation" :value="old('password_confirmation')" :error="$errors->first('password_confirmation')" ></form-group>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </l-form>
        </div>
    </tabs>
</modal>