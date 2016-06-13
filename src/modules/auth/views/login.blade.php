@extends("admin::layouts.auth")

@section("content")

<p><?php echo trans("auth::auth.sign_in_to_account"); ?></p>
<form class="m-t" role="form" action="<?php echo route("admin.auth.login") ?>" id="signin-form_id" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" name="url" value="<?php echo Request::old("url", Session::get("url")); ?>"/>

    <?php if (isset($errors) and count($errors)) { ?>
        <?php if ($errors->first("message")) { ?>
            <div class="alert alert-danger"><?php echo $errors->first("message"); ?></div>
        <?php } ?>
    <?php } ?>

    <div class="form-group" <?php if ($errors->first("username")) { ?>has-error<?php } ?>>
        <input type="text" name="username" value="<?php echo Request::old("username"); ?>" class="form-control"
               placeholder="<?php echo trans("auth::auth.username") ?>" required="">
        <span class="help-block"><?php echo $errors->first("username"); ?></span>
    </div>
    <div class="form-group" <?php if ($errors->first("password")) { ?>has-error<?php } ?>>
        <input type="password" name="password" class="form-control"
               placeholder="<?php echo trans("auth::auth.password") ?>" required="">
        <span class="help-block"><?php echo $errors->first("password"); ?></span>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" value="1">
                <span class="remember_text"><?php echo trans("auth::auth.remember_me") ?></span>
            </label>
        </div>
    </div>

    <button type="submit"
            class="btn btn-primary block full-width m-b"><?php echo trans("auth::auth.login_in"); ?></button>
    <a class="text-navy" href="<?php echo route("admin.auth.forget"); ?>">
        <small><?php echo trans("auth::auth.forget_password"); ?></small>
    </a>
</form>


@stop

@section("footer")
@parent

<script src="<?php echo assets("admin::") ?>/js/plugins/switchery/switchery.js"></script>

<script>

    var elems = Array.prototype.slice.call(document.querySelectorAll('input[type=checkbox]'));
    elems.forEach(function (html) {
        var switchery = new Switchery(html);
    });

</script>

@stop
