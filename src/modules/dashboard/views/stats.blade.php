@extends("admin::layouts.master")
<?php
$params = '';
foreach (Request::except('per_page', 'page') as $key => $value) {
    $params .= '&' . $key . '=' . $value;
}
?>



<style type="text/css">
    .selected{
        color:#555;
    }
</style>

@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><i class="fa fa-info-circle faa-tada animated faa-slow"></i> {!!Lang::get('admin::common.categories_statistics')!!}</h2>
        <ol class="breadcrumb" style="background: none;">
            <li><a  href="{!!URL::to('/'.ADMIN.'/dashboard')!!}">{!!Lang::get('admin::common.dashboard')!!}</a></li>
            <li>{!!Lang::get('admin::common.categories_statistics')!!}</li>
        </ol>
    </div>

</div>
@stop
@section("content")

<div id="content-wrapper">


    <div class="row wrapper animated fadeInRight ">



        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5> {!!Lang::get('admin::common.categories_statistics')!!}</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        {!! Form::open(array('url' => ADMIN.'/stats', 'method' => 'get', 'class' => 'col-xs-12 col-sm-8', 'style' => 'padding:0')) !!}

                        <div class="input-group" id="data_5" style="display:inline-block">
                            <div class="input-daterange input-group" id="datepicker" >
                                <input type="text" class="input-sm form-control" name="start" placeholder="{!!Lang::get('posts::posts.start')!!}" value="<?php echo Request::get("start"); ?>"/>
                                <span class="input-group-addon">{!!Lang::get('posts::posts.to')!!}</span>
                                <input type="text" class="input-sm form-control" name="end" value="<?php echo Request::get("end"); ?>" placeholder="{!!Lang::get('posts::posts.end')!!}"/>
                            </div>

                        </div>
                        <button style="display:inline-block; margin-top: -18px;" type="submit" class="btn btn-primary">{!!Lang::get('posts::posts.view')!!}</button>
                        {!! Form::close()!!}

                    </div>

                </div>
                <div class="table-responsive">

                    <table cellspacing="0" cellpadding="0" border="0" class="table table-striped">
                        <thead>
                            <tr>
                                <th>{!!Lang::get('posts::posts.category')!!}</th>
                                <th>{!!Lang::get('posts::posts.views')!!}</th>
                                <th>{!!Lang::get('posts::posts.facebook')!!}</th>
                                <th>{!!Lang::get('posts::posts.twitter')!!}</th>
                                <th>{!!Lang::get('posts::posts.youtube')!!}</th>
                            </tr>
                        </thead>
                        <tbody >
                            @if(count(@$stats))
                            @foreach($stats as $key => $stat)
                            <tr class="odd gradeX">
                                <td>
                                    @if($stat['cat_id'] == 'article')
                                    <h4><a href="{!!URL::to(ADMIN.'/posts')!!}?order_by=most&type=article">{!!$stat['cat_name']!!}</a></h4>
                                    @else
                                    <h4><a href="{!!URL::to(ADMIN.'/posts')!!}?order_by=most&category_id={!!$stat['cat_id']!!}">{!!$stat['cat_name']!!}</a></h4>
                                    @endif
                                </td>
                                <td>
                                    <h4><span class="label label-primary">{!!$stat['views']!!}</span></h4>
                                </td>
                                <td>
                                    <h4><span class="label label-success">{!!$stat['facebook']!!}</span></h4>
                                </td>
                                <td>
                                    <h4><span class="label label-purple">{!!$stat['twitter']!!}</span></h4>
                                </td>
                                <td>
                                    <h4><span class="label label-danger">{!!$stat['youtube']!!}</span></h4>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="odd gradeX" style="height:200px">
                                <td colspan="5" style="vertical-align:middle; text-align:center; font-weight:bold; font-size:22px">{!!Lang::get('posts::posts.no_stats')!!}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>


                </div>

            </div>
        </div>

    </div>
</div>

@section('footer')
<link href="<?php echo assets("admin::") ?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script src="<?php echo assets("admin::") ?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script>
$(document).ready(function () {

    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        language: 'ar', //as you defined in bootstrap-datepicker.XX.js
        isRTL: true
    });

});

</script>

@stop
@stop
