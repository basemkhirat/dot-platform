<?php
$name = isset($name) ? $name : "post_content";
$value = isset($value) ? $value : "";
$id = isset($id) ? $id : "post-content";
?>

<div style="margin-bottom:5px;">
    <a id="add_files" class="btn btn-default" href="#">
        <span class="btn-label icon fa fa-camera"></span>
        &nbsp;{!!Lang::get('admin::editor.add_media')!!}</a>

</div>
<textarea style="display: none" name="<?php echo $name; ?>" id="<?php echo $id; ?>"><?php echo $value; ?></textarea>


<?php /*
<div id="modal_polls" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">{!! trans('topics::topics.add_new') !!}</h4>
            </div>
            <div class="modal-body">
                <?php foreach (Poll::getActivePools() as $poll) { ?>
                <div class="dd-handle">
                    <!-- Default panel contents -->
                    <a href="#" class="embed_poll" data-id='{!!$poll->poll_id!!}'>
                        <div class="panel-heading">
                            <span class="panel-title">{!!$poll->poll_title!!}</span>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
</div> <!-- / .modal -->
*/ ?>

@section("footer")
@parent
<script>

    CKEDITOR.replace("<?php echo $id; ?>", {
        language: '<?php echo App::getLocale(); ?>',
        height: '300px',
        resize_enabled: true,
        resize_dir: 'vertical',
    });

    $(document).ready(function () {

        $("#add_files").filemanager({
            types: "image|video|audio|pdf",
            done: function (files) {
                if (files.length) {
                    files.forEach(function (file) {
                        var html = "";
                        if (file.url.split('.').pop() == 'pdf') {
                            html += "<iframe src='" + file.url + "' width='100%' height='300px'  /><br>";
                            html += "<a href='" + file.url + "' target='_blank'><img src='<?php echo assets("images/pdf.png"); ?>' width='30' height='30'></a>";
                        } else {

                            if (file.type == 'image') {
                                html += "<img width='100%' src='" + file.url + "'> ";
                            } else {
                                html += file.embed;
                            }
                            var element = CKEDITOR.dom.element.createFromHtml(html);
                            CKEDITOR.instances["<?php echo $id; ?>"].insertElement(element);
                        }

                    });
                }
            },
            error: function (media_path) {
                alert("<?php echo trans("admin::common.not_supported_file") ?>");
            }
        });


        $('.embed_poll').on('click', function (ev) {
            ev.preventDefault();
            var editor = $("iframe.cke_wysiwyg_frame").contents().find("body");
            var pollId = $(this).attr('data-id');
            console.log(pollId);
            editor.append($('<p>').html('<div name="poll" class="shortcode" id="' + pollId + '"><img src="<?php echo assets("images/polls.png"); ?>" style="max-width:50px;"></div>'));
            $('#modal_polls').modal('hide')
        });


    });
</script>
@stop
