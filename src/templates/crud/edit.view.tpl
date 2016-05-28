@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-7">
        <h2>
        <i class="fa #options.icon#"></i>
        <?php if($#model#){
            echo trans("#module#::#module#.edit");
           }else{
            echo trans("#module#::#module#.add_new");
           } ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/#module#"); ?>"><?php echo trans("#module#::#module#.#module#"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php if($#model#){
                     echo trans("#module#::#module#.edit");
                    }else{
                     echo trans("#module#::#module#.add_new");
                    } ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
        <?php if($#model#){ ?>
           <a href="<?php echo route("admin.#module#.create"); ?>" class="btn btn-primary btn-labeled btn-main pull-right"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("#module#::#module#.add_new") ?></a>
        <?php } ?>
        <a href="<?php echo route("admin.#module#.show"); ?>" class="btn btn-primary btn-labeled btn-main pull-right">
            <?php echo trans("#module#::#module#.back_to_#module#") ?>
            &nbsp;  <i class="fa fa-chevron-left"></i>
        </a>
    </div>
</div>
@stop
@section("content")
@include("admin::partials.messages")
<form action="" method="post">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    [loop html as code]
                    #code#
                    [/loop]
                </div>
            </div>
        </div>
        <div class="col-md-4">
            {if options.status}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square"></i>
                    <?php echo trans("#module#::#module#.#model#_status"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group switch-row">
                        <label class="col-sm-9 control-label" for="input-status"><?php echo trans("#module#::#module#.attributes.status") ?></label>
                        <div class="col-sm-3">
                            <input <?php if (@Request::old("status", $#model#->status)) { ?> checked="checked" <?php } ?> type="checkbox" id="input-status" name="status" value="1" class="status-switcher switcher-sm">
                        </div>
                    </div>
                </div>
            </div>
            {/if}
            {if module.image}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-picture-o"></i>
                    <?php echo trans("#module#::#module#.add_image"); ?>
                </div>
                <div class="panel-body form-group">

                    <div class="row post-image-block">
                        <input type="hidden" name="image_id" class="post-image-id" value="<?php
                        if ($#model# and @ $#model#->image->media_path != "") {
                            echo @$#model#->image->media_id;
                        }
                        ?>">

                        <a class="change-post-image label" href="javascript:void(0)">
                            <i class="fa fa-pencil text-navy"></i>
                            <?php echo trans("#module#::#module#.change_image"); ?>
                        </a>

                        <a class="post-image-preview" href="javascript:void(0)">
                            <img width="100%" height="130px" class="post-image" src="<?php if ($#model# and @ $#model#->image->media_id != "") { ?> <?php echo thumbnail(@$#model#->image->media_path); ?> <?php } else { ?> <?php echo assets("default/post.png"); ?><?php } ?>">
                        </a>

                    </div>
                </div>
            </div>
            {/if}
            {if module.categories}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-folder"></i>
                    <?php echo trans("#module#::#module#.add_category"); ?>
                </div>

                <div class="panel-body">
                    <ul class='tree-views'>
                        <?php
                        echo Category::tree(array(
                            "row" => function($row, $depth) use ($#model#_categories) {
                                $html = "<li><div class='tree-row checkbox i-checks'><a class='expand' href='javascript:void(0)'>+</a><label><input type='checkbox' ";
                                if (in_array($row->id, $#model#_categories)) {
                                    $html .= 'checked="checked"';
                                }
                                $html .= "name='categories[]' value='" . $row->id . "'> " . $row->name . "</label></div>";
                                return $html;
                            }
                        ));
                        ?>
                    </ul>
                </div>
            </div>
            {/if}
            {if module.tags}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tags"></i>
                    <?php echo trans("#module#::#module#.add_tag"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="position:relative">
                        <input type="hidden" name="tags" id="tags_names" value="<?php echo join(",", $#model#_tags); ?>">
                        <ul id="mytags"></ul>
                    </div>
                </div>
            </div>
            {/if}
        </div>
        <div style="clear:both"></div>
        <div>
            <div class="panel-footer" style="border-top: 1px solid #ececec; position: relative;">
                <div class="form-group" style="margin-bottom:0">
                    <input type="submit" class="pull-right btn btn-flat btn-primary" value="<?php echo trans("#module#::#module#.save_#model#") ?>" />
                </div>
            </div>
        </div>
    </div>
</form>
@section("header")
@parent
{if module.tags}
<link href="<?php echo assets("tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
{/if}
[loop stylesheets as link]
<link href="<?php echo assets('#link#') ?>" rel="stylesheet" type="text/css">
[/loop]
@stop
@section("footer")
@parent
{if module.tags}
<script type="text/javascript" src="<?php echo assets("tagit") ?>/tag-it.js"></script>
{/if}
[loop javascripts as link]
<script type="text/javascript" src="<?php echo assets('#link#') ?>"></script>
[/loop]
<script>
    $(document).ready(function () {
        {if options.status}
        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });
        {/if}
        [loop codes as code]
        #code#
        [/loop]
        {if module.image}
        $(".change-post-image").filemanager({
            types: "image",
            done: function (result, base) {
                if (result.length) {
                    var file = result[0];
                    base.parents(".post-image-block").find(".post-image-id").first().val(file.media_id);
                    base.parents(".post-image-block").find(".post-image").first().attr("src", file.media_thumbnail);
                }
            },
            error: function (media_path) {
                alert("<?php echo trans("#module#::#module#.not_allowed_file") ?>");
            }
        });
        {/if}
        {if module.tags}
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
        {/if}
        {if module.categories}
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
        {/if}
    });
</script>
@stop
@stop
