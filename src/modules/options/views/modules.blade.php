@extends("admin::layouts.master")

@section("breadcrumb")
@include("options::partials.nav")
@stop

@section("content")

@include("admin::partials.messages")

<form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
    <div class="row">

        <div class="col-md-12">
            <div class="panel ">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                            <fieldset>
                                <legend><?php echo trans("options::options.modules") ?> <sup><span class="badge badge-primary">12</span></sup></legend>



                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for="s3_status">Tellus Institute</label>
                                            </td>
                                            <td class="client-status">
                                                <input <?php if (Config::get("s3.status")) { ?> checked="checked" <?php } ?> type="checkbox" id="s3_status" name="s3_status" value="1" class="switcher switcher-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php /* ?>
                                  <div class="form-group switch-row">
                                  <label class="col-sm-10 control-label" for="s3_status"><?php echo trans("options::options.attributes.s3_status") ?></label>
                                  <div class="col-sm-2">
                                  <input <?php if (Config::get("s3.status")) { ?> checked="checked" <?php } ?> type="checkbox" id="s3_status" name="s3_status" value="1" class="switcher switcher-sm">
                                  </div>
                                  </div>
                                  <?php */ ?>
                            </fieldset>
                        </div>
                    </div>

                </div>

            </div> <!-- / .panel-body -->
        </div>
    </div>

    <div style="clear:both"></div>
    <div>
        <div class="panel-footer" style="border-top: 1px solid #ececec; position: relative;">
            <div class="form-group" style="margin-bottom:0">
                <input type="submit" class="pull-right btn btn-flat btn-primary" value="<?php echo trans("options::options.save_options") ?>" />
            </div>
        </div>
    </div>

</div>
</form>
@section("header")
<link href="<?php echo assets("tagit") ?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("tagit") ?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@stop
@section("footer")
<script src="<?php echo assets("tagit") ?>/tag-it.js"></script>
<script>
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html);
        });
    });
</script>
<script>
    $(document).ready(function () {

        $("#change_logo").filemanager({
            types: "image",
            done: function (result, base) {
                if (result.length) {
                    var file = result[0];
                    $("#site_logo_path").val(file.media_path);
                    $("#site_logo").attr("src", file.media_thumbnail);
                }
            },
            error: function (media_path) {
                alert(media_path + " <?php echo trans("options::options.file_not_supported") ?>");
            }
        });

        $("#mytags").tagit({
            singleField: true,
            singleFieldNode: $('#allowed_file_types'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "",
            removeConfirmation: true,
            availableTags: ['jpg', 'png', 'jpeg', 'gif', 'doc', 'docx', 'txt', 'pdf', 'zip']
        });

    });
</script>
@stop
@stop
