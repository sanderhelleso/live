<!DOCTYPE html>
<html>
<?php 
    include('../auth/auth.php');  
    isLoggedIn();
    include("../head/signup.php");
?>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <div id="signup-cover">
            <div id="signup" class="animated fadeIn">
                <h1>Sign Up to LIVE</h1> 
                <div id="signup-border"></div>
                <p id="intro">Join the community and start making a difference today</p>
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