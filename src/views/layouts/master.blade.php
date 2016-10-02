@include("admin::partials.header_part")
@include("media::manager")
<div class="main-container <?php if (isset($_COOKIE["active_container"]) and $_COOKIE["active_container"]) { ?>active<?php } ?>">
    <div id="wrapper">
        @include("admin::partials.sidebar")
        @include("admin::partials.topnav")
        @yield("breadcrumb")
        <div class="wrapper wrapper-content fadeInRight">
            @yield("content")
        </div>
        <?php echo Widget::render("admin.content.end"); ?>
        @include("admin::partials.footer")
    </div>

    @include("admin::partials.footer_part")
