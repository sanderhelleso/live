<div class="modal animated fadeIn modal-contact">
    <div class="modal-background animated fadeIn hide-modal"></div>
    <div class="modal-card animated fadeIn">
        <header class="modal-card-head">
            <p class="modal-card-title">Get In Touch</p>
            <button class="delete hide-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body has-text-centered">
            <figure class="image is-128x128">
                <img id="contact-img" class="is-rounded">
            </figure>
            <h2 id="contact-heading"></h2>
            <p id="contact-intro"></p>
            <div id="modal-border"></div>
            <div class="columns">
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="child-care-contact" disabled="true">
                    <label class="checkbox" for="child-care-contact"><span>Child Care</span></label>
                </div>
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="elder-care-contact" disabled="true">
                    <label class="checkbox" for="elder-care-contact"><span>Elder Care</span></label>
                </div>
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="animal-care-contact" disabled="true">
                    <label class="checkbox" for="animal-care-contact"><span>Animal Care</span></label>
                </div>
            </div>
            <div id="contact-message" class="control">
                <textarea class="textarea" placeholder="I want to request you to take care of..."></textarea>
                <p id="character-counter">Characters remaining: 2000</p>
                <p class="help is-danger has-text-left"></p>
            </div>

        </section>
        <footer class="modal-card-foot">
            <button class="button hide-modal">Cancel</button>
            <button id="confirm-contact" class="button is-primary confirm"></button>
        </footer>
    </div>
</div>