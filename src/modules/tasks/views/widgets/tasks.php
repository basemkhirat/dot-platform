<div class="row">

    <div class="col-md-12">

        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <h5>
                    <i class="fa fa-tasks"></i>
                    <?php echo trans("dashboard::dashboard.tasks") ?>
                </h5>

                <strong class="pull-right">
                    <a class="text-navy" href="<?php echo URL::to(ADMIN . "/tasks"); ?>">
                        <?php echo trans("dashboard::dashboard.show_all"); ?>
                    </a>
                </strong>
            </div>
            <div class="ibox-content">
                <?php if (count($tasks)) { ?>
                    <ul class="todo-list m-t small-list">
                        <?php foreach ($tasks as $task) { ?>
                            <li>
                                <a href="#" class="check-link" data-task-id="<?php echo $task->id ?>">
                                    <?php if ($task->done) { ?>
                                        <i class="fa fa-check-square-o text-navy"></i>
                                    <?php } else { ?>
                                        <i class="fa fa-square-o text-navy"></i>
                                    <?php } ?>
                                </a>
                                <span
                                    class="m-l-xs <?php if ($task->done) { ?>todo-completed<?php } ?>"><?php echo $task->title; ?></span>
                            </li>
                        <?php } ?>
                        <script>
                            $(document).ready(function () {
                                $(".check-link").click(function () {
                                    var base = $(this);
                                    var task_id = base.attr("data-task-id");

                                    if (base.children('i').hasClass("fa-square-o")) {
                                        var done = 1;
                                    } else {
                                        var done = 0;
                                    }

                                    $.post("<?php echo URL::to(ADMIN . "/tasks"); ?>/" + done + "/done?id=" + task_id);

                                });
                            });
                        </script>

                    </ul>
                <?php } else { ?>
                    <p class="text-center"><?php echo trans("dashboard::dashboard.no_tasks") ?></p>
                <?php } ?>


            </div>
        </div>

    </div>

</div>
