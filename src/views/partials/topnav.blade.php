<div id="page-wrapper" class="gray-bg" style="overflow: hidden !important">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0)"><i
                        class="fa fa-bars"></i> </a>
                <form method="get" role="search" class="navbar-form-custom"
                      action="">
                    <div class="form-group">
                        <input type="text" value="<?php echo Request::get("q"); ?>"
                               placeholder="<?php echo trans("admin::common.search"); ?>..."
                               class="form-control" name="q" id="top-search">
                    </div>
                </form>
            </div>
            <ul class="nav navbar-top-links navbar-right">

                <li>
                    <span
                        class="m-r-sm text-muted welcome-message"><?php echo strtoupper(Config::get("site_title", Config::get("site_name"))); ?></span>
                </li>

                <?php echo Navigation::get("topnav")->render(); ?>

                <li>
                    <a href="<?php echo route("admin.auth.logout"); ?>" class="ask"
                       message="<?php echo trans("admin::common.sure_logout"); ?>">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>
            </ul>

        </nav>
    </div>