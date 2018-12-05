<!DOCTYPE html>
<html>
<?php include("../head/findhead.php"); ?>
<body class="site">
	<?php
        if (isset($_COOKIE['auth_token'])) {
			include("../nav/dashboardNav.php");
        }

        else {
			include("../nav/nav.php");
        }
    ?>
	<main class="site-content is-centered has-text-centered">
		<div id="main-cont" class="columns">
			<?php include('contact.php') ?>
			<?php include('map.php') ?>
			<?php include('form.php') ?>
		</div>
		<?php include('results.php') ?>
	</main>
<?php include("../footer/footer.php"); ?>
</body>
<script>
	feather.replace();
</script>
</html>