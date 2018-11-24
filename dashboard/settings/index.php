<?php
    include("../../auth/auth.php"); 
    canAccessRoute();
?>

<!DOCTYPE html>
<?php include("../../head/settingsHead.php"); ?>
<html>
<body class="site">
<?php include("../../nav/dashboardNav.php"); ?>
    <main class="site-content is-centered has-text-centered desktop">
        <?php include("confirmPassword.php"); ?>
        <?php include("confirmDelete.php"); ?>
        <div id="settings" class="animated fadeIn">
            <h1 class="animated fadeIn">Settings</h1>
            <div id="settings-border"></div>
            <div id="settings-cont" class="columns is-centered">
                <?php include("avatarUpload.php"); ?>
                <?php include("settingsForm.php"); ?>
            </div>
        </div>
    </main>
<?php include("../../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>