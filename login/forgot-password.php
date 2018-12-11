<div class="modal animated fadeIn modal-forgot">
    <div class="modal-background animated fadeIn hide-modal"></div>
    <div class="modal-card animated fadeIn">
        <header class="modal-card-head">
            <p class="modal-card-title">Forgot Password</p>
            <button class="delete hide-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body has-text-centered">
            
            <div class="columns forgot-info-col">
                <div class="field column forgot-info">
                    <span><i data-feather="send"></i></span>
                    <p>If you forgot your password you can recieve instructions on how to reset your password send to your accounts registered E-Mail address.</p>
                    <br>
                </div>
            </div>

            <div class="columns is-centered enter-email">
                <div class="field column">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-rounded is-medium email-input" type="email" placeholder="E-Mail">
                        <span class="icon is-small is-left">
                        <i data-feather="mail"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>
            </div>

        </section>
        <footer class="modal-card-foot">
            <button class="button hide-modal">Cancel</button>
            <button id="send-forgot-password-email" class="button is-primary confirm">Send</button>
        </footer>
    </div>
</div>