@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa fa-file-text-o"></i>
            <?php
            if ($page) {
                echo trans("pages::pages.edit");
            } else {
                echo trans("pages::pages.add_new");
            }
            ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/pages"); ?>"><?php echo trans("pages::pages.pages"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php
                    if ($page) {
                        echo trans("pages::pages.edit");
                    } else {
                        echo trans("pages::pages.add_new");
                    }
                    ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">
        <?php if ($page) { ?>
            <a href="<?php echo route("admin.pages.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("pages::pages.add_new") ?></a>
        <?php } else { ?>
            <a href="<?php echo route("admin.pages.show"); ?>" class="btn btn-primary btn-labeled btn-main">
                <?php echo trans("pages::pages.back_to_pages") ?>
                &nbsp;  <i class="fa fa-chevron-left"></i>
            </a>
        <?php } ?>
    </div>
</div>
@stop
@section("content")
@include("admin::partials.messages")
<form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <textarea name="title" class="form-control input-lg" rows="1" id="post_title" placeholder="<?php echo trans("pages::pages.attributes.title") ?>"><?php echo @Request::old("title", $page->title); ?></textarea>
                    </div>

                    <div class="form-group">
                        <textarea name="excerpt" class="form-control" id="post_excerpt" placeholder="<?php echo trans("pages::pages.attributes.excerpt") ?>"><?php echo @Request::old("excerpt", $page->excerpt); ?></textarea>
                    </div>

                    <div class="form-group">
                        @include("admin::partials.editor", ["name" => "content", "id" => "pagecontent", "value" => @$page->content])
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square"></i>
                    <?php echo trans("pages::pages.page_status"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group switch-row">
                        <label class="col-sm-9 control-label" for="input-status"><?php echo trans("pages::pages.attributes.status") ?></label>
                        <div class="col-sm-3">
                            <input <?php if (@Request::old("status", $page->status)) { ?> checked="checked" <?php } ?> type="checkbox" id="input-status" name="status" value="1" class="status-switcher switcher-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-picture-o"></i>
                    <?php echo trans("pages::pages.add_image"); ?>
                </div>
                <div class="panel-body form-group">
                    <div class="row post-image-block">
                        <input type="hidden" name="image_id" class="post-image-id" value="<?php
                        if ($page and @ $page->image) {
                            echo @$page->image->id;
                        }
                        ?>">
                        <a class="change-post-image label" href="javascript:void(0)">
                            <i class="fa fa-pencil text-navy"></i>
                            <?php echo trans("pages::pages.change_image"); ?>
                        </a>
                        <a class="post-image-preview" href="javascript:void(0)">
                            <img width="100%" height="130px" class="post-image" src="<?php if ($page and @ $page->image) { ?> <?php echo thumbnail(@$page->image->path); ?> <?php } else { ?> <?php echo assets("admin::default/image.png"); ?><?php } ?>">
                        </a>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tags"></i>
                    <?php echo trans("pages::pages.add_tag"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="position:relative">
                        <input type="hidden" name="tags" id="tags_names" value="<?php echo join(",", $page_tags); ?>">
                        <ul id="mytags"></ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div>
        <div class="container-fluid">
            <div class="form-group">
                <input type="submit" class="pull-left btn btn-flat btn-primary" value="<?php echo trans("pages::pages.save_page") ?>" />
            </div>
        </div>
    </div>

</form>
@section("header")
@parent
<link href="<?php echo assets("admin::tagit")?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("admin::tagit")?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@stop
@section("footer")
@parent
<script type="text/javascript" src="<?php echo assets("admin::tagit")?>/tag-it.js"></script>
<script type="text/javascript" src="<?php echo assets('admin::ckeditor/ckeditor.js') ?>"></script>
<script>
    var baseURL = '{!! URL::to("/".ADMIN) !!}/';
    var postURL = '{!! URL::to(' / details / ') !!}/{!!$page->slug!!}';
    var baseURL2 = '{!! URL::to("") !!}/';
    var assetsURL = '{!! assets("") !!}/';
    var post_id = "{!!$page->id!!}";
    var mongo_id = false;
    var AMAZON_URL = "{!!AMAZON_URL!!}";

    $(document).ready(function () {

        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
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
                alert("<?php echo trans("pages::pages.not_allowed_file") ?>");
            }
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


    $(window).load(function () {
        // slug
        $('.edit_slug').click(function (e) {
            e.preventDefault();
            $('.edit_slug').hide();
            $('#permalink_ok').show();
            $('#permalink_cancel').show();
            $('#slug_name').hide();
            $('#new-post-slug').show();
        });

        $('#permalink_cancel').click(function (e) {
            e.preventDefault();
            $(this).hide();
            $('#permalink_ok').hide();
            $('.edit_slug').show();
            $('#new-post-slug').hide();
        });

        $('#permalink_ok').click(function (e) {
            e.preventDefault();
            ajaxData = {
                slug: $("#new-post-slug").val(),
                id: post_id
            };
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: baseURL + "pages/newSlug",
                data: ajaxData,
                beforeSend: function (res) {

                },
                success: function (res) {
                    $("#slug_name").html(res);
                    $("#editable-post-name-full").html(res);
                    //$("#wpseosnippet_slug").html(res);
                    $("#new-post-slug").val(res).hide();
                    $('#permalink_ok').hide();
                    $('#permalink_cancel').hide();
                    $('.edit_slug').show();
                    postURL = baseURL2 + "/details/" + res;
                    amtUpdateURL();
                },
                complete: function () {

                }
            });
        });
    });


</script>

@stop
@stop
