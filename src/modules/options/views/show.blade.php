@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        @include("options::partials.nav")

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

            <div class="row">

                <div class="col-md-12">
                    <div class="panel ">

                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="options_main" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-6">


                                            <div class="form-group">
                                                <label
                                                    for="site_name"><?php echo trans("options::options.attributes.site_name") ?></label>
                                                <input name="site_name" type="text"
                                                       value="<?php echo @Request::old("site_name", Config::get("site_name")); ?>"
                                                       class="form-control" id="site_name"
                                                       placeholder="<?php echo trans("options::options.attributes.site_name") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="site_slogan"><?php echo trans("options::options.attributes.site_slogan") ?></label>
                                                <input name="site_slogan" type="text"
                                                       value="<?php echo @Request::old("site_slogan", Config::get("site_slogan")); ?>"
                                                       class="form-control" id="site_slogan"
                                                       placeholder="<?php echo trans("options::options.attributes.site_slogan") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="site_email"><?php echo trans("options::options.attributes.site_email") ?></label>
                                                <input name="site_email" type="text"
                                                       value="<?php echo @Request::old("site_email", Config::get("site_email")); ?>"
                                                       class="form-control" id="site_email"
                                                       placeholder="<?php echo trans("options::options.attributes.site_email") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="site_copyrights"><?php echo trans("options::options.attributes.site_copyrights") ?></label>
                                                <input name="site_copyrights" type="text"
                                                       value="<?php echo @Request::old("site_copyrights", Config::get("site_copyrights")); ?>"
                                                       class="form-control" id="site_copyrights"
                                                       placeholder="<?php echo trans("options::options.attributes.site_copyrights") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="timezone"><?php echo trans("options::options.attributes.timezone") ?></label>
                                                <select id="timezone" class="form-control chosen-select chosen-rtl"
                                                        name="app_timezone">
                                                    <?php
                                                    for ($i = -12; $i <= 12; $i++) {

                                                    if ($i == 0) {
                                                        $zone = "";
                                                    } elseif ($i > 0) {
                                                        $zone = "+$i";
                                                    } else {
                                                        $zone = $i;
                                                    }
                                                    ?>
                                                    <option
                                                        value="Etc/GMT<?php echo $zone; ?>"
                                                        <?php if (Config::get("app.timezone") == "Etc/GMT" . $zone) { ?> selected="selected" <?php } ?>>
                                                        GMT<?php echo $zone; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="date_format"><?php echo trans("options::options.attributes.date_format") ?></label>
                                                <select id="date_format" class="form-control chosen-select chosen-rtl"
                                                        name="date_format">
                                                    <?php foreach (array("Y-m-d H:i A", "Y-m-d", "d/m/Y", "H:i A") as $format) { ?>
                                                    <option
                                                        value="<?php echo $format; ?>"
                                                        <?php if (Config::get("date_format") == $format) { ?> selected="selected" <?php } ?>><?php echo date($format, time() - 2 * 60 * 60); ?></option>
                                                    <?php } ?>
                                                    <option
                                                        value="relative"
                                                        <?php if (Config::get("date_format") == "relative") { ?> selected="selected" <?php } ?>><?php echo time_ago(time() - 2 * 60 * 60); ?></option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="app_locale"><?php echo trans("options::options.attributes.locale") ?></label>
                                                <select id="app_locale" class="form-control chosen-select chosen-rtl"
                                                        name="app_locale">
                                                    <?php foreach (Config::get("admin.locales") as $code => $lang) { ?>
                                                    <option
                                                        value="<?php echo $code; ?>"
                                                        <?php if (Config::get("app.locale") == $code) { ?> selected="selected" <?php } ?>><?php echo $lang["title"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <fieldset>
                                                <legend><?php echo trans("options::options.attributes.site_status") ?></legend>

                                                <div class="form-group switch-row">
                                                    <label class="col-sm-10 control-label"
                                                           for="site_status"><?php echo trans("options::options.attributes.site_status") ?></label>
                                                    <div class="col-sm-2">
                                                        <input
                                                            <?php if (Config::get("site_status")) { ?> checked="checked"
                                                            <?php } ?>
                                                            type="checkbox" id="site_status" name="site_status"
                                                            value="1"
                                                            class="switcher switcher-sm">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        for="offline_message"><?php echo trans("options::options.attributes.offline_message") ?></label>
                                                    <br/>
                                                    <textarea class="form-control" id="offline_message"
                                                              name="offline_message"
                                                              placeholder="<?php echo trans("options::options.attributes.offline_message") ?>"><?php echo @Request::old("offline_message", Config::get("offline_message")); ?></textarea>
                                                </div>

                                            </fieldset>

                                        </div>
                                        <div class="col-md-6">


                                            <div class="widget style1 navy-bg">
                                                <div class="row">

                                                    <div class="col-xs-8 text-left">
                                                        <span> <?php echo trans("options::options.dot_version"); ?>
                                                            : </span>
                                                        <h2 class="font-bold"
                                                            style="font-family: sans-serif,Verdana, Arial"><?php echo DOT_VERSION; ?></h2>
                                                    </div>

                                                    <div class="col-xs-4 text-center">
                                                        <i class="fa fa-cloud fa-5x"></i>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row text-center">
                                                <a href="javascript:void(0)"
                                                   data-loading-text="<?php echo trans("options::options.checking"); ?>"
                                                   class="btn btn-primary btn-labeled btn-main check-update"> <span
                                                        class="btn-label icon fa fa-life-ring"></span> &nbsp;
                                                    <?php echo trans("options::options.check_for_update"); ?>
                                                </a>
                                            </div>

                                            <br/> <br/>

                                            <div class="update-status">

                                                <?php if(version_compare(Config::get("latest_version"), DOT_VERSION, ">")){ ?>
                                                @include("options::update", ["version" => Config::get("latest_version")])
                                                <?php } ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div style="clear:both"></div>
            <div>
                <div class="container-fluid">
                    <div class="form-group">
                        <input type="submit" class="pull-left btn btn-flat btn-primary"
                               value="<?php echo trans("options::options.save_options") ?>"/>
                    </div>
                </div>
            </div>

        </div>

    </form>

@stop


@push("header")
    <link href="<?php echo assets("admin::tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets("admin::tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@endpush

@push("footer")
    <script src="<?php echo assets("admin::tagit") ?>/tag-it.js"></script>
    <script>
        $(document).ready(function () {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html);
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $('.chosen-select').chosen();


            $(".check-update").click(function () {

                var base = $(this);

                base.button("loading");

                $.post("<?php echo route("admin.options.check_update"); ?>", function (result) {


                    $(".update-status").html(result);

                    base.button("reset");


                }).fail(function () {
                    base.button("reset");
                });

            });


            $("#mytags").tagit({
                singleField: true,
                singleFieldNode: $('#tags_names'),
                allowSpaces: true,
                minLength: 2,
                placeholderText: "",
                removeConfirmation: true,
                tagSource: function (request, response) {
                    $.ajax({
                        url: "<?php echo route("admin.google.search"); ?>",
                        data: {term: request.term},
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            response($.map(data, function (item) {
                                return {
                                    label: item.name,
                                    value: item.name
                                }
                            }));
                        }
                    });
                }
            });


        });
    </script>
@endpush
