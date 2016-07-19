<script src="<?php echo assets("admin::") ?>/js/jquery-ui-1.10.4.min.js"></script>
<script src="<?php echo assets("admin::") ?>/js/bootbox.min.js"></script>

<script>

    var confirm_box = function (message, callback) {

        if(message === undefined){
            callback();
        }

        bootbox.dialog({
            message: message,
            buttons: {
                success: {
                    label: "<?php echo trans("admin::common.yes"); ?>",
                    className: "btn-primary",
                    callback: function () {
                        if (typeof(callback) == "function") {
                            callback();
                        }
                    }
                },
                danger: {
                    label: "<?php echo trans("admin::common.cancel"); ?>",
                    className: "btn-default",
                    callback: function () {
                    }
                },
            },
            className: "bootbox-sm"
        });
    }

    var alert_box = function (message, callback) {
        bootbox.dialog({
            message: message,
            buttons: {
                success: {
                    label: "<?php echo trans("admin::common.yes"); ?>",
                    className: "btn-primary",
                    callback: function () {
                        if (typeof(callback) == "function") {
                            callback();
                        }

                    }
                }
            },
            className: "bootbox-sm"
        });
    }

</script>
<!-- Mainly scripts -->
<script src="<?php echo assets("admin::") ?>/js/bootstrap.min.js"></script>
<script src="<?php echo assets("admin::") ?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo assets("admin::") ?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo assets("admin::") ?>/js/plugins/switchery/switchery.js"></script>
<script src="<?php echo assets("admin::") ?>/js/plugins/chosen/chosen.jquery.js"></script>
<script src="<?php echo assets("admin::") ?>/js/jquery.cookie.js"></script>


<!-- Peity -->
<script src="<?php echo assets("admin::") ?>/js/plugins/peity/jquery.peity.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo assets("admin::") ?>/js/inspinia.js"></script>
<script src="<?php echo assets("admin::") ?>/js/plugins/pace/pace.min.js"></script>

<!-- iCheck -->
<script src="<?php echo assets("admin::") ?>/js/plugins/iCheck/icheck.min.js"></script>

<!-- Peity -->
<script src="<?php echo assets("admin::") ?>/js/demo/peity-demo.js"></script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo assets("admin::") ?>/uploader/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo assets("admin::") ?>/uploader/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo assets("admin::") ?>/uploader/jquery.fileupload.js"></script>

<script src="<?php echo assets("admin::") ?>/uploader/popup.js"></script>

<script type="text/javascript" src="<?php echo assets('admin::js/plugins/moment/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo assets('admin::js/plugins/toastr/toastr.min.js') ?>"></script>

<script>

    $(document).ready(function(){
        resizeChosen();
        jQuery(window).on('resize', resizeChosen);
    });

    function resizeChosen() {
        $(".chosen-container").each(function() {
            $(this).attr('style', 'width: 100%');
        });
    }

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.chosen-select').chosen();

        var url = window.location.href;
        $("#side-menu li a[href='" + url + "']").parents("li").addClass("active");
        $("#side-menu li a[href='" + url + "']").parents("li").parents(".nav-second-level").addClass("collapse in");

        $("#side-menu li.active").each(function(){
            $(this).children("ul").addClass("in");
        });

        $(".minimalize-styl-2").click(function () {
            if ($("body").hasClass("mini-navbar")) {
                $.cookie('mini_nav', "1", {path: '/'});
            } else {
                $.cookie('mini_nav', "0", {path: '/'});
            }
        });

        // trash page action
        $('a.ask').on('click', function (e) {
            e.preventDefault();
            $this = $(this);
            bootbox.dialog({
                message: $this.attr('message'),
                buttons: {
                    success: {
                        label: "<?php echo trans("admin::common.yes"); ?>",
                        className: "btn-primary",
                        callback: function () {
                            location.href = $this.attr('href');
                        }
                    },
                    danger: {
                        label: "<?php echo trans("admin::common.cancel"); ?>",
                        className: "btn-default",
                        callback: function () {
                        }
                    },
                },
                className: "bootbox-sm"
            });
        });

    })
    ;

</script>

<?php echo Widget::render("admin.footer"); ?>

@yield("footer")

</body>
</html>
