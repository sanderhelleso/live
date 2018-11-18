<!DOCTYPE html>
<?php include("../head/loginHead.php"); ?>
<html>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <div id="login-cover">
            <div id="login" class="animated fadeIn">
                <h1>Log In to LIVE</h1> 
                <div id="login-border"></div>
                <?php include("loginForm.php"); ?>
            </div>
        </div>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>