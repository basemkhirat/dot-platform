@extends("admin::layouts.master")

@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
        <h2>
            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            <?php echo trans("roles::roles.edit") ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo URL::to(ADMIN . "/roles"); ?>"><?php echo trans("roles::roles.roles") ?></a>
            </li>
            <li class="active">
                <strong><?php echo trans("roles::roles.edit") ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-6 text-right">
        <?php if (!User::access("roles.create")) { ?>
            <a href="<?php echo route("admin.roles.create"); ?>" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("roles::roles.add_new") ?></a>
        <?php } ?>
    </div>
</div>
@stop

@section("content")


@include("admin::partials.messages")

<form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="panel">

                <div class="panel-body">

                    <div class="form-group">
                        <input name="name" value="<?php echo @Request::old("name", $role->name); ?>"
                               class="form-control input-lg" value=""
                               placeholder="<?php echo trans("roles::roles.name"); ?>"/>
                    </div>

                    <?php foreach ($modules as $module) {
                        $permissions = Config::get("$module.permissions");
                        ?>

                        <?php if ($permissions != NULL) { ?>
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <a class="accordion-toggle text-navy" data-toggle="collapse"
                                       href="#collapse-<?php echo $module; ?>">
                                        <strong><?php echo ucfirst(trans(trans("$module::$module.module"))); ?></strong>
                                    </a>
                                </div>

                                <div id="collapse-<?php echo $module; ?>" class="panel-collapse in">
                                    <div class="panel-body">
                                        <?php foreach ($permissions as $slug) { ?>
                                            <label class="checkbox">
                                                <input <?php if ($role and in_array($module . "." . $slug, $role_permissions)) { ?> checked="checked" <?php } ?>
                                                    type="checkbox" name="permissions[]"
                                                    value="<?php echo $module . "." . $slug; ?>"
                                                    class="switcher permission-switcher switcher-sm">
                                            <span style="margin: 0 10px 10px;">
                                                <?php echo ucfirst(trans($module . "::" . $module . ".permissions." . $slug)); ?>
                                            </span>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-group">
            <input type="submit" class="pull-left btn btn-primary"
                   value="<?php echo trans("roles::roles.save"); ?>"/>
        </div>
    </div>
</form>

@stop

@section("footer")

<script>
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.permission-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html);
        });
    });
</script>

@stop