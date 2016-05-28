@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4">
        <h2>
            <i class="fa fa-tasks"></i>
            <?php echo trans("tasks::tasks.tasks") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/tasks"); ?>"><?php echo trans("tasks::tasks.tasks") ?> (<?php echo $tasks->total() ?>)</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-5"></div>
    <div class="col-lg-3">
        <?php if (User::access("tasks.create")) { ?>
            <a href="<?php echo route("admin.tasks.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("tasks::tasks.add_new") ?></a>
        <?php } ?>
    </div>
</div>
@stop
@section("content")
<div id="content-wrapper">
    @include("admin::partials.messages")
    <form action="" method="get" class="filter-form">
        <input type="hidden" name="per_page" value="<?php echo Request::get('per_page') ?>" />
        <input type="hidden" name="tag_id" value="<?php echo Request::get('tag_id') ?>" />
        <div class="row">
            <div class="col-sm-5 m-b-xs">
                <div class="form-group">
                    <select name="sort" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value="id" <?php if (Request::get("sort") == "id") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.sort_by"); ?></option>

                        <option value="title" <?php if (Request::get("sort") == "title") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.attributes.title"); ?></option>
                        <option value="start_date" <?php if (Request::get("sort") == "start_date") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.attributes.start_date"); ?></option>
                        <option value="end_date" <?php if (Request::get("sort") == "end_date") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.attributes.end_date"); ?></option>
                        <option value="done" <?php if (Request::get("sort") == "done") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.attributes.done"); ?></option>
                    </select>
                    <select name="order" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value="DESC" <?php if (Request::get("order") == "DESC") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.desc"); ?></option>
                        <option value="ASC" <?php if (Request::get("order") == "ASC") { ?> selected='selected' <?php } ?>><?php echo trans("tasks::tasks.asc"); ?></option>
                    </select>
                    <button type="submit" class="btn btn-primary"><?php echo trans("tasks::tasks.order"); ?></button>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="status" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value=""><?php echo trans("tasks::tasks.all"); ?></option>
                        <option <?php if (Request::get("status") == "1") { ?> selected='selected' <?php } ?> value="1"><?php echo trans("tasks::tasks.activated"); ?></option>
                        <option <?php if (Request::get("status") == "0") { ?> selected='selected' <?php } ?> value="0"><?php echo trans("tasks::tasks.deactivated"); ?></option>
                    </select>

                    <select name="done" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value=""><?php echo trans("tasks::tasks.all"); ?></option>
                        <option <?php if (Request::get("done") == "1") { ?> selected='selected' <?php } ?> value="1"><?php echo trans("tasks::tasks.completed"); ?></option>
                        <option <?php if (Request::get("done") == "0") { ?> selected='selected' <?php } ?> value="0"><?php echo trans("tasks::tasks.uncompleted"); ?></option>
                    </select>

                    <button type="submit" class="btn btn-primary"><?php echo trans("tasks::tasks.filter"); ?></button>
                </div>
            </div>

            <div class="col-lg-3">
                <form action="" method="get" class="search_form">
                    <div class="input-group">
                        <input name="q" value="<?php echo Request::get("q"); ?>" type="text" class=" form-control" placeholder="<?php echo trans("tasks::tasks.search_tasks") ?> ...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i> </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </form>
    <form action="" method="post" class="action_form">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <i class="fa fa-tasks"></i>
                    <?php echo trans("tasks::tasks.tasks") ?>
                </h5>
            </div>
            <div class="ibox-content">
                <?php if (count($tasks)) { ?>
                    <div class="row">
                        <div class="col-sm-4 m-b-xs">
                            <div class="form-group">
                                <select name="action" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                                    <option value="-1" selected="selected"><?php echo trans("tasks::tasks.bulk_actions"); ?></option>
                                    <?php if (User::access("tasks.delete")) { ?>
                                        <option value="delete"><?php echo trans("tasks::tasks.delete"); ?></option>
                                    <?php } ?>

                                    <option value="complete"><?php echo trans("tasks::tasks.complete"); ?></option>
                                    <option value="uncomplete"><?php echo trans("tasks::tasks.uncomplete"); ?></option>

                                    <?php if (User::access("tasks.edit")) { ?>
                                        <option value="activate"><?php echo trans("tasks::tasks.activate"); ?></option>
                                        <option value="deactivate"><?php echo trans("tasks::tasks.deactivate"); ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-primary"><?php echo trans("tasks::tasks.apply"); ?></button>
                            </div>
                        </div>
                        <div class="col-sm-5 m-b-xs"></div>
                        <div class="col-sm-3">
                            <select  name="post_status" id="post_status" class="form-control per_page_filter chosen-select chosen-rtl">
                                <option value="" selected="selected">-- <?php echo trans("tasks::tasks.per_page") ?> --</option>
                                <?php foreach (array(10, 20, 30, 40) as $num) { ?>
                                    <option value="<?php echo $num; ?>" <?php if ($num == $per_page) { ?> selected="selected" <?php } ?>><?php echo $num; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:35px"><input type="checkbox" class="i-checks check_all" name="ids[]" /></th>

                                    <th><?php echo trans("tasks::tasks.attributes.title"); ?></th>
                                    <th><?php echo trans("tasks::tasks.attributes.start_date"); ?></th>
                                    <th><?php echo trans("tasks::tasks.attributes.end_date"); ?></th>
                                    <th><?php echo trans("tasks::tasks.user"); ?></th>
                                    <th><?php echo trans("tasks::tasks.tags"); ?></th>
                                    <?php if (User::access("tasks.edit")) { ?>
                                        <th><?php echo trans("tasks::tasks.attributes.status"); ?></th>
                                    <?php } ?>
                                    <th><?php echo trans("tasks::tasks.attributes.done"); ?></th>

                                    <?php if (User::access("tasks.delete") or User::access("tasks.edit")) { ?>
                                        <th><?php echo trans("tasks::tasks.actions"); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task) { ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="i-checks" name="id[]" value="<?php echo $task->id; ?>" />
                                        </td>

                                        <td>
                                            <?php if (User::access("tasks.edit")) { ?>
                                                <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.edit"); ?>" class="text-navy" href="<?php echo route("admin.tasks.edit", array("id" => $task->id)); ?>">
                                                    <?php echo $task->title; ?>
                                                </a>
                                            <?php } else { ?>
                                                <?php echo $task->title; ?>
                                            <?php } ?>
                                            <br/>
                                            <?php if ($task->done) { ?>
                                                <p>
                                                    <?php echo trans("tasks::tasks.completed_by") ?> <?php echo $task->completedUser->username ?>
                                                    <?php echo trans("tasks::tasks.at") ?> <?php echo $task->completed_at ?>
                                                </p>
                                            <?php } ?>

                                        </td>

                                        <td>

                                            <?php echo $task->start_date; ?>
                                        </td>
                                        <td>

                                            <?php echo $task->end_date; ?>
                                        </td>

                                        <td>
                                            <a href="?user_id=<?php echo @$task->user->id; ?>" class="text-navy">
                                                <?php echo @$task->user->first_name; ?>
                                            </a>
                                        </td>

                                        <td>
                                            <?php foreach ($task->tags as $tag) { ?>
                                                <a href="?tag_id=<?php echo $tag->id; ?>" class="text-navy">
                                                    <span class="badge badge-primary"><?php echo $tag->name; ?></span>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <?php if (User::access("tasks.edit")) { ?>
                                            <td>
                                                <?php if ($task->status) { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.activated"); ?>" class="ask" message="<?php echo trans('tasks::tasks.sure_deactivate') ?>" href="<?php echo URL::route("admin.tasks.status", array("id" => $task->id, "status" => 0)) ?>">
                                                        <i class="fa fa-toggle-off text-success"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.deactivated"); ?>" class="ask" message="<?php echo trans('tasks::tasks.sure_activate') ?>" href="<?php echo URL::route("admin.tasks.status", array("id" => $task->id, "status" => 1)) ?>">
                                                        <i class="fa fa-toggle-off text-danger"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <?php if ($task->done) { ?>
                                                <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.completed"); ?>" class="ask" message="<?php echo trans('tasks::tasks.sure_uncomplete') ?>" href="<?php echo URL::route("admin.tasks.done", array("id" => $task->id, "status" => 0)) ?>">
                                                    <i class="fa fa-check-circle-o text-success"></i>
                                                </a>
                                            <?php } else { ?>
                                                <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.uncompleted"); ?>" class="ask" message="<?php echo trans('tasks::tasks.sure_complete') ?>" href="<?php echo URL::route("admin.tasks.done", array("id" => $task->id, "status" => 1)) ?>">
                                                    <i class="fa fa-circle-o text-danger"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <?php if (User::access("tasks.delete") or User::access("tasks.edit")) { ?>
                                            <td class="center">
                                                <?php if (User::access("tasks.edit")) { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.edit"); ?>" href="<?php echo route("admin.tasks.edit", array("id" => $task->id)); ?>">
                                                        <i class="fa fa-pencil text-navy"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php if (User::access("tasks.delete")) { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("tasks::tasks.delete"); ?>" class="delete_user ask" message="<?php echo trans("tasks::tasks.sure_delete") ?>" href="<?php echo URL::route("admin.tasks.delete", array("id" => $task->id)) ?>">
                                                        <i class="fa fa-times text-navy"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="dataTables_info" id="editable_info" role="status" aria-live="polite">
                                <?php echo trans("tasks::tasks.page"); ?> <?php echo $tasks->currentPage() ?> <?php echo trans("tasks::tasks.of") ?> <?php echo $tasks->lastPage() ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                <?php echo $tasks->appends(Request::all())->render(); ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php echo trans("tasks::tasks.no_records"); ?>
                <?php } ?>
            </div>
        </div>
    </form>
</div>
@section("footer")
@parent
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('.chosen-select').chosen();

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
    });
</script>
@stop
@stop
