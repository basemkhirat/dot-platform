<?php if (count(Config::get("admin.locales")) > 1) { ?>
    <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
            <?php echo strtoupper(Config::get("app.locale")); ?>
        </a>
        <ul class="dropdown-menu dropdown-alerts dropdown-locales">
            <div class="aro"></div>
            <?php foreach (config("admin.locales") as $code => $lang) { ?>
                <?php if ($code != app()->getLocale()) { ?>
                    <li>
                        <a href="<?php echo url("locale?lang=" . $code) ?>">
                            <?php echo $lang["title"]; ?>
                        </a>

                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </li>
<?php } ?>