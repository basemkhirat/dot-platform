@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa fa-blocks"></i>
            <?php echo trans("blocks::blocks.blocks") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/blocks"); ?>"><?php echo trans("blocks::blocks.blocks") ?>
                    (<?php echo $blocks->total() ?>)</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">
        <a href="<?php echo route("admin.blocks.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span
                class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("blocks::blocks.add_new") ?></a>
    </div>
</div>
@stop
@section("content")
<div id="content-wrapper">
    @include("admin::partials.messages")
    <form action="" method="get" class="filter-form">
        <input type="hidden" name="per_page" value="<?php echo Request::get('per_page') ?>"/>

        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <select name="sort" class="form-control chosen-select chosen-rtl">
                        <option
                            value="name" <?php if ($sort == "name") { ?> selected='selected' <?php } ?>><?php echo ucfirst(trans("blocks::blocks.attributes.name")); ?></option>
                        <option
                            value="created_at" <?php if ($sort == "created_at") { ?> selected='selected' <?php } ?>><?php echo ucfirst(trans("blocks::blocks.attributes.created_at")); ?></option>
                      </select>
                    <select name="order" class="form-control chosen-select chosen-rtl">
                        <option
                            value="DESC" <?php if (Request::get("order") == "DESC") { ?> selected='selected' <?php } ?>><?php echo trans("blocks::blocks.desc"); ?></option>
                        <option
                            value="ASC" <?php if (Request::get("order") == "ASC") { ?> selected='selected' <?php } ?>><?php echo trans("blocks::blocks.asc"); ?></option>
                    </select>
                    <button type="submit" class="btn btn-primary"><?php echo trans("blocks::blocks.order"); ?></button>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">

            </div>
            <div class="col-lg-4 col-md-4">
                <form action="" method="get" class="search_form">


                    <div class="input-group">
                        <div class="autocomplete_area">
                            <input type="text" name="q" value="<?php echo Request::get("q"); ?>" autocomplete="off"
                                   placeholder="<?php echo trans("blocks::blocks.search_blocks") ?>"
                                   class="form-control linked-text">

                            <div class="autocomplete_result">
                                <div class="result_body"></div>
                            </div>

                        </div>

                         <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
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
                    <i class="fa fa-blocks"></i>
                    <?php echo trans("blocks::blocks.blocks") ?>
                </h5>
            </div>
            <div class="ibox-content">
                <?php if (count($blocks)) { ?>
                    <div class="row">

                            <div class="col-lg-3 action-box">
                                <select name="action" class="form-control chosen-select chosen-rtl pull-left">
                                    <option value="-1"
                                            selected="selected"><?php echo trans("blocks::blocks.bulk_actions"); ?></option>
                                    <option value="delete"><?php echo trans("blocks::blocks.delete"); ?></option>
                                </select>
                                <button type="submit"
                                        class="btn btn-primary pull-right"><?php echo trans("blocks::blocks.apply"); ?></button>
                            </div>

                        <div class="col-lg-7">

                        </div>

                        <div class="col-lg-2">
                            <select name="post_status" id="post_status"
                                    class="form-control per_page_filter chosen-select chosen-rtl">
                                <option value="" selected="selected">-- <?php echo trans("blocks::blocks.per_page") ?>--
                                </option>
                                <?php foreach (array(10, 20, 30, 40, 60, 80, 100, 150) as $num) { ?>
                                    <option
                                        value="<?php echo $num; ?>" <?php if ($num == $per_page) { ?> selected="selected" <?php } ?>><?php echo $num; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width:35px"><input type="checkbox" class="i-checks check_all" name="ids[]"/>
                                </th>

                                <th><?php echo trans("blocks::blocks.attributes.name"); ?></th>

                                <th><?php echo trans("blocks::blocks.actions"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($blocks as $block) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="i-checks" name="id[]"
                                               value="<?php echo $block->id; ?>"/>
                                    </td>

                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom" class="text-navy"
                                           title="<?php echo trans("blocks::blocks.edit"); ?>"
                                           href="<?php echo route("admin.blocks.edit", array("id" => $block->id)); ?>">
                                           <strong><?php echo $block->name; ?></strong>
                                        </a>
                                    </td>


                                    <td class="center">
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("blocks::blocks.edit"); ?>"
                                           href="<?php echo route("admin.blocks.edit", array("id" => $block->id)); ?>">
                                            <i class="fa fa-pencil text-navy"></i>
                                        </a>
                                        <a <?php /* data-toggle="tooltip" data-placement="bottom" */ ?>
                                            title="<?php echo trans("blocks::blocks.delete"); ?>" class="ask delete_block"
                                            data-block-id="<?php echo $block->id; ?>"
                                            message="<?php echo trans("blocks::blocks.sure_delete") ?>"
                                            href="<?php echo URL::route("admin.blocks.delete", array("id" => $block->id)) ?>">
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
                                <?php echo trans("blocks::blocks.page"); ?>
                                <?php echo $blocks->currentPage() ?>
                                <?php echo trans("blocks::blocks.of") ?>
                                <?php echo $blocks->lastPage() ?>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                <?php echo $blocks->appends(Request::all())->render(); ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php echo trans("blocks::blocks.no_records"); ?>
                <?php } ?>
            </div>
        </div>
    </form>
</div>

@section("header")
@parent

@stop

@section("footer")
@parent

<script>

    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

//        $('.chosen-select').chosen();

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
