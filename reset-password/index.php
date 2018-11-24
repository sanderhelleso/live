<!DOCTYPE html>
<?php 
    include("../auth/auth.php");
    activeResetPassword(); // check if reset password code is valid
    include("../head/loginHead.php"); // replace with reset password head
?>
<html>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <h1> Reset password </h1>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>