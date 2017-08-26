@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        @include("options::partials.nav")

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <form action="" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                <div class="row">

                    <div class="col-md-12">
                        <div class="panel ">
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="options_main" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="facebook_page">
                                                        <i class="fa fa-facebook-square"></i>

                                                        <?php echo trans("options::options.attributes.facebook_page") ?>
                                                    </label>
                                                    <input name="facebook_page" type="url"
                                                           value="<?php echo @Request::old("facebook_page", Config::get("facebook_page")); ?>"
                                                           class="form-control forign-box" id="facebook_page"
                                                           placeholder="https://www.facebook.com/fanpage">
                                                </div>

                                                <div class="form-group">
                                                    <label for="twitter_page">
                                                        <i class="fa fa-twitter-square"></i>
                                                        <?php echo trans("options::options.attributes.twitter_page") ?>
                                                    </label>
                                                    <input name="twitter_page" type="url"
                                                           value="<?php echo @Request::old("twitter_page", Config::get("twitter_page")); ?>"
                                                           class="form-control forign-box" id="twitter_page"
                                                           placeholder="https://twitter.com/fanpage">
                                                </div>

                                                <div class="form-group">
                                                    <label for="googleplus_page">
                                                        <i class="fa fa-google-plus-square"></i>

                                                        <?php echo trans("options::options.attributes.googleplus_page") ?>
                                                    </label>
                                                    <input name="googleplus_page" type="url"
                                                           value="<?php echo @Request::old("googleplus_page", Config::get("googleplus_page")); ?>"
                                                           class="form-control forign-box" id="googleplus_page"
                                                           placeholder="https://plus.google.com/+fanpage">
                                                </div>

                                                <div class="form-group">
                                                    <label for="youtube_page">
                                                        <i class="fa fa-youtube-square"></i>

                                                        <?php echo trans("options::options.attributes.youtube_page") ?>
                                                    </label>
                                                    <input name="youtube_page" type="url"
                                                           value="<?php echo @Request::old("youtube_page", Config::get("youtube_page")); ?>"
                                                           class="form-control forign-box" id="youtube_page"
                                                           placeholder="https://www.youtube.com/channel/fanpage">
                                                </div>

                                                <div class="form-group">
                                                    <label for="instagram_page">
                                                        <i class="fa fa-instagram"></i>

                                                        <?php echo trans("options::options.attributes.instagram_page") ?>
                                                    </label>
                                                    <input name="instagram_page" type="url"
                                                           value="<?php echo @Request::old("instagram_page", Config::get("instagram_page")); ?>"
                                                           class="form-control forign-box" id="instagram_page"
                                                           placeholder="https://instagram.com/fanpage">
                                                </div>

                                                <div class="form-group">
                                                    <label for="soundcloud_page">
                                                        <i class="fa fa-soundcloud"></i>

                                                        <?php echo trans("options::options.attributes.soundcloud_page") ?>
                                                    </label>
                                                    <input name="soundcloud_page" type="url"
                                                           value="<?php echo @Request::old("soundcloud_page", Config::get("soundcloud_page")); ?>"
                                                           class="form-control forign-box" id="soundcloud_page"
                                                           placeholder="https://soundcloud.com/fanpage">
                                                </div>

                                                <div class="form-group">
                                                    <label for="linkedin_page">
                                                        <i class="fa fa-linkedin-square"></i>

                                                        <?php echo trans("options::options.attributes.linkedin_page") ?>
                                                    </label>
                                                    <input name="linkedin_page" type="url"
                                                           value="<?php echo @Request::old("linkedin_page", Config::get("linkedin_page")); ?>"
                                                           class="form-control forign-box" id="linkedin_page"
                                                           placeholder="https://www.linkedin.com/profile">
                                                </div>

                                            </div>

                                            <?php /*
                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="breaking_live_stream">
                                            <i class="fa fa-television"></i>


                                            <?php echo trans("options::options.attributes.breaking_live_stream") ?></label>
                                        <input name="breaking_live_stream" type="text" value="<?php echo @Request::old("breaking_live_stream", Config::get("breaking_live_stream")); ?>" class="form-control text-left" id="breaking_live_stream" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label for="breaking_hash_tag">
                                            <i class="fa fa-hashtag"></i>


                                            <?php echo trans("options::options.attributes.breaking_hash_tag") ?></label>
                                        <input name="breaking_hash_tag" type="text" value="<?php echo @Request::old("breaking_hash_tag", Config::get("breaking_hash_tag")); ?>" class="form-control" id="breaking_hash_tag" placeholder="">
                                    </div>





                                </div>*/?>

                                            <div class="col-md-6">
                                                <?php /*

                                    <div class="form-group">
                                        <label for="facebook_page">
                                            <i class="fa fa-facebook-square"></i>

                                            <?php echo trans("options::options.attributes.facebook_page") ?></label>
                                        <input name="facebook_page" type="text" value="<?php echo @Request::old("facebook_page", Config::get("facebook_page")); ?>" class="form-control text-left" id="facebook_page" placeholder="https://www.facebook.com/fanpage">
                                    </div>
 */ ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div> <!-- / .panel-body -->
                        </div>
                    </div>

                    <div style="clear:both"></div>
                    <div>
                        <div class="container-fluid">
                            <div class="form-group">
                                <input type="submit" class="pull-left btn btn-flat btn-primary"
                                       value="<?php echo trans("options::options.save_options") ?>"/>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            @push("header")
                <link href="<?php echo assets("admin::tagit")?>/jquery.tagit.css" rel="stylesheet" type="text/css">
                <link href="<?php echo assets("admin::tagit")?>/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
            @endpush

            @push("footer")
                <script src="<?php echo assets("admin::tagit")?>/tag-it.js"></script>
                <script>
                    $(document).ready(function () {
                        var elems = Array.prototype.slice.call(document.querySelectorAll('.switcher'));
                        elems.forEach(function (html) {
                            var switchery = new Switchery(html);
                        });
                    });
                </script>
                <script>
                    $(document).ready(function () {

                        $('.chosen-select').chosen();

                        $("#mytags").tagit({
                            singleField: true,
                            singleFieldNode: $('#tags_names'),
                            allowSpaces: true,
                            minLength: 2,
                            placeholderText: "",
                            removeConfirmation: true,
                            tagSource: function (request, response) {
                                $.ajax({
                                    url: "<?php echo route("admin.google.search"); ?>",
                                    data: {term: request.term},
                                    dataType: "json",
                                    success: function (data) {
                                        console.log(data);
                                        response($.map(data, function (item) {
                                            return {
                                                label: item.name,
                                                value: item.name
                                            }
                                        }));
                                    }
                                });
                            }
                        });


                    });
                </script>
    @endpush
@stop
