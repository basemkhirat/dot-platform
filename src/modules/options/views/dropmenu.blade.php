<li <?php if (Request::segment(2) == "options") { ?> class="active"<?php } ?>>
    <a href="<?php echo route("admin.options.show"); ?>">
        <span class="fa fa-cogs"></span>
    </a>
</li>