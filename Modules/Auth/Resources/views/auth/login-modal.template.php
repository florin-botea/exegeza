<modal id="AuthModal">
    <tabs :tabs="['login' => 'Login', 'register' => 'Register']" value="login">
        <div slot="tab-pane">
            <l-form action="/login" method="post" class="p-3">
                <input name="form_id" value="login" hidden>
                <form-group type="email" label="Email" id="login-email" :value="old('email')" ></form-group>
                <form-group type="password" label="Password" id="login-password" :value="old('password')" ></form-group>
                <form-group type="checkbox" label="Remember me" id="remember-me" :value="old('remember_me', 0)"></form-group>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </l-form>
        </div>
        <div slot="tab-pane">
            <l-form action="/register" method="post" class="p-3">
                <input name="form_id" value="register" hidden>
                <form-group type="text" label="Name" id="register-name" :value="old('name')" ></form-group>
                <form-group type="email" label="Email" id="register-email" :value="old('email')" ></form-group>
                <form-group type="password" label="Password" id="register-password" :value="old('password')" ></form-group>
                <form-group type="password" label="Re-type password" id="register-password_confirmation" :value="old('password_confirmation')" ></form-group>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </l-form>
        </div>
    </tabs>
</modal>