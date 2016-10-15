<?php if (count($items)) { ?>

    <?php if ($type != "url") { ?>
        <div class="dd" id="nest-<?php echo $type; ?>">

        <ul class="dd-list">
    <?php } ?>

    <?php foreach ($items as $item) {

        $name = strip_tags(trim(preg_replace('/\s\s+/', ' ', $item->name)));

        if ($item->type == "post") {
            $icon = "fa-newspaper-o";
        } elseif ($item->type == "page") {
            $icon = "fa-file-text-o";
        } elseif ($item->type == "tag") {
            $icon = "fa-tag";
        } elseif ($item->type == "category") {
            $icon = "fa-folder";
        } else {
            $icon = "fa-link";
        }

        ?>
        <li class="dd-item" data-id="<?php echo str_random(10); ?>" data-name="<?php echo $name ?>"
            data-link="<?php echo $item->link ?>" data-type="<?php echo $item->type ?>"
            data-type_id="<?php echo $item->type_id ?>">
            <div class="dd-handle">
                <i class="fa <?php echo $icon ?>"></i> &nbsp;
                <?php echo $item->name ?>
            </div>
            <a href="javascript:void(0)" class="pull-right remove-item"> <i class="fa fa-times"></i> </a>
        </li>

    <?php } ?>

    <?php if ($type != "url") { ?>
        </ul>

        </div>
    <?php } ?>

<?php } else { ?>

    <div class="dd-handle">
        <?php echo trans("navigations::navigations.no_results"); ?>
    </div>

<?php } ?>
