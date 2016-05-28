<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <i class="fa fa-users"></i>
                    <?php echo trans("dashboard::dashboard.recent_users") ?>                </h5>

                <strong class="pull-right">
                    <a class="text-navy" href="<?php echo URL::to(ADMIN . "/users"); ?>">
                        <?php echo trans("dashboard::dashboard.show_all"); ?>
                    </a>
                </strong>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-hover">
                    <?php /*
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo trans("dashboard::dashboard.photo") ?></th>
                                <th><?php echo trans("dashboard::dashboard.full_name") ?></th>
                                <th><?php echo trans("dashboard::dashboard.role") ?></th>
                                <th></th>
                            </tr>
                            </thead>
 */ ?>
                    <tbody class="valign-middle">
                    <?php
                    $i = 1;
                    foreach ($users as $user) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <?php if ($user->media_path != "") { ?>
                                    <img src="<?php echo thumbnail($user->media_path); ?>" alt=""
                                         style="width:26px;height:26px;" class="rounded">
                                <?php } else { ?>
                                    <img src="<?php echo assets("images/user.png"); ?>" alt=""
                                         style="width:26px;height:26px;" class="rounded">
                                <?php } ?>
                            </td>

                            <td>
                                <a class="text-navy"
                                   href="<?php echo route("admin.users.edit", array("id" => $user->id)); ?>">
                                    <?php echo $user->first_name . " " . $user->last_name; ?>
                                </a>
                            </td>
                            <td><?php echo $user->role_name; ?></td>
                            <td></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
