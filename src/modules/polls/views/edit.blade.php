@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa fa-pie-chart"></i>
            <?php if ($poll) {
                echo trans("polls::polls.edit");
            } else {
                echo trans("polls::polls.add_new");
            } ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/polls"); ?>"><?php echo trans("polls::polls.polls"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php if ($poll) {
                        echo trans("polls::polls.edit");
                    } else {
                        echo trans("polls::polls.add_new");
                    } ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">

        <a href="<?php echo route("admin.polls.show"); ?>" class="btn btn-primary btn-labeled btn-main">
            <i class="fa fa-bars"></i>
            <?php echo trans("polls::polls.back_to_polls") ?>
        </a>

        <?php if ($poll) { ?>
            <a href="<?php echo route("admin.polls.create"); ?>"
               class="btn btn-primary btn-labeled btn-main pull-right"> <span class="btn-label icon fa fa-plus"></span>
                &nbsp; <?php echo trans("polls::polls.add_new") ?></a>
        <?php } ?>

    </div>
</div>
@stop
@section("content")
@include("admin::partials.messages")
<form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
    <input type="hidden" name="parent" value="0"/>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label for="input-title"><?php echo trans("polls::polls.attributes.title") ?></label>
                        <input name="title" type="text" value="<?php echo @Request::old("title", $poll->title); ?>"
                               class="form-control" id="input-title"
                               placeholder="<?php echo trans("polls::polls.attributes.title") ?>">
                    </div>

                    <div class="form-group">
                        <label class="poll-left">
                            <?php echo trans("polls::polls.answers") ?>
                            &nbsp;
                            <a class="label pull-right poll-add" href="">
                                <i class="fa fa-plus"></i>
                            </a>
                        </label>
                        <div class="polls-area">

                            <?php if (count($poll->answers)) { ?>

                                <?php foreach ($poll->answers as $answer) { ?>
                                    <div class="row poll-row">

                                        <div class="col-md-2">
                                            <input type="hidden" name="images[]" value="<?php echo $answer->image ? $answer->image->id: 0 ?>"/>
                                            <img style="cursor: pointer;" width="50" height="50"
                                                 src="<?php echo $answer->image ? thumbnail($answer->image->path): assets("admin::default/post.png") ?>"
                                                 class="add-answer-image" rel="<?php echo  str_random(9); ?>"/>
                                        </div>

                                        <div class="input-group col-md-10">

                                            <input name="answers[]" type="text" value="<?php echo $answer->title ?>"
                                                   class="form-control" placeholder="">
                                    <span class="input-group-addon">
                                        <a class="poll-remove" href="">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </span>
                                        </div>

                                    </div>
                                <?php } ?>
                            <?php } else { ?>

                                <div class="row poll-row">

                                    <div class="col-md-2">
                                        <input type="hidden" name="images[]" value="0"/>
                                        <img style="cursor: pointer;" width="50" height="50"
                                             src="<?php echo assets("admin::default/post.png"); ?>"
                                             class="add-answer-image"/>
                                    </div>

                                    <div class="input-group col-md-10">

                                        <input name="answers[]" type="text" value=""
                                               class="form-control" placeholder="">
                                    <span class="input-group-addon">
                                        <a class="poll-remove" href="">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </span>
                                    </div>


                                </div>


                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div>
                <div class="container-fluid">
                    <div class="form-group">
                        <input type="submit" class="pull-left btn btn-flat btn-primary"
                               value="<?php echo trans("polls::polls.save_poll") ?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square"></i>
                    <?php echo trans("polls::polls.poll_status"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group switch-row">
                        <label class="col-sm-9 control-label"
                               for="input-status"><?php echo trans("polls::polls.attributes.status") ?></label>
                        <div class="col-sm-3">
                            <input <?php if (@Request::old("status", $poll->status)) { ?> checked="checked" <?php } ?>
                                type="checkbox" id="input-status" name="status" value="1"
                                class="status-switcher switcher-sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-picture-o"></i>
                    <?php echo trans("polls::polls.add_image"); ?>
                    <a class="remove-post-image pull-right" href="javascript:void(0)">
                        <i class="fa fa-times text-navy"></i>
                    </a>
                </div>
                <div class="panel-body form-group">
                    <div class="row post-image-block">
                        <input type="hidden" name="image_id" class="post-image-id"
                               value="<?php echo ($poll and $poll->image) ? $poll->image->id : 0; ?>">
                        <a class="change-post-image label" href="javascript:void(0)">
                            <i class="fa fa-pencil text-navy"></i>
                            <?php echo trans("polls::polls.change_image"); ?>
                        </a>
                        <a class="post-image-preview" href="javascript:void(0)">
                            <img width="100%" height="130px" class="post-image"
                                 src="<?php if ($poll and @ $poll->image->id != "") { ?> <?php echo thumbnail(@$poll->image->path); ?> <?php } else { ?> <?php echo assets("admin::default/post.png"); ?><?php } ?>">
                        </a>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tags"></i>
                    <?php echo trans("polls::polls.add_tag"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="position:relative">
                        <input type="hidden" name="tags" id="tags_names" value="<?php echo join(",", $poll_tags); ?>">
                        <ul id="mytags"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@push("header")

<link href="<?php echo assets("admin::tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("admin::tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
<style>

    .poll-row {
        margin: 5px 0;
    }

</style>

@endpush

@push("footer")

<script type="text/javascript" src="<?php echo assets("admin::tagit") ?>/tag-it.js"></script>
<script>

    $(document).ready(function () {


        var activate_file_manager = function(id){

            $(".add-answer-image[rel="+id+"]").filemanager({
                types: "image",
                done: function (result, base) {
                    if (result.length) {
                        var file = result[0];
                        base.attr("src", file.url);
                        base.parents(".poll-row").find("input").eq(0).val(file.id);
                    }
                },
                error: function (media_path) {
                    alert("s<?php echo trans("polls::polls.not_allowed_file") ?>");
                }
            });
        }


        $(".add-answer-image").each(function(){
            var random_key = $(this).attr("rel");
            activate_file_manager(random_key);
        });

        $(".poll-add").click(function () {

            var random_key = Math.floor((Math.random() * 9999999999) + 1);
            var html = `
                  <div class="row poll-row">

                        <div class="col-md-2">
                            <input type="hidden" name="images[]" value="0" />
                            <img style="cursor: pointer;" width="50" height="50"
                                 src="<?php echo assets("admin::default/post.png"); ?>"
                                 class="add-answer-image" rel="`+random_key+`"/>
                        </div>

                        <div class="input-group col-md-10">
                            <input name="answers[]" type="text" value="" class="form-control" placeholder="">
                            <span class="input-group-addon">
                                <a class="poll-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                        </div>

                    </div>
                  `;

            $(".polls-area").append(html);

            activate_file_manager(random_key);

            return false;
        });

        $("body").on("click", ".poll-remove", function () {

            if ($(".polls-area .poll-row").length <= 2) {
                alert_box("<?php echo trans("polls::polls.min_two_answers"); ?>");
            } else {
                $(this).parents(".poll-row").remove();
            }

            return false;
        });



        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        /*
        $(".add-answer-image").filemanager({
            types: "image",
            done: function (result, base) {
                if (result.length) {
                    var file = result[0];
                    base.attr("src", file.url);
                    base.parents("poll-row").find("input").eq(0).val(file.id);
                }
            },
            error: function (media_path) {
                alert("s<?php echo trans("polls::polls.not_allowed_file") ?>");
            }
        });
        */

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
                alert("<?php echo trans("polls::polls.not_allowed_file") ?>");
            }
        });
        $(".remove-post-image").click(function () {
            var base = $(this);
            $(".post-image-id").first().val(0);
            $(".post-image").attr("src", "<?php echo assets("admin::default/post.png"); ?>");
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
                    data: {term: request.term},
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
            }
        });

    });
</script>
@endpush

@stop
