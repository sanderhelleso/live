<?php
    include('searchLogic.php');
?>
<div id="form-cont" class="column container">

    <div id="find-content-cont" class="animated fadeIn">

        <div id="top-cont">
            <h1>Find Help</h1>
            <div id="find-border"></div>
            <h5>Looking for someone to care of loved ones or another service?</h1>
            <p>Here you can search based on what you're looking for. You don't need to be a member.</p>
        </div>
            
        <form id="find-form">
            <div class="field">
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-medium find-input" type="text" name="searchByStats" placeholder="What do you need help you with?" size="45" id="searchForm">
                    <span class="icon is-left">
                    <i data-feather="search"></i>
                    </span>
                </div>
                <p class="help password-help is-danger has-text-left"></p>
            </div>
        </form>
        <button id="find-btn" class="button is-primary">Search</button>

        <!--child care, elder care, other-->
    </div>
</div>