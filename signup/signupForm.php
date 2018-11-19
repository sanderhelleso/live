<form id="signup-form-cont">
    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium firstName-input" type="text" placeholder="First Name">
                <span class="icon is-small is-left">
                <i data-feather="user"></i>
                </span>
            </div>
            <p class="help email-help is-danger has-text-left"></p>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium lastName-input" type="text" placeholder="Last Name">
                <span class="icon is-left">
                <i data-feather="users"></i>
                </span>
            </div>
            <p class="help password-help is-danger has-text-left"></p>
        </div>
    </div>

    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium login-input" type="email" placeholder="E-Mail">
                <span class="icon is-small is-left">
                <i data-feather="mail"></i>
                </span>
            </div>
            <p class="help email-help is-danger has-text-left"></p>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium login-input" type="number" placeholder="Age">
                <span class="icon is-small is-left">
                <i data-feather="calendar"></i>
                </span>
            </div>
            <p class="help email-help is-danger has-text-left"></p>
        </div>
    </div>

    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <div class="select is-rounded is-medium">
                    <select>
                        <option>Country</option>
                        <option>With options</option>
                    </select>
                </div>
                <span class="icon is-left">
                <i data-feather="map"></i>
                </span>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <div class="select is-rounded is-medium">
                    <select>
                        <option>State</option>
                        <option>With options</option>
                    </select>
                </div>
                <span class="icon is-left">
                <i data-feather="map-pin"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="columns">
            <div class="field is-horizontal column">
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-rounded is-medium street-input" type="text" placeholder="Street Address">
                    <span class="icon is-small is-left">
                    <i data-feather="mail"></i>
                    </span>
                </div>
                <p class="help email-help is-danger has-text-left"></p>
            </div>

            <div class="field is-horizontal column">
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-rounded is-medium phone-input" type="tlf" placeholder="Phone Number">
                    <span class="icon is-small is-left">
                    <i data-feather="phone"></i>
                    </span>
                </div>
                <p class="help email-help is-danger has-text-left"></p>
            </div>
        </div>

    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium password-input" type="password" placeholder="Password">
                <span class="icon is-left">
                <i data-feather="lock"></i>
                </span>
            </div>
            <p class="help password-help is-danger has-text-left"></p>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium confirmPassword-input" type="password" placeholder="Confirm Password">
                <span class="icon is-left">
                <i data-feather="unlock"></i>
                </span>
            </div>
            <p class="help password-help is-danger has-text-left"></p>
        </div>
    </div>

    <div class="control has-text-centered is-medium">
        <button id="signup-btn" class="button is-primary is-disabled">Sign Up And Create Account</button>
    </div>
    <div class="checkbox-cont">
        <label class="checkbox">
        <input type="checkbox">
        Subscribe to our newsletter
        </label>
    </div>
    <a href="/login/login.php">Allready have an account?</a>
</form>