
@extends("admin::layouts.master")

@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><i class="fa fa-tasks faa-tada animated faa-slow"></i> {!!trans('navs::navs.navigations')!!} ({!!$navigations->total()!!})</h2>
        <ol class="breadcrumb" style="background: none;">
            <li><a  href="{!!URL::to('/'.ADMIN.'/dashboard')!!}">{!!Lang::get('admin::common.dashboard')!!}</a></li>
            <li>{!!trans('navs::navs.all')!!} {!!trans('navs::navs.navigations')!!}</li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a href="{!!route(ADMIN . '.navigations.create')!!}" class="btn btn-primary btn-labeled btn-main pull-right"><span class="btn-label icon fa fa-plus"></span> {!!trans('navs::navs.add_new')!!}</a>
    </div>
</div>
@stop
@section("content")

<div id="content-wrapper">

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> {!!trans('navs::navs.navigations')!!} </h5>

                </div>
                <div class="ibox-content">
                    <?php /*
                    <div class="row">
                        <div class="col-sm-4 m-b-xs pull-right">
                            {!! Form::open(array('method' => 'get', 'id' => 'search',  'class' => 'choosen-rtl')) !!}

                            <div class="input-group">
                                <input type="text" placeholder="{!!Lang::get('pages::pages.search')!!}" class="input-sm form-control" value="{!!(Request::get('search')) ? Request::get('search') : ''!!}" name="search" id="q"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> {!!Lang::get('pages::pages.search')!!}</button> </span>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
 */ ?>
                    <div class="table-responsive">
                        <table cellspacing="0" cellpadding="0" border="0" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{!!trans('navs::navs.navigations')!!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($navigations as $navigation)

                                <tr>
                                    <td><a href="{!!$navigation->url!!}">{!!$navigation->id!!}</a></td>
                                    <td><a href="{!!$navigation->url!!}">{!!$navigation->name!!}</a></td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <div class="panel-footer text-right" style="border-top: none; background: none;">

                            <div class="col-sm-10 m-b-xs" style="padding:0">
                                <div class="pull-right">
                                    {!!$navigations->appends(Request::all())->setPath('')->render()!!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // search submit
        $("#search").submit(function (e) {
            if ($("#q").val() == '') {
                return false
            }
        });
    });
</script>

@stop

