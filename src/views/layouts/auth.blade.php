<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo Config::get("site_title"); ?> - CMS</title>

        <link href="<?php echo assets() ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/css/plugins/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="<?php echo assets() ?>/css/animate.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/css/style.css" rel="stylesheet">

        <link href="<?php echo assets() ?>/css/plugins/switchery/switchery.css" rel="stylesheet">
        <script src="<?php echo assets() ?>/js/plugins/switchery/switchery.js"></script>

        <link href="<?php echo assets() ?>/css/auth.css" rel="stylesheet" />
        
    </head>

    <body class="gray-bg rtls">

        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
               <div>
    
                    <h1 class="logo-name"><?php echo Config::get("site_name") ?></h1>
    
                </div> 
                <h3><?php echo Config::get("site_slogan") ?></h3>
       

                @yield("content")

                <!--
                <p>Login in. To see it in action.</p>
                <form class="m-t" role="form" action="index.html">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Username" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
    
                    <a href="<?php echo assets() ?>/#"><small>Forgot password?</small></a>
                    <p class="text-muted text-center"><small>Do not have an account?</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="<?php echo assets() ?>/register.html">Create an account</a>
                </form>
                -->


                <p class="m-t"> <small> <?php echo Config::get("site_copyrights") ?> </small> </p>
            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="<?php echo assets() ?>/js/jquery-2.1.1.js"></script>
        <script src="<?php echo assets() ?>/js/bootstrap.min.js"></script>

    </body>

</html>
