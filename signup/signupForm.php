<form id="signup-form-cont">
    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium firstName-input" type="text" placeholder="First Name">
                <span class="icon is-small is-left">
                <i data-feather="user"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium lastName-input" type="text" placeholder="Last Name">
                <span class="icon is-left">
                <i data-feather="users"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium email-input" type="email" placeholder="E-Mail">
                <span class="icon is-small is-left">
                <i data-feather="mail"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium age-input" type="number" placeholder="Age">
                <span class="icon is-small is-left">
                <i data-feather="calendar"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="field is-horizontal column select-field">
            <div class="control has-icons-left has-icons-right">
                <div class="select is-rounded is-medium">
                    <select id="select-country">
                        <option disabled>Select Country</option>
                    </select>
                    <p class="help is-danger has-text-left"></p>
                </div>
                <span class="icon is-left">
                <i data-feather="map"></i>
                </span>
            </div>
        </div>

        <div class="field is-horizontal column select-field">
            <div class="control has-icons-left has-icons-right">
                <div class="select is-rounded is-medium">
                    <select id="select-state">
                        <option disabled>Select State</option>
                    </select>
                    <p class="help is-danger has-text-left"></p>
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
                    <input class="input is-rounded is-medium address-input" type="text" placeholder="Street Address">
                    <span class="icon is-small is-left">
                    <i data-feather="flag"></i>
                    </span>
                    <p class="help is-danger has-text-left"></p>
                </div>
            </div>

            <div class="field is-horizontal column">
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-rounded is-medium phone-input" type="tlf" placeholder="Phone Number">
                    <span class="icon is-small is-left">
                    <i data-feather="phone"></i>
                    </span>
                    <p class="help is-danger has-text-left"></p>
                </div>
            </div>
        </div>

    <div class="columns">
        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium password-input" type="password" placeholder="Password">
                <span class="icon is-left">
                <i data-feather="lock"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left has-icons-right">
                <input class="input is-rounded is-medium confirmPassword-input" type="password" placeholder="Confirm Password">
                <span class="icon is-left">
                <i data-feather="unlock"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
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