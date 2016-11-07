@extends("admin::layouts.master")

@section("breadcrumb")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
            <h2>
                <i class="fa fa-th-large"></i>
                <?php echo trans("navigations::navigations.module") ?>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
                </li>
                <li>
                    <a href="<?php echo URL::to(ADMIN . "/navigations"); ?>"><?php echo trans("navigations::navigations.module") ?></a>
                </li>
            </ol>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">

            <a data-toggle="modal"
               data-target="#createNavMenu" class="btn btn-primary btn-labeled btn-main">
        <span
                class="btn-label icon fa fa-plus"></span>
                &nbsp; <?php echo trans("navigations::navigations.add_new"); ?>
            </a>

        </div>
    </div>

@stop

@section("content")

    <div class="modal fade" id="createNavMenu" tabindex="-1" role="dialog"
         aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="create_nav_menu">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title"
                            id="myModalLabel"><?php echo trans("navigations::navigations.add_new"); ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="input-group input-group-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                                </span>
                            <input autocomplete="off"
                                   placeholder="<?php echo trans("navigations::navigations.attributes.name"); ?>"
                                   value="" class="form-control" name="name">


                        </div>

                        <div class="text-danger nav-form-error" style="margin: 5px;"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo trans("navigations::navigations.close"); ?>
                        </button>
                        <button type="submit"
                                data-loading-text="<?php echo trans("navigations::navigations.loading"); ?>"
                                class="btn btn-primary"><?php echo trans("navigations::navigations.save"); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (count($nav) == 0) { ?>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo trans("navigations::navigations.no_menus"); ?>
                </div>
            </div>
        </div>

    </div>
    <?php } ?>

    <?php if (count($nav)) { ?>


    <div class="modal fade" id="editNavMenu" tabindex="-1" role="dialog"
         aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="create_nav_menu">

                    <input type="hidden" name="id" value="<?php echo $nav->id ?>"/>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        <h4 class="modal-title"
                            id="myModalLabel"><?php echo trans("navigations::navigations.edit_menu"); ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="input-group input-group-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                                </span>
                            <input autocomplete="off"
                                   placeholder="<?php echo trans("navigations::navigations.attributes.name"); ?>"
                                   value="<?php echo $nav->name ?>" class="form-control" name="name">


                        </div>

                        <div class="text-danger nav-form-error" style="margin: 5px;"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo trans("navigations::navigations.close"); ?>
                        </button>
                        <button type="submit"
                                data-loading-text="<?php echo trans("navigations::navigations.loading"); ?>"
                                class="btn btn-primary"><?php echo trans("navigations::navigations.save"); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">


                    <div class="form-group">

                        <div class="dd-handle">
                            <div class="row">

                                <div class="col-md-9">
                                    <select id="input-type" class="form-control chosen-select chosen-rtl nav-selector"
                                            name="type">
                                        <?php foreach ($navs as $menu) { ?>
                                        <option
                                                value="<?php echo $menu->id; ?>"
                                                <?php if ($id == $menu->id) { ?> selected="selected" <?php } ?>><?php echo $menu->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-3">

                                    <a class="btn btn-danger btn-labeled pull-right delete-menu"
                                       data-id="<?php echo $nav->id; ?>" style="margin: 5px">
        <span
                class="btn-label icon fa fa-trash"></span>
                                    </a>

                                    <a data-toggle="modal"
                                       data-target="#editNavMenu" class="btn btn-primary btn-labeled pull-right"
                                       style="margin: 5px">
        <span
                class="btn-label icon fa fa-edit"></span>
                                    </a>
                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="dd" id="nestable2">

                        <?php
                        $html = Nav::tree(array(

                                "query" => function ($query) use ($id) {
                                    return $query->where("menu", $id);
                                },

                                "row" => function ($row, $depth) {

                                    $name = strip_tags(trim(preg_replace('/\s\s+/', ' ', $row->name)));

                                    if ($row->type == "post") {
                                        $icon = "fa-newspaper-o";
                                    } elseif ($row->type == "page") {
                                        $icon = "fa-file-text-o";
                                    } elseif ($row->type == "tag") {
                                        $icon = "fa-tag";
                                    } elseif ($row->type == "category") {
                                        $icon = "fa-folder";
                                    } else {
                                        $icon = "fa-link";
                                    }

                                    $html = '<li class="dd-item" data-link="' . $row->link . '" data-id="' . $row->id . '" data-name="' . $name . '" data-type="' . $row->type . '" data-type_id="' . $row->type_id . '">
                                        <div class="dd-handle">

                                          <i class="fa ' . $icon . '"></i> &nbsp;' . $row->name
                                            . '</div> <a href="javascript:void(0)" class="pull-right remove-item"> <i class="fa fa-times"></i> </a>';
                                    return $html;
                                }
                        ));

                        ?>

                        <?php if(trim($html) == ""){ ?>
                            <?php echo '<div class="dd-empty"></div>'; ?>
                        <?php }else{ ?>
                        <ul class="dd-list">
                            <?php echo $html; ?>
                        </ul>
                        <?php } ?>


                    </div>

                    <form class="nav-items-form">

                        <input type="hidden" name="menu" value="<?php echo $id ?>"/>
                        <br/>

                        <textarea name="tree" id="nestable2-output" class="form-control hidden"></textarea>

                        <div class="dd-handle" style="overflow: hidden">

                            <button type="submit" class="btn btn-primary pull-right"
                                    data-loading-text="<?php echo trans("navigations::navigations.loading"); ?>">
                                <?php echo trans("navigations::navigations.save_items"); ?>
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="panel panel-default">
                <div class="panel-body">


                    <div class="panel-group" id="accordion">
                        <?php

                        foreach (["post", "page", "category", "tag"] as $type) {

                        if ($type == "post") {
                            $icon = "fa-newspaper-o";
                        } elseif ($type == "page") {
                            $icon = "fa-file-text-o";
                        } elseif ($type == "tag") {
                            $icon = "fa-tag";
                        } elseif ($type == "category") {
                            $icon = "fa-folder";
                        } else {
                            $icon = "fa-link";
                        }

                        ?>


                        <div class="panel panel-default">
                            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion"
                                 href="#collapse<?php echo $type ?>" style="cursor: pointer">
                                <h5 class="panel-title">

                                    <i class="fa <?php echo $icon; ?>"></i>

                                    <a data-toggle="collapse" data-parent="#accordion"
                                       href="#collapse<?php echo $type ?>"><?php echo trans("navigations::navigations." . str_plural($type)) ?></a>
                                </h5>
                            </div>
                            <div id="collapse<?php echo $type ?>"
                                 class="panel-collapse collapse <?php echo ($type == "post") ? "in" : ""; ?>">
                                <div class="panel-body">

                                    <form class="nav-search-form">

                                        <input type="hidden" name="type" value="<?php echo $type ?>">

                                        <div class="input-group">
                                            <input autocomplete="off" name="q" value="" type="text"
                                                   class=" form-control"
                                                   placeholder="<?php echo trans("navigations::navigations.search_" . str_plural($type)) ?> ..">
                                    <span class="input-group-btn">
                                        <button data-loading-text="<i class='fa fa-spinner fa-spin'><i>"
                                                class="btn btn-primary" type="submit"><i class="fa fa-search"></i>
                                        </button>
                                    </span>

                                        </div>

                                        <div class="search-items">

                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>


                        <?php } ?>

                        <div class="panel panel-default">
                            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion"
                                 href="#collapselink" style="cursor: pointer">
                                <h5 class="panel-title">

                                    <i class="fa fa-link"></i>

                                    <a><?php echo trans("navigations::navigations.links") ?></a>
                                </h5>
                            </div>
                            <div id="collapselink"
                                 class="panel-collapse collapse">
                                <div class="panel-body">

                                    <form class="nav-link-form">

                                        <input type="hidden" name="type" value="url">

                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                            <input autocomplete="off" required name="name" value=""
                                                   class="form-control input-lg"
                                                   placeholder="<?php echo trans("navigations::navigations.name") ?>"/>
                                        </div>

                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                            <input type="text" required autocomplete="off" name="link" value=""
                                                   class="form-control input-lg forign-box"
                                                   placeholder="http://example.com"/>
                                        </div>

                                        <div class="dd-handle" style="overflow: hidden">

                                            <button type="submit" class="btn btn-primary pull-right">
                                                <?php echo trans("navigations::navigations.add_item"); ?>
                                            </button>

                                        </div>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    </div>
    <?php } ?>

@stop


@section("header")


    <link href="<?php echo assets("admin::css/plugins/nestable/nestable.ltr.css"); ?>" type="text/css" rel="stylesheet" />

    <style>

        .dd-placeholder, .dd-empty {
            background: none;
        }


    </style>

@stop

@section("footer")

    <script src="<?php echo assets("admin::js/plugins/nestable/jquery.nestable.".DIRECTION.".js"); ?>"></script>

    <script>
        $(document).ready(function () {


            $(".nav-search-form").submit(function () {

                var base = $(this);

                var type = base.find("input[name=type]").first().val();
                var loader = base.find("button[type=submit]").first();

                loader.button("loading");

                $.post("<?php echo route("admin.navigations.search"); ?>", base.serialize(), function (data) {

                    base.find(".search-items").first().html(data);

                    loader.button("reset");

                    $('#nest-' + type).nestable({
                        listNodeName: 'ul',
                        group: 1
                    });

                });

                return false;
            });


            $(".create_nav_menu").submit(function () {


                var base = $(this);


                var loader = base.find("button[type=submit]").first();

                loader.button("loading");

                $.post("<?php echo route("admin.navigations.save_menu"); ?>", base.serialize(), function (result) {

                    if (result.name !== undefined) {
                        error = result.name.join(" ");
                        $(".nav-form-error").html(error);
                        loader.button("reset");
                        return false
                    }

                    loader.button("reset");


                    window.location.href = result.url;

                }, "json").fail(function () {
                    loader.button("reset");
                });


                return false;
            });

            $(".nav-selector").change(function () {

                var base = $(this);
                window.location.href = "<?php echo route("admin.navigations.show") ?>/" + base.val();

            });


            $(".nav-items-form").submit(function () {

                var base = $(this);

                var loader = base.find("button[type=submit]").first();

                loader.button("loading");

                $.post("<?php echo route("admin.navigations.save_items"); ?>", base.serialize(), function (data) {

                    base.find(".search-items").first().html(data);

                    loader.button("reset");

                    // reload parent window if iframe
                    if(window.self !== window.top) {
                        window.parent.location.reload()
                    }

                }).fail(function () {
                    loader.button("reset");
                });

                return false;
            });


            $(".nav-link-form").submit(function () {


                var base = $(this);

                var loader = base.find("button[type=submit]").first();

                loader.button("loading");

                $.post("<?php echo route("admin.navigations.add_link"); ?>", base.serialize(), function (data) {


                    $(".dd-list").append(data);

                    // $(data).insertBefore( $(".dd-list .dd-placeholder"));

                    base.find("[name=name]").first().val("");
                    base.find("[name=link]").first().val("");

                    loader.button("reset");

                    // activate Nestable for list 2
                    $('#nestable2').nestable({
                        listNodeName: 'ul',
                        group: 1
                    }).on('change', updateOutput);

                    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

                });

                return false;


            });


            $("body").on("click", ".remove-item", function () {

                var item = $(this).closest("li");

                confirm_box("<?php echo trans("navigations::navigations.confirm_item_delete"); ?>", function () {

                    item.remove();

                    // activate Nestable for list 2
                    $('#nestable2').nestable({
                        listNodeName: 'ul',
                        group: 1
                    }).on('change', updateOutput);

                    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

                    // check empty list
                    if ($("#nestable2 ul li").length == 0) {
                        $("#nestable2").html('<div class="dd-empty"></div>');
                    }

                });

            });

            $("body").on("click", ".delete-menu", function () {

                var id = $(this).attr("data-id");

                confirm_box("<?php echo trans("navigations::navigations.confirm_menu_delete"); ?>", function () {

                    $.post("<?php echo route("admin.navigations.delete_menu"); ?>", {id: id}, function (data) {
                        window.location.href = "<?php echo route("admin.navigations.show"); ?>";
                    });

                });

            });


            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                        output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 2
            $('#nestable2').nestable({
                listNodeName: 'ul',
                group: 1
            }).on('change', updateOutput);

            updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        });
    </script>

@stop