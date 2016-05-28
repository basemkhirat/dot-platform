@extends("admin::layouts.auth")

@section("content")


<p><?php echo trans("auth::auth.password_reset") ?></p>

<form class="m-t" role="form" action="<?php echo route("admin.auth.forget"); ?>" id="signin-form_id" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <?php if ($errors->first("not_registed")) { ?>
        <div class="alert alert-danger"><?php echo $errors->first("not_registed"); ?></div>
    <?php } ?>

    <?php if ($errors->first("email_sent")) { ?>
        <div class="alert alert-success"><?php echo $errors->first("email_sent"); ?></div>
    <?php } ?>

    <div class="form-group" <?php if ($errors->first("email")) { ?>has-error<?php } ?>>
        <input type="text" name="email" value="<?php echo Request::old("email"); ?>" class="form-control" placeholder="<?php echo trans("auth::auth.email") ?>" required="">
        <span class="help-block"><?php echo $errors->first("email"); ?></span>
    </div>

    <button type="submit" class="btn btn-primary block full-width m-b"><?php echo trans("auth::auth.send_reset_link") ?></button>
    <a class="text-navy" href="<?php echo route("admin.auth.login"); ?>"><small><?php echo trans("auth::auth.back_to_login") ?></small></a>
</form>

@stop
