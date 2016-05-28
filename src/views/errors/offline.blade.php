@extends("admin::layouts.message")

@section("content")

<div class="middle-box text-center animated fadeInDown">
    <h4><?php echo trans("admin::common.sorry") ?></h4>
    <div class="error-desc">
        <?php echo Config::get("offline_message"); ?>
    </div>
    <p class="m-t"> <small> <?php echo Config::get("site_copyrights") ?> </small> </p>
</div>

@stop