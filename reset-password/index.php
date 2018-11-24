<!DOCTYPE html>
<?php 
    include("../auth/auth.php");
    validateResetPassword(); // check if reset password code is valid
    include("../head/resetPasswordHead.php");
?>
<html>
<body class="site">
<?php include("../nav/nav.php"); ?>
    <main class="site-content is-centered has-text-centered">
        <div id="reset-password-cont">
            <h1> Reset password </h1>
            <div id="reset-border"></div>
            <form>
                <div class="field is-center">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-rounded is-medium password-input" name="password" type="password" placeholder="Password">
                        <span class="icon is-left">
                        <i data-feather="lock"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>

                <div class="field is-center">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-rounded is-medium confirmPassword-input" name="password" type="password" placeholder="Confirm Password">
                        <span class="icon is-left">
                        <i data-feather="unlock"></i>
                        </span>
                        <p class="help is-danger has-text-left"></p>
                    </div>
                </div>
                <div class="control has-text-centered is-medium">
                    <button id="reset-password-btn" class="button is-primary">Update Password</button>
                </div>
            </form>
        </div>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>