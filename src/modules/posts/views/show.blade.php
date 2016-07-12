@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa fa-newspaper-o"></i>
            <?php echo trans("posts::posts.posts") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/posts"); ?>"><?php echo trans("posts::posts.posts") ?>
                    (<?php echo $posts->total() ?>)</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">
        <a href="<?php echo route("admin.posts.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span
                class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("posts::posts.add_new") ?></a>
    </div>
</div>
@stop
@section("content")
<div id="content-wrapper">
    @include("admin::partials.messages")
    <form action="" method="get" class="filter-form">
        <input type="hidden" name="per_post" value="<?php echo Request::get('per_post') ?>"/>
        <input type="hidden" name="tag_id" value="<?php echo Request::get('tag_id') ?>"/>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <select name="sort" class="form-control chosen-select chosen-rtl">
                        <option
                        <option
                            value="title" <?php if ($sort == "title") { ?> selected='selected' <?php } ?>><?php echo ucfirst(trans("posts::posts.attributes.title")); ?></option>
                        <option
                            value="created_at" <?php if ($sort == "created_at") { ?> selected='selected' <?php } ?>><?php echo ucfirst(trans("posts::posts.attributes.created_at")); ?></option>
                    </select>
                    <select name="order" class="form-control chosen-select chosen-rtl">
                        <option
                            value="DESC" <?php if ($order == "DESC") { ?> selected='selected' <?php } ?>><?php echo trans("posts::posts.desc"); ?></option>
                        <option
                            value="ASC" <?php if ($order == "ASC") { ?> selected='selected' <?php } ?>><?php echo trans("posts::posts.asc"); ?></option>
                    </select>
                    <button type="submit" class="btn btn-primary"><?php echo trans("posts::posts.order"); ?></button>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">

                    <select name="status" class="form-control chosen-select chosen-rtl">
                        <option value=""><?php echo trans("posts::posts.all"); ?></option>
                        <option <?php if (Request::get("status") == "1") { ?> selected='selected' <?php } ?>
                            value="1"><?php echo trans("posts::posts.activated"); ?></option>
                        <option <?php if (Request::get("status") == "0") { ?> selected='selected' <?php } ?>
                            value="0"><?php echo trans("posts::posts.deactivated"); ?></option>
                    </select>

                    <select name="category_id" class="form-control chosen-select chosen-rtl" >
                        <option value=""><?php echo trans("posts::posts.all_categories"); ?></option>
                        <?php
                        echo Category::tree(array(
                            "row" => function($row, $depth) {
                                $html = '<option value="' . $row->id . '"';
                                if (Request::get("category_id") == $row->id) {
                                    $html .= 'selected="selected"';
                                }
                                $html .= '>' . str_repeat("&nbsp;", $depth * 1) . " - " . $row->name . '</option>';
                                return $html;
                            }
                        ));
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary"><?php echo trans("posts::posts.filter"); ?></button>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <form action="" method="get" class="search_form">


                    <div class="input-group">
                        <input name="q" value="<?php echo Request::get("q"); ?>" type="text" class=" form-control"
                               placeholder="<?php echo trans("posts::posts.search_posts") ?> ...">
                        <span class="input-group-btn">search_posts
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>



                        <div class="input-group date datetimepick col-sm-6 pull-left" style="margin-top: 5px">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="from" type="text" value="<?php echo @Request::get("from"); ?>" class="form-control" id="input-from" placeholder="<?php echo trans("posts::posts.from") ?>">
                        </div>

                        <div class="input-group date datetimepick col-sm-6 pull-left"  style="margin-top: 5px">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="to" type="text" value="<?php echo @Request::get("to"); ?>" class="form-control" id="input-to" placeholder="<?php echo trans("posts::posts.to") ?>">
                        </div>


                </form>
            </div>
        </div>
    </form>
    <form action="" method="post" class="action_form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <i class="fa fa-file-text-o"></i>
                    <?php echo trans("posts::posts.posts") ?>
                </h5>
            </div>
            <div class="ibox-content">
                <?php if (count($posts)) { ?>
                    <div class="row">
                        <div class="col-lg-3 action-box">

                            <select name="action" class="form-control chosen-select chosen-rtl pull-left">
                                <option value="-1"
                                        selected="selected"><?php echo trans("posts::posts.bulk_actions"); ?></option>
                                <option value="delete"><?php echo trans("posts::posts.delete"); ?></option>
                                <option value="activate"><?php echo trans("posts::posts.activate"); ?></option>
                                <option value="deactivate"><?php echo trans("posts::posts.deactivate"); ?></option>
                            </select>

                            <button type="submit"
                                    class="btn btn-primary pull-right"><?php echo trans("posts::posts.apply"); ?></button>

                        </div>
                        <div class="col-lg-7">

                        </div>
                        <div class="col-lg-2">
                            <select name="post_status" id="post_status"
                                    class="form-control per_page_filter chosen-select chosen-rtl">
                                <option value="" selected="selected">-- <?php echo trans("posts::posts.per_page") ?>
                                    --
                                </option>
                                <?php foreach (array(10, 20, 30, 40) as $num) { ?>
                                    <option
                                        value="<?php echo $num; ?>" <?php if ($num == $per_page) { ?> selected="selected" <?php } ?>><?php echo $num; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width:35px"><input type="checkbox" class="i-checks check_all" name="ids[]"/>
                                </th>

                                <th><?php echo trans("posts::posts.attributes.title"); ?></th>
                                <th><?php echo trans("posts::posts.attributes.created_at"); ?></th>
                                <th><?php echo trans("posts::posts.user"); ?></th>

                                <th><?php echo trans("posts::posts.tags"); ?></th>
                                <th><?php echo trans("posts::posts.attributes.status"); ?></th>
                                <th><?php echo trans("posts::posts.actions"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($posts as $post) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="i-checks" name="id[]"
                                               value="<?php echo $post->id; ?>"/>
                                    </td>

                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("posts::posts.edit"); ?>" class="text-navy"
                                           href="<?php echo route("admin.posts.edit", array("id" => $post->id)); ?>">
                                            <strong><?php echo $post->title; ?></strong>
                                        </a>

                                    </td>
                                    <td>
                                        <small><?php echo $post->created_at->render(); ?></small>
                                    </td>
                                    <td>
                                        <a href="?user_id=<?php echo @$post->user->id; ?>" class="text-navy">
                                            <small> <?php echo @$post->user->first_name; ?></small>
                                        </a>
                                    </td>

                                    <td>
                                        <?php foreach ($post->tags as $tag) { ?>
                                            <a href="?tag_id=<?php echo $tag->id; ?>" class="text-navy">
                                                <span class="badge badge-primary"><?php echo $tag->name; ?></span>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($post->status) { ?>
                                            <a data-toggle="tooltip" data-placement="bottom"
                                               title="<?php echo trans("posts::posts.activated"); ?>" class="ask"
                                               message="<?php echo trans('posts::posts.sure_deactivate') ?>"
                                               href="<?php echo URL::route("admin.posts.status", array("id" => $post->id, "status" => 0)) ?>">
                                                <i class="fa fa-toggle-on text-success"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a data-toggle="tooltip" data-placement="bottom"
                                               title="<?php echo trans("posts::posts.deactivated"); ?>" class="ask"
                                               message="<?php echo trans('posts::posts.sure_activate') ?>"
                                               href="<?php echo URL::route("admin.posts.status", array("id" => $post->id, "status" => 1)) ?>">
                                                <i class="fa fa-toggle-off text-danger"></i>
                                            </a>
                                        <?php } ?>
                                    </td>

                                    <td class="center">
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("posts::posts.edit"); ?>"
                                           href="<?php echo route("admin.posts.edit", array("id" => $post->id)); ?>">
                                            <i class="fa fa-pencil text-navy"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("posts::posts.delete"); ?>" class="delete_user ask"
                                           message="<?php echo trans("posts::posts.sure_delete") ?>"
                                           href="<?php echo URL::route("admin.posts.delete", array("id" => $post->id)) ?>">
                                            <i class="fa fa-times text-navy"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="dataTables_info" id="editable_info" role="status" aria-live="polite">
                                <?php echo trans("posts::posts.post"); ?>
                                <?php echo $posts->currentPage() ?>
                                <?php echo trans("posts::posts.of") ?>
                                <?php echo $posts->lastPage() ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                <?php echo $posts->appends(Request::all())->render(); ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php echo trans("posts::posts.no_records"); ?>
                <?php } ?>
            </div>
        </div>
    </form>
</div>


@section("header")
@parent

<link href="<?php echo assets('admin::css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet" type="text/css">

@stop

@section("footer")
@parent

<script type="text/javascript" src="<?php echo assets('admin::js/plugins/moment/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo assets('admin::js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') ?>"></script>

<script>
    $(document).ready(function () {

        $('.datetimepick').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
        });

        $('[data-toggle="tooltip"]').tooltip();

        //$('.chosen-select').chosen();

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.check_all').on('ifChecked', function (event) {
            $("input[type=checkbox]").each(function () {
                $(this).iCheck('check');
                $(this).change();
            });
        });
        $('.check_all').on('ifUnchecked', function (event) {
            $("input[type=checkbox]").each(function () {
                $(this).iCheck('uncheck');
                $(this).change();
            });
        });
        $(".filter-form input[name=per_page]").val($(".per_page_filter").val());
        $(".per_page_filter").change(function () {
            var base = $(this);
            var per_page = base.val();
            $(".filter-form input[name=per_page]").val(per_page);
            $(".filter-form").submit();
        });

        $(".filter-form input[name=from]").val($(".datetimepick input[name=from]").val());
        $(".filter-form input[name=to]").val($(".datetimepick input[name=to]").val());
        $(".date_filter").click(function () {
            var base = $(this);
            var from = $(".datetimepick input[name=from]").val();
            var to = $(".datetimepick input[name=to]").val();
            $(".filter-form input[name=from]").val(from);
            $(".filter-form input[name=to]").val(to);
            $(".filter-form").submit();
        });
    });
</script>
@stop
@stop
