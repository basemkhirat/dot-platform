<?php


/*
 * Validate unique tag
 */

Validator::extend('tag_unique', function ($field, $value, $parameters) {

    if (count($parameters) == 0) {
        return false;
    }

    $query = Tag::where($parameters[0], $value);

    if (count($parameters) == 3) {
        $query->where($parameters[2], "!=", (int)$parameters[1]);
    }

    $tag = $query->first();

    if (count($tag)) {

        // Tag exists
        $tag_id = $tag->id;
        $tag_visible = $tag->visible;
        $tag_deleted = $tag->deleted;

        if ($tag_visible == 0 or $tag_deleted == 1) {
            DB::connection("mongodb")->collection("tags")->where("id", (int)$tag_id)->delete();
            return true;
        }

    } else {
        return true;
    }

    return false;


});

/*
 * Validate min characers
 */

Validator::extend('tag_min', function ($field, $value, $parameters) {

    if (count($parameters)) {

        if (mb_strlen(trim($value)) < (int)$parameters[0]) {
            return false;
        }

        return true;

    }

});


/*
 * Validate max characers
 */

Validator::extend('tag_max', function ($field, $value, $parameters) {

    if (count($parameters)) {

        if (mb_strlen(trim($value)) >= (int)$parameters[0]) {
            return false;
        }

        return true;

    }

});


Validator::extend('tag_clean', function ($field, $value, $parameters) {


    return (bool) preg_match( "/^[أ-يA-Za-z0-9ءآ\s]+$/ui", $value );
    //return (bool) preg_match( "/^[أ-يA-Za-z0-9\s]+$/ui", $value );

    /*
    $special_chars = [
        "*", "~", "+", ";", "Ø›", ".", ",", "ØŒ", "(", ")", "'", '"', "!", "%", "?", "؟", "@", "Â»", "Â«", "/", "_", ";", "-", ":", "»", "«", "#", "&", "$", "^"
    ];

    foreach ($special_chars as $char) {
        if (strstr($value, $char)) {
            return false;
        }
    }

    return true;
    */
});




function remove_stop_words($string = "")
{

    $string = str_replace("ى", "ي", $string);
    $string = str_replace("ة", "ه", $string);
    $string = str_replace(array("أ", "إ", "آ"), "ا", $string);
    $string = str_replace(array(".", ",", "،", "(", ")", "'", '"', "!", "?", "@", "»", "«", "/"), " ", $string);
    $string = str_replace(array("*", "~", "+", ";", "Ø›", ".", ",", "ØŒ", "(", ")", "'", '"', "!", "?", "@", "Â»", "Â«", "/", "_", ";", "-", ":"), " ", $string);
    return $string;
}

function normalize($string = "")
{
    $string = strip_tags($string);
    $string = preg_replace("/&[a-z0-9]+;/i", "", $string);
    $arabic = new I18N_Arabic('Normalise');
    $string = $arabic->unshape($string);
    $string = $arabic->stripTashkeel($string);
    $string = $arabic->stripTatweel($string);
    $string = $arabic->normaliseLamaleph($string);
    $string = remove_stop_words($string);
    $string = strtolower($string);
    return $string;
}


Navigation::menu("sidebar", function($menu) {
    $menu->item('tags', trans("tags::tags.tags"), URL::to(ADMIN . '/tags'))->icon("fa-tags")->order(3);
});


function str_lang($name)
{
    if (preg_match('/[A-Za-z]+/', $name)) {
        $lang = "en";
    } else {
        $lang = "ar";
    }

    return $lang;
}


include __DIR__ . "/routes.php";
