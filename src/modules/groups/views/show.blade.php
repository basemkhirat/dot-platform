@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4">
        <h2>
            <i class="fa fa-th-large"></i>
            <?php echo trans("groups::groups.groups") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
            </li>
            <li>
                <a href="<?php echo URL::to(ADMIN . "/groups"); ?>"><?php echo trans("groups::groups.groups") ?> (<?php echo $groups->total() ?>)</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-5"></div>
    <div class="col-lg-3">
        <?php if (User::access("groups.create")) { ?>
            <a href="<?php echo route("admin.groups.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("groups::groups.add_new") ?></a>
        <?php } ?>
    </div>
</div>
@stop
@section("content")
<div id="content-wrapper">
    @include("admin::partials.messages")
    <form action="" method="get" class="filter-form">
        <input type="hidden" name="per_page" value="<?php echo Request::get('per_page') ?>" />

        <div class="row">
            <div class="col-sm-5 m-b-xs">
                <div class="form-group">
                    <select name="sort" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value="id" <?php if (Request::get("sort") == "id") { ?> selected='selected' <?php } ?>><?php echo trans("groups::groups.sort_by"); ?></option>

                        <option value="name" <?php if (Request::get("sort") == "name") { ?> selected='selected' <?php } ?>><?php echo trans("groups::groups.attributes.name"); ?></option>
                        <option value="created_at" <?php if (Request::get("sort") == "created_at") { ?> selected='selected' <?php } ?>><?php echo trans("groups::groups.attributes.created_at"); ?></option>
                        <option value="updated_at" <?php if (Request::get("sort") == "updated_at") { ?> selected='selected' <?php } ?>><?php echo trans("groups::groups.attributes.updated_at"); ?></option>
                    </select>
                    <select name="order" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value="DESC" <?php if (Request::get("order") == "DESC") { ?> selected='selected' <?php } ?>><?php echo trans("groups::groups.desc"); ?></option>
                        <option value="ASC" <?php if (Request::get("order") == "ASC") { ?> selected='selected' <?php } ?>><?php echo trans("groups::groups.asc"); ?></option>
                    </select>
                    <button type="submit" class="btn btn-primary"><?php echo trans("groups::groups.order"); ?></button>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="status" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                        <option value=""><?php echo trans("groups::groups.all"); ?></option>
                        <option <?php if (Request::get("status") == "1") { ?> selected='selected' <?php } ?> value="1"><?php echo trans("groups::groups.activated"); ?></option>
                        <option <?php if (Request::get("status") == "0") { ?> selected='selected' <?php } ?> value="0"><?php echo trans("groups::groups.deactivated"); ?></option>
                    </select>

                    <button type="submit" class="btn btn-primary"><?php echo trans("groups::groups.filter"); ?></button>
                </div>
            </div>

            <div class="col-lg-3">
                <form action="" method="get" class="search_form">
                    <div class="input-group">
                        <input name="q" value="<?php echo Request::get("q"); ?>" type="text" class=" form-control" placeholder="<?php echo trans("groups::groups.search_groups") ?> ...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i> </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </form>
    <form action="" method="post" class="action_form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <i class="fa fa-th-large"></i>
                    <?php echo trans("groups::groups.groups") ?>
                </h5>
            </div>
            <div class="ibox-content">
                <?php if (count($groups)) { ?>
                    <div class="row">
                        <div class="col-sm-3 m-b-xs">
                            <div class="form-group">
                                <select name="action" class="form-control chosen-select chosen-rtl" style="width:auto; display: inline-block;">
                                    <option value="-1" selected="selected"><?php echo trans("groups::groups.bulk_actions"); ?></option>
                                    <?php if (User::access("groups.delete")) { ?>
                                        <option value="delete"><?php echo trans("groups::groups.delete"); ?></option>
                                    <?php } ?>
                                    <?php if (User::access("groups.edit")) { ?>
                                        <option value="activate"><?php echo trans("groups::groups.activate"); ?></option>
                                        <option value="deactivate"><?php echo trans("groups::groups.deactivate"); ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-primary"><?php echo trans("groups::groups.apply"); ?></button>
                            </div>
                        </div>
                        <div class="col-sm-6 m-b-xs"></div>
                        <div class="col-sm-3">
                            <select  name="post_status" id="post_status" class="form-control per_page_filter chosen-select chosen-rtl">
                                <option value="" selected="selected">-- <?php echo trans("groups::groups.per_page") ?> --</option>
                                <?php foreach (array(10, 20, 30, 40) as $num) { ?>
                                    <option value="<?php echo $num; ?>" <?php if ($num == $per_page) { ?> selected="selected" <?php } ?>><?php echo $num; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:35px"><input type="checkbox" class="i-checks check_all" name="ids[]" /></th>

                                    <th><?php echo trans("groups::groups.attributes.name"); ?></th>
                                    <th><?php echo trans("groups::groups.attributes.created_at"); ?></th>
                                    <th><?php echo trans("groups::groups.attributes.updated_at"); ?></th>
                                    <th><?php echo trans("groups::groups.user"); ?></th>
                                    <th><?php echo trans("groups::groups.users_count"); ?></th>
                                    <?php if (User::access("groups.edit")) { ?>
                                        <th><?php echo trans("groups::groups.attributes.status"); ?></th>
                                    <?php } ?>
                                    <?php if (User::access("groups.delete") or User::access("groups.edit")) { ?>
                                        <th><?php echo trans("groups::groups.actions"); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groups as $group) { ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="i-checks" name="id[]" value="<?php echo $group->id; ?>" />
                                        </td>

                                        <td>

                                            <?php if (User::access("groups.edit")) { ?>
                                                <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("groups::groups.edit"); ?>" class="text-navy" href="<?php echo route("admin.groups.edit", array("id" => $group->id)); ?>">
                                                    <?php echo $group->name; ?>
                                                </a>
                                            <?php } else { ?>
                                                <?php echo $group->name; ?>
                                            <?php } ?>
                                        </td>
                                        <td>

                                            <?php echo $group->created_at; ?>
                                        </td>
                                        <td>

                                            <?php echo $group->updated_at; ?>
                                        </td>
                                        <td>
                                            <a href="?user_id=<?php echo @$group->user->id; ?>" class="text-navy">
                                                <?php echo @$group->user->first_name; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $group->users->count(); ?>
                                        </td>

                                        <?php if (User::access("groups.edit")) { ?>
                                            <td>
                                                <?php if ($group->status) { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("groups::groups.activated"); ?>" class="ask" message="<?php echo trans('groups::groups.sure_deactivate') ?>" href="<?php echo URL::route("admin.groups.status", array("id" => $group->id, "status" => 0)) ?>">
                                                        <i class="fa fa-toggle-off text-success"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("groups::groups.deactivated"); ?>" class="ask" message="<?php echo trans('groups::groups.sure_activate') ?>" href="<?php echo URL::route("admin.groups.status", array("id" => $group->id, "status" => 1)) ?>">
                                                        <i class="fa fa-toggle-off text-danger"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                        <?php if (User::access("groups.delete") or User::access("groups.edit")) { ?>
                                            <td class="center">
                                                <?php if (User::access("groups.edit")) { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("groups::groups.edit"); ?>" href="<?php echo route("admin.groups.edit", array("id" => $group->id)); ?>">
                                                        <i class="fa fa-pencil text-navy"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php if (User::access("groups.delete")) { ?>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("groups::groups.delete"); ?>" class="delete_user ask" message="<?php echo trans("groups::groups.sure_delete") ?>" href="<?php echo URL::route("admin.groups.delete", array("id" => $group->id)) ?>">
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
                                <?php echo trans("groups::groups.page"); ?> <?php echo $groups->currentPage() ?> <?php echo trans("groups::groups.of") ?> <?php echo $groups->lastPage() ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                <?php echo $groups->appends(Request::all())->render(); ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php echo trans("groups::groups.no_records"); ?>
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
