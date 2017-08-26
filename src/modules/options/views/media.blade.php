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
                        <div class="panel ">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label
                                                for="allowed_file_types"><?php echo trans("options::options.attributes.allowed_file_types") ?></label>
                                            <br/>
                                            <input type="hidden" name="allowed_file_types" id="allowed_file_types"
                                                   value="<?php echo @Request::old("allowed_file_types", Config::get("media.allowed_file_types")); ?>">
                                            <ul id="mytags"></ul>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="max_file_size"><?php echo trans("options::options.attributes.max_file_size") ?></label>
                                            <div class="input-group m-b">
                                                <input name="max_file_size" type="text"
                                                       value="<?php echo @Request::old("max_file_size", Config::get("media.max_file_size")); ?>"
                                                       class="form-control col-md-11" id="max_file_size"
                                                       placeholder="<?php echo trans("options::options.attributes.max_file_size") ?>">
                                                <span
                                                    class="input-group-addon"><?php echo trans("options::options.kilobytes"); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="max_width"><?php echo trans("options::options.attributes.max_width") ?></label>
                                            <div class="input-group m-b">
                                                <input name="max_width" type="text"
                                                       value="<?php echo @Request::old("max_width", Config::get("media.max_width")); ?>"
                                                       class="form-control col-md-11" id="max_width"
                                                       placeholder="<?php echo trans("options::options.attributes.max_width") ?>">
                                                <span
                                                    class="input-group-addon"><?php echo trans("options::options.pixels"); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="media_thumbnails"><?php echo trans("options::options.attributes.media_thumbnails") ?></label>
                                            <div class="col-sm-2">
                                                <input
                                                    <?php if (Config::get("media.media_thumbnails")) { ?> checked="checked"
                                                    <?php } ?>
                                                    type="checkbox" id="media_thumbnails" name="media_thumbnails"
                                                    value="1"
                                                    class="switcher switcher-sm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                for="media_resize_mode"><?php echo trans("options::options.attributes.resize_mode") ?></label>
                                            <select id="media_resize_mode" class="form-control chosen-select chosen-rtl"
                                                    name="media_resize_mode">
                                                <?php foreach (["resize", "resize_crop", "color_background", "gradient_background", "blur_background"] as $mode) { ?>
                                                <option
                                                    value="<?php echo $mode; ?>"
                                                    <?php if (Config::get("media.resize_mode") == $mode) { ?> selected="selected" <?php } ?>><?php echo trans("options::options.resize_mode_" . $mode) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group color-background-area" style="display: none">
                                            <label
                                                for="resize_background_color"><?php echo trans("options::options.attributes.resize_background_color") ?></label>
                                            <input name="resize_background_color" type="text"
                                                   value="<?php echo @Request::old("resize_background_color", Config::get("media.resize_background_color")); ?>"
                                                   class="form-control color-input" id="resize_background_color"
                                                   placeholder="<?php echo trans("options::options.attributes.resize_background_color") ?>">
                                        </div>

                                        <div class="row gradient-background-area" style="display: none">

                                            <div class="form-group col-md-6">
                                                <label
                                                    for="resize_gradient_first_color"><?php echo trans("options::options.attributes.resize_gradient_first_color") ?></label>
                                                <input name="resize_gradient_first_color" type="text"
                                                       value="<?php echo @Request::old("resize_gradient_first_color", Config::get("media.resize_gradient_first_color")); ?>"
                                                       class="form-control color-input" id="resize_gradient_first_color"
                                                       placeholder="<?php echo trans("options::options.attributes.resize_gradient_first_color") ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label
                                                    for="resize_gradient_second_color"><?php echo trans("options::options.attributes.resize_gradient_second_color") ?></label>
                                                <input name="resize_gradient_second_color" type="text"
                                                       value="<?php echo @Request::old("resize_gradient_second_color", Config::get("media.resize_gradient_second_color")); ?>"
                                                       class="form-control color-input"
                                                       id="resize_gradient_second_color"
                                                       placeholder="<?php echo trans("options::options.attributes.resize_gradient_second_color") ?>">
                                            </div>

                                        </div>


                                        <?php /* ?>
                            <div class="form-group switch-row">
                                <label class="col-sm-10 control-label" for="media_cropping"><?php echo trans("options::options.attributes.media_cropping") ?></label>
                                <div class="col-sm-2">
                                    <input <?php if (Config::get("media.media_cropping")) { ?> checked="checked" <?php } ?> type="checkbox" id="media_cropping" name="media_cropping" value="1" class="switcher switcher-sm">
                                </div>
                            </div>

                            <div class="form-group switch-row">
                                <label class="col-sm-10 control-label" for="media_watermarking"><?php echo trans("options::options.attributes.media_watermarking") ?></label>
                                <div class="col-sm-2">
                                    <input <?php if (Config::get("media.media_watermarking")) { ?> checked="checked" <?php } ?> type="checkbox" id="media_watermarking" name="media_watermarking" value="1" class="switcher switcher-sm">
                                </div>
                            </div>
                            <?php */ ?>


                                    </div>
                                    <div class="col-md-6">

                                        <fieldset>
                                            <legend><?php echo trans("options::options.amazon_integration") ?></legend>

                                            <div class="form-group switch-row">
                                                <label class="col-sm-10 control-label"
                                                       for="s3_status"><?php echo trans("options::options.attributes.s3_status") ?></label>
                                                <div class="col-sm-2">
                                                    <input
                                                        <?php if (Config::get("media.s3.status")) { ?> checked="checked"
                                                        <?php } ?>
                                                        type="checkbox" id="s3_status" name="s3_status" value="1"
                                                        class="switcher switcher-sm">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="s3_bucket"
                                                       col-sm-10><?php echo trans("options::options.attributes.s3_bucket") ?></label>
                                                <input name="s3_bucket" type="text"
                                                       value="<?php echo @Request::old("s3_bucket", Config::get("media.s3.bucket")); ?>"
                                                       class="form-control" id="s3_bucket"
                                                       placeholder="<?php echo trans("options::options.attributes.s3_bucket") ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="s3_region"
                                                       col-sm-10><?php echo trans("options::options.attributes.s3_region") ?></label>
                                                <input name="s3_region" type="text"
                                                       value="<?php echo @Request::old("s3_region", Config::get("media.s3.region")); ?>"
                                                       class="form-control" id="s3_region"
                                                       placeholder="<?php echo trans("options::options.attributes.s3_region") ?>">
                                            </div>

                                            <div class="form-group switch-row">
                                                <label class="col-sm-10 control-label"
                                                       for="s3_delete_locally"><?php echo trans("options::options.attributes.s3_delete_locally") ?></label>
                                                <div class="col-sm-2">
                                                    <input
                                                        <?php if (Config::get("media.s3.delete_locally")) { ?> checked="checked"
                                                        <?php } ?>
                                                        type="checkbox" id="s3_delete_locally" name="s3_delete_locally"
                                                        value="1"
                                                        class="switcher switcher-sm">
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>
                                </div>

                            </div>

                        </div> <!-- / .panel-body -->
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

    @push("header")
        <link href="<?php echo assets("admin::tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
        <link href="<?php echo assets("admin::tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
        <link href="<?php echo assets("admin::css") ?>/plugins/colorpicker/bootstrap-colorpicker.min.css"
              rel="stylesheet">

        <style>

            .colorpicker {
                right: unset;
            }

        </style>

    @endpush
    @push("footer")
        <script src="<?php echo assets("admin::tagit") ?>/tag-it.js"></script>
        <script src="<?php echo assets("admin::js") ?>/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

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

                function switch_mode(mode) {

                    $(".gradient-background-area").hide();
                    $(".color-background-area").hide();

                    if (mode == "color_background") {
                        $(".color-background-area").show();
                    }

                    if (mode == "gradient_background") {
                        $(".gradient-background-area").show();
                    }

                }

                switch_mode($("[name=media_resize_mode]").val());
                $("[name=media_resize_mode]").change(function () {
                    var base = $(this);
                    var mode = base.val();
                    switch_mode(mode);
                });

                $('.color-input').colorpicker();


                $("#change_logo").filemanager({
                    types: "image",
                    done: function (result, base) {
                        if (result.length) {
                            var file = result[0];
                            $("#site_logo_path").val(file.media_path);
                            $("#site_logo").attr("src", file.media_thumbnail);
                        }
                    },
                    error: function (media_path) {
                        alert(media_path + " <?php echo trans("options::options.file_not_supported") ?>");
                    }
                });

                $("#mytags").tagit({
                    singleField: true,
                    singleFieldNode: $('#allowed_file_types'),
                    allowSpaces: true,
                    minLength: 2,
                    placeholderText: "",
                    removeConfirmation: true,
                    availableTags: ['jpg', 'png', 'jpeg', 'gif', 'doc', 'docx', 'txt', 'pdf', 'zip']
                });

            });
        </script>
    @endpush
@stop
