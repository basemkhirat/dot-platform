@extends("admin::layouts.master")
@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2><?php echo trans("dashboard::dashboard.dashboard") ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo URL::to(ADMIN . "/dashboard"); ?>"><?php echo trans("dashboard::dashboard.dashboard") ?></a>
                </li>
            </ol>
        </div>

        <div class="col-lg-4 text-center">
        </div>
    </div>

    <div class="wrapper wrapper-content fadeInRight">

        <?php Action::render("dashboard.featured"); ?>

        <div class="row" style="margin-top:10px">

            <div class="col-md-4">
                <?php Action::render("dashboard.right"); ?>
            </div>

            <div class="col-md-4">
                <?php Action::render("dashboard.middle"); ?>
            </div>

            <div class="col-md-4">
                <?php Action::render("dashboard.left"); ?>
            </div>

        </div>

    </div>

@stop


@section("header")

    <style>
        #category_filter_chosen {
            margin-top: 30px;
        }
    </style>

@stop


