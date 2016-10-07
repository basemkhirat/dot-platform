<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Config::get("site_title"); ?></title>
    <link href="<?php echo assets("admin::css/app.css") ?>" rel="stylesheet">
    <?php if (DIRECTION == "rtl") { ?>
    <link href="<?php echo assets("admin::css/app.rtl.css") ?>" rel="stylesheet">
    <?php } ?>
    <link rel="icon" type="image/png" href="<?php echo url("favicon.ico") ?>">
    <script>
        base_url = "<?php echo Config::get("app.url"); ?>/";
        baseURL = "<?php echo Config::get("app.url") . "/" . ADMIN . '/' ?>";
    </script>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>"/>
    @yield("header")
</head>

<body class="<?php if (Auth::user()->color == "blue") { ?>dark-theme<?php } ?> <?php if (DIRECTION == "rtl") { ?>rtls<?php } ?> <?php if (isset($_COOKIE["mini_nav"]) and $_COOKIE["mini_nav"] == "1") { ?>mini-navbar<?php } ?>">

<div class="loadingWrapper">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
</div>

<div class="bodyWrapper">



