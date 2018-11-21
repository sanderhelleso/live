<form id="settings-form-cont" class="column has-text-centered">
    <div class="columns animated fadeIn">
        <div class="field is-horizontal column">
            <div class="control has-icons-left">
                <input class="input is-rounded is-medium firstName-input" name="first_name" type="text" placeholder="First Name">
                <span class="icon is-small is-left">
                <i data-feather="user"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left">
                <input class="input is-rounded is-medium lastName-input" name="last_name" type="text" placeholder="Last Name">
                <span class="icon is-left">
                <i data-feather="users"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>
    </div>

    <div class="columns animated fadeIn">
        <div class="field is-horizontal column">
            <div class="control has-icons-left">
                <input class="input is-rounded is-medium email-input" name="email" type="email" placeholder="E-Mail">
                <span class="icon is-small is-left">
                <i data-feather="mail"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left">
                <input class="input is-rounded is-medium age-input" name="age" type="number" placeholder="Age">
                <span class="icon is-small is-left">
                <i data-feather="calendar"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>
    </div>

    <div class="columns animated fadeIn">
        <div class="field is-horizontal column select-field">
            <div class="control has-icons-left">
                <div class="select is-rounded is-medium">
                    <select id="select-country" name="country">
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
            <div class="control has-icons-left">
                <div class="select is-rounded is-medium">
                    <select id="select-state" name="state">
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

    <div class="columns animated fadeIn">
            <div class="field is-horizontal column">
                <div class="control has-icons-left">
                    <input class="input is-rounded is-medium address-input" name="street_address" type="text" placeholder="Street Address">
                    <span class="icon is-small is-left">
                    <i data-feather="flag"></i>
                    </span>
                    <p class="help is-danger has-text-left"></p>
                </div>
            </div>

            <div class="field is-horizontal column">
                <div class="control has-icons-left">
                    <input class="input is-rounded is-medium phone-input" name="phone_number" type="tlf" placeholder="Phone Number">
                    <span class="icon is-small is-left">
                    <i data-feather="phone"></i>
                    </span>
                    <p class="help is-danger has-text-left"></p>
                </div>
            </div>
        </div>

    <div class="columns animated fadeIn">
        <div class="field is-horizontal column">
            <div class="control has-icons-left">
                <input class="input is-rounded is-medium password-input" name="password" type="password" placeholder="New Password">
                <span class="icon is-left">
                <i data-feather="lock"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>

        <div class="field is-horizontal column">
            <div class="control has-icons-left">
                <input class="input is-rounded is-medium confirmPassword-input" name="password" type="password" placeholder="Confirm New Password">
                <span class="icon is-left">
                <i data-feather="unlock"></i>
                </span>
                <p class="help is-danger has-text-left"></p>
            </div>
        </div>
    </div>

    <div class="checkbox-cont">
        <label class="checkbox">
        <input type="checkbox" name="newsletter">
        Subscribe to our newsletter
        </label>
    </div>

    <div id="confirm-settings-col" class="columns level-left">
        <button id="settings-btn" class="button is-primary">Update Settings</button>
        <p>Current password must be confirmed in order to update password</p>
    </div>
</form>