<?php
    include("../../auth/auth.php"); 
    canAccessRoute();
?>

<!DOCTYPE html>
<?php include("../../head/settings.php"); ?>
<html>
<body class="site">
<?php include("../../nav/dashboard-nav.php"); ?>
    <main class="site-content is-centered has-text-centered desktop">
        <?php include("password.php"); ?>
        <?php include("delete.php"); ?>
        <div id="settings" class="animated fadeIn">
            <h1 class="animated fadeIn">Settings</h1>
            <div id="settings-border"></div>
            <div id="settings-cont" class="columns is-centered">
                <?php include("avatar.php"); ?>
                <?php include("form.php"); ?>
            </div>
        </div>
    </main>
<?php include("../../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>