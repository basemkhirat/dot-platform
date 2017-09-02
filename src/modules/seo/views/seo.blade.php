<div class="panel panel-default" id="seotool">

    <div class="panel-heading">
        <i class="fa fa-line-chart"></i>
        <?php echo trans("seo::seo.search_engines") ?>
    </div>

    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#general-tab" data-toggle="tab">{!!Lang::get('seo::seo.general')!!}</a>
            </li>
            <li>
                <a href="#analysis-tab" data-toggle="tab">{!!Lang::get('seo::seo.page_analysis')!!}</a>
            </li>
            <li>
                <a href="#advanced-tab" data-toggle="tab">{!!Lang::get('seo::seo.advanced')!!}</a>
            </li>
            <li>
                <a href="#facebook-tab" data-toggle="tab">{!!Lang::get('seo::seo.facebook')!!}</a>
            </li>
            <li>
                <a href="#twitter-tab" data-toggle="tab">{!!Lang::get('seo::seo.twitter')!!}</a>
            </li>
        </ul>
        <div class="tab-content tab-content-bordered form-horizontal" style="padding-top:15px">
            <div class="tab-pane fade active in " id="general-tab">
                <div class="form-group tooltip-demo">
                    <label class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.snippet_preview')!!}</label>
                    <div class="col-sm-1 text-left"><label style="cursor: pointer; padding: 15px 0;"
                                                           class="control-label " data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{!!Lang::get('seo::seo.snippet_info')!!}"><i
                                class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">


                        <div class="wpseosnippet">
                            <a class="title" id="google_title" href="#"><?php if ($post) { ?> <?php echo @
                                $post->seo->meta_title ?> <?php } ?></a>
                            <a class="title" id="google_separator" href="#"> - </a>
                            <a class="title" href="#"> <?php echo config("site_title") ?></a>
                            <div class="clear"></div>
                            <?php if($post){ ?>
                            <span class="url"><?php echo @get_post_url($post); ?></span>
                            <?php }else{ ?>
                            <span class="url"><?php echo URL::to("/"); ?></span>
                            <?php } ?>
                            <p class="desc"><span class="autogen"></span><span class="content"
                                                                               id="google_description"><?php if (@
                                    $post->seo->meta_description != ""){ ?><?php echo @
                                    $post->seo->meta_description;  ?><?php }else{ ?><?php echo @
                                    $post->excerpt; ?><?php } ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="form-group tooltip-demo">
                    <label for="focus_keyword" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.focus_keyword')!!}</label>
                    <div class="col-sm-1 text-left"><label for="focus_keyword" style="cursor: pointer; padding: 15px 0;"
                                                           id="focuskwhelp" class="control-label " data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{!!Lang::get('seo::seo.focus_info')!!}"><i
                                class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">
                        <input type="hidden" name="meta[focus_keyword]" id="focus_keyword"
                               value="{!! Request::old('meta[focus_keyword]', @$post->seo->focus_keyword) !!}">
                        <ul id="metafocus" style="border: 1px solid #E5E6E7 !important;"></ul>
                        <br>
                        <div>
                            <div id="focuskwresults">
                            <!--                                                    <p>
                                    <strong>{!!Lang::get('seo::seo.focus_keyword_usage')!!}</strong><br>{!!Lang::get('seo::seo.focus_keyword_p')!!}:
                                </p>
                                <ul>
                                    <li>{!!Lang::get('seo::seo.article_heading')!!}: <span class="good">{!!Lang::get('seo::seo.yes')!!} (1)</span></li>
                                    <li>{!!Lang::get('seo::seo.page_title')!!}: <span class="wrong">{!!Lang::get('seo::seo.no')!!}</span></li>
                                    <li>{!!Lang::get('seo::seo.page_url')!!}: <span class="good">{!!Lang::get('seo::seo.yes')!!} (1)</span></li>
                                    <li>{!!Lang::get('seo::seo.content')!!}: <span class="good">{!!Lang::get('seo::seo.yes')!!} (8)</span></li>
                                    <li>{!!Lang::get('seo::seo.meta_description')!!}: <span class="wrong">{!!Lang::get('seo::seo.no')!!}</span></li>
                                </ul>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group tooltip-demo">
                    <label for="meta_title" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.meta_title')!!}</label>
                    <div class="col-sm-1 text-left"><label for="meta_title" id="title-length-warning"
                                                           style="cursor: pointer; padding: 15px 0;"
                                                           class="control-label " data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{!!Lang::get('seo::seo.title_info')!!}"><i
                                class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">
                        <?php

                        $meta_title = "";
                        if ($post and $post->seo and $post->seo->meta_title != "") {
                            $meta_title = $post->seo->meta_title;
                        } elseif ($post) {
                            $meta_title = $post->title;
                        }

                        ?>

                        <input type="text" name="meta[meta_title]" value="<?php echo string_sanitize(Request::old('meta[meta_title]', $meta_title)) ?>" class="form-control input-lg" id="meta_title" placeholder="<?php echo Lang::get('seo::seo.meta_title'); ?>"/>

                    </div>
                </div>

                <div class="form-group tooltip-demo">
                    <label for="meta_description" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.meta_description')!!}</label>
                    <div class="col-sm-1 text-left"><label for="meta_description"
                                                           style="cursor: pointer; padding: 15px 0;"
                                                           class="control-label " data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{!!Lang::get('seo::seo.description_info')!!}"><i
                                class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">

                        <?php

                        $meta_description = "";
                        if ($post and $post->seo and $post->seo->meta_description != "") {
                            $meta_description = $post->seo->meta_description;
                        } elseif ($post) {
                            $meta_description = $post->excerpt;
                        }

                        ?>

                        <textarea name="meta[meta_description]" class="form-control" id="meta_description" rows="4"
                                  style="resize: vertical"
                                  placeholder="<?php echo Lang::get('seo::seo.meta_description'); ?>"><?php echo @Request
                            ::old("meta[meta_description]", $meta_description) ?></textarea>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.meta_descrip_subtitle', array('maxLength' => 156))!!} <span
                                id="metadesc-length"><span
                                    class="good">156</span></span> {!!Lang::get('seo::seo.chars_left')!!}.
                        </div>
                    </div>
                </div>
            </div> <!-- / .tab-pane -->


            <div class="tab-pane fade" id="analysis-tab">
                <div class="form-group" style="padding:0 14px">
                    {!!$seo_results!!}
                </div>
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade form-group" id="advanced-tab">
                <div class="form-group">
                    <label for="robots_index" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.meta_robots_index')!!}</label>
                    <div class="col-sm-7">


                        <select name="meta[robots_index]" id="robots_index"
                                class="form-control chosen-select chosen-rtl">


                            <?php

                            $index = 1;

                            if (isset($post->seo) and $post->seo->robots_index == 0) {
                                $index = 0;

                            }

                            ?>

                            <option value="0"
                                    @if($index == 0) selected @endif>{!!Lang::get('seo::seo.noindex')!!}</option>
                            <option value="1"
                                    @if($index == 1) selected @endif>{!!Lang::get('seo::seo.index')!!}</option>

                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-top:20px">
                    <label for="robots_follow" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.meta_robots_follow')!!}</label>
                    <div class="col-sm-7">


                        <?php

                        $follow = 1;

                        if (isset($post->seo) and $post->seo->robots_follow == 0) {
                            $follow = 0;

                        }

                        ?>

                        <input type="radio" name="meta[robots_follow]" value="0"
                               class="i-checks" <?php if ($follow == 0) { ?><?php echo "checked"; ?><?php } ?>>
                        <span class="lbl">{!!Lang::get('seo::seo.nofollow')!!}</span>

                        <input type="radio" name="meta[robots_follow]" value="1"
                               class="i-checks" <?php if ($follow == 1) { ?><?php echo "checked"; ?><?php } ?>>
                        <span class="lbl">{!!Lang::get('seo::seo.follow')!!}</span>&nbsp;&nbsp;

                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="robots_advanced" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.meta_robots_advanced')!!}</label>
                    <div class="col-sm-7">

                        <select data-placeholder="{!!Lang::get('seo::seo.site_wide_default')!!}" style=""
                                class="form-control chosen-select chosen-rtl" name="robots_advanced[]"
                                multiple="multiple" id="robots_advanced">
                            <option value="none"
                                    @if(strpos(@$post->seo->robots_advanced, 'none') !== false) selected="selected" @endif>{!!Lang::get('seo::seo.none')!!}</option>
                            <option value="noodp"
                                    @if(strpos(@$post->seo->robots_advanced, 'noodp') !== false) selected="selected" @endif>{!!Lang::get('seo::seo.noodp')!!}</option>
                            <option value="noydir"
                                    @if(strpos(@$post->seo->robots_advanced, 'noydir') !== false) selected="selected" @endif>{!!Lang::get('seo::seo.noydir')!!}</option>
                            <option value="noimageindex"
                                    @if(strpos(@$post->seo->robots_advanced, 'noimageindex') !== false) selected="selected" @endif>{!!Lang::get('seo::seo.no_image_index')!!}</option>
                            <option value="noarchive"
                                    @if(strpos(@$post->seo->robots_advanced, 'noarchive') !== false) selected="selected" @endif>{!!Lang::get('seo::seo.no_archive')!!}</option>
                            <option value="nosnippet"
                                    @if(strpos(@$post->seo->robots_advanced, 'nosnippet') !== false) selected="selected" @endif>{!!Lang::get('seo::seo.no_snippet')!!}</option>
                        </select>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.robots_advanced_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="in_sitemap" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.include_in_sitemap')!!}</label>
                    <div class="col-sm-7">
                        <select name="meta[in_sitemap]" id="in_sitemap" class="form-control chosen-select chosen-rtl">
                            <?php /*
                            <option value="0" <?php if(@$post->seo->in_sitemap == "0"){ ?><?php echo "selected"; ?><?php } ?>>{!!Lang::get('seo::seo.auto_detect')!!}</option>
                            */ ?>
                            <option value="0" <?php if(@$post->seo->in_sitemap == 0){
                                ?><?php echo "selected"; ?><?php } ?>>{!!Lang::get('seo::seo.never_include')!!}</option>
                            <option value="1" <?php if(@$post->seo->in_sitemap == 1 or @$post->seo->in_sitemap == null){
                                ?><?php echo "selected"; ?><?php } ?>
                                >{!!Lang::get('seo::seo.always_include')!!}</option>
                        </select>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.sitemap_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="sitemap_priority" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.sitemap_priority')!!}</label>
                    <div class="col-sm-7">
                        <select name="meta[sitemap_priority]" id="sitemap_priority"
                                class="form-control chosen-select chosen-rtl">

                            <?php $values = [0, 0.1, 0.2, 0.3. 0.4. 0.5, 0.6, 0.7, 0.8, 0.9, 1]; ?>
                            <?php foreach($values as $value){ ?>
                            <option <?php if($post and @$post->seo->sitemap_priority == $value){ echo "selected"; } ?>
                                value="<?php echo $value ?>"><?php echo $value ?></option>
                            <?php } ?>
                        </select>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.sitemap_priority_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:20px">
                    <label for="canonical_url" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.canonical_url')!!}</label>
                    <div class="col-sm-7">
                        <?php
                        if(isset($post->seo->canonical_url) and $post->seo->canonical_url != ""){
                            $link = $post->seo->canonical_url;
                        }else{
                        $link = "";

                        }
                        ?>

                            <input type="text" name="meta[canonical_url]" value="<?php echo string_sanitize(Request::old('meta[canonical_url]', $link)) ?>" class="form-control input-lg" style="text-align:left; direction:ltr" id="canonical_url" placeholder="<?php echo  @get_post_url($post); ?>"/>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.canonical_url_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="seo_redirect" class="col-sm-4 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.seo_redirect')!!}</label>
                    <div class="col-sm-7">

                        <input type="text" value="<?php echo string_sanitize(Request::old('meta[seo_redirect]', @$post->seo->seo_redirect)) ?>" class="form-control input-lg" style="text-align:left; direction:ltr" id="seo_redirect" placeholder="<?php echo Lang::get('seo::seo.seo_redirect'); ?>"/>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.seo_redirect_info')!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="facebook-tab">
                <div class="form-group">
                    <label for="facebook_title" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.facebook_title')!!}</label>
                    <div class="col-sm-8">
                        <input type="text" name="meta[facebook_title]" value="<?php echo string_sanitize(Request::old('meta[facebook_title]', @$post->seo->facebook_title)) ?>" class="form-control input-lg"  id="facebook_title" placeholder="<?php echo Lang::get('seo::seo.facebook_title'); ?>"/>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.facebook_title_info')!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="facebook_description" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.facebook_description')!!}</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="4" name="meta[facebook_description]" id="facebook_description" style="resize: vertical" placeholder="<?php echo Lang::get('seo::seo.facebook_description'); ?>"><?php echo string_sanitize(Request::old('meta[facebook_description]', @$post->seo->facebook_description)) ?></textarea>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.facebook_descrip_info')!!}
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="facebook_image" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.image')!!}</label>
                    <div class="col-sm-8" style=" padding-top:7px; position:relative;">
                        <span>
                            <input type="hidden" value="{!!@$post->seo->facebook_image!!}" id="facebook_photo"
                                   name="meta[facebook_image]">
                            <img
                                src="{{{ @$post->seo->facebook ? @ thumbnail($post->seo->facebook->path) : assets("admin::images/default.png") }}}"
                                height="108px" id="facebook_image"
                                @if(!@$post->seo->facebook_image) style="display:none" @endif>

                            <a href="javascript:void(0)" id="remove-facebook-image"
                               @if(!@$post->seo->facebook_image) style="display:none"
                               @else style="display:block" @endif>{!!Lang::get('seo::seo.remove_fb_image')!!}</a>
                            <a href="javascript:void(0)" id="set-facebook-image"
                               @if(!@$post->seo->facebook_image) style="display:block"
                               @else style="display:none" @endif>{!!Lang::get('seo::seo.set_fb_image')!!}</a>
                        </span>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.facebook_image_info')!!}
                        </div>
                    </div>
                </div>
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="twitter-tab">
                <div class="form-group">
                    <label for="twitter_title" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.twitter_title')!!}</label>
                    <div class="col-sm-8">

                        <input type="text" name="meta[twitter_title]" value="<?php echo string_sanitize(Request::old('meta[twitter_title]', @$post->seo->twitter_title)) ?>" class="form-control input-lg"  id="twitter_title" placeholder="<?php echo Lang::get('seo::seo.twitter_title'); ?>"/>

                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.twitter_title_info')!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="twitter_description" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.twitter_description')!!}</label>
                    <div class="col-sm-8">
                        <textarea name="meta[twitter_description]" class="form-control" id="twitter_description" style="resize: vertical" rows="4" placeholder="<?php echo Lang::get('seo::seo.twitter_description'); ?>"><?php echo string_sanitize(Request::old('meta[twitter_description]', @$post->seo->twitter_description)) ?></textarea>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.twitter_descrip_info')!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="twitter_image" class="col-sm-3 control-label"
                           style="padding-top: 7px;">{!!Lang::get('seo::seo.image')!!}</label>
                    <div class="col-sm-8" style=" padding-top:7px; position:relative;">
                        <span>
                            <input type="hidden" value="{!!@$post->seo->twitter_image!!}" id="twitter_photo"
                                   name="meta[twitter_image]">
                            <img
                                src="{{{ @$post->seo->twitter ? @thumbnail($post->seo->twitter->path) : assets("admin::images/default.png") }}}"
                                height="108px" id="twitter_image"
                                @if(!@$post->seo->twitter_image) style="display:none" @endif>

                            <a href="javascript:void(0)" id="remove-twitter-image"
                               @if(!@$post->seo->twitter_image) style="display:none"
                               @else style="display:block" @endif>{!!Lang::get('seo::seo.remove_fb_image')!!}</a>
                            <a href="javascript:void(0)" id="set-twitter-image"
                               @if(!@$post->seo->twitter_image) style="display:block"
                               @else style="display:none" @endif>{!!Lang::get('seo::seo.set_fb_image')!!}</a>
                        </span>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('seo::seo.twitter_image_info')!!}
                        </div>
                    </div>
                </div>
            </div> <!-- / .tab-pane -->
        </div> <!-- / .tab-content -->

    </div>
</div>


@push("header")

<style>


    #seotool .chosen-container {
        min-width: 80px;
    }

    #seotool tr {
        background: #f7f7f7 none repeat scroll 0 0;
        border: 1px solid #fff;
        display: block;
        padding: 5px;
    }

    #seotool ul.tagit input[type="text"] {

        width: 100px

    }
</style>
@endpush


@push("footer")

<script>
    $(document).ready(function () {

        $("#google_separator").hide();

        var update_google_description = function(){

            var meta_description = $('#meta_description').val();
            var post_excerpt = $('#post_excerpt').val();

            if(meta_description != ""){
                var description = meta_description;
            }else{
                var description = post_excerpt;
            }

            $('#google_description').text(description);
        }

        update_google_description();

        $('#meta_description').keyup('input', function () {
            update_google_description();
        });

        $('#post_excerpt').keyup('input', function () {
            update_google_description();
        });


        var update_google_title = function(){

            var meta_title = $('#meta_title').val();
            var post_title = $('#post_title').val();

            if(meta_title != ""){
                var title = meta_title;
            }else{
                var title = post_title;
            }

            $('#google_title').text(title);

            if(title != ""){
                $("#google_separator").show();
            }else{
                $("#google_separator").hide();
            }

        }

        update_google_title();

        $('#meta_title').keyup('input', function () {
            update_google_title();
        });

        $('#post_title').keyup('input', function () {
            update_google_title();
        });


        var length = $('#meta_description').val().length;
        var reminder = 156 - length;

        if (reminder > 0) {
            $("#metadesc-length span").removeClass("wrong");
            $("#metadesc-length span").addClass("good");
        } else {
            $("#metadesc-length span").removeClass("good");
            $("#metadesc-length span").addClass("wrong");
        }
        $("#metadesc-length span").text(reminder);

        $('#meta_description').on('input', function () {
            var length = $('#meta_description').val().length;
            var reminder = 156 - length;

            if (reminder > 0) {
                $("#metadesc-length span").removeClass("wrong");
                $("#metadesc-length span").addClass("good");
            } else {
                $("#metadesc-length span").removeClass("good");
                $("#metadesc-length span").addClass("wrong");
            }
            $("#metadesc-length span").text(reminder);
        });

        $('#input-title').on('input', function () {

            if ($('#meta_title').val() == "") {
                var title = $('#input-title').val();
                if (title != "") {
                    $('#google_title').text(title);
                } else {
                    $('#google_title').text($('#input-title').val());
                }
            }

            if ($('#google_title').text() != "") {
                $("#google_separator").show();
            } else {
                $("#google_separator").hide();
            }

        });

        $('#input-excerpt').on('input', function () {

            if ($('#meta_description').val() == "") {
                var meta_description = $('#input-excerpt').val();
                if (meta_description != "") {
                    $('#google_description').text(meta_description);
                } else {
                    $('#google_description').text("<?php if($post){ echo Str::words(strip_tags(string_sanitize($post->excerpt)), 15); } ?>");
                }
            }
        });


        $("#metakeywords").tagit({
            singleField: true,
            singleFieldNode: $('#meta_keywords'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "{!!Lang::get('seo::seo.meta_keywords')!!}",
            removeConfirmation: true,
            tagSource: function (request, response) {
                $.ajax({
                    url: "<?php echo route("google.search"); ?>",
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

        $("#metafocus").tagit({
            singleField: true,
            singleFieldNode: $('#focus_keyword'),
            allowSpaces: true,
            minLength: 2,
            tagLimit: 1,
            placeholderText: "{!!Lang::get('seo::seo.focus_keyword')!!}",
            removeConfirmation: true,
            tagSource: function (request, response) {
                $.ajax({
                    url: "<?php echo route("google.search"); ?>",
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

        $("#remove-facebook-image").click(function (e) {
            e.preventDefault();
            $("#facebook_photo").val("");
            $(this).hide();
            $("#facebook_image").hide();
            $("#set-facebook-image").css('display', 'block');
            $("#facebook_image").attr("src", '');
        });
        $("#set-facebook-image").filemanager({
            types: "image",
            panel: "media",
            done: function (files) {
                if (files.length) {
                    var file = files[0];

                    $("#facebook_image").show();
                    $("#set-facebook-image").hide();
                    $("#remove-facebook-image").css('display', 'block');
                    $("#remove_fb_image").show();
                    $("#facebook_photo").val(file.id);
                    $("#facebook_image").attr("src", file.url);


                }
            },
            error: function (media_path) {
                alert(media_path + is_not_an_image_lang);
            }
        });
        $("#remove_fb_image").click(function (e) {
            e.preventDefault();
            $("#remove-facebook-image").click();
        });
        $("#remove-twitter-image").click(function (e) {
            e.preventDefault();
            $("#twitter_photo").val("");
            $(this).hide();
            $("#twitter_image").hide();
            $("#remove_tw_image").hide();
            $("#set-twitter-image").css('display', 'block');
            $("#twitter_image").attr("src", '');
        });
        $("#set-twitter-image").filemanager({
            types: "image",
            panel: "media",
            done: function (files) {
                if (files.length) {
                    var file = files[0];
                    console.log(file);
                    $("#twitter_image").show();
                    $("#set-twitter-image").hide();
                    $("#remove-twitter-image").css('display', 'block');
                    $("#remove_tw_image").show();
                    $("#twitter_photo").val(file.id);
                    $("#twitter_image").attr("src", file.url);
                }
            },
            error: function (media_path) {
                alert(media_path + is_not_an_image_lang);
            }
        });
        $("#remove_tw_image").click(function (e) {
            e.preventDefault();
            $("#remove-twitter-image").click();
        });

        @if (isset($id))
        //$('#robots_index').val("{!!@$post->seo->robots_index!!}");
        $('input[name="meta[robots_follow]"][value="{!!@$post->seo->robots_follow!!}"]').prop('checked', 'checked');
        //$('#in_sitemap').val("{!!@$post->seo->in_sitemap!!}");
        $('#sitemap_priority').val("{!!round(@$post->seo->sitemap_priority, 2)!!}");
        @endif
    });

    $(window).load(function () {
        $('#robots_advanced_chosen').css('width', 'inherit');
        $('#robots_advanced_chosen input').css('width', 'inherit');
        $('#metafocus li.tagit-new').css("cssText", "width: inherit !important;");
        $('#metakeywords li.tagit-new').css("cssText", "width: inherit !important;");
    });
</script>
@endpush
