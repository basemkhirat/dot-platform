<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Config::get("site_title"); ?></title>
    <?php /*
        <link href="https://necolas.github.io/normalize.css/3.0.2/normalize.css" rel="stylesheet" />
        */ ?>
    <link href="<?php echo assets() ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/font-awesome-animation.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/animate.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/style.css" rel="stylesheet">

    <link href="<?php echo assets() ?>/uploader/popup.css" rel="stylesheet" type="text/css">

    <script src="<?php echo assets() ?>/js/jquery-2.1.1.js"></script>
    <link href="<?php echo assets() ?>/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="<?php echo assets() ?>/css/master.css" rel="stylesheet">

    <?php if (DIRECTION == "rtl") { ?>
        <link href="<?php echo assets() ?>/css/rtl.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/css/plugins/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet">
        <link href="<?php echo assets() ?>/uploader/rtl.css" rel="stylesheet" type="text/css">
    <?php } ?>

    @yield("header")

    <?php /*
        <link href="<?php echo assets() ?>/css/adnan.css" rel="stylesheet">
       */ ?>


    <link rel="icon" type="image/png" href="<?php echo url("favicon.ico") ?>">

    <script>
        AMAZON = "<?php echo AMAZON; ?>";
        base_url = "<?php echo Config::get("app.url"); ?>/";
        baseURL = "<?php echo Config::get("app.url") . "/" . ADMIN . '/' ?>";
    </script>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>" />
</head>

<body
    class="<?php if (DIRECTION == "rtl") { ?>rtls<?php } ?> <?php if (isset($_COOKIE["mini_nav"]) and $_COOKIE["mini_nav"] == "1") { ?>mini-navbar<?php } ?>">
