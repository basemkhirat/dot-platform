@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        @include("options::partials.nav")

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <form action="" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                <div class="row">
                    <div class="col-md-12">


                        <?php if (count($all_plugins)) { ?>

                        <?php foreach ($all_plugins as $plugin) { ?>

                        <div class="panel panel-plugin">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs text-center">
                                        <i class="plugin-icon fa <?php echo $plugin->icon; ?>"></i>
                                    </div>

                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                        <label
                                            for="<?php echo $plugin->path; ?>_status"><?php echo ucfirst($plugin->name); ?>

                                        </label>

                                        <?php if ($plugin->description) { ?>
                                        <p>
                                            <small><?php echo $plugin->description; ?></small>
                                        </p>
                                        <?php } ?>

                                        <p class="plugin-control">

                                            <?php if ($plugin->installed) { ?>
                                            <a href="<?php echo route("admin.plugins.activation", ["name" => $plugin->path, "status" => 0]) ?>"
                                               message="<?php echo trans("options::options.sure_uninstall_plugin", ["name" => $plugin->name]); ?>"
                                               class="text-danger ask"><?php echo trans("options::options.uninstall"); ?></a>
                                            <?php } else { ?>
                                            <a href="<?php echo route("admin.plugins.activation", ["name" => $plugin->path, "status" => 1]) ?>"
                                               class="text-navy ask"
                                               message="<?php echo trans("options::options.sure_install_plugin", ["name" => $plugin->path]); ?>"><?php echo trans("options::options.install"); ?></a>
                                            <?php } ?>
                                        </p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs text-right">
                                        <div class="plugin-version"><?php echo $plugin->version; ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php } ?>

                        <?php } else { ?>

                        <div class="panel">
                            <div class="panel-body">
                                <div>
                                    <i class="fa fa-puzzle-piece"></i>
                                    &nbsp; <?php echo trans("options::options.no_plugins"); ?>
                                </div>
                            </div>
                        </div>


                        <?php } ?>

                    </div>

                </div>

        </div>
    </form>

    @push("header")

        <style>
            .plugin-icon {
                font-size: 56px;
                opacity: 0.3;
            }

            .plugin-version {
                font-size: 14px;
                opacity: 0.4;
                font-family: verdana !important;
            }

            .panel-plugin {
                border-radius: 5px;
                border: 1px solid #ddd;
                margin-bottom: 5px;
            }
        </style>

    @endpush
    @push("footer")

        <script>
            $(document).ready(function () {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.switcher'));
                elems.forEach(function (html) {
                    var switchery = new Switchery(html);
                });
            });
        </script>
    @endpush
@stop
