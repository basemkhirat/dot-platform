@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-file-text-o"></i>
                <?php echo trans("pages::pages.pages") ?>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
                </li>
                <li>
                    <a href="<?php echo route("admin.pages.show"); ?>"><?php echo trans("pages::pages.pages") ?>
                        (<?php echo $pages->total() ?>)</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="<?php echo route("admin.pages.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> <?php echo trans("pages::pages.add_new") ?></a>
        </div>
    </div>


    <div class="wrapper wrapper-content fadeInRight">

        <div id="content-wrapper">

            @include("admin::partials.messages")

            <form action="" method="get" class="filter-form">
                <input type="hidden" name="per_page" value="<?php echo Request::get('per_page') ?>"/>
                <input type="hidden" name="tag_id" value="<?php echo Request::get('tag_id') ?>"/>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <select name="sort" class="form-control chosen-select chosen-rtl">
                                <option
                                    value="title"
                                    <?php if ($sort == "title") { ?> selected='selected' <?php } ?>><?php echo ucfirst(trans("pages::pages.attributes.title")); ?></option>
                                <option
                                    value="created_at"
                                    <?php if ($sort == "created_at") { ?> selected='selected' <?php } ?>><?php echo ucfirst(trans("pages::pages.attributes.created_at")); ?></option>
                            </select>
                            <select name="order" class="form-control chosen-select chosen-rtl">
                                <option
                                    value="DESC"
                                    <?php if ($sort == "DESC") { ?> selected='selected' <?php } ?>><?php echo trans("pages::pages.desc"); ?></option>
                                <option
                                    value="ASC"
                                    <?php if ($sort == "ASC") { ?> selected='selected' <?php } ?>><?php echo trans("pages::pages.asc"); ?></option>
                            </select>
                            <button type="submit"
                                    class="btn btn-primary"><?php echo trans("pages::pages.order"); ?></button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">

                            <select name="status" class="form-control chosen-select chosen-rtl">
                                <option value=""><?php echo trans("pages::pages.all"); ?></option>
                                <option <?php if (Request::get("status") == "1") { ?> selected='selected' <?php } ?>
                                value="1"><?php echo trans("pages::pages.activated"); ?></option>
                                <option <?php if (Request::get("status") == "0") { ?> selected='selected' <?php } ?>
                                value="0"><?php echo trans("pages::pages.deactivated"); ?></option>
                            </select>

                            <button type="submit"
                                    class="btn btn-primary"><?php echo trans("pages::pages.filter"); ?></button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <form action="" method="get" class="search_form">
                            <div class="input-group">
                                <input name="q" value="<?php echo Request::get("q"); ?>" type="text"
                                       class=" form-control"
                                       placeholder="<?php echo trans("pages::pages.search_pages") ?> ...">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
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
                            <i class="fa fa-file-text-o"></i>
                            <?php echo trans("pages::pages.pages") ?>
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <?php if (count($pages)) { ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                <select name="action" class="form-control pull-left">
                                    <option value="-1"
                                            selected="selected"><?php echo trans("pages::pages.bulk_actions"); ?></option>
                                    <option value="delete"><?php echo trans("pages::pages.delete"); ?></option>
                                    <option value="activate"><?php echo trans("pages::pages.activate"); ?></option>
                                    <option value="deactivate"><?php echo trans("pages::pages.deactivate"); ?></option>
                                </select>

                                <button type="submit"
                                        class="btn btn-primary pull-right"><?php echo trans("pages::pages.apply"); ?></button>

                            </div>

                            <div class="col-lg-6 col-md-4 hidden-sm hidden-xs"></div>

                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">

                                <select class="form-control per_page_filter">
                                    <option value="" selected="selected">
                                        -- <?php echo trans("pages::pages.per_page") ?> --
                                    </option>
                                    <?php foreach (array(10, 20, 30, 40) as $num) { ?>
                                    <option
                                        value="<?php echo $num; ?>"
                                        <?php if ($num == $per_page) { ?> selected="selected" <?php } ?>><?php echo $num; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width:35px"><input type="checkbox" class="i-checks check_all"
                                                                  name="ids[]"/>
                                    </th>
                                    <th><?php echo trans("pages::pages.attributes.title"); ?></th>
                                    <th><?php echo trans("pages::pages.attributes.created_at"); ?></th>
                                    <th><?php echo trans("pages::pages.user"); ?></th>
                                    <th><?php echo trans("pages::pages.tags"); ?></th>
                                    <th><?php echo trans("pages::pages.attributes.status"); ?></th>
                                    <th><?php echo trans("pages::pages.actions"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($pages as $page) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="i-checks" name="id[]"
                                               value="<?php echo $page->id; ?>"/>
                                    </td>

                                    <td>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("pages::pages.edit"); ?>" class="text-navy"
                                           href="<?php echo route("admin.pages.edit", array("id" => $page->id)); ?>">
                                            <strong><?php echo $page->title; ?></strong>
                                        </a>

                                    </td>
                                    <td>
                                        <small><?php echo $page->created_at->render(); ?></small>
                                    </td>
                                    <td>
                                        <a href="?user_id=<?php echo @$page->user->id; ?>" class="text-navy">
                                            <small> <?php echo @$page->user->first_name; ?></small>
                                        </a>
                                    </td>

                                    <td>
                                        <?php if(count($page->tags)){ ?>
                                        <?php foreach ($page->tags as $tag) { ?>
                                        <a href="?tag_id=<?php echo $tag->id; ?>" class="text-navy">
                                            <span class="badge badge-primary"><?php echo $tag->name; ?></span>
                                        </a>
                                        <?php } ?>
                                        <?php }else{ ?>
                                        -
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($page->status) { ?>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("pages::pages.activated"); ?>" class="ask"
                                           message="<?php echo trans('pages::pages.sure_deactivate') ?>"
                                           href="<?php echo URL::route("admin.pages.status", array("id" => $page->id, "status" => 0)) ?>">
                                            <i class="fa fa-toggle-on text-success"></i>
                                        </a>
                                        <?php } else { ?>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("pages::pages.deactivated"); ?>" class="ask"
                                           message="<?php echo trans('pages::pages.sure_activate') ?>"
                                           href="<?php echo URL::route("admin.pages.status", array("id" => $page->id, "status" => 1)) ?>">
                                            <i class="fa fa-toggle-off text-danger"></i>
                                        </a>
                                        <?php } ?>
                                    </td>

                                    <td class="center">
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("pages::pages.edit"); ?>"
                                           href="<?php echo route("admin.pages.edit", array("id" => $page->id)); ?>">
                                            <i class="fa fa-pencil text-navy"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="bottom"
                                           title="<?php echo trans("pages::pages.delete"); ?>" class="delete_user ask"
                                           message="<?php echo trans("pages::pages.sure_delete") ?>"
                                           href="<?php echo URL::route("admin.pages.delete", array("id" => $page->id)) ?>">
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
                                <?php echo trans("pages::pages.page"); ?>
                                <?php echo $pages->currentPage() ?>
                                <?php echo trans("pages::pages.of") ?>
                                <?php echo $pages->lastPage() ?>
                            </div>
                            <div class="col-lg-12 text-center">
                                <?php echo $pages->appends(Request::all())->render(); ?>
                            </div>
                        </div>
                        <?php } else { ?>
                    <?php echo trans("pages::pages.no_records"); ?>
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
