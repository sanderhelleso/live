<?php
    include('searchLogic.php');
?>
<div id="form-cont" class="column container">

    <div id="find-content-cont" class="animated fadeIn">

        <div id="top-cont">
            <h1>Find Help</h1>
            <div id="find-border"></div>
            <h5>Looking for someone to take care of loved ones?</h1>
            <p>Here you can find what you're looking for. Select areas and how far away your helpers can be</p>
        </div>
            
        <form id="find-form">

            <div class="column">
                <h5 id="range-value">50<span>km</span></h5>
                <input id="range-input" class="slider is-fullwidth" step="1" min="1" max="100" value="50" type="range">
            </div>

            <div class="columns">
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="child-care" checked="checked">
                    <label class="checkbox" for="child-care"><span>Child Care</span></label>
                </div>
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="elder-care" checked="checked">
                    <label class="checkbox" for="elder-care"><span>Elder Care</span></label>
                </div>
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="animal-care" checked="checked">
                    <label class="checkbox" for="animal-care"><span>Animal Care</span></label>
                </div>
            </div>
        </form>
        <button id="find-btn" class="button is-primary">Find</button>

    </div>
</div>