@extends("admin::layouts.master")
@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-7">
        <h2>
            <i class="fa fa-th-large"></i>
            <?php
            if ($group) {
                echo trans("groups::groups.edit");
            } else {
                echo trans("groups::groups.add_new");
            }
            ?>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo route("admin"); ?>"><?php echo trans("admin::common.admin") ?></a>
            </li>
            <li>
                <a href="<?php echo URL::to(ADMIN . "/groups"); ?>"><?php echo trans("groups::groups.groups"); ?></a>
            </li>
            <li class="active">
                <strong>
                    <?php
                    if ($group) {
                        echo trans("groups::groups.edit");
                    } else {
                        echo trans("groups::groups.add_new");
                    }
                    ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-5">
        <?php if ($group) { ?>
            <a href="<?php echo route("admin.groups.create"); ?>" class="btn btn-primary btn-labeled btn-main pull-right"> <span class="btn-label icon fa fa-plus"></span> &nbsp; <?php echo trans("groups::groups.add_new") ?></a>
        <?php } ?>
        <a href="<?php echo route("admin.groups.show"); ?>" class="btn btn-primary btn-labeled btn-main pull-right">
            <i class="fa fa-bars"></i>
            <?php echo trans("groups::groups.back_to_groups") ?>
        </a>
    </div>
</div>
@stop
@section("content")
@include("admin::partials.messages")
<form action="" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label for="input-name"><?php echo trans("groups::groups.attributes.name") ?></label>
                        <input name="name" type="text" value="<?php echo @Request::old("name", $group->name); ?>" class="form-control" id="input-name" placeholder="<?php echo trans("groups::groups.attributes.name") ?>">
                    </div>

                    <div class="form-group">
                        <label for="input-description"><?php echo trans("groups::groups.attributes.description") ?></label>
                        <textarea name="description" class="form-control" id="input-description" placeholder="<?php echo trans("groups::groups.attributes.description") ?>"><?php echo @Request::old("description", $group->description); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="input-usernames"><?php echo trans("groups::groups.users") ?></label>
                        <input type="hidden" name="users" id="usernames" value="<?php echo join(",", $group_users); ?>">
                        <ul id="group-users"></ul>
                    </div>


                </div>
            </div>




            <?php /*
              <div class="ibox">
              <div class="ibox-content">
              <h2>Clients</h2>

              <div class="input-group">
              <input type="text" placeholder="Search client " class="input form-control">
              <span class="input-group-btn">
              <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Search</button>
              </span>
              </div>
              <div class="clients-list">

              <div class="table-responsive">
              <table class="table table-striped table-hover">
              <tbody>
              <tr>
              <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td>
              <td><a data-toggle="tab" href="#contact-1" class="client-link">Anthony Jackson</a></td>
              <td> Tellus Institute</td>
              <td class="contact-type"><i class="fa fa-envelope"> </i></td>
              <td> gravida@rbisit.com</td>
              <td class="client-status"><span class="label label-primary">Active</span></td>
              </tr>
              </tbody>
              </table>
              </div>

              </div>
              </div>
              </div>
             */ ?>


        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square"></i>
                    <?php echo trans("groups::groups.group_status"); ?>
                </div>
                <div class="panel-body">
                    <div class="form-group switch-row">
                        <label class="col-sm-9 control-label" for="input-status"><?php echo trans("groups::groups.attributes.status") ?></label>
                        <div class="col-sm-3">
                            <input <?php if (@Request::old("status", $group->status)) { ?> checked="checked" <?php } ?> type="checkbox" id="input-status" name="status" value="1" class="status-switcher switcher-sm">
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div style="clear:both"></div>
        <div>
            <div class="panel-footer" style="border-top: 1px solid #ececec; position: relative;">
                <div class="form-group" style="margin-bottom:0">
                    <input type="submit" class="pull-right btn btn-flat btn-primary" value="<?php echo trans("groups::groups.save_group") ?>" />
                </div>
            </div>
        </div>
    </div>
</form>
@section("header")
@parent
<link href="<?php echo assets("admin::tagit")?>/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?php echo assets("admin::tagit")?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@stop
@section("footer")
@parent
<script type="text/javascript" src="<?php echo assets("admin::tagit")?>/tag-it.js"></script>
<script>
    $(document).ready(function () {

        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });


        $("#group-users").tagit({
            singleField: true,
            singleFieldNode: $('#usernames'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "",
            removeConfirmation: true,
            tagSource: function (request, response) {
                $.ajax({
                    url: "<?php echo route("admin.users.search"); ?>",
                    data: {term: request.term},
                    dataType: "json",
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: item.username,
                                value: item.username
                            }
                        }));
                    }
                });
            }
        });

    });
</script>
@stop
@stop
