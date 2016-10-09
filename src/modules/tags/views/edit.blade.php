@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
        <h2>
            <i class="fa fa-tags"></i>
            <?php
            if ($tag) {
                echo trans("tags::tags.edit");
            } else {
                echo trans("tags::tags.add_new");
            }
            ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
            </li>
            <li>
                <a href="<?php echo URL::to(ADMIN . "/tags"); ?>"><?php echo trans("tags::tags.tags"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php
                    if ($tag) {
                        echo trans("tags::tags.edit");
                    } else {
                        echo trans("tags::tags.add_new");
                    }
                    ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-right">

        <a href="<?php echo route("admin.tags.show"); ?>" class="btn btn-primary btn-labeled btn-main">
            <i class="fa fa-bars"></i>
            <?php echo trans("tags::tags.back_to_tags") ?>
        </a>

        <?php if ($tag) { ?>
            <a href="<?php echo route("admin.tags.create"); ?>" class="btn btn-primary btn-labeled btn-main pull-right"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("tags::tags.add_new") ?></a>
        <?php } ?>

    </div>
</div>
@stop
@section("content")
@include("admin::partials.messages")
<form action="" method="post" class="TagsForm">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label for="input-name"><?php echo trans("tags::tags.attributes.name") ?></label>
                        <input name="name" type="text" value="<?php echo @Request::old("name", $tag->name); ?>" class="form-control" id="input-name" placeholder="<?php echo trans("tags::tags.attributes.name") ?>">
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>

    </div>

    <div>
        <div class="container-fluid">
            <div class="form-group">
                <input type="submit" class="pull-left btn btn-flat btn-primary" value="<?php echo trans("tags::tags.save_tag") ?>" />
            </div>
        </div>
    </div>

</form>
@section("header")
@parent

@stop

@section("footer")
@parent

<script>
    $(document).ready(function () {

        $("#mytags").tagit({
            singleField: true,
            singleFieldNode: $('#tags_names'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "",
            removeConfirmation: true,
            tagSource: function (request, response) {
                $.ajax({
                    url: "<?php echo route("admin.tags.search"); ?>",
                    data: {term: request.term, ignored: $("#tags_names").val()<?php if($tag){ ?>, except: "<?php echo $tag->name ?>"<?php } ?>},
                    dataType: "json",
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: item.name,
                                value: item.name
                            }
                        }));
                    }
                });
            }
        });

    });
</script>
@stop
@stop
