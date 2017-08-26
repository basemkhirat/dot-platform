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

                            <div id="options_seo" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label
                                                for="site_title"><?php echo trans("options::options.attributes.site_title") ?></label>
                                            <input name="site_title" type="text"
                                                   value="<?php echo @Request::old("site_title", Config::get("site_title")); ?>"
                                                   class="form-control" id="site_title"
                                                   placeholder="<?php echo trans("options::options.attributes.site_title") ?>">
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="site_description"><?php echo trans("options::options.attributes.site_description") ?></label>
                                            <br/>
                                            <textarea class="form-control" id="site_description" name="site_description"
                                                      placeholder="<?php echo trans("options::options.attributes.site_description") ?>"><?php echo @Request::old("site_description", Config::get("site_description")); ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="site_author"><?php echo trans("options::options.attributes.site_author") ?></label>
                                            <input name="site_author" type="text"
                                                   value="<?php echo @Request::old("site_author", Config::get("site_author")); ?>"
                                                   class="form-control" id="site_author"
                                                   placeholder="<?php echo trans("options::options.attributes.site_author") ?>">
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="site_robots"><?php echo trans("options::options.attributes.site_robots") ?></label>
                                            <select id="site_robots" class="form-control chosen-select chosen-rtl"
                                                    name="site_robots">
                                                <?php foreach (array("INDEX, FOLLOW", "NOINDEX, NOFOLLOW", "INDEX, NOFOLLOW", "NOINDEX, FOLLOW") as $robot) { ?>
                                                <option value="<?php echo $robot; ?>"
                                                        <?php if (Config::get("site_robots") == $robot) { ?> selected="selected" <?php } ?>><?php echo $robot ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="site_keywords"><?php echo trans("options::options.attributes.site_keywords") ?></label>
                                            <br/>
                                            <input type="hidden" name="site_keywords" id="tags_names"
                                                   value="<?php echo @Request::old("site_keywords", Config::get("site_keywords")); ?>">
                                            <ul id="mytags"></ul>
                                        </div>

                                        <fieldset>
                                            <legend><?php echo trans("options::options.attributes.site_logo") ?></legend>
                                            <div class="row">
                                                <div class="col-md-3 text-center">
                                                    <input id="site_logo_path" type="hidden"
                                                           value="<?php if (Config::get("site_logo") != "") { ?><?php echo Config::get("site_logo"); ?><?php } ?>"
                                                           id="user_photo_id" name="site_logo"/>
                                                    <img id="site_logo" style="border: 1px solid #ccc; width: 100%;"
                                                         src="<?php if (Config::get("site_logo") != "") { ?> <?php echo thumbnail(Config::get("site_logo")); ?> <?php } else { ?> <?php echo assets("admin::default/image.png"); ?><?php } ?>"/>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <p><?php echo trans("options::options.chane_logo_help"); ?></p>
                                                        <a href="javascript:void(0)" id="change_logo" class="text-navy"
                                                           <?php if(Config::get("site_logo") != ""){ ?>style="display: none"<?php } ?>><?php echo trans("options::options.change_logo") ?></a>
                                                        <a href="javascript:void(0)" id="remove_logo" class="text-navy"
                                                           <?php if(Config::get("site_logo") == ""){ ?>style="display: none"<?php } ?>><?php echo trans("options::options.remove_logo") ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>


                                    </div>
                                    <div class="col-md-6">

                                        <fieldset>
                                            <legend><?php echo trans("options::options.sitemap") ?>

                                                <?php /* if (Config::get("sitemap_status") == 1 and File::isWritable(dirname(public_path(Config::get("sitemap_path"))))) { ?>
                                            <a href="javascript:void(0)" id="update-sitemap" class="btn btn-primary btn-flat pull-right" style="margin-bottom: 6px">
                                                <i class="fa fa-refresh"></i>
                                                <?php echo trans("options::options.update_sitemap") ?>
                                            </a>
                                        <?php } */ ?>

                                            </legend>
                                            <div style="margin:5px 0">
                                                <?php echo trans("options::options.attributes.sitemap_last_update"); ?>
                                                <i id="sitemap_last_update"><?php echo time_ago(Config::get("sitemap_last_update")); ?></i>
                                            </div>
                                            <br/>
                                            <div style="clear:both"></div>


                                            <div class="form-group switch-row">
                                                <label class="col-sm-10 control-label"
                                                       for="sitemap_status"><?php echo trans("options::options.attributes.sitemap_status") ?></label>
                                                <div class="col-sm-2">
                                                    <input
                                                        <?php if (Config::get("sitemap_status")) { ?> checked="checked"
                                                        <?php } ?> type="checkbox" id="sitemap_status"
                                                        name="sitemap_status" value="1"
                                                        class="option-switcher switcher-sm">
                                                </div>
                                            </div>


                                            <div id="sitemap_status_options"
                                                 <?php if (Config::get("sitemap_status") == 0) { ?> style="display:none" <?php } ?>>

                                                <div class="well">
                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_xml_status"><?php echo trans("options::options.attributes.sitemap_xml_status") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_xml_status")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_xml_status"
                                                                name="sitemap_xml_status" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_html_status"><?php echo trans("options::options.attributes.sitemap_html_status") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_html_status")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_html_status"
                                                                name="sitemap_html_status" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_txt_status"><?php echo trans("options::options.attributes.sitemap_txt_status") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_txt_status")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_txt_status"
                                                                name="sitemap_txt_status" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group switch-row">
                                                    <label class="col-sm-10 control-label"
                                                           for="sitemap_ping"><?php echo trans("options::options.attributes.sitemap_ping") ?></label>
                                                    <div class="col-sm-2">
                                                        <input
                                                            <?php if (Config::get("sitemap_ping")) { ?> checked="checked"
                                                            <?php } ?> type="checkbox" id="sitemap_ping"
                                                            name="sitemap_ping" value="1"
                                                            class="option-switcher switcher-sm">
                                                    </div>
                                                </div>

                                                <div class="well" id="sitemap_ping_options"
                                                     <?php if (Config::get("sitemap_ping") == 0) { ?> style="display:none" <?php } ?>>
                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_google_ping"><?php echo trans("options::options.attributes.sitemap_google_ping") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_google_ping")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_google_ping"
                                                                name="sitemap_google_ping" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_bing_ping"><?php echo trans("options::options.attributes.sitemap_bing_ping") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_bing_ping")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_bing_ping"
                                                                name="sitemap_bing_ping" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_yahoo_ping"><?php echo trans("options::options.attributes.sitemap_yahoo_ping") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_yahoo_ping")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_yahoo_ping"
                                                                name="sitemap_yahoo_ping" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>

                                                    <div class="form-group switch-row">
                                                        <label class="col-sm-10 control-label"
                                                               for="sitemap_ask_ping"><?php echo trans("options::options.attributes.sitemap_ask_ping") ?></label>
                                                        <div class="col-sm-2">
                                                            <input
                                                                <?php if (Config::get("sitemap_ask_ping")) { ?> checked="checked"
                                                                <?php } ?> type="checkbox" id="sitemap_ask_ping"
                                                                name="sitemap_ask_ping" value="1"
                                                                class="option-switcher switcher-sm">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        for="sitemap_path"><?php echo trans("options::options.attributes.sitemap_path") ?></label>
                                                    <div class="input-group" style="direction: rtl;">
                                                        <input name="sitemap_path" type="text"
                                                               value="<?php echo @Request::old("sitemap_path", Config::get("sitemap_path")); ?>"
                                                               class="form-control" id="sitemap_path"
                                                               style="direction: ltr; text-align: left"
                                                               placeholder="<?php echo trans("options::options.attributes.sitemap_path") ?>">
                                                        <span class="input-group-addon">/public/</span>
                                                    </div>
                                                </div>


                                                <?php if (!File::isWritable(public_path(Config::get("sitemap_path")))) { ?>
                                                <div class="alert alert-danger " role="alert">
                                                <span
                                                    class="pull-right text-left "> <?php echo public_path(Config::get("sitemap_path")) ?>
                                                    <?php echo trans("options::options.not_writable") ?>
                                                </span>
                                                    <span class="glyphicon glyphicon-exclamation-sign"
                                                          aria-hidden="true"></span>
                                                </div>

                                            <?php } ?>


                                            <?php /*
                                        <div class="form-group">
                                            <label for="sitemap_limit"><?php echo trans("options::options.attributes.sitemap_limit") ?></label>
                                            <input name="sitemap_limit" type="number" value="<?php echo @Request::old("sitemap_limit", Config::get("sitemap_limit")); ?>" class="form-control" id="sitemap_limit" placeholder="<?php echo trans("options::options.attributes.sitemap_limit") ?>">
                                        </div>
                                        */ ?>

                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div> <!-- / .panel-body -->
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

    @push("header")
        <link href="<?php echo assets("admin::tagit")?>/jquery.tagit.css" rel="stylesheet" type="text/css">
        <link href="<?php echo assets("admin::tagit")?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
    @endpush

    @push("footer")


        <script src="<?php echo assets("admin::tagit")?>/tag-it.js"></script>

        <script>
            $(document).ready(function () {


                $('.chosen-select').chosen();

                var elems = Array.prototype.slice.call(document.querySelectorAll('.option-switcher'));
                elems.forEach(function (html) {
                    var switchery = new Switchery(html, {size: 'small'});
                });

                var sitemap_status = document.querySelector('#sitemap_status');
                sitemap_status.onchange = function () {
                    if (sitemap_status.checked) {
                        $("#sitemap_status_options").slideDown();
                    } else {
                        $("#sitemap_status_options").slideUp();
                    }
                };

                var sitemap_ping = document.querySelector('#sitemap_ping');
                sitemap_ping.onchange = function () {
                    if (sitemap_ping.checked) {
                        $("#sitemap_ping_options").slideDown();
                    } else {
                        $("#sitemap_ping_options").slideUp();
                    }
                };


                $('#update-sitemap').click(function () {
                    btn = $(this);
                    simpleLoad(btn, true)
                    $.post("<?php echo route("admin.sitemap.update") ?>", function (date) {
                        $("#sitemap_last_update").text(date);
                        simpleLoad(btn, false);
                    });
                });

                function simpleLoad(btn, state) {
                    if (state) {
                        btn.children().addClass('fa-spin');
                        btn.contents().last().replaceWith(" <?php echo trans("options::options.updating_sitemap") ?>");
                    } else {
                        btn.children().removeClass('fa-spin');
                        btn.contents().last().replaceWith(" <?php echo trans("options::options.update_sitemap") ?>");
                    }
                }

                $("#change_logo").filemanager({
                    types: "image",
                    done: function (result, base) {
                        if (result.length) {
                            var file = result[0];
                            $("#site_logo_path").val(file.url.split("uploads/")[1]);
                            $("#site_logo").attr("src", file.url);

                            base.hide();
                            $("#remove_logo").show();
                        }
                    },
                    error: function (media_path) {
                        alert_box(media_path + " <?php echo trans("options::options.file_not_supported") ?>");
                    }
                });

                $("#remove_logo").click(function () {
                    $("#site_logo_path").val("");
                    $("#site_logo").attr("src", "<?php echo assets("admin::default/image.png"); ?>");

                    $(this).hide();
                    $("#change_logo").show();
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
                            url: "<?php echo route("admin.google.search"); ?>", data: {term: request.term},
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
@stop
