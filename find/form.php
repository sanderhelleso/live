<?php
    include('find/searchLogic.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
        <style>@import url("css/styles.css");</style>
    </head>
    
    <body>
        <div id="topPage">
            <h1>Looking for someone to care of loved ones or another service?</h1>
            <br>
            <h2>Here you can search based on what you're looking for. You don't need to be a member.</h2>
        </div>
        
            <form method="post">
                <p>Search based on area of expertise:</p> <br>
                    <input type="text" name="searchByStats" placeholder="What can we help you with? Search 'babysitter'" size="45" id="searchForm">
                    <!--<button type="button" id="searchBtn">Search</button>-->
                    <input type="submit" name="submitSearch" value="Search" id="submitSearchBtn">
                    <!--<button id="submitSearchBtn" class="button is-primary">Search</button>-->
            </form>
            <?php checkSearchIsNotEmpty(); ?>
            <?php $memes = searchFor(); ?>
            <?php displayMemes(); ?>
    </body>
    <!--child care, elder care, other-->
</html>