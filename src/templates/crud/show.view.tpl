@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa #options.icon#"></i>
            <?php echo trans("#module#::#module#.#module#") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
            </li>
            <li>
                <a href="<?php echo URL::to(ADMIN . "/#module#"); ?>"><?php echo trans("#module#::#module#.#module#") ?> (<?php echo $#module#->total() ?>)</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">
        <a href="<?php echo route("admin.#module#.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("#module#::#module#.add_new") ?></a>
    </div>
</div>
@stop
@section("content")
<div id="content-wrapper">
    @include("admin::partials.messages")
    <form action="" method="get" class="filter-form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
        <input type="hidden" name="per_page" value="<?php echo Request::get('per_page') ?>" />
        {if module.tags}
        <input type="hidden" name="tag_id" value="<?php echo Request::get('tag_id') ?>" />
        {/if}
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <select name="sort" class="form-control chosen-select chosen-rtl">
                        <option value="#key#" <?php if(Request::get("sort") == "#key#"){ ?> selected='selected' <?php } ?>><?php echo trans("#module#::#module#.sort_by"); ?></option>
                        [loop sortable_fields as field => value]
                        <option value="#field#" <?php if(Request::get("sort") == "#field#"){ ?> selected='selected' <?php } ?>><?php echo trans("#module#::#module#.attributes.#field#"); ?></option>
                        [/loop]
                    </select>
                    <select name="order" class="form-control chosen-select chosen-rtl">
                        <option value="DESC" <?php if(Request::get("order") == "DESC"){ ?> selected='selected' <?php } ?>><?php echo trans("#module#::#module#.desc"); ?></option>
                        <option value="ASC" <?php if(Request::get("order") == "ASC"){ ?> selected='selected' <?php } ?>><?php echo trans("#module#::#module#.asc"); ?></option>
                    </select>
                    <button type="submit" class="btn btn-primary"><?php echo trans("#module#::#module#.order"); ?></button>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    {if options.status}
                    <select name="status" class="form-control chosen-select chosen-rtl">
                        <option value=""><?php echo trans("#module#::#module#.all"); ?></option>
                        <option <?php if(Request::get("status") == "1"){ ?> selected='selected' <?php } ?> value="1"><?php echo trans("#module#::#module#.activated"); ?></option>
                        <option <?php if(Request::get("status") == "0"){ ?> selected='selected' <?php } ?> value="0"><?php echo trans("#module#::#module#.deactivated"); ?></option>
                    </select>
                    {/if}
                    {if module.categories}
                    <select name="category_id" class="form-control chosen-select chosen-rtl">
                        <option value=""><?php echo trans("#module#::#module#.all_categories"); ?></option>
                        <?php
                        echo Category::tree(array(
                            "row" => function($row, $depth) {
                                $html = '<option value="' . $row->id . '"';
                                if (Request::get("category_id") == $row->id) {
                                    $html .= 'selected="selected"';
                                }
                                $html .= '>' . str_repeat("&nbsp;", $depth * 10) . " - " . $row->name . '</option>';
                                return $html;
                            }
                        ));
                        ?>
                    </select>
                    {/if}
                    {if options.categories_or_status}
                    <button type="submit" class="btn btn-primary"><?php echo trans("#module#::#module#.filter"); ?></button>
                    {/if}
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <form action="" method="get" class="search_form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                    <div class="input-group">
                        <input name="q" value="<?php echo Request::get("q"); ?>" type="text" class=" form-control" placeholder="<?php echo trans("#module#::#module#.search_#module#") ?> ...">
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
                    <i class="fa #options.icon#"></i>
                    <?php echo trans("#module#::#module#.#module#") ?>
                </h5>
            </div>
            <div class="ibox-content">
                <?php if(count($#module#)){ ?>
                <div class="row">
                        <div class="col-lg-3 action-box">
                            <select name="action" class="form-control chosen-select chosen-rtl pull-left">
                                <option value="-1" selected="selected"><?php echo trans("#module#::#module#.bulk_actions"); ?></option>
                                <option value="delete"><?php echo trans("#module#::#module#.delete"); ?></option>
                                {if options.status}
                                <option value="activate"><?php echo trans("#module#::#module#.activate"); ?></option>
                                <option value="deactivate"><?php echo trans("#module#::#module#.deactivate"); ?></option>
                                {/if}
                            </select>
                            <button type="submit" class="btn btn-primary pull-right"><?php echo trans("#module#::#module#.apply"); ?></button>
                        </div>
                    <div class="col-lg-7">

                    </div>
                    <div class="col-lg-2">
                        <select  name="post_status" id="post_status" class="form-control per_page_filter chosen-select chosen-rtl">
                            <option value="" selected="selected">-- <?php echo trans("#module#::#module#.per_page") ?> --</option>
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
                                [loop fields as field => value]
                                <th><?php echo trans("#module#::#module#.attributes.#field#"); ?></th>
                                [/loop]
                                {if module.user}<th><?php echo trans("#module#::#module#.user"); ?></th>{/if}
                                {if module.categories}<th><?php echo trans("#module#::#module#.categories"); ?></th>{/if}
                                {if module.tags}<th><?php echo trans("#module#::#module#.tags"); ?></th>{/if}
                                {if options.status}<th><?php echo trans("#module#::#module#.attributes.status"); ?></th>{/if}
                                <th><?php echo trans("#module#::#module#.actions"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($#module# as $#model#) { ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks" name="#key#[]" value="<?php echo $#model#->#key#; ?>" />
                                </td>
                                [loop fields as field => value]
                                <td>
                                    {if loop.first}
                                        <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("#module#::#module#.edit"); ?>" class="text-navy" href="<?php echo route("admin.#module#.edit", array("#key#" => $#model#->#key#)); ?>">
                                            #value#
                                        </a>
                                    {/if}
                                    {if not loop.first}
                                        #value#
                                    {/if}
                                </td>
                                [/loop]
                                {if module.user}
                                 <td>
                                    <a href="?user_id=<?php echo @$#model#->user->id; ?>" class="text-navy">
                                    <?php echo @$#model#->user->first_name; ?>
                                    </a>
                                </td>
                                {/if}
                                {if module.categories}
                                <td>
                                    <?php foreach($#model#->categories as $category){ ?>
                                    <a href="?category_id=<?php echo $category->id; ?>" class="text-navy">
                                        <?php echo $category->name; ?>
                                    </a>
                                    <?php } ?>
                                </td>
                                {/if}
                                {if module.tags}
                                <td>
                                    <?php foreach($#model#->tags as $tag){ ?>
                                    <a href="?tag_id=<?php echo $tag->id; ?>" class="text-navy">
                                        <span class="badge badge-primary"><?php echo $tag->name; ?></span>
                                    </a>
                                    <?php } ?>
                                </td>
                                {/if}
                                {if options.status}
                                <td>
                                   <?php if($#model#->status){ ?>
                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("#module#::#module#.activated"); ?>" class="ask" message="<?php echo trans('#module#::#module#.sure_deactivate') ?>" href="<?php echo URL::route("admin.#module#.status", array("#key#" => $#model#->#key#, "status" => 0)) ?>">
                                        <i class="fa fa-toggle-off text-success"></i>
                                    </a>
                                   <?php }else{ ?>
                                   <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("#module#::#module#.deactivated"); ?>" class="ask" message="<?php echo trans('#module#::#module#.sure_activate') ?>" href="<?php echo URL::route("admin.#module#.status", array("#key#" => $#model#->#key#, "status" => 1)) ?>">
                                        <i class="fa fa-toggle-off text-danger"></i>
                                    </a>
                                   <?php } ?>
                                </td>
                                {/if}
                                <td class="center">
                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("#module#::#module#.edit"); ?>" href="<?php echo route("admin.#module#.edit", array("#key#" => $#model#->#key#)); ?>">
                                        <i class="fa fa-pencil text-navy"></i>
                                    </a>
                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo trans("#module#::#module#.delete"); ?>" class="delete_user ask" message="<?php echo trans("#module#::#module#.sure_delete") ?>" href="<?php echo URL::route("admin.#module#.delete", array("#key#" => $#model#->#key#)) ?>">
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
                            <?php echo trans("#module#::#module#.page"); ?> <?php echo $#module#->currentPage() ?> <?php echo trans("#module#::#module#.of") ?> <?php echo $#module#->lastPage() ?>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                            <?php echo $#module#->appends(Request::all())->render(); ?>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <?php echo trans("#module#::#module#.no_records"); ?>
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
