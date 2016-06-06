<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo Config::get("site_title"); ?> - CMS</title>

        <link href="<?php echo assets("admin::") ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="<?php echo assets("admin::") ?>/css/animate.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/auth.css" rel="stylesheet" />

    </head>

    <body class="gray-bg">
        
        @yield("content")

        <!-- Mainly scripts -->
        <script src="<?php echo assets("admin::") ?>/js/jquery-2.1.1.js"></script>
        <script src="<?php echo assets("admin::") ?>/js/bootstrap.min.js"></script>

    </body>

</html>
