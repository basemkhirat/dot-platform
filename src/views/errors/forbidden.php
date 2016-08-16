
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

</head>

<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>403</h1>
    <h3 class="font-bold">Access denied</h3>

    <div class="error-desc">
        Sorry you are not authorized to view this page <br/><a href="<?php echo url(ADMIN); ?>" class="btn btn-primary m-t">Go Back</a>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo assets("admin::") ?>/js/jquery-2.1.1.js"></script>
<script src="<?php echo assets("admin::") ?>/js/bootstrap.min.js"></script>

</body>

</html>
