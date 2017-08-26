@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-folder"></i>
                <?php echo trans("categories::categories.categories") ?>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
                </li>
                <li>
                    <a href="<?php echo route("admin.categories.show"); ?>"><?php echo trans("categories::categories.categories") ?>
                        (<?php echo $categories->total() ?>)</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="<?php echo route("admin.categories.create"); ?>" class="btn btn-primary btn-labeled btn-main">
                <span class="btn-label icon fa fa-plus"></span>
                 <?php echo trans("categories::categories.add_new") ?></a>
        </div>
    </div>

    <div class="wrapper wrapper-content fadeInRight">

        <div id="content-wrapper">

            @include("admin::partials.messages")

            <form action="" method="get" class="filter-form">
                <input type="hidden" name="per_page" value="<?php echo Request::get('per_page') ?>"/>

                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <select name="sort" class="form-control chosen-select chosen-rtl">

                                <option value="name"
                                        <?php if($sort == "name"){ ?> selected='selected' <?php } ?>><?php echo trans("categories::categories.attributes.name"); ?></option>
                            </select>
                            <select name="order" class="form-control chosen-select chosen-rtl">
                                <option value="DESC"
                                        <?php if($order == "DESC"){ ?> selected='selected' <?php } ?>><?php echo trans("categories::categories.desc"); ?></option>
                                <option value="ASC"
                                        <?php if($order == "ASC"){ ?> selected='selected' <?php } ?>><?php echo trans("categories::categories.asc"); ?></option>
                            </select>
                            <button type="submit"
                                    class="btn btn-primary"><?php echo trans("categories::categories.order"); ?></button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <form action="" method="get" class="search_form">
                            <div class="input-group">
                                <input name="q" value="<?php echo Request::get("q"); ?>" type="text"
                                       class=" form-control"
                                       placeholder="<?php echo trans("categories::categories.search_categories") ?> ...">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i> </button>
                        </span>
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
                            <i class="fa fa-folder"></i>
                            <?php echo trans("categories::categories.categories") ?>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <?php if(count($categories)){ ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                <select name="action" class="form-control pull-left">
                                    <option value="-1"
                                            selected="selected"><?php echo trans("categories::categories.bulk_actions"); ?></option>
                                    <option
                                        value="delete"><?php echo trans("categories::categories.delete"); ?></option>

                                </select>
                                <button type="submit"
                                        class="btn btn-primary pull-right"><?php echo trans("categories::categories.apply"); ?></button>

                            </div>

                            <div class="col-lg-6 col-md-4 hidden-sm hidden-xs"></div>

                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <select class="form-control per_page_filter">
                                    <option value="" selected="selected">
                                        -- <?php echo trans("categories::categories.per_page") ?> --
                                    </option>
                                    <?php foreach (array(10, 20, 30, 40) as $num) { ?>
                                    <option value="<?php echo $num; ?>"
                                            <?php if ($num == $per_page) { ?> selected="selected" <?php } ?>><?php echo $num; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th style="width:35px"><input type="checkbox" class="i-checks check_all"
                                                                  name="ids[]"/></th>
                                    <th><?php echo trans("categories::categories.attributes.name"); ?></th>
                                    <th><?php echo trans("categories::categories.actions"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($categories as $category) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="i-checks" name="id[]"
                                               value="<?php echo $category->id; ?>"/>
                                    </td>

                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("categories::categories.show_children"); ?>"
                                           class="text-navy"
                                           href="<?php echo route("admin.categories.show", array("id" => $category->id)); ?>">
                                            <strong><?php echo $category->name; ?></strong>
                                        </a>

                                    </td>

                                    <td class="center">
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("categories::categories.edit"); ?>"
                                           href="<?php echo route("admin.categories.edit", array("id" => $category->id)); ?>">
                                            <i class="fa fa-pencil text-navy"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("categories::categories.delete"); ?>"
                                           class="delete_user ask"
                                           message="<?php echo trans("categories::categories.sure_delete") ?>"
                                           href="<?php echo URL::route("admin.categories.delete", array("id" => $category->id)) ?>">
                                            <i class="fa fa-times text-navy"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                    <?php echo trans("categories::categories.page"); ?> <?php echo $categories->currentPage() ?> <?php echo trans("categories::categories.of") ?> <?php echo $categories->lastPage() ?>
                            </div>
                            <div class="col-lg-12 text-center">
                                    <?php echo $categories->appends(Request::all())->render(); ?>
                            </div>
                        </div>
                        <?php }else { ?>
                <?php echo trans("categories::categories.no_records"); ?>
                <?php } ?>
                    </div>
                </div>
            </form>
        </div>

    </div>

@stop

@push("footer")

    <script>
        $(document).ready(function () {
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
        });
    </script>

@endpush

