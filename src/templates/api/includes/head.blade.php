<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>API DOCS</title>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/normalize.min.css">
<link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/main.css">
<link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/prettify.css">
<link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/f2m2-grid.css">
<script src="<?php echo assets("admin::js/jquery-2.1.1.js"); ?>"></script>
<script src="<?php echo assets("admin::js/modernizr.js"); ?>"></script>
<script src="<?php echo assets("admin::js/jquery-ui-1.10.4.min.js"); ?>"></script>
<script>
    $.ajaxSetup({headers: {'Authorization': 'Bearer <?php echo $user->api_token; ?>'}});
</script>
<script src="<?php echo assets("admin::docs"); ?>/js/prettify.js"></script>
<script src="<?php echo assets("admin::docs"); ?>/js/waypoints.min.js"></script>
<script src="<?php echo assets("admin::docs"); ?>/js/highlight.js"></script>
<script src="<?php echo assets("admin::docs"); ?>/js/main.js"></script>