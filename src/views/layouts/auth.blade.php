<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo Config::get("site_title"); ?> - CMS</title>

        <link href="<?php echo assets("admin::") ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/plugins/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/animate.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/plugins/switchery/switchery.css" rel="stylesheet">
        <link href="<?php echo assets("admin::") ?>/css/auth.css" rel="stylesheet" />

        @yield("header")
        
    </head>

    <body class="dark-theme gray-bg rtls">

        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>

                <div>
                    <h1 class="logo-name"><?php echo Config::get("site_name") ?></h1>
                </div> 

                <h3><?php echo Config::get("site_slogan") ?></h3>

                @yield("content")

                <p class="m-t"> <small> <?php echo Config::get("site_copyrights") ?> </small> </p>
            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="<?php echo assets("admin::js/jquery-2.1.1.js") ?>"></script>
        <script src="<?php echo assets("admin::js/bootstrap.min.js") ?>"></script>

        @yield("footer")

    </body>

</html>
