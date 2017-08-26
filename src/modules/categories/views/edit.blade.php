@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-folder"></i>
                    <?php echo $category ? trans("categories::categories.edit") : trans("categories::categories.add_new"); ?>
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
                    </li>
                    <li>
                        <a href="<?php echo route("admin.categories.show"); ?>"><?php echo trans("categories::categories.categories"); ?></a>
                    </li>
                    <li class="active">
                        <strong>
                            <?php echo $category ? trans("categories::categories.edit") : trans("categories::categories.add_new"); ?>
                        </strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                <?php if ($category) { ?>
                <a href="<?php echo route("admin.categories.create"); ?>"
                   class="btn btn-primary btn-labeled btn-main"> <span
                        class="btn-label icon fa fa-plus"></span>
                    &nbsp; <?php echo trans("categories::categories.add_new") ?></a>
                <?php } ?>

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <?php echo trans("categories::categories.save_category") ?>
                </button>

            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label
                                    for="input-name"><?php echo trans("categories::categories.attributes.name") ?></label>
                                <input name="name" type="text"
                                       value="<?php echo @Request::old("name", $category->name); ?>"
                                       class="form-control" id="input-name"
                                       placeholder="<?php echo trans("categories::categories.attributes.name") ?>">
                            </div>

                            <div class="form-group">
                                <label
                                    for="input-slug"><?php echo trans("categories::categories.attributes.slug") ?></label>
                                <input name="slug" type="text"
                                       value="<?php echo @Request::old("slug", $category->slug); ?>"
                                       class="form-control" id="input-slug"
                                       placeholder="<?php echo trans("categories::categories.attributes.slug") ?>">
                            </div>


                            <div class="form-group">
                                <label
                                    for="input-name"><?php echo trans("categories::categories.attributes.parent") ?></label>
                                <select name="parent" class="form-control chosen-select chosen-rtl">
                                    <option
                                        value="0"><?php echo trans("categories::categories.parent_category"); ?></option>
                                    <?php
                                    echo Category::tree(array(
                                        "row" => function ($row, $depth) use ($category) {
                                            $html = '<option value="' . $row->id . '"';
                                            if ($category and $category->parent == $row->id) {
                                                $html .= 'selected="selected"';
                                            }
                                            $html .= '>' . str_repeat("&nbsp;", $depth * 10) . " - " . $row->name . '</option>';

                                            if (!$category or ($category and $category->id != $row->id)) {
                                                return $html;
                                            }
                                        }
                                    ));
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-picture-o"></i>
                            <?php echo trans("categories::categories.add_image"); ?>
                        </div>
                        <div class="panel-body form-group">
                            <div class="row post-image-block">
                                <input type="hidden" name="image_id" class="post-image-id" value="<?php
                                if ($category and @ $category->image->path != "") {
                                    echo @$category->image->id;
                                } else {
                                    echo 0;
                                }
                                ?>">
                                <a class="change-post-image label" href="javascript:void(0)">
                                    <i class="fa fa-pencil text-navy"></i>
                                    <?php echo trans("categories::categories.change_image"); ?>
                                </a>
                                <a class="post-image-preview" href="javascript:void(0)">
                                    <img width="100%" height="130px" class="post-image"
                                         src="<?php if ($category and @ $category->image->id != "") { ?> <?php echo thumbnail(@$category->image->path); ?> <?php } else { ?> <?php echo assets("admin::default/image.png"); ?><?php } ?>">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </form>

@stop

@push("footer")

    <script>
        $(document).ready(function () {

            $(".change-post-image").filemanager({
                panel: "media",
                types: "image",
                done: function (result, base) {
                    if (result.length) {
                        var file = result[0];
                        base.parents(".post-image-block").find(".post-image-id").first().val(file.id);
                        base.parents(".post-image-block").find(".post-image").first().attr("src", file.thumbnail);
                    }
                },
                error: function (media_path) {
                    alert_box("<?php echo trans("categories::categories.not_allowed_file") ?>");
                }
            });

        });
    </script>
@endpush
