<?php

function get_post_url($post = NULL)
{

    if ($post->id == NULL) {
        return "";
    }

    $preview_url = Config::get("seo.preview");
    $preview_url = str_replace("[id]", $post->id, $preview_url);
    $preview_url = str_replace("[slug]", $post->slug, $preview_url);
    $preview_url = str_replace("[site]", $post->site, $preview_url);

    return $preview_url;

}
