@extends("admin::layouts.master")
@section("breadcrumb")

<style>
    #category_filter_chosen {
        margin-top: 30px;
    }
</style>

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

        <?php /*
        <form action="" method="get" class="">
            <select class="form-control chosen-select chosen-rtl" name="cat_id" id="category_filter">
                <option value="0"><?php echo trans("dashboard::dashboard.all_categories") ?></option>
                <?php foreach ($cats as $cat) { ?>
                    <option <?php if ($cat->id == $cat_id) { ?> selected="selected" <?php } ?>
                        value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                <?php } ?>

            </select>
        </form>
 */ ?>
    </div>
</div>
@stop

@section("content")

<?php // echo Widget::render("dashboard.featured"); ?>

<div class="row" style="margin-top:10px">

    <div class="col-md-4">
        <?php echo Widget::render("dashboard.right"); ?>
    </div>

    <div class="col-md-4">
        <?php echo Widget::render("dashboard.middle"); ?>
    </div>

    <div class="col-md-4">
        <?php echo Widget::render("dashboard.left"); ?>
    </div>

</div>


@section("header")

<style>
    .ibox-content {
        min-height: 99px;
        border-radius: 0 0 5px 5px;
        line-height: 53px;
    }
</style>

@stop

@section('footer')
<script>
    $(document).ready(function () {

        $("#category_filter").change(function () {
            var base = $(this);
            base.parents("form").submit();
        });


    });
</script>

<script>
    $(document).ready(function () {
        $('.chosen-select').chosen();

    });

</script>


@stop
@stop
