<form id="login-form-cont">
    <div class="field">
        <div class="control has-icons-left has-icons-right">
            <input class="input is-rounded is-medium login-input" type="email" placeholder="E-Mail">
            <span class="icon is-small is-left">
            <i data-feather="mail"></i>
            </span>
        </div>
        <p class="help email-help is-danger has-text-left"></p>
    </div>

    <div class="field">
        <div class="control has-icons-left has-icons-right">
            <input class="input is-rounded is-medium login-input" type="password" placeholder="Password">
            <span class="icon is-left">
            <i data-feather="lock"></i>
            </span>
        </div>
        <p class="help password-help is-danger has-text-left"></p>
    </div>
    <div class="control has-text-centered is-medium">
        <button id="login-btn" class="button is-primary">Log In</button>
    </div>
    <div class="checkbox-cont field">
        <input type="checkbox" class="is-checkradio" id="remember-me-checkbox" checked="checked">
        <label class="checkbox" for="remember-me-checkbox"><span>Remember me</span></label>
    </div>
    <a id="forgot-password">Forgot password?</a>
    <span class="login-options">or</span>
    <a href="/signup">Dont have an account yet?</a>
</form>