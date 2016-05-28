
@extends("admin::layouts.master")

@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{!!trans('navigations::navigations.navigations')!!}</h2>
        <ol class="breadcrumb" style="background: none;">
            <li><a  href="{!!URL::to('/'.ADMIN.'/dashboard')!!}">{!!Lang::get('admin::common.dashboard')!!}</a></li>
            <li><a  href="{!!URL::to('/'.ADMIN.'/navigations')!!}">{!!Lang::get('navigations::navigations.navigations')!!}</a></li>
            <li>{!!trans('navigations::navigations.add_new')!!} {!!trans('navigations::navigations.navigation')!!}</li>
        </ol>
    </div>

</div>
@stop
@section("content")
<div id="content-wrapper">

    <div class="row">

        <div class="col-sm-12">
            {!!Form::open([
                    'route' => [ADMIN . '.navigations.store'],
                    'method' => 'POST',
                    'class' => 'panel form-horizontal',
                    'id' => 'form',
        ])!!}
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> {!!trans('navigations::navigations.new_navigation')!!} </h5>

                </div>
                <div class="ibox-content">
                    <div class="form-group {!!$errors->has('name') ? 'has-error has-feedback' : ''!!}">
                        <label for="menu-name" class="col-sm-2 control-label">{!!trans('navigations::navigations.menu_name')!!}</label>
                        <div class="col-sm-5">
                            <input name="name" type="text" class="form-control" id="menu-name" placeholder="{!!trans('navigations::navigations.menu_name')!!}" @if(Request::old('name')) value="{!!Request::old('name')!!}" @endif>
                                   @if($errors->has('name'))<span class="fa fa-times-circle form-control-feedback"></span>@endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9">
                            <button type="submit" class="btn btn-primary">{!!trans('navigations::navigations.save')!!}</button>
                        </div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>

    </div>
</div> <!-- / #content-wrapper -->
<script src="<?php echo assets() ?>/js/plugins/validate/jquery.validate.min.js"></script>

<script>

$(document).ready(function() {

    $("#form").validate({
        ignore:[],
        rules: {
            name: {
                required: true
            },
        }
    });
});

jQuery.extend(jQuery.validator.messages, {
    required: "{!!Lang::get('pages::pages.required')!!}",
});
</script>
@stop
