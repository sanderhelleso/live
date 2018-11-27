<?php
    include("../../auth/auth.php"); 
    canAccessRoute();
?>

<!DOCTYPE html>
<?php include("../../head/offerHelpHead.php"); ?>
<html>
<body class="site">
<?php include("../../nav/dashboardNav.php"); ?>
    <main class="site-content is-centered has-text-centered desktop">
        <div id="offer-help-cont">
            <div id="offer-help-intro-cont" class="animated fadeIn">
                <h1><span id="offer-help-word"></span> <span id="offer-help-name"></span> !</h1>
                <p>You are only a few steps away from helping someone that needs it</p>
                <div id="offer-border"></div>
            </div>
            <?php include("./offerHelpForm.php") ?>
        </div>
    </main>
<?php include("../../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>