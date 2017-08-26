@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-camera"></i>
                <?php echo trans("galleries::galleries.galleries") ?>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
                </li>
                <li>
                    <a href="<?php echo route("admin.galleries.show"); ?>"><?php echo trans("galleries::galleries.galleries") ?>
                        (<?php echo $galleries->total() ?>)</a>
                </li>
            </ol>
        </div>

        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 text-right">
            <form action="" method="get" class="search_form">
                <div class="input-group">
                    <input name="q" value="<?php echo Request::get("q"); ?>" type="text" class=" form-control"
                           placeholder="<?php echo trans("galleries::galleries.search_galleries") ?> ..."> <span
                        class="input-group-btn">
                    <button class="btn btn-primary"
                            type="button"> <i class="fa fa-search"></i> </button> </span>
                </div>
            </form>
        </div>

        <div class="col-lg-2 pull-right">
            <a href="<?php echo route("admin.galleries.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> <?php echo trans("galleries::galleries.add_new") ?>
            </a>
        </div>
    </div>

    <div class="wrapper wrapper-content fadeInRight">

        @include("admin::partials.messages")

        <div class="row">

            <div class="col-md-12">

                <form action="" method="post" class="action_form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

                    <div class="ibox float-e-margins">
                        <div class="ibox-content">

                            <?php if (count($galleries)) { ?>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                    <select name="action" class="form-control pull-left">
                                        <option value="-1"
                                                selected="selected"><?php echo trans("galleries::galleries.bulk_actions") ?></option>
                                        <option
                                            value="delete"><?php echo trans("galleries::galleries.delete") ?></option>
                                    </select>
                                    <button type="submit"
                                            class="btn btn-primary pull-right"><?php echo trans("galleries::galleries.apply") ?></button>

                                </div>
                                <div class="col-lg-6 col-md-4 hidden-sm hidden-xs">

                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">

                                    <select class="form-control per_page_filter">
                                        <option value="" selected="selected">
                                            -- <?php echo trans("galleries::galleries.per_page") ?> --
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

                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped"
                                       id="jq-datatables-example">
                                    <thead>
                                    <tr>
                                        <th style="width:35px"><input type="checkbox" class="check_all i-checks"
                                                                      name="ids[]"/></th>
                                        <th><?php echo trans("galleries::galleries.name"); ?></th>
                                        <th><?php echo trans("galleries::galleries.media_count"); ?></th>
                                        <th><?php echo trans("galleries::galleries.actions") ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($galleries as $gallery) { ?>
                                    <tr>
                                        <td>
                                            <input class="i-checks" type="checkbox" name="id[]"
                                                   value="<?php echo $gallery->id; ?>"/>
                                        </td>
                                        <td>
                                            <a class="text-navy"
                                               href="<?php echo route("admin.galleries.edit", ["id" => $gallery->id]); ?>">
                                                <strong><?php echo $gallery->name; ?></strong>
                                            </a>
                                        </td>
                                        <td>
                                            <small><?php echo $gallery->files()->count(); ?></small>

                                        </td>
                                        <td class="center">
                                            <a href="<?php echo URL::to(ADMIN) ?>/galleries/<?php echo $gallery->id; ?>/edit">
                                                <i class="fa fa-pencil text-navy"></i>
                                            </a>
                                            <a class="ask"
                                               message="<?php echo trans("galleries::galleries.sure_delete") ?>"
                                               href="<?php echo URL::to(ADMIN) ?>/galleries/delete?id[]=<?php echo $gallery->id; ?>">
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
                                    <?php echo trans("galleries::galleries.page") ?>
                                    <?php echo $galleries->currentPage() ?>
                                    <?php echo trans("galleries::galleries.of") ?>
                                    <?php echo $galleries->lastPage() ?>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <?php echo $galleries->appends(Request::all())->render(); ?>
                                </div>
                            </div>


                            <?php } else { ?>

                        <?php echo trans("galleries::galleries.no_galleries"); ?>

                    <?php } ?>

                        </div>
                    </div>
                </form>

            </div>

        </div>

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

            $(".per_page_filter").change(function () {
                var base = $(this);
                var per_page = base.val();
                location.href = "<?php echo route("admin.galleries.show") ?>?per_page=" + per_page;
            });

            $('.file-box').each(function () {
                animationHover(this, 'pulse');
            });

        });


    </script>

@endpush
