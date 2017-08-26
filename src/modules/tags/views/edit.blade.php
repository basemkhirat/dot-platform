@extends("admin::layouts.master")
@section("content")

    <form action="" method="post" class="TagsForm">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-tags"></i>
                    <?php echo $tag ? trans("tags::tags.edit") : trans("tags::tags.add_new"); ?>
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
                    </li>
                    <li>
                        <a href="<?php echo route("admin.tags.show"); ?>"><?php echo trans("tags::tags.tags"); ?></a>
                    </li>
                    <li class="active">
                        <strong>
                            <?php echo $tag ? trans("tags::tags.edit") : trans("tags::tags.add_new"); ?>
                        </strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                <?php if ($tag) { ?>
                <a href="<?php echo route("admin.tags.create"); ?>"
                   class="btn btn-primary btn-labeled btn-main">
                    <span class="btn-label icon fa fa-plus"></span>
                     <?php echo trans("tags::tags.add_new") ?></a>
                <?php } ?>


                    <button type="submit" class="btn btn-flat btn-danger btn-main">
                        <i class="fa fa-download" aria-hidden="true"></i>
                        <?php echo trans("tags::tags.save_tag") ?>
                    </button>
            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="input-name"><?php echo trans("tags::tags.attributes.name") ?></label>
                                <input name="name" type="text" value="<?php echo @Request::old("name", $tag->name); ?>"
                                       class="form-control" id="input-name"
                                       placeholder="<?php echo trans("tags::tags.attributes.name") ?>">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>

            </div>

        </div>

    </form>

@stop

@push("footer")

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
                        data: {
                            term: request.term,
                            ignored: $("#tags_names").val()<?php if($tag){ ?>,
                            except: "<?php echo $tag->name ?>"<?php } ?>},
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

@endpush

