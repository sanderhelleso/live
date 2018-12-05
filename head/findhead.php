
<!-- Find Head component -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
    <!-- SEO META -->
    <meta name="robots" content="follow, index" />
    <meta name="publisher" content="https://github.com/sanderhelleso" />
    <meta name="description" content="APP DESC">
    <meta property="og:site_name" content="APP NAME">
    <meta name="keyword" content="APP KEYWORDS">
    <meta name="robots" content="index, follow">
        
    <!-- Google + -->
    <meta itemprop="[Organization]">
    <meta itemprop="name" content="APP NAME">
    <meta itemprop="description" content="APP DESC">
    <meta property="og:site_name" content="APP NAME">
    <meta itemprop="image" content="/URL/APPCOVER">
        
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="APP TITLE">
    <meta name="twitter:description" content="APP DESC">
    <meta property="og:site_name" content="APP TITLE">
    <meta name="twitter:image" content="/URL/APPCOVER">
    <meta name="twitter:url" content="APP URL">
        
    <!-- Facebook -->
    <meta property="og:title" content="APP NAME">
    <meta property="og:type" content="website">
    <meta property="og:url" content="APP URL">
    <meta property="og:image" content="/URL/APPCOVER">
    <meta property="og:description" content="APP DESC">
    <meta property="og:site_name" content="APP NAME"> 
        
    <link rel="icon" href="/URL/TO/ICON" type="image/gif" sizes="16x16">

    <link rel="stylesheet" type="text/css" media="screen" href="../public/css/lib/animate.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../public/css/lib/bulma.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../public/css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../public/css/find.css" />
    
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <?php
        if (isset($_COOKIE['auth_token'])) {
            echo '<link rel="stylesheet" type="text/css" media="screen" href="../public/css/dashboard/dashboardNavbar.css" />';
            echo '<script src="../public/js/dashboard/dashboardNavbar.js" type="module"></script>';
        }
    ?>
    <script src="../public/js/navbar.js"></script>
    <script src="../public/js/find.js" type="module"></script>
    <?php
        echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=' . $_ENV['GOOGLE_MAPS_API_KEY'] . '"></script>';
    ?>

    <title>Find</title>
</head>