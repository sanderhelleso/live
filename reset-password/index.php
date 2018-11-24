<!DOCTYPE html>
<?php 
    include("../head/resetPasswordHead.php");
?>
<html>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <div id="reset-password-cont">
            <h1> Reset password </h1>
            <?php 
                    include("../auth/auth.php");
                    validateResetPassword(); // check if reset password code is valid
                ?>
        </div>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>