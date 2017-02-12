</div>
<script type="text/javascript" src="<?php echo assets('admin::js/app.js') ?>"></script>
<script>

    /**
     * check cms is loaded in iframe.
     */
    $(document).ready(function(){
        if(window.self !== window.top){
            $("#page-wrapper").css("margin", 0);
            $("#page-wrapper nav").remove();
            $("#wrapper .main-nav").remove();
            //$("ol.breadcrumb li").first().remove();
            $(".btn-main").remove();


        }
    });

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

@stack("footer")

</body>
</html>
