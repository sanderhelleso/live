<!DOCTYPE html>
<html>
<?php 
    include("../auth/auth.php");
    isLoggedIn();
    include("../head/login.php");
?>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <?php include("./forgot-password.php"); ?>
        <div id="login-cover">
            <div id="login" class="animated fadeIn">
                <h1>Log In to LIVE</h1> 
                <div id="login-border"></div>
                <?php include("form.php"); ?>
            </div>
        </div>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>