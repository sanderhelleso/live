<!DOCTYPE html>
<?php 
    include("../head/404.php");
?>
<html>
<body class="site">
<?php 
    if (isset($_COOKIE['auth_token'])) {
        include("../nav/dashboard-nav.php"); 
    }

    else {
        include("../nav/nav.php"); 
    }
?>
    <main class="site-content is-centered has-text-centered">
        <div id="cont">
            <h1>404</h1>
            <h5>Page Not Found</h5>
            <div id="border"></div>
            <p>The page you are looking for was moved, removed, renamed or might never existed.</p>
            <div class="control has-text-centered is-medium">
                <a id="btn" class="button is-primary" href="/">Go Home</a>
            </div>
        </div>
    </main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>