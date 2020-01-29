<div class="modal fade show" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true">Login</a>
                    <a class="nav-item nav-link" id="register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">Register</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="modal-body">
                        @form(['action'=>'/login'])
                            <input name="_auth" value="login" hidden>
                            @text(['name'=>'email', 'label'=>'Email', 'value'=>old('email'), 'error'=>$errors->first('email')])
                            @text(['name'=>'password', 'label'=>'Password', 'value'=>old('password'), 'error'=>$errors->first('password')])
                            <div class="form-group">
                                <input type="checkbox" name="remember" id="rememberMe">
                                <label for="rememberMe">Remember me</label>
                            </div>
                            @submit(['class'=>'btn-primary', 'text'=>'Login'])
                        @endform
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="register-tab">
                    <div class="modal-body">
                        @form(['action'=>'/register'])
                            <input name="_auth" value="register" hidden>
                            @text(['name'=>'name', 'label'=>'Username'])
                            @text(['name'=>'email', 'label'=>'Email'])
                            @text(['name'=>'password', 'label'=>'Password'])
                            @text(['name'=>'password_confirmation', 'label'=>'Re-type password'])
                            @submit(['class'=>'btn-success', 'text'=>'Register'])
                        @endform
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>