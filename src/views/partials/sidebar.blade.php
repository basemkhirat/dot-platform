<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">

                    <span>
                        <img alt="image" class="img-circle" src="<?php echo Auth::user()->photo_url; ?>"/>
                    </span>

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="">
                        <span class="clear">
                            <span class="block sm-t-xs">
                                <strong
                                    class="font-bold"><?php echo ucfirst(Auth::user()->first_name) . " " . ucfirst(Auth::user()->last_name); ?></strong>
                            </span>

                            <?php if (Auth::user()->role){ ?>
                            <span
                                class="text-muted text-xs block"> <?php echo Auth::user()->role->name ?>
                                <b class="caret"></b>
                            </span>
                            </span>
                        <?php } ?>
                    </a>

                    <ul class="dropdown-menu m-t-xs">

                        <li>
                            <a href="<?php echo route("admin.users.edit", array("id" => Auth::user()->id)); ?>"><?php echo trans("auth::auth.edit_profile") ?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a class="ask" message="<?php echo trans("admin::common.sure_logout"); ?>" href="<?php echo route("admin.auth.logout"); ?>"><?php echo trans("auth::auth.logout") ?></a>
                        </li>
                    </ul>

                </div>

                <div class="logo-element">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                </div>

            </li>

            <?php  echo Navigation::get("sidebar")->render(); ?>

        </ul>
    </div>
</nav>
