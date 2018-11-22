<div class="modal animated fadeIn modal-delete">
    <div class="modal-background animated fadeIn hide-modal"></div>
    <div class="modal-card animated fadeIn">
        <header class="modal-card-head">
            <p class="modal-card-title">Delete Account</p>
            <button class="delete hide-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body has-text-centered">
            
            <div class="columns">
                <div class="field column delete-info">
                    <span><i data-feather="alert-triangle"></i></span>
                    <p>Deleting your account is permanent and will clear all data personally releated to this account.</p>
                    <br>
                    <h5>Ths action is NOT reversible</h5>
                </div>
            </div>
            <div class="columns is-centered enter-current-password">
                <div class="field column">
                    <div class="control has-icons-left">
                        <input class="input is-rounded is-medium currentPassword-input" name="password" type="password" placeholder="Enter Password">
                        <span class="icon is-left">
                        <i data-feather="check-circle"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>
            </div>

        </section>
        <footer class="modal-card-foot">
            <button class="button hide-modal">Back to Safety</button>
            <button id="confirm-delete-account" class="button is-danger confirm">Confirm and Delete</button>
        </footer>
    </div>
</div>