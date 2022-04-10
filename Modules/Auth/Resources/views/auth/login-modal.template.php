<modal id="AuthModal">
    <tabs :tabs="['login' => 'Login', 'register' => 'Register']">
        <div slot="tab-pane">
            <csrf-form action="/login" method="post" class="p-3">
                <input name="form_id" value="login" hidden>
                <form-group type="email" label="Email" id="login-email" :value="old('email')" ></form-group>
                <form-group type="password" label="Password" id="login-password" :value="old('password')" ></form-group>
                <form-group type="checkbox" id="remember-me" :options="['remember_me' => 'Remember me']" :values="[old('remember_me') ? 'remember_me' : '']"></form-group>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </csrf-form>
        </div>
        <div slot="tab-pane">
            <csrf-form action="/register" method="post" class="p-3">
                <input name="form_id" value="register" hidden>
                <form-group type="text" label="Name" id="register-name" :value="old('name')" ></form-group>
                <form-group type="email" label="Email" id="register-email" :value="old('email')" ></form-group>
                <form-group type="password" label="Password" id="register-password" :value="old('password')" ></form-group>
                <form-group type="password" label="Re-type password" id="register-password_confirmation" :value="old('password_confirmation')" ></form-group>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </csrf-form>
        </div>
    </tabs>
</modal>