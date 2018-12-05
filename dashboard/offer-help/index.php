<?php
    include("../../auth/auth.php"); 
    canAccessRoute();
?>
<!DOCTYPE html>
<?php include("../../head/offer-help.php"); ?>
<html>
<body class="site">
<?php include("../../nav/dashboard-nav.php"); ?>
    <main class="site-content is-centered has-text-centered desktop">
        <div id="offer-help-cont">
            <?php include("./form.php") ?>
            <?php include("./preview.php") ?>
        </div>
    </main>
<?php include("../../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>