<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs">
        <h2>
            <i class="fa fa-cogs"></i>
            <?php echo trans("options::options.options"); ?>
        </h2>
        <ol class="breadcrumb ">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/options"); ?>"><?php echo trans("options::options.options"); ?></a>
            </li>
            <li class="active">
                <strong><?php echo trans("options::options." . $option_page); ?></strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
        <ul class="nav nav-tabs option-tabs">

            <?php if(Gate::allows("options.general")) { ?>
            <li <?php if ($option_page == "main") { ?>class="active"<?php } ?>><a href="<?php echo route("admin.options.show"); ?>"><i class="fa fa-sliders"></i> <span class="hidden-sm hidden-xs hidden-md"><?php echo trans("options::options.main") ?></span></a></li>
            <?php } ?>

            <?php if(Gate::allows("options.seo")) { ?>
            <li <?php if ($option_page == "seo") { ?>class="active"<?php } ?>><a  href="<?php echo route("admin.options.seo"); ?>"><i class="fa fa-line-chart"></i> <span class="hidden-sm hidden-xs hidden-md"><?php echo trans("options::options.seo") ?></span></a></li>
            <?php } ?>

            <?php if(Gate::allows("options.media")) { ?>
            <li <?php if ($option_page == "media") { ?>class="active"<?php } ?>><a  href="<?php echo route("admin.options.media"); ?>"><i class="fa fa-camera"></i> <span class="hidden-sm hidden-xs hidden-md"><?php echo trans("options::options.media") ?></span></a></li>
            <?php  } ?>


            <?php if(Gate::allows("options.social")) { ?>
            <li <?php if ($option_page == "social") { ?>class="active"<?php } ?>><a  href="<?php echo route("admin.options.social"); ?>"><i class="fa fa-globe"></i>  <span class="hidden-sm hidden-xs hidden-md"><?php echo trans("options::options.social") ?></span></a></li>
            <?php } ?>

            <?php if(Gate::allows("options.plugins")) { ?>

                <li <?php if ($option_page == "plugins") { ?>class="active"<?php } ?>>
                <a  href="<?php echo route("admin.options.plugins"); ?>"><i class="fa fa-puzzle-piece"></i>
                    <span class="hidden-sm hidden-xs hidden-md">
                        <?php echo trans("options::options.plugins") ?> <?php if($available_plugins_count != "0"){ ?>&nbsp;<span class="badge badge-primary"><?php echo $available_plugins_count; ?></span><?php } ?>
                    </span>
                </a>
            </li>

            <?php } ?>
        </ul>
    </div>
</div>