<?php if (Session::has("message")) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Session::get("message"); ?>
    </div>
<?php } ?>

<?php  if ($errors->count() > 0) { ?>
    <div class="alert alert-danger alert-dark">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo implode(' <br /> ', $errors->all()) ?>
    </div>
<?php }  ?>
