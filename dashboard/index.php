<?php
    include("../auth/auth.php"); 
    canAccessRoute();
?>

<!DOCTYPE html>
<?php include("../head/dashboardHead.php"); ?>
<html>
<body class="site">
    <?php include("../nav/dashboardNav.php"); ?>
    <?php include("main/main.php"); ?>
    <?php include("../footer/footer.php"); ?>
</body>
<script>
    feather.replace();
</script>
</html>