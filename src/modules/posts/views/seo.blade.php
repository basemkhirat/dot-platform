<div class="panel panel-default" id="seotool">

    <div class="panel-heading">
                            <i class="fa fa-line-chart"></i>
                            <?php echo trans("posts::posts.search_engines") ?>
                        </div>

    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#general-tab" data-toggle="tab">{!!Lang::get('posts::posts.general')!!}</a>
            </li>
            <li>
                <a href="#analysis-tab" data-toggle="tab">{!!Lang::get('posts::posts.page_analysis')!!}</a>
            </li>
            <li>
                <a href="#advanced-tab" data-toggle="tab">{!!Lang::get('posts::posts.advanced')!!}</a>
            </li>
            <li>
                <a href="#facebook-tab" data-toggle="tab">{!!Lang::get('posts::posts.facebook')!!}</a>
            </li>
            <li>
                <a href="#twitter-tab" data-toggle="tab">{!!Lang::get('posts::posts.twitter')!!}</a>
            </li>
        </ul>
        <div class="tab-content tab-content-bordered form-horizontal" style="padding-top:15px">
            <div class="tab-pane fade active in " id="general-tab">
                <div class="form-group tooltip-demo">
                    <label class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.snippet_preview')!!}</label>
                    <div class="col-sm-1 text-left"><label style="cursor: pointer; padding: 15px 0;" class="control-label " data-toggle="tooltip" data-placement="top" title="{!!Lang::get('posts::posts.snippet_info')!!}"><i class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">



                        <div class="wpseosnippet">
                            <a class="title" id="google_title"  href="#"><?php if ($post) { ?> <?php echo @$post->meta->meta_title  ?> <?php } ?></a>
                            <a class="title" id="google_separator"  href="#"> - </a>
                            <a class="title"  href="#"><?php

                                if($post and isset($post->id)){

                                    if($post->site == "en"){
                                        echo "dotemirates";
                                    }else{
                                        echo "دوت إمارات";
                                    }

                                }else{
                                    echo "دوت إمارات";
                                }

                                ?></a>
                            <div class="clear"></div>
                            <?php if($post){ ?>
                            <span class="url"><?php echo @get_post_url($post); ?></span>
                            <?php }else{ ?>
                             <span class="url"><?php echo URL::to("/"); ?></span>
                            <?php } ?>
                            <p class="desc"><span class="autogen"></span><span class="content" id="google_description"><?php if(@$post->meta->meta_description != ""){ ?><?php echo @$post->meta->meta_description;  ?><?php }else{ ?><?php echo @$post->excerpt; ?><?php } ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="form-group tooltip-demo">
                    <label for="focus_keyword" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.focus_keyword')!!}</label>
                    <div class="col-sm-1 text-left"><label for="focus_keyword" style="cursor: pointer; padding: 15px 0;" id="focuskwhelp" class="control-label " data-toggle="tooltip" data-placement="top" title="{!!Lang::get('posts::posts.focus_info')!!}"><i class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">
                        <input type="hidden" name="meta[focus_keyword]" id="focus_keyword" value="{!! Input::old('meta[focus_keyword]', @$post->meta->focus_keyword) !!}">
                        <ul id="metafocus" style="border: 1px solid #E5E6E7 !important;"></ul>
                        <br>
                        <div>
                            <div id="focuskwresults">
<!--                                                    <p>
                                    <strong>{!!Lang::get('posts::posts.focus_keyword_usage')!!}</strong><br>{!!Lang::get('posts::posts.focus_keyword_p')!!}:
                                </p>
                                <ul>
                                    <li>{!!Lang::get('posts::posts.article_heading')!!}: <span class="good">{!!Lang::get('posts::posts.yes')!!} (1)</span></li>
                                    <li>{!!Lang::get('posts::posts.page_title')!!}: <span class="wrong">{!!Lang::get('posts::posts.no')!!}</span></li>
                                    <li>{!!Lang::get('posts::posts.page_url')!!}: <span class="good">{!!Lang::get('posts::posts.yes')!!} (1)</span></li>
                                    <li>{!!Lang::get('posts::posts.content')!!}: <span class="good">{!!Lang::get('posts::posts.yes')!!} (8)</span></li>
                                    <li>{!!Lang::get('posts::posts.meta_description')!!}: <span class="wrong">{!!Lang::get('posts::posts.no')!!}</span></li>
                                </ul>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group tooltip-demo">
                    <label for="meta_title" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_title')!!}</label>
                    <div class="col-sm-1 text-left"><label for="meta_title" id="title-length-warning" style="cursor: pointer; padding: 15px 0;" class="control-label " data-toggle="tooltip" data-placement="top" title="{!!Lang::get('posts::posts.title_info')!!}"><i class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">
                        <?php

                        $meta_title = "";
                        if($post and $post->meta and $post->meta->meta_title != ""){
                            $meta_title = $post->meta->meta_title;
                        }elseif($post){
                            $meta_title = $post->title;
                        }

                        ?>
                        {!! Form::text("meta[meta_title]", string_sanitize(Input::old('meta[meta_title]', $meta_title)), array('class' => 'form-control input-lg', 'id' => 'meta_title', 'placeholder' => Lang::get('posts::posts.meta_title'))) !!}

                    </div>
                </div>

                <div class="form-group tooltip-demo">
                    <label for="meta_description" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_description')!!}</label>
                    <div class="col-sm-1 text-left"><label for="meta_description" style="cursor: pointer; padding: 15px 0;" class="control-label " data-toggle="tooltip" data-placement="top" title="{!!Lang::get('posts::posts.description_info')!!}"><i class="fa fa-question-circle"></i></label></div>
                    <div class="col-sm-8">

                        <?php

                        $meta_description = "";
                        if($post and $post->meta and $post->meta->meta_description != ""){
                            $meta_description = $post->meta->meta_description;
                        }elseif($post){
                            $meta_description = $post->excerpt;
                        }

                        ?>

                        <textarea name="meta[meta_description]" class="form-control" id="meta_description" rows="4" style="resize: vertical" placeholder="<?php echo Lang::get('posts::posts.meta_description'); ?>" ><?php echo @Input::old("meta[meta_description]", $meta_description) ?></textarea>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.meta_descrip_subtitle', array('maxLength' => 156))!!} <span id="metadesc-length"><span class="good">156</span></span> {!!Lang::get('posts::posts.chars_left')!!}.
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
                    <label for="robots_index" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_robots_index')!!}</label>
                    <div class="col-sm-7">


                        <select name="meta[robots_index]" id="robots_index" class="form-control chosen-select chosen-rtl">


                            <?php

                            $index = 1;

                            if(isset($post->meta) and $post->meta->robots_index == 0){
                                $index = 0;

                                }

                            ?>

                            <option value="0" @if($index == 0) selected @endif>{!!Lang::get('posts::posts.noindex')!!}</option>
                            <option value="1" @if($index == 1) selected @endif>{!!Lang::get('posts::posts.index')!!}</option>

                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-top:20px">
                    <label for="robots_follow" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_robots_follow')!!}</label>
                    <div class="col-sm-7">


                        <?php

                        $follow = 1;

                        if(isset($post->meta) and $post->meta->robots_follow == 0){
                            $follow = 0;

                        }

                        ?>

                        <input type="radio" name="meta[robots_follow]" value="0" class="i-checks" <?php if($follow == 0){ ?><?php echo "checked" ; ?><?php } ?>>
                        <span class="lbl">{!!Lang::get('posts::posts.nofollow')!!}</span>

                        <input type="radio" name="meta[robots_follow]" value="1" class="i-checks" <?php if($follow == 1){ ?><?php echo "checked" ; ?><?php } ?>>
                        <span class="lbl">{!!Lang::get('posts::posts.follow')!!}</span>&nbsp;&nbsp;

                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="robots_advanced" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_robots_advanced')!!}</label>
                    <div class="col-sm-7">

                        <select data-placeholder="{!!Lang::get('posts::posts.site_wide_default')!!}" style="" class="form-control chosen-select chosen-rtl" name="robots_advanced[]"  multiple="multiple" id="robots_advanced">
                            <option value="none" @if(strpos(@$post->meta->robots_advanced, 'none') !== false) selected="selected" @endif>{!!Lang::get('posts::posts.none')!!}</option>
                            <option value="noodp" @if(strpos(@$post->meta->robots_advanced, 'noodp') !== false) selected="selected" @endif>{!!Lang::get('posts::posts.noodp')!!}</option>
                            <option value="noydir" @if(strpos(@$post->meta->robots_advanced, 'noydir') !== false) selected="selected" @endif>{!!Lang::get('posts::posts.noydir')!!}</option>
                            <option value="noimageindex" @if(strpos(@$post->meta->robots_advanced, 'noimageindex') !== false) selected="selected" @endif>{!!Lang::get('posts::posts.no_image_index')!!}</option>
                            <option value="noarchive" @if(strpos(@$post->meta->robots_advanced, 'noarchive') !== false) selected="selected" @endif>{!!Lang::get('posts::posts.no_archive')!!}</option>
                            <option value="nosnippet" @if(strpos(@$post->meta->robots_advanced, 'nosnippet') !== false) selected="selected" @endif>{!!Lang::get('posts::posts.no_snippet')!!}</option>
                        </select>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.robots_advanced_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="in_sitemap" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.include_in_sitemap')!!}</label>
                    <div class="col-sm-7">
                        <select name="meta[in_sitemap]" id="in_sitemap" class="form-control chosen-select chosen-rtl" >
                            <?php /*
                            <option value="0" <?php if(@$post->meta->in_sitemap == "0"){ ?><?php echo "selected"; ?><?php } ?>>{!!Lang::get('posts::posts.auto_detect')!!}</option>
                            */ ?>
                            <option value="0" <?php if(@$post->meta->in_sitemap == 0){ ?><?php echo "selected"; ?><?php } ?>>{!!Lang::get('posts::posts.never_include')!!}</option>
                            <option value="1" <?php if(@$post->meta->in_sitemap == 1 or @$post->meta->in_sitemap == null){ ?><?php echo "selected"; ?><?php } ?>>{!!Lang::get('posts::posts.always_include')!!}</option>
                        </select>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.sitemap_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="sitemap_priority" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.sitemap_priority')!!}</label>
                    <div class="col-sm-7">
                        <select name="meta[sitemap_priority]" id="sitemap_priority" class="form-control chosen-select chosen-rtl">

                            <?php $values = [0, 0.1, 0.2, 0.3. 0.4. 0.5, 0.6, 0.7, 0.8, 0.9, 1]; ?>
                            <?php foreach($values as $value){ ?>
                                <option <?php if($post and @$post->meta->sitemap_priority == $value){ echo "selected"; } ?> value="<?php echo $value ?>"><?php echo $value ?></option>
                            <?php } ?>
                        </select>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.sitemap_priority_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top:20px">
                    <label for="canonical_url" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.canonical_url')!!}</label>
                    <div class="col-sm-7">
                        <?php
                    if(isset($post->meta->canonical_url) and $post->meta->canonical_url != ""){
$link = $post->meta->canonical_url;
}else{
    $link = @get_post_url($post)."?from=dot";

}
?>
                        {!! Form::text("meta[canonical_url]", string_sanitize(Input::old('meta[canonical_url]', $link)), array('class' => 'form-control input-lg', "style" => "text-align:left; direction:ltr", 'id' => 'canonical_url', 'placeholder' => @get_post_url($post))) !!}
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.canonical_url_info')!!}
                        </div>
                    </div>
                </div>
                <div class="form-group hidden" style="margin-top:20px">
                    <label for="seo_redirect" class="col-sm-4 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.seo_redirect')!!}</label>
                    <div class="col-sm-7">
                        {!! Form::text("meta[seo_redirect]", string_sanitize(Input::old('meta[seo_redirect]', @$post->meta->seo_redirect)), array('class' => 'form-control input-lg', 'id' => 'seo_redirect', 'placeholder' => Lang::get('posts::posts.seo_redirect'))) !!}
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.seo_redirect_info')!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="facebook-tab">
                <div class="form-group">
                    <label for="facebook_title" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_title')!!}</label>
                    <div class="col-sm-8">
                        {!! Form::text("meta[facebook_title]", string_sanitize(Input::old('meta[facebook_title]', @$post->meta->facebook_title)), array('class' => 'form-control input-lg', 'id' => 'facebook_title', 'placeholder' => Lang::get('posts::posts.meta_title'))) !!}
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.facebook_title_info')!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="facebook_description" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_description')!!}</label>
                    <div class="col-sm-8">
                        {!! Form::textarea("meta[facebook_description]", string_sanitize(Input::old('meta[facebook_description]', @$post->meta->facebook_description)), ['class' => 'form-control', 'rows' => 4, 'id' => 'facebook_description', 'style' => 'resize: vertical;', 'placeholder' => Lang::get('posts::posts.meta_description')]) !!}
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.facebook_descrip_info')!!}
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="facebook_image" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.image')!!}</label>
                    <div class="col-sm-8" style=" padding-top:7px; position:relative;">
                        <span>
                            <input type="hidden" value="{!!@$post->meta->facebook_image!!}" id="facebook_photo" name="meta[facebook_image]">
                            <img src="{{{ @$post->meta->facebook ? @$post->meta->facebook->getImageURL('small') : assets("images/default.png") }}}" height="108px" id="facebook_image" @if(!@$post->meta->facebook_image) style="display:none" @endif>
                                 <button type="button" class="close" id="remove_fb_image" style="position:absolute; @if(DIRECTION == 'rtl') left:14px; @else right:14px @endif top:0; @if(!@$post->meta->facebook_image) display:none @endif"><i class="fa fa-times"></i></button>
                            <a href="javascript:void(0)" id="remove-facebook-image" @if(!@$post->meta->facebook_image) style="display:none" @else style="display:block" @endif>{!!Lang::get('posts::posts.remove_fb_image')!!}</a>
                            <a href="javascript:void(0)" id="set-facebook-image" @if(!@$post->meta->facebook_image) style="display:block" @else style="display:none" @endif>{!!Lang::get('posts::posts.set_fb_image')!!}</a>
                        </span>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.facebook_image_info')!!}
                        </div>
                    </div>
                </div>
            </div> <!-- / .tab-pane -->
            <div class="tab-pane fade" id="twitter-tab">
                <div class="form-group">
                    <label for="twitter_title" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_title')!!}</label>
                    <div class="col-sm-8">
                        {!! Form::text("meta[twitter_title]", string_sanitize(Input::old('meta[twitter_title]', @$post->meta->twitter_title)), array('class' => 'form-control input-lg', 'id' => 'twitter_title', 'placeholder' => Lang::get('posts::posts.meta_title'))) !!}
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.twitter_title_info')!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="twitter_description" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.meta_description')!!}</label>
                    <div class="col-sm-8">
                        {!! Form::textarea("meta[twitter_description]", string_sanitize(Input::old('meta[twitter_description]', @$post->meta->twitter_description)), ['class' => 'form-control', 'rows' => 4, 'id' => 'twitter_description', 'style' => 'resize: vertical;', 'placeholder' => Lang::get('posts::posts.meta_description')]) !!}
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.twitter_descrip_info')!!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="twitter_image" class="col-sm-3 control-label" style="padding-top: 7px;">{!!Lang::get('posts::posts.image')!!}</label>
                    <div class="col-sm-8" style=" padding-top:7px; position:relative;">
                        <span>
                            <input type="hidden" value="{!!@$post->meta->twitter_image!!}" id="twitter_photo" name="meta[twitter_image]">
                            <img src="{{{ @$post->meta->twitter ? @$post->meta->twitter->getImageURL('small') : assets("images/default.png") }}}" height="108px" id="twitter_image" @if(!@$post->meta->twitter_image) style="display:none" @endif>
                                 <button type="button" class="close" id="remove_tw_image" style="position:absolute; @if(DIRECTION == 'rtl') left:14px; @else right:14px @endif top:0; @if(!@$post->meta->twitter_image) display:none @endif"><i class="fa fa-times"></i></button>
                            <a href="javascript:void(0)" id="remove-twitter-image" @if(!@$post->meta->twitter_image) style="display:none" @else style="display:block" @endif>{!!Lang::get('posts::posts.remove_fb_image')!!}</a>
                            <a href="javascript:void(0)" id="set-twitter-image" @if(!@$post->meta->twitter_image) style="display:block" @else style="display:none" @endif>{!!Lang::get('posts::posts.set_fb_image')!!}</a>
                        </span>
                        <div style="font-size: 14px; margin-top: 2px">
                            {!!trans('posts::posts.twitter_image_info')!!}
                        </div>
                    </div>
                </div>
            </div> <!-- / .tab-pane -->
        </div> <!-- / .tab-content -->

    </div>
</div>


@section("header")
@parent
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
@stop
@section("footer")
@parent
<script>
    $(document).ready(function () {

         $("#google_separator").hide();

        if($('#meta_title').val() != ""){
             $("#google_separator").show();
            $('#google_title').text($('#meta_title').val());
        }else if($('#input-title').val() != ""){
            $("#google_separator").show();
            $('#google_title').text($('#input-title').val());
        }else{
            $("#google_separator").hide();
            $('#google_title').text('');
        }


        if($('#meta_description').val() != ""){
            $('#google_description').text($('#meta_description').val());
        }else if($('#input-excerpt').val() != ""){
            $('#google_description').text($('#input-excerpt').val());
        }else{
            $('#google_description').text('');
        }

        $('#meta_title').on('input', function () {
            var meta_title = $('#meta_title').val();
            if(meta_title != ""){
                $('#google_title').text(meta_title);
                $("#google_separator").show();
            }else if($('#input-title').val() != ""){
                $('#google_title').text($('#input-title').val());
                $("#google_separator").show();
            }else{
                $('#google_title').text("");
                $("#google_separator").hide();
            }
        });

        $('#meta_description').on('input', function () {
            var description = $('#meta_description').val();
            if(description != ""){
                $('#google_description').text(description);
            }else{
                $('#google_description').text($('#input-excerpt').val());
            }
        });


        var length = $('#meta_description').val().length;
            var reminder = 156 - length;

            if(reminder > 0){
                $("#metadesc-length span").removeClass("wrong");
                $("#metadesc-length span").addClass("good");
            }else{
                $("#metadesc-length span").removeClass("good");
                $("#metadesc-length span").addClass("wrong");
            }
            $("#metadesc-length span").text(reminder);

         $('#meta_description').on('input', function () {
            var length = $('#meta_description').val().length;
            var reminder = 156 - length;

            if(reminder > 0){
                $("#metadesc-length span").removeClass("wrong");
                $("#metadesc-length span").addClass("good");
            }else{
                $("#metadesc-length span").removeClass("good");
                $("#metadesc-length span").addClass("wrong");
            }
            $("#metadesc-length span").text(reminder);
        });

        $('#input-title').on('input', function () {

            if($('#meta_title').val() == ""){
                var title = $('#input-title').val();
                if(title != ""){
                    $('#google_title').text(title);
                }else{
                    $('#google_title').text($('#input-title').val());
                }
            }

            if($('#google_title').text() != ""){
                $("#google_separator").show();
            }else{
                $("#google_separator").hide();
            }

        });

        $('#input-excerpt').on('input', function () {

            if($('#meta_description').val() == ""){
                var meta_description = $('#input-excerpt').val();
                if(meta_description != ""){
                    $('#google_description').text(meta_description);
                }else{
                    $('#google_description').text("<?php if($post){ echo Str::words(strip_tags(string_sanitize($post->excerpt)), 15); } ?>");
                }
            }
        });



        $("#metakeywords").tagit({
            singleField: true,
            singleFieldNode: $('#meta_keywords'),
            allowSpaces: true,
            minLength: 2,
            placeholderText: "{!!Lang::get('posts::posts.meta_keywords')!!}",
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
            placeholderText: "{!!Lang::get('posts::posts.focus_keyword')!!}",
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
            $("#remove_fb_image").hide();
            $("#set-facebook-image").css('display', 'block');
            $("#facebook_image").attr("src", '');
        });
        $("#set-facebook-image").filemanager({
            types: "image",
            done: function (files) {
                if (files.length) {
                    var file = files[0];
                    $("#facebook_image").show();
                    $("#set-facebook-image").hide();
                    $("#remove-facebook-image").css('display', 'block');
                    $("#remove_fb_image").show();
                    $("#facebook_photo").val(file.media_id);
                    $("#facebook_image").attr("src", file.media_url);
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
            done: function (files) {
                if (files.length) {
                    var file = files[0];
                    console.log(file);
                    $("#twitter_image").show();
                    $("#set-twitter-image").hide();
                    $("#remove-twitter-image").css('display', 'block');
                    $("#remove_tw_image").show();
                    $("#twitter_photo").val(file.media_id);
                    $("#twitter_image").attr("src", file.media_url);
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
                //$('#robots_index').val("{!!@$post->meta->robots_index!!}");
                $('input[name="meta[robots_follow]"][value="{!!@$post->meta->robots_follow!!}"]').prop('checked', 'checked');
        //$('#in_sitemap').val("{!!@$post->meta->in_sitemap!!}");
        $('#sitemap_priority').val("{!!round(@$post->meta->sitemap_priority, 2)!!}");
                @endif
    });

    $(window).load(function () {
        $('#robots_advanced_chosen').css('width', 'inherit');
        $('#robots_advanced_chosen input').css('width', 'inherit');
        $('#metafocus li.tagit-new').css("cssText", "width: inherit !important;");
        $('#metakeywords li.tagit-new').css("cssText", "width: inherit !important;");
    });
</script>
@stop
