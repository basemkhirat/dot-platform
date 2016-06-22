@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa fa-newspaper-o"></i>
            <?php
            if ($post) {
                echo trans("posts::posts.edit");
            } else {
                echo trans("posts::posts.add_new");
            }
            ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/posts"); ?>"><?php echo trans("posts::posts.posts"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php
                    if ($post) {
                        echo trans("posts::posts.edit");
                    } else {
                        echo trans("posts::posts.add_new");
                    }
                    ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">
        <?php if ($post) { ?>
            <a href="<?php echo route("admin.posts.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("posts::posts.add_new") ?></a>
        <?php } else { ?>
            <a href="<?php echo route("admin.posts.show"); ?>" class="btn btn-primary btn-labeled btn-main">
                <?php echo trans("posts::posts.back_to_posts") ?>
                &nbsp; <i class="fa fa-chevron-left"></i>
            </a>
        <?php } ?>
    </div>
</div>
@stop
@section("content")
@include("admin::partials.messages")
<form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <textarea name="title" class="form-control input-lg" rows="1" id="post_title"
                                  placeholder="<?php echo trans("posts::posts.attributes.title") ?>"><?php echo @Request::old("title", $post->title); ?></textarea>
                    </div>

                    <div class="form-group">
                        <textarea name="excerpt" class="form-control" id="post_excerpt"
                                  placeholder="<?php echo trans("posts::posts.attributes.excerpt") ?>"><?php echo @Request::old("excerpt", $post->excerpt); ?></textarea>
                    </div>

                    <div class="form-group">
                        @include("admin::partials.editor", ["name" => "content", "id" => "postcontent", "value" =>
                        @$post->content])
                    </div>

                </div>
            </div>


            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-camera"></i>
                            <?php echo trans("posts::posts.add_image"); ?>
                            <a class="remove-post-image pull-right" href="javascript:void(0)">
                                <i class="fa fa-times text-navy"></i>
                            </a>
                        </div>
                        <div class="panel-body form-group">
                            <div class="row post-image-block">
                                <input type="hidden" name="image_id" class="post-image-id"
                                       value="<?php if ($post and isset($post->image)) {
                                           echo $post->image->id;
                                       } ?>">

                                <a class="change-post-image label" href="javascript:void(0)">
                                    <i class="fa fa-pencil text-navy"></i>
                                    <?php echo trans("posts::posts.change_image"); ?>
                                </a>

                                <a class="post-media-preview" href="javascript:void(0)">
                                    <img width="100%" height="130px" class="post-image"
                                         src="<?php if ($post and @ $post->image) { ?> <?php echo thumbnail($post->image->path); ?> <?php } else { ?> <?php echo assets("admin::default/image.png"); ?><?php } ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-camera"></i>
                            <?php echo trans("posts::posts.add_media"); ?>
                            <a class="remove-post-media pull-right" href="javascript:void(0)">
                                <i class="fa fa-times text-navy"></i>
                            </a>
                        </div>
                        <div class="panel-body form-group">
                            <div class="row post-media-block">
                                <input type="hidden" name="media_id" class="post-media-id"
                                       value="<?php if ($post and isset($post->media)) {
                                           echo $post->media->id;
                                       } ?>">

                                <a class="change-post-media label" href="javascript:void(0)">
                                    <i class="fa fa-pencil text-navy"></i>
                                    <?php echo trans("posts::posts.change_media"); ?>
                                </a>

                                <a class="post-media-preview" href="javascript:void(0)">
                                    <img width="100%" height="130px" class="post-media"
                                         src="<?php if ($post and @ $post->media) { ?> <?php echo($post->media->provider_image); ?> <?php } else { ?> <?php echo assets("admin::default/video.png"); ?><?php } ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square"></i>
                    <?php echo trans("posts::posts.post_status"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group switch-row">
                        <label class="col-sm-9 control-label"
                               for="input-status"><?php echo trans("posts::posts.attributes.status") ?></label>
                        <div class="col-sm-3">
                            <input <?php if (@Request::old("status", $post->status)) { ?> checked="checked" <?php } ?>
                                type="checkbox" id="input-status" name="status" value="1"
                                class="status-switcher switcher-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-folder"></i>
                    <?php echo trans("posts::posts.attributes.format"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="margin-bottom:0px">

                        <?php foreach (["post" => "fa-newspaper-o", "article" => "fa-newspaper-o", "video" => "fa-video-camera"] as $format => $icon) { ?>
                            <div class="radio" style="margin-top: 0;">
                                <label>
                                    <input type="radio" name="format" value="<?php echo $format; ?>" class="i-checks"
                                           <?php if ((!$post->id and $format == "post") or ($post and $post->format == $format)) { ?>checked<?php } ?>>&nbsp;
                                    <i class="fa <?php echo $icon ?>"></i>&nbsp;
                                    <span class="lbl"><?php echo trans('posts::posts.format_' . $format); ?></span>
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                </div>

            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-folder"></i>
                    <?php echo trans("posts::posts.add_category"); ?>
                </div>
                <div class="panel-body">

                    <?php if (Category::count()) { ?>
                        <ul class='tree-views'>
                            <?php
                            echo Category::tree(array(
                                "row" => function ($row, $depth) use ($post, $post_categories) {
                                    $html = "<li><div class='tree-row checkbox i-checks'><a class='expand' href='javascript:void(0)'>+</a> <label><input type='checkbox' ";
                                    if ($post and in_array($row->id, $post_categories->lists("id")->toArray())) {
                                        $html .= 'checked="checked"';
                                    }
                                    $html .= "name='categories[]' value='" . $row->id . "'> &nbsp;" . $row->name . "</label></div>";
                                    return $html;
                                }
                            ));
                            ?>
                        </ul>
                    <?php } else { ?>
                        <?php echo trans("categories::categories.no_records"); ?>
                    <?php } ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tags"></i>
                    <?php echo trans("posts::posts.add_tag"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="position:relative">
                        <input type="hidden" name="tags" id="tags_names" value="<?php echo join(",", $post_tags); ?>">
                        <ul id="mytags"></ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div>
        <div class="container-fluid">
            <div class="form-group">
                <input type="submit" class="pull-left btn btn-flat btn-primary"
                       value="<?php echo trans("posts::posts.save_post") ?>"/>
            </div>
        </div>
    </div>

</form>
@section("header")
@parent
<link href="<?php echo assets("admin::tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("admin::tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@stop
@section("footer")
@parent
<script type="text/javascript" src="<?php echo assets("admin::tagit") ?>/tag-it.js"></script>
<script type="text/javascript" src="<?php echo assets('admin::ckeditor/ckeditor.js') ?>"></script>
<script>

    $(document).ready(function () {

        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.tree-views input[type=checkbox]').on('ifChecked', function () {
            var checkbox = $(this).closest('ul').parent("li").find("input[type=checkbox]").first();
            checkbox.iCheck('check');
            checkbox.change();
        });
        $('.tree-views input[type=checkbox]').on('ifUnchecked', function () {
            var checkbox = $(this).closest('ul').parent("li").find("input[type=checkbox]").first();
            checkbox.iCheck('uncheck');
            checkbox.change();
        });
        $(".expand").each(function (index, element) {
            var base = $(this);
            if (base.parents("li").find("ul").first().length > 0) {
                base.text("+");
            } else {
                base.text("-");
            }
        });
        $("body").on("click", ".expand", function () {
            var base = $(this);
            if (base.text() == "+") {
                if (base.closest("li").find("ul").length > 0) {
                    base.closest("li").find("ul").first().slideDown("fast");
                    base.text("-");
                }
                base.closest("li").find(".expand").last().text("-");
            } else {
                if (base.closest("li").find("ul").length > 0) {
                    base.closest("li").find("ul").first().slideUp("fast");
                    base.text("+");
                }
            }
            return false;
        });


        $(".change-post-image").filemanager({
            types: "image",
            done: function (result, base) {
                if (result.length) {
                    var file = result[0];
                    base.parents(".post-image-block").find(".post-image-id").first().val(file.id);
                    base.parents(".post-image-block").find(".post-image").first().attr("src", file.thumbnail);
                }
            },
            error: function (media_path) {
                alert_box("<?php echo trans("posts::posts.not_image_file") ?>");
            }
        });

        $(".change-post-media").filemanager({
            types: "video",
            done: function (result, base) {
                if (result.length) {
                    var file = result[0];
                    base.parents(".post-media-block").find(".post-media-id").first().val(file.id);
                    base.parents(".post-media-block").find(".post-media").first().attr("src", file.thumbnail);
                }
            },
            error: function (media_path) {
                alert_box("<?php echo trans("posts::posts.not_media_file") ?>");
            }
        });

        $(".remove-post-image").click(function () {
            var base = $(this);
            $(".post-image-id").first().val(0);
            $(".post-image").attr("src", "<?php echo assets("admin::default/post.png"); ?>");
        });

        $(".remove-post-media").click(function () {
            var base = $(this);
            $(".post-media-id").first().val(0);
            $(".post-media").attr("src", "<?php echo assets("admin::default/media.gif"); ?>");
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
                    url: "<?php echo route("admin.tags.search"); ?>",
                    data: {q: request.term},
                    dataType: "json",
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: item.name,
                                value: item.name
                            }
                        }));
                    }
                });
            },
            beforeTagAdded: function (event, ui) {
                $("#metakeywords").tagit("createTag", ui.tagLabel);
            }
        });

    });


</script>

@stop
@stop
