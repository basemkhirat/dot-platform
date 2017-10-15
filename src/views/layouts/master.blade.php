<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="viewport" content="width=device-width initial-scale=1.0"/>
    <title>{{ option("site_name") }} - CMS</title>
    <link href="{{ assets("admin::css/app.css") }}" rel="stylesheet"/>
    @if (DIRECTION == "rtl")
        <link href="<?php echo assets("admin::css/app.rtl.css") ?>" rel="stylesheet"/>
    @endif
    <link rel="icon" type="image/png" href="<?php echo url("favicon.ico") ?>"/>
    <script>
        base_url = "{{ admin_url() }}/";
        baseURL = "{{ admin_url() }}/";
    </script>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>"/>
    @stack("header")
    <?php Action::render("admin.head"); ?>
</head>

<body
    class="@if(Auth::user()->color == "blue") dark-theme @endif @if (DIRECTION == "rtl") rtls @endif @if (isset($_COOKIE["mini_nav"]) and $_COOKIE["mini_nav"] == "1") mini-navbar @endif">

<div class="loadingWrapper">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
</div>

<div class="bodyWrapper">

    @include("media::manager")

    <div
        class="main-container @if (isset($_COOKIE["active_container"]) and $_COOKIE["active_container"]) active @endif">

        <div id="wrapper">

            <nav class="main-nav navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">

                                <span>
                                    <img alt="image" class="img-circle" src="<?php echo Auth::user()->photo_url; ?>"/>
                                </span>

                                <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="">

                                    <span class="clear">

                                        <span class="block sm-t-xs">
                                            <strong
                                                class="font-bold"><?php echo ucfirst(Auth::user()->first_name) . " " . ucfirst(Auth::user()->last_name); ?></strong>
                                        </span>

                                        @if (Auth::user()->role)
                                            <span class="text-muted text-xs block">
                                                <?php echo Auth::user()->role->name ?>
                                                <b class="caret"></b>
                                            </span>
                                        @endif
                                    </span>

                                </a>

                                <ul class="dropdown-menu m-t-xs">

                                    <li>
                                        <a href="<?php echo route("admin.users.edit", array("id" => Auth::user()->id)); ?>"><?php echo trans("auth::auth.edit_profile") ?></a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a class="ask" message="<?php echo trans("admin::common.sure_logout"); ?>"
                                           href="<?php echo route("admin.auth.logout"); ?>"><?php echo trans("auth::auth.logout") ?></a>
                                    </li>
                                </ul>

                            </div>

                            <div class="logo-element">
                                <i class="fa fa-circle" aria-hidden="true"></i>
                            </div>

                        </li>

                        <?php echo Navigation::get("sidebar")->render(); ?>

                    </ul>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg" style="overflow: hidden !important">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0)"><i
                                    class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">

                            <li>
                                <span
                                    class="m-r-sm text-muted welcome-message"><?php echo strtoupper(Config::get("site_title", Config::get("site_name"))); ?></span>
                            </li>

                            <?php echo Navigation::get("topnav")->render(); ?>

                            <li>
                                <a href="<?php echo route("admin.auth.logout"); ?>" class="ask"
                                   message="<?php echo trans("admin::common.sure_logout"); ?>">
                                    <i class="fa fa-sign-out"></i>
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>

                @yield("content")

                <?php echo Widget::render("admin.content.end"); ?>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript" src="<?php echo assets('admin::js/app.js') ?>"></script>

<script>

    /**
     * check cms is loaded in iframe.
     */
    $(document).ready(function () {
        if (window.self !== window.top) {
            $("#page-wrapper").css("margin", 0);
            $("#page-wrapper nav").remove();
            $("#wrapper .main-nav").remove();
            $(".btn-main").remove();


        }
    });

    var confirm_box = function (message, callback) {

        if (message === undefined) {
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

<link rel="stylesheet" href="<?php echo assets('admin::css/plugins/selectpicker/bootstrap-select.css') ?>">

<script src="<?php echo assets('admin::js/plugins/selectpicker/bootstrap-select.js') ?>"></script>


<script>

    $(document).ready(function () {

        $('.chosen-select').chosen();

        $('[data-toggle="tooltip"]').tooltip();

        if (!$(this).parent().hasClass("action-box")) {
            $(this).attr('style', 'width: 100%');
        }

        resizeChosen();
        jQuery(window).on('resize', resizeChosen);
    });

    function resizeChosen() {
        $(".chosen-container").each(function () {

            if (!$(this).parent().hasClass("action-box")) {
                $(this).attr('style', 'width: 100%');
            }


        });
    }

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = window.location.href;
        $("#side-menu li a[href='" + url + "']").parents("li").addClass("active");
        $("#side-menu li a[href='" + url + "']").parents("li").parents(".nav-second-level").addClass("collapse in");

        $("#side-menu li.active").each(function () {
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

    });

</script>

{{ Widget::render("admin.footer") }}

<?php Action::render("admin.footer"); ?>

@stack("footer")

</body>
</html>
