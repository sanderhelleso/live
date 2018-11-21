<div class="modal animated fadeIn">
    <div class="modal-background animated fadeIn hide-modal"></div>
    <div class="modal-card animated fadeInUp">
        <header class="modal-card-head">
            <p class="modal-card-title">Change Password</p>
            <button class="delete hide-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body has-text-centered">

            <div class="columns is-centered">
                <div class="field column">
                    <div class="control has-icons-left">
                        <input class="input is-rounded is-medium password-input" name="password" type="password" placeholder="New Password">
                        <span class="icon is-left">
                        <i data-feather="lock"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="field column">
                    <div class="control has-icons-left">
                        <input class="input is-rounded is-medium confirmPassword-input" name="password" type="password" placeholder="Confirm New Password">
                        <span class="icon is-left">
                        <i data-feather="unlock"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>
            </div>

            <div class="columns is-centered enter-current-password">
                <div class="field column">
                    <div class="control has-icons-left">
                        <input class="input is-rounded is-medium confirmPassword-input" name="password" type="password" placeholder="Enter Password">
                        <span class="icon is-left">
                        <i data-feather="check-circle"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>
            </div>

        </section>
        <footer class="modal-card-foot">
            <button class="button hide-modal">Cancel</button>
            <button class="button is-primary">Update Password</button>
        </footer>
    </div>
</div>