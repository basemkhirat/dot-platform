@extends("admin::layouts.master")

@section("breadcrumb")

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
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
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right"></div>
</div>

@stop

@section("content")

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                #module|ucfirst#
            </div>
        </div>
    </div>

</div>

@stop