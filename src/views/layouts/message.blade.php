<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo Config::get("site_title"); ?> - CMS</title>

        <link href="<?php echo assets() ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="<?php echo assets() ?>/css/animate.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/css/auth.css" rel="stylesheet" />

    </head>

    <body class="gray-bg">
        
        @yield("content")

        <!-- Mainly scripts -->
        <script src="<?php echo assets() ?>/js/jquery-2.1.1.js"></script>
        <script src="<?php echo assets() ?>/js/bootstrap.min.js"></script>

    </body>

</html>
