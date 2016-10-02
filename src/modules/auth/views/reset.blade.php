@extends("admin::layouts.auth")

@section("content")

<p><?php echo trans("auth::auth.password_reset") ?></p>
<?php if ($reseted) { ?>
    <div class="alert alert-success"><?php echo trans("auth::auth.password_changed") ?></div>
    <div class="form-actions">

        <a href="<?php echo route("admin.auth.login"); ?>" class="signin-btn"><?php echo trans("auth::auth.back_to_login") ?></a>
    </div> <!-- / .form-actions -->
<?php } else { ?>
    <form class="m-t" role="form" action="<?php echo route("admin.auth.reset", array("code" => $code)); ?>" id="signin-form_id" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="code" value="<?php echo $code; ?>" />


        <?php if ($errors->first("not_registed")) { ?>
            <div class="alert alert-danger"><?php echo $errors->first("not_registed"); ?></div>
        <?php } ?>

        <?php if ($errors->first("email_sent")) { ?>
            <div class="alert alert-success"><?php echo $errors->first("email_sent"); ?></div>
        <?php } ?>

        <div class="form-group" <?php if ($errors->first("password")) { ?>has-error<?php } ?>>
            <input type="password" name="password"  class="form-control" placeholder="<?php echo trans("auth::auth.password") ?>" required="">
            <span class="help-block"><?php echo $errors->first("password"); ?></span>
        </div>

        <div class="form-group" <?php if ($errors->first("repassword")) { ?>has-error<?php } ?>>
            <input type="password" name="repassword"  class="form-control" placeholder="<?php echo trans("auth::auth.confirm_password") ?>" required="">
            <span class="help-block"><?php echo $errors->first("repassword"); ?></span>
        </div>

        <button type="submit" class="btn btn-primary block full-width m-b"><?php echo trans("auth::auth.reset_my_password") ?></button>
        <a class="text-navy" href="<?php echo route("admin.auth.login"); ?>"><small><?php echo trans("auth::auth.login_now") ?></small></a>
    </form>
<?php } ?>

@stop
