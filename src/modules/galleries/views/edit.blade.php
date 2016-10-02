@extends("admin::layouts.master")

@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>
            <i class="fa fa-camera"></i>
            <?php echo trans("galleries::galleries.edit") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
            </li>
            <li>
                <a href="<?php echo URL::to(ADMIN . "/galleries"); ?>"><?php echo trans("galleries::galleries.galleries") ?></a>
            </li>
            <li class="active">
                <strong><?php echo trans("galleries::galleries.edit") ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a href="<?php echo route("admin.galleries.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("galleries::galleries.add_new") ?></a>
    </div>
</div>
@stop


@section("content")
<?php if (Session::has("message")) { ?>
    <div class="alert alert-success alert-dark">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Session::get("message"); ?>
    </div>
<?php } ?>

<?php if ($errors->count() > 0) { ?>
    <div class="alert alert-danger alert-dark">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo implode(' <br /> ', $errors->all()) ?>
    </div>
<?php } ?>

<form action="" method="post" >
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body">

                    <div class="form-group" style="position: relative;" >

                        <input name="name" value="<?php echo @Request::old("name", $gallery->name); ?>" class="form-control input-md" value="" placeholder="<?php echo trans("galleries::galleries.name") ?>" />


                        <button type="button" class="add-media btn-primary btn btn-flat" id="add_media">
                            <i class="fa fa-camera"></i>
                            <?php echo trans("galleries::galleries.add_media") ?>
                        </button>

                    </div>

                    <div class="input-group input-group-md">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>

                        <input name="author" class="form-control " value="<?php echo @Request::old("author", $gallery->author); ?>" placeholder="<?php echo trans("galleries::galleries.author") ?>" />
                    </div>
                    <br/>
                    <div class="panel">
                        <div id="collapse-media" class="panel-collapse in">
                            <div class="panel-body">
                                <div class="media_rows">
                                    <?php if ($gallery) { ?>
                                        <?php if (count($gallery_media)) { ?>
                                            <?php foreach ($gallery_media as $media) { ?>

                                                <div class="file-box">
                                                    <input type="hidden" name="media_id[]" value="<?php echo $media->id; ?>" />
                                                    <div class="file">
                                                        <a href="#">
                                                            <span class="corner"></span>
                                                            <a href="#" class="media_del"><i class="fa fa-times"></i></a>
                                                            <?php if ($media->type == "image") { ?>
                                                                <div class="image">
                                                                    <img src="<?php echo thumbnail($media->path, "small"); ?>" class="img-responsive" alt="image">
                                                                </div>
                                                            <?php } elseif ($media->type == "audio") { ?>
                                                                <div class="icon"><i class="fa fa-music"></i></div>
                                                            <?php } elseif ($media->type == "video") { ?>
                                                                <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                                            <?php } else { ?>
                                                                <div class="icon"><i class="fa fa-file"></i></div>
                                                            <?php } ?>

                                                            <div class="file-name">
                                                                <?php echo $media->title; ?>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>

                                                <?php /*
                                                  <div class="media_row" >
                                                  <input type="hidden" name="media_id[]" value="<?php echo $media->media_id; ?>" />
                                                  <a href="#" class="media_row_delete">
                                                  <i class="fa fa-times"></i>
                                                  </a>
                                                  <?php if ($media->media_provider == "") { ?>
                                                  <img src="<?php echo thumbnail($media->media_path); ?>">
                                                  <?php } else { ?>
                                                  <?php if ($media->media_provider_image != "") { ?>
                                                  <img src="<?php echo $media->media_provider_image; ?>" />
                                                  <?php } else { ?>
                                                  <img src="<?php echo assets("default/soundcloud.png"); ?>" />
                                                  <?php } ?>
                                                  <?php } ?>
                                                  <label><?php echo $media->media_title; ?></label>
                                                  </div> */ ?>
                                            <?php } ?>
                                            <div class="well text-center empty-content hidden"><?php echo trans("galleries::galleries.no_media") ?></div>
                                        <?php } else { ?>
                                            <div class="well text-center empty-content"><?php echo trans("galleries::galleries.no_media") ?></div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="well text-center empty-content"><?php echo trans("galleries::galleries.no_media") ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container-fluid">
                <div class="form-group">
                    <input type="submit" class="pull-left btn-flat btn btn-primary" value="<?php echo trans("galleries::galleries.save_gallery") ?>" />
                </div>
            </div>
        </div>

    </div>
</form>
</div>

@section("header")
<style>

    .file-box .file{
        overflow: hidden;
    }

</style>
@stop

@section("footer")
<script>
    $(document).ready(function () {
        $("#add_media").filemanager({
            /*types: "jpg|png|jpeg|bmp|gif",*/
            done: function (files) {
                if (files.length) {
                    $(".empty-content").addClass("hidden");
                    files.forEach(function (file) {

                        if (file.media_provider == "") {
                            var thumbnail = file.thumbnail;
                        } else {
                            var thumbnail = file.provider_image;
                        }

                        console.log(file);

                        var html = '<div class="file-box"><input type="hidden" name="media_id[]" value="' + file.id + '" /><div class="file"><a href="#"><span class="corner"></span><a href="#" class="media_del"><i class="fa fa-times"></i></a>';

                        if (file.type == "image") {
                            html = html + '<div class="image"><img src="' + file.url + '" class="img-responsive" alt="image"></div>';

                        } else if (file.type == "audio") {
                            html = html + '<div class="icon"><i class="fa fa-music"></i></div>';
                        } else if (file.type == "video") {
                            html = html + '<div class="icon"><i class="img-responsive fa fa-film"></i></div>';
                        } else {
                            html = html + '<div class="icon"><i class="fa fa-file"></i></div>';
                        }

                        html = html + '<div class="file-name">' + file.title + '</div>';
                        html = html + ' </a></div></div>';

                        $(".media_rows").append(html);

                        $('.file-box').each(function () {
                            animationHover(this, 'pulse');
                        });


                    });
                }

            },
            error: function (media_path) {
                alert(media_path + "<?php echo trans("galleries::galleries.is_not_valid_image") ?>");
            }
        });


        $("body").on("click", ".media_del", function () {
            var base = $(this);
            if (confirm("<?php echo trans("galleries::galleries.sure_delete") ?>")) {
                base.parents(".file-box").slideUp(function () {
                    base.parents(".file-box").remove();

                    if ($(".media_rows .file-box").length == 0) {
                        $(".empty-content").removeClass("hidden");
                    }

                });
            }

        });

        $('.file-box').each(function () {
            animationHover(this, 'pulse');
        });

    });
</script>
@stop
@stop
