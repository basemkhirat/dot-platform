@extends("admin::layouts.master")

@section("breadcrumb")

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4">
        <h2>
            <i class="fa fa-th-large"></i>
            <?php echo trans("#module#::#module#.module") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
            </li>
            <li>
                <a href="<?php echo URL::to(ADMIN . "/#module#"); ?>"><?php echo trans("#module#::#module#.module") ?></a>
            </li>
        </ol>
    </div>
    <div class="col-lg-5"></div>
    <div class="col-lg-3"></div>
</div>

@stop

@section("content")

@stop