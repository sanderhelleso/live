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
            <?php include("./offerHelpForm.php") ?>
        </div>
    </main>
<?php include("../../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>