<div class="row  border-bottom white-bg dashboard-header" style="margin:0">

    <div class="col-sm-3">
        <h2><?php echo Config::get("site_title"); ?></h2>
        <small><?php echo trans("dashboard::dashboard.welcome") ?></small>
        <ul class="list-group clear-list m-t">
            <li class="list-group-item fist-item">
                <span class="label label-primary pull-right">
                    <?php echo $news_count; ?>
                </span>
                <?php echo trans("dashboard::dashboard.news"); ?>
            </li>
            <li class="list-group-item">
                <span class="label label-primary pull-right">
                    <?php echo $articles_count; ?>
                </span>
                <?php echo trans("dashboard::dashboard.articles"); ?>
            </li>
            <li class="list-group-item">
                <span class="label label-primary pull-right">
                    <?php echo $galleries_count; ?>
                </span>
                <?php echo trans("dashboard::dashboard.galleries"); ?>
            </li>
            <li class="list-group-item">
                <span class="label label-primary pull-right">
                    <?php echo $users_count; ?>
                </span>
                <?php echo trans("dashboard::dashboard.users"); ?>
            </li>
            <li class="list-group-item">
                <span class="label label-primary pull-right">
                    <?php echo $categories_count; ?>
                </span>
                <?php echo trans("dashboard::dashboard.categories"); ?>
            </li>
            <li class="list-group-item">
                <span class="label label-primary pull-right">
                    <?php echo $tags_count; ?>
                </span>
                <?php echo trans("dashboard::dashboard.tags"); ?>
            </li>
        </ul>
    </div>
    <div class="col-sm-9">
        <div style="margin-top:33px">
            <canvas id="lineChart" height="114"></canvas>
        </div>
    </div>
</div>



@push("footer")

<script src="<?php echo assets("admin::") ?>/js/plugins/chartJs/Chart.min.js"></script>

<script>
    $(document).ready(function () {

        var lineData = {
            labels: [<?php echo '"' . join('", "', array_keys($posts_charts)) . '"'; ?>],
            datasets: [
                {
                    label: "الأخبار",
                    fillColor: "rgba(26,179,148,0.5)",
                    strokeColor: "rgba(26,179,148,0.7)",
                    pointColor: "rgba(26,179,148,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php echo join(', ', array_values($posts_charts)); ?>]
                }
            ]
        };

        var lineOptions = {
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            bezierCurve: true,
            bezierCurveTension: 0.4,
            pointDot: true,
            pointDotRadius: 4,
            pointDotStrokeWidth: 1,
            pointHitDetectionRadius: 20,
            datasetStroke: true,
            datasetStrokeWidth: 2,
            datasetFill: true,
            responsive: true,
        };

        var ctx = document.getElementById("lineChart").getContext("2d");
        var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    });
</script>

@endpush
