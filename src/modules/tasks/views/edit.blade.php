@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-7">
        <h2>
            <i class="fa fa-tasks"></i>
            <?php
            if ($task) {
                echo trans("tasks::tasks.edit");
            } else {
                echo trans("tasks::tasks.add_new");
            }
            ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/tasks"); ?>"><?php echo trans("tasks::tasks.tasks"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php
                    if ($task) {
                        echo trans("tasks::tasks.edit");
                    } else {
                        echo trans("tasks::tasks.add_new");
                    }
                    ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
        <?php if ($task) { ?>
            <a href="<?php echo route("admin.tasks.create"); ?>" class="btn btn-primary btn-labeled btn-main pull-right"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("tasks::tasks.add_new") ?></a>
        <?php } ?>
        <a href="<?php echo route("admin.tasks.show"); ?>" class="btn btn-primary btn-labeled btn-main pull-right">
            <?php echo trans("tasks::tasks.back_to_tasks") ?>
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


                    <div class="form-group">
                        <label for="input-title"><?php echo trans("tasks::tasks.attributes.title") ?></label>
                        <input name="title" type="text" value="<?php echo @Request::old("title", $task->title); ?>" class="form-control" id="input-title" placeholder="<?php echo trans("tasks::tasks.attributes.title") ?>">
                    </div>

                    <div class="form-group">
                        @include("admin::partials.editor", ["name" => "description", "id" => "description", "value" => @$task->description])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square"></i>
                    <?php echo trans("tasks::tasks.task_status"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group switch-row">
                        <label class="col-sm-9 control-label" for="input-status"><?php echo trans("tasks::tasks.attributes.status") ?></label>
                        <div class="col-sm-3">
                            <input <?php if (@Request::old("status", $task->status)) { ?> checked="checked" <?php } ?> type="checkbox" id="input-status" name="status" value="1" class="status-switcher switcher-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users"></i>
                    <?php echo trans("tasks::tasks.assigned_to"); ?>
                </div>
                <div class="panel-body">


                    <div class="form-group" style="position:relative" id="tasks_groups_area">
                        <label for="tasks_groups"><?php echo trans("tasks::tasks.select_groups") ?></label>
                        <input type="hidden" name="groups" id="tasks_groups" value="<?php echo join(",", $task_groups); ?>">
                        <ul id="tasks_groups_box"></ul>
                    </div>

                    <div class="form-group" style="position:relative" id="tasks_users_area">
                        <label for="tasks_users"><?php echo trans("tasks::tasks.select_users") ?></label>
                        <input type="hidden" name="users" id="tasks_users" value="<?php echo join(",", $task_users); ?>">
                        <ul id="tasks_users_box"></ul>
                    </div>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-clock-o"></i>
                    <?php echo trans("tasks::tasks.period"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="input-start_date"><?php echo trans("tasks::tasks.attributes.start_date") ?></label>
                        <div class="input-group date datetimepick">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="start_date" type="text" value="<?php echo @Request::old("start_date", $task->start_date); ?>" class="form-control" id="input-start_date" placeholder="<?php echo trans("tasks::tasks.attributes.start_date") ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-end_date"><?php echo trans("tasks::tasks.attributes.end_date") ?></label>
                        <div class="input-group date datetimepick">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="end_date" type="text" value="<?php echo @Request::old("end_date", $task->end_date); ?>" class="form-control" id="input-end_date" placeholder="<?php echo trans("tasks::tasks.attributes.end_date") ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tags"></i>
                    <?php echo trans("tasks::tasks.add_tag"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="position:relative">
                        <input type="hidden" name="tags" id="tags_names" value="<?php echo join(",", $task_tags); ?>">
                        <ul id="mytags"></ul>
                    </div>
                </div>
            </div>




        </div>
        <div style="clear:both"></div>
        <div>
            <div class="panel-footer" style="border-top: 1px solid #ececec; position: relative;">
                <div class="form-group" style="margin-bottom:0">
                    <input type="submit" class="pull-right btn btn-flat btn-primary" value="<?php echo trans("tasks::tasks.save_task") ?>" />
                </div>
            </div>
        </div>
    </div>
</form>
@section("header")
@parent
<link href="<?php echo assets("tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets('css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet" type="text/css">
@stop
@section("footer")
@parent
<script type="text/javascript" src="<?php echo assets("tagit") ?>/tag-it.js"></script>
<script type="text/javascript" src="<?php echo assets('ckeditor/ckeditor.js') ?>"></script>
<script type="text/javascript" src="<?php echo assets('js/plugins/moment/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo assets('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        $('.datetimepick').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
        });
        $('.chosen-select').chosen();

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

        $("#tasks_groups_box").tagit({
            singleField: true,
            singleFieldNode: $('#tasks_groups'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "",
            removeConfirmation: true,
            tagSource: function (request, response) {
                $.ajax({
                    url: "<?php echo route("admin.groups.search"); ?>",
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

        $("#tasks_users_box").tagit({
            singleField: true,
            singleFieldNode: $('#tasks_users'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "",
            removeConfirmation: true,
            tagSource: function (request, response) {
                $.ajax({
                    url: "<?php echo route("admin.users.search"); ?>",
                    data: {term: request.term},
                    dataType: "json",
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: item.username,
                                value: item.username
                            }
                        }));
                    }
                });
            }
        });




    });
</script>
@stop
@stop
