<?php
    include('searchLogic.php');
?>
<div id="form-cont" class="column container">

    <div id="find-content-cont" class="animated fadeIn">

        <div id="top-cont">
            <h1>Find Help</h1>
            <div id="find-border"></div>
            <h5>Looking for someone to care of loved ones or another service?</h1>
            <p>Here you can find what you're looking for. Select areas and how far away your helpers can be</p>
        </div>
            
        <form id="find-form">

            <div class="column">
                <h5 id="range-value">20<span>km</span></h5>
                <input id="range-input" class="slider is-fullwidth" step="1" min="1" max="100" value="20" type="range">
            </div>

            <div class="columns">
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="child-care-checkbox" checked="checked">
                    <label class="checkbox" for="child-care-checkbox"><span>Child Care</span></label>
                </div>
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="elder-care-checkbox" checked="checked">
                    <label class="checkbox" for="elder-care-checkbox"><span>Elder Care</span></label>
                </div>
                <div class="checkbox-cont field column">
                    <input type="checkbox" class="is-checkradio" id="animal-care-checkbox" checked="checked">
                    <label class="checkbox" for="animal-care-checkbox"><span>Animal Care</span></label>
                </div>
            </div>
            <!--<div class="field">
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-medium find-input" type="text" name="searchByStats" placeholder="What do you need help you with?" size="45" id="searchForm">
                    <span class="icon is-left">
                    <i data-feather="search"></i>
                    </span>
                </div>
                <p class="help password-help is-danger has-text-left"></p>
            </div>-->
        </form>
        <button id="find-btn" class="button is-primary">Find</button>

        <!--child care, elder care, other-->
    </div>
</div>