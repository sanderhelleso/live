<!DOCTYPE html>
<?php include("../head/signupHead.php"); ?>
<html>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <div id="signup-cover">
            <div id="signup" class="animated fadeIn">
                <h1>Sign Up to LIVE</h1> 
                <div id="signup-border"></div>
                <p>Join the community and start making a difference today</p>
                <?php include("signupForm.php"); ?>
            </div>
        </div>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>