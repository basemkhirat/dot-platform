<?php

use Sunra\PhpSimple\HtmlDomParser;
use DaveChild\TextStatistics as TS;

class Analysis {

    public $post;
    public $score;
    public $type;

    //=========================================================
    // CONSTRUCTOR
    //=========================================================
    final public function __construct() {

    }

    /**
     * update score.
     *
     */
    public function update_score($score = 0) {
        //$meta = PostMeta::find(@$this->post->meta->id);
        if ($this->post->meta) {
            $this->score = $this->absint($score);
            $this->post->seo()->update(['score' => $this->score]);
        } else {
            $this->score = $this->absint($score);
        }
    }

    /**
     * Outputs the page analysis score in the Publish Box.
     *
     */
    public function publish_box() {

        if (@$this->post->seo->robots_index == 1) {
            $score_label = 'noindex';
            $title = Lang::get('seo::seo.post_noindex');
            $score_title = $title;
        } else {

            $score = $this->score;

            if (!$score) {
                $score_label = 'na';
                $title = Lang::get('seo::seo.post_nokw');
            } else {
                $score_label = self::translate_score($score);
            }

            $score_title = self::translate_score($score, false);
            if (!isset($title)) {
                $title = $score_title;
            }
        }

        $output = '<div class="form-group misc-pub-section misc-yoast misc-pub-section-last">
                    <div style="margin-left:0; margin-right:0; cursor:pointer" title="' . $title . '" class="wpseo-score-icon ' . $score_label . '"></div>&nbsp;&nbsp;
                    ' . trans("seo::seo.seo") . ': &nbsp;&nbsp;<span class="wpseo-score-title label label-pa-purple">' . $score_title . '</span>
                </div>';

        return $output;
    }

    /**
     * Translates a decimal analysis score into a textual one.
     *
     * @static
     *
     * @param int  $val       The decimal score to translate.
     * @param bool $css_value Whether to return the i18n translated score or the CSS class value.
     *
     * @return string
     */
    public static function translate_score($val, $css_value = true) {
        if ($val > 10) {
            $val = round($val / 10);
        }
        switch ($val) {
            case 0:
                $score = Lang::get('seo::seo.n-a');
                $css = 'na';
                break;
            case 4:
            case 5:
                $score = Lang::get('seo::seo.s_poor');
                $css = 'poor';
                break;
            case 6:
            case 7:
                $score = Lang::get('seo::seo.s_ok');
                $css = 'ok';
                break;
            case 8:
            case 9:
            case 10:
                $score = Lang::get('seo::seo.s_good');
                $css = 'good';
                break;
            default:
                $score = Lang::get('seo::seo.s_bad');
                $css = 'bad';
                break;
        }

        if ($css_value) {
            return $css;
        } else {
            return $score;
        }
    }

    /**
     * Output the page analysis results.
     *
     * @param object $post Post to output the page analysis results for.
     *
     * @return string
     */
    public function linkdex_output($post, $type = 1) {

        $this->post = $post;
        $this->type = $type;

        $results = $this->calculate_results($post);

        if (!is_array($results)) {
            return '<table class="form-table"><tr><td><div class="wpseo_msg"><p><strong>' . $results . '</strong></p></div></td></tr></table>';
        }
        $output = '';

        if (is_array($results) && $results !== array()) {

            $output = '<table class="wpseoanalysis">';
            $perc_score = $this->absint($results['total']);
            unset($results['total']); // unset to prevent echoing it.

            foreach ($results as $result) {
                if (is_array($result)) {
                    $score = self::translate_score($result['val']);
                    $output .= '<tr><td class="score"><div class="wpseo-score-icon ' . $score . '"></div></td><td>' . $result['msg'] . '</td></tr>';
                }
            }
            unset($result, $score);
            $output .= '</table>';

            //if (WP_DEBUG === true || ( defined('WPSEO_DEBUG') && WPSEO_DEBUG === true )) {
            $output .= '<p style="margin-top: 15px;margin-bottom: 0;"><span class="wpseo-score-title label label-pa-purple">' . $perc_score . ' %</span></p>';
            //}
        }

        $output = '<div class="alert alert-warning">' . Lang::get('seo::seo.page_analysis_info') . '</div>' . $output;

        unset($results);

        return $output;
    }

    /**
     * Calculate the page analysis results for post.
     *
     * @todo [JRF => whomever] check whether the results of this method are always checked with is_wp_error()
     * @todo [JRF => whomever] check the usage of this method as it's quite intense/heavy, see if it's only
     * used when really necessary
     * @todo [JRF => whomever] see if we can get rid of the passing by reference of $results as it makes
     * the code obfuscated
     *
     * @param  object $post Post to calculate the results for.
     *
     * @return  array|WP_Error
     */
    public function calculate_results($post) {

        if (!count($this->post['attributes'])) {
            return Lang::get('seo::seo.no_post');
        }

        $focuskw = @$this->post->seo->focus_keyword;
        $content = ($this->type == 1) ? $this->post->content : $this->post->content;
        $slug = ($this->type == 1) ? $this->post->slug : $this->post->slug;
        $id = ($this->type == 1) ? $this->post->id : $this->post->id;
        $title = ($this->type == 1) ? $this->post->title : $this->post->title;
        $image_id = ($this->type == 1) ? $this->post->post_image_id : $this->post->image_id;

        $content = !is_null($content)? $content : " ";

        if ($focuskw == '') {
            // save score
            $this->update_score();
            return Lang::get('seo::seo.focuskw_no');
        }

        $results = array();
        $job = array();

        $job['pageUrl'] = URL::to("/details") . '/' . $slug;
        $job['pageSlug'] = $slug;
        $job['keyword'] = $focuskw;
        $job['keyword_folded'] = $this->strip_separators_and_fold($job['keyword']);
        $job['id'] = $id;
        unset($slug);

        // Check if the post content is not empty
        if (!empty($content)) {
            $dom = HtmlDomParser::str_get_html($content);
        }

        // Check if this focus keyword has been used already.
        $this->check_double_focus_keyword($job, $results);

        // Keyword
        $this->score_keyword($job['keyword'], $results);

        // Title
        if ($title !== '') {
            $job['title'] = $title;
        }
        unset($title);
        $this->score_title($job, $results);

        // Meta description
        $description = $this->post->meta_description;

        $this->score_description($job, $results, $description, 156);
        unset($description);

        // Body
        $body = $this->get_body($content);
        $firstp = $this->get_first_paragraph($body);
        $this->score_body($job, $results, $body, $firstp);

        unset($firstp);
        unset($content);

        // URL
        $this->score_url($job, $results);

        // Headings
        $headings = $this->get_headings($body);
        $this->score_headings($job, $results, $headings);
        unset($headings);

        // Images
        $imgs = array();
        $imgs['count'] = substr_count($body, '<img');
        $imgs = $this->get_images_alt_text($id, $body, $imgs);
        unset($id);

        // Check featured image
        if ($image_id) {
            $imgs['count'] += 1;

            if (empty($imgs['alts'])) {
                $imgs['alts'] = array();
            }

            $media = Media::find($image_id);
            if ($media) {
                $imgs['alts'][] = $media->title;
            }
        }
        $this->score_images_alt_text($job, $results, $imgs);
        unset($imgs);
        unset($body);
        unset($image_id);

        // Anchors
        $anchors = $this->get_anchor_texts($dom);
        $count = $this->get_anchor_count($dom);

        $this->score_anchor_texts($job, $results, $anchors, $count);
        unset($anchors, $count, $dom);

        $this->aasort($results, 'val');

        $overall = 0;
        $overall_max = 0;
        foreach ($results as $result) {
            $overall += $result['val'];
            $overall_max += 9;
        }
        unset($result);

        if ($overall < 1) {
            $overall = 1;
        }
        $score = self::calc(self::calc($overall, '/', $overall_max), '*', 100, true);

        // save score
        $this->update_score($score);

        $results['total'] = $score;

        return $results;
    }

    /**
     * Clean up the input string.
     *
     * @param string $inputString              String to clean up.
     * @param bool   $removeOptionalCharacters Whether or not to do a cleanup of optional chars too.
     *
     * @return string
     */
    public function strip_separators_and_fold($inputString, $removeOptionalCharacters = false) {
        $keywordCharactersAlwaysReplacedBySpace = array(',', "'", '"', '?', 'â€™', 'â€œ', 'â€?', '|', '/');
        $keywordCharactersRemovedOrReplaced = array('_', '-');
        $keywordWordsRemoved = array(' a ', ' in ', ' an ', ' on ', ' for ', ' the ', ' and ');

//        // Normalize the Alef.
//        $str = str_replace(array(
//            'أ', 'إ', 'آ'
//                ), 'ا', $str);
//        // Normalize the Diacritics.
//        $str = str_replace(array(
//            'َ', 'ً', 'ُ', 'ٌ', 'ِ', 'ٍ', 'ْ', 'ّ'
//                ), '', $str);
//        // Return the new string.
//        return $str;
        // lower
        $inputString = $this->strtolower_utf8($inputString);

        // default characters replaced by space
        $inputString = str_replace($keywordCharactersAlwaysReplacedBySpace, ' ', $inputString);

        // standardise whitespace
        $inputString = $this->standardize_whitespace($inputString);

        // deal with the separators that can be either removed or replaced by space
        if ($removeOptionalCharacters) {
            // remove word separators with a space
            $inputString = str_replace($keywordWordsRemoved, ' ', $inputString);

            $inputString = str_replace($keywordCharactersRemovedOrReplaced, '', $inputString);
        } else {
            $inputString = str_replace($keywordCharactersRemovedOrReplaced, ' ', $inputString);
        }

        // standardise whitespace again
        $inputString = $this->standardize_whitespace($inputString);

        return trim($inputString);
    }

    /**
     * Standardize whitespace in a string
     *
     * Replace line breaks, carriage returns, tabs with a space, then remove double spaces.
     *
     * @static
     *
     * @param string $string
     *
     * @return string
     */
    public static function standardize_whitespace($string) {
        return trim(str_replace('  ', ' ', str_replace(array("\t", "\n", "\r", "\f"), ' ', $string)));
    }

    /**
     * Check whether this focus keyword has been used for other posts before.
     *
     * @param array $job
     * @param array $results
     */
    public function check_double_focus_keyword($job, &$results) {

        $id = ($this->type == 1) ? 'id' : 'id';
        $post = ($this->type == 1) ? new Post : new Page;
        $prop = ($this->type == 1) ? '/posts?post_type=' . $this->post->post_type : '/pages';


        $posts = $post->where("$id", '!=', $job['id'])->whereHas('seo', function($q) use($job) {
                    $q->where('focus_keyword', $job['keyword']);
                })->count();

        if ($posts == 0) {
            $this->save_score_result($results, 9, Lang::get('seo::seo.keyword_overused_9'), 'keyword_overused');
        } elseif ($posts == 1) {
            $this->save_score_result($results, 6, trans('seo::seo.keyword_overused_6', ['opentag' => '<a href="' . URL::to(ADMIN . $prop . '&kw_filter=' . $job['keyword']) . '" target="_blank">', 'endtag' => '</a>']), 'keyword_overused');
        } else {
            $this->save_score_result($results, 1, trans('seo::seo.keyword_overused_1', ['opentag' => '<a href="' . URL::to(ADMIN . $prop . '&kw_filter=' . $job['keyword']) . '" target="_blank">', 'endtag' => '</a>', 'times' => $posts, 'url' => '<a href="https://yoast.com/cornerstone-content-rank/">']), 'keyword_overused');
        }
    }

    /**
     * Check whether the keyword contains stopwords.
     *
     * @param string $keyword The keyword to check for stopwords.
     * @param array  $results The results array.
     */
    public function score_keyword($keyword, &$results) {
        if ($this->stopwords_check($keyword) !== false) {
            $this->save_score_result($results, 5, trans('seo::seo.keyword_stopwords_5', ['opentag' => '<a href="http://en.wikipedia.org/wiki/Stop_words" target="_blank">', 'endtag' => '</a>', 'stopKY' => $this->stopwords_check($keyword)]), 'keyword_stopwords');
        }
    }

    /**
     * Check whether the stopword appears in the string
     *
     * @param string $haystack    The string to be checked for the stopword
     * @param bool   $checkingUrl Whether or not we're checking a URL
     *
     * @return bool|mixed
     */
    public function stopwords_check($haystack, $checkingUrl = false) {
        if (app()->getLocale() == 'en')
            $stopWords = array("a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "amoungst", "amount", "an", "and", "another", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "are", "around", "as", "at", "back", "be", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom", "but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "eight", "either", "eleven", "else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own", "part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the");
        else
            $stopWords = array('في', 'كل', 'لم', 'لن', 'له', 'من', 'هو', 'هي', 'قوة', 'كما', 'لها', 'منذ', 'وقد', 'ولا', 'لقاء', 'مقابل', 'هناك', 'وقال', 'وكان', 'وقالت', 'وكانت', 'فيه', 'لكن', 'وفي', 'ولم', 'ومن', 'وهو', 'وهي', 'يوم', 'فيها', 'منها', 'يكون', 'يمكن 	حيث', 'االا', 'اما', 'االتى', 'التي', 'اكثر', 'ايضا', 'الذى', 'الذي', 'الان', 'الذين', 'ابين', 'ذلك', 'دون', 'حول', 'حين', 'الى', 'انه', 'اول', 'انها', 'ف', 'و', 'و6', 'قد', 'لا', 'ما', 'مع', 'هذا', 'واحد', 'واضاف', 'واضافت', 'فان', 'قبل', 'قال', 'كان', 'لدى', 'نحو', 'هذه', 'وان', 'واكد', 'كانت', 'واوضح', 'ب', 'ا', 'أ', '،', 'عن', 'عند', 'عندما', 'على', 'عليه', 'عليها', 'تم', 'ضد', 'بعد', 'بعض', 'حتى', 'اذا', 'احد', 'بان', 'اجل', 'غير', 'بن', 'به', 'ثم', 'اف', 'ان', 'او', 'اي', 'بها');

        if (is_array($stopWords) && $stopWords !== array()) {
            foreach ($stopWords as $stopWord) {
                // If checking a URL remove the single quotes
                if ($checkingUrl) {
                    $stopWord = str_replace("'", '', $stopWord);
                }

                // Check whether the stopword appears as a whole word
                // @todo [JRF => whomever] check whether the use of \b (=word boundary) would be more efficient ;-)
                $res = preg_match("`(^|[ \n\r\t\.,'\(\)\"\+;!?:])" . preg_quote($stopWord, '`') . "($|[ \n\r\t\.,'\(\)\"\+;!?:])`iu", $haystack);
                if ($res > 0) {
                    return $stopWord;
                }
            }
        }

        return false;
    }

    /**
     * Check whether the keyword is contained in the title.
     *
     * @param array $job     The job array holding both the keyword versions.
     * @param array $results The results array.
     */
    public function score_title($job, &$results) {
        $scoreTitleMinLength = 40;
        $scoreTitleMaxLength = 70;
        $scoreTitleKeywordLimit = 0;

        if ($job['title'] == '') {
            $this->save_score_result($results, 1, Lang::get('seo::seo.title_1'), 'title');
        } else {
            $job['title'] = $this->wp_strip_all_tags($job['title']);

            $length = TS\Text::textLength($job['title']);
            if ($length < $scoreTitleMinLength) {
                $this->save_score_result($results, 6, trans('seo::seo.title_length_6', ['length' => $length]), 'title_length');
            } elseif ($length > $scoreTitleMaxLength) {
                $this->save_score_result($results, 6, trans('seo::seo.title_length_6_6', ['length' => $length]), 'title_length');
            } else {
                $this->save_score_result($results, 9, Lang::get('seo::seo.title_length_9'), 'title_length');
            }

            // @todo MA Keyword/Title matching is exact match with separators removed, but should extend to distributed match
            $needle_position = stripos($job['title'], $job['keyword_folded']);

            if ($needle_position === false) {
                $needle_position = stripos($job['title'], $job['keyword']);
            }

            if ($needle_position === false) {
                $this->save_score_result($results, 2, trans('seo::seo.title_keyword_2', ['KY' => $job['keyword_folded']]), 'title_keyword');
            } elseif ($needle_position <= $scoreTitleKeywordLimit) {
                $this->save_score_result($results, 9, Lang::get('seo::seo.title_keyword_9'), 'title_keyword');
            } else {
                $this->save_score_result($results, 6, Lang::get('seo::seo.title_keyword_6'), 'title_keyword');
            }
        }
    }

    /**
     * Score the meta description for length and keyword appearance.
     *
     * @param array  $job         The array holding the keywords.
     * @param array  $results     The results array.
     * @param string $description The meta description.
     * @param int    $maxlength   The maximum length of the meta description.
     */
    public function score_description($job, &$results, $description, $maxlength = 155) {
        $scoreDescriptionMinLength = 120;
        $metaShorter = '';
        if ($maxlength != 155) {
            $metaShorter = Lang::get('seo::seo.meta_shorter');
        }

        if ($description == '') {
            $this->save_score_result($results, 1, Lang::get('seo::seo.description_length_1'), 'description_length');
        } else {
            $length = TS\Text::textLength($description);

            if ($length < $scoreDescriptionMinLength) {
                $this->save_score_result($results, 6, trans('seo::seo.description_length_6', ['max' => $maxlength, 'meta' => $metaShorter]), 'description_length');
            } elseif ($length <= $maxlength) {
                $this->save_score_result($results, 9, Lang::get('seo::seo.description_length_9'), 'description_length');
            } else {
                $this->save_score_result($results, 6, trans('seo::seo.description_length_6_6', ['max' => $maxlength, 'meta' => $metaShorter]), 'description_length');
            }

            // @todo MA Keyword/Title matching is exact match with separators removed, but should extend to distributed match
            $haystack1 = $this->strip_separators_and_fold($description, true);
            $haystack2 = $this->strip_separators_and_fold($description, false);
            if (strrpos($haystack1, $job['keyword_folded']) === false && strrpos($haystack2, $job['keyword_folded']) === false) {
                $this->save_score_result($results, 3, Lang::get('seo::seo.description_keyword_3'), 'description_keyword');
            } else {
                $this->save_score_result($results, 9, Lang::get('seo::seo.description_keyword_9'), 'description_keyword');
            }
        }
    }

    /**
     * Score the body for length and keyword appearance.
     *
     * @param array  $job     The array holding the keywords.
     * @param array  $results The results array.
     * @param string $body    The body.
     * @param string $firstp  The first paragraph.
     */
    public function score_body($job, &$results, $body, $firstp) {
        $lengthScore = array(
            'good' => 300,
            'ok' => 250,
            'poor' => 200,
            'bad' => 100,
        );

        $fleschurl = trans('seo::seo.flesch_url');

        // Replace images with their alt tags, then strip all tags
        $body = preg_replace('`<img(?:[^>]+)?alt="([^"]+)"(?:[^>]+)>`', '$1', $body);
        $body = strip_tags($body);

        // Copy length check
        $wordCount = TS\Text::wordCount($body);

        if ($wordCount < $lengthScore['bad']) {
            $this->save_score_result($results, - 20, trans('seo::seo.body_length_20', ['count' => $wordCount, 'score' => $lengthScore['good']]), 'body_length', $wordCount);
        } elseif ($wordCount < $lengthScore['poor']) {
            $this->save_score_result($results, - 10, trans('seo::seo.body_length_5', ['count' => $wordCount, 'score' => $lengthScore['good']]), 'body_length', $wordCount);
        } elseif ($wordCount < $lengthScore['ok']) {
            $this->save_score_result($results, 5, trans('seo::seo.body_length_5', ['count' => $wordCount, 'score' => $lengthScore['good']]), 'body_length', $wordCount);
        } elseif ($wordCount < $lengthScore['good']) {
            $this->save_score_result($results, 7, trans('seo::seo.body_length_7', ['count' => $wordCount, 'score' => $lengthScore['good']]), 'body_length', $wordCount);
        } else {
            $this->save_score_result($results, 9, trans('seo::seo.body_length_9', ['count' => $wordCount, 'score' => $lengthScore['good']]), 'body_length', $wordCount);
        }

        $body = $this->strtolower_utf8($body);
        $job['keyword'] = $this->strtolower_utf8($job['keyword']);

        $keywordWordCount = TS\Text::wordCount($job['keyword']);

        if ($keywordWordCount > 10) {
            $this->save_score_result($results, 0, trans('seo::seo.focus_keyword_length_0'), 'focus_keyword_length');
        } else {
            // Keyword Density check
            $keywordDensity = 0;
            if ($wordCount > 100) {
                $keywordCount = preg_match_all('`\b' . preg_quote($job['keyword'], '`') . '\b`miu', $body, $matches);
                if (( $keywordCount > 0 && $keywordWordCount > 0 ) && $wordCount > $keywordCount) {
                    $keywordDensity = self::calc(self::calc($keywordCount, '/', self::calc($wordCount, '-', ( self::calc(self::calc($keywordWordCount, '-', 1), '*', $keywordCount)))), '*', 100, true, 2);
                }
                if ($keywordDensity < 1) {
                    $this->save_score_result($results, 4, trans('seo::seo.keyword_density_4', ['density' => $keywordDensity, 'count' => $keywordCount]), 'keyword_density');
                } elseif ($keywordDensity > 4.5) {
                    $this->save_score_result($results, - 50, trans('seo::seo.keyword_density_50', ['density' => $keywordDensity, 'count' => $keywordCount]), 'keyword_density');
                } else {
                    $this->save_score_result($results, 9, trans('seo::seo.keyword_density_9', ['density' => $keywordDensity, 'count' => $keywordCount]), 'keyword_density');
                }
            }
        }

        $firstp = $this->strtolower_utf8($firstp);

        // First Paragraph Test
        // check without /u modifier as well as /u might break with non UTF-8 chars.
        if (preg_match('`\b' . preg_quote($job['keyword'], '`') . '\b`miu', $firstp) || preg_match('`\b' . preg_quote($job['keyword'], '`') . '\b`mi', $firstp) || preg_match('`\b' . preg_quote($job['keyword_folded'], '`') . '\b`miu', $firstp)
        ) {
            $this->save_score_result($results, 9, trans('seo::seo.keyword_first_paragraph_9'), 'keyword_first_paragraph');
        } else {
            $this->save_score_result($results, 3, trans('seo::seo.keyword_first_paragraph_3'), 'keyword_first_paragraph');
        }

        //$lang = get_bloginfo('language');
        if (/* substr($lang, 0, 2) == 'en' && */ $wordCount > 100) {
            // Flesch Reading Ease check
            $textStatistics = new TS\TextStatistics;
            $flesch = $textStatistics->fleschKincaidReadingEase($body);

            $note = '';
            $level = '';
            $score = 1;
            if ($flesch >= 90) {
                $level = trans('seo::seo.level_9');
                $score = 9;
            } elseif ($flesch >= 80) {
                $level = trans('seo::seo.level_8');
                $score = 9;
            } elseif ($flesch >= 70) {
                $level = trans('seo::seo.level_7');
                $score = 8;
            } elseif ($flesch >= 60) {
                $level = trans('seo::seo.level_6');
                $score = 7;
            } elseif ($flesch >= 50) {
                $level = trans('seo::seo.level_5');
                $note = trans('seo::seo.note_5');
                $score = 6;
            } elseif ($flesch >= 30) {
                $level = trans('seo::seo.level_3');
                $note = trans('seo::seo.note_3');
                $score = 5;
            } elseif ($flesch >= 0) {
                $level = trans('seo::seo.level_0');
                $note = trans('seo::seo.note_3');
                $score = 4;
            }
            $this->save_score_result($results, $score, trans('seo::seo.flesch_kincaid', ['flesch' => $flesch, 'url' => $fleschurl, 'level' => $level, 'note' => $note]), 'flesch_kincaid');
        }
    }

    /**
     * Check whether the keyword is contained in the URL.
     *
     * @param array $job     The job array holding both the keyword and the URLs.
     * @param array $results The results array.
     */
    public function score_url($job, &$results) {

        $needle = $this->strip_separators_and_fold($this->remove_accents($job['keyword']));
        $haystack1 = $this->strip_separators_and_fold($job['pageUrl'], true);
        $haystack2 = $this->strip_separators_and_fold($job['pageUrl'], false);

        if (stripos($haystack1, $needle) || stripos($haystack2, $needle)) {
            $this->save_score_result($results, 9, trans('seo::seo.url_keyword_9'), 'url_keyword');
        } else {
            $this->save_score_result($results, 6, trans('seo::seo.url_keyword_6'), 'url_keyword');
        }

        // Check for Stop Words in the slug
        if ($this->stopwords_check($job['pageSlug'], true) !== false) {
            $this->save_score_result($results, 5, trans('seo::seo.url_stopword_5'), 'url_stopword');
        }

        // Check if the slug isn't too long relative to the length of the keyword
        if (( TS\Text::textLength($job['keyword']) + 20 ) < TS\Text::textLength($job['pageSlug']) && 40 < TS\Text::textLength($job['pageSlug'])) {
            $this->save_score_result($results, 5, trans('seo::seo.url_length_5'), 'url_length');
        }
    }

    /**
     * Score the headings for keyword appearance.
     *
     * @param array $job      The array holding the keywords.
     * @param array $results  The results array.
     * @param array $headings The headings found in the document.
     */
    public function score_headings($job, &$results, $headings) {

        $headingCount = count($headings);
        if ($headingCount == 0) {
            $this->save_score_result($results, 7, trans('seo::seo.headings_7'), 'headings');
        } else {
            $found = 0;
            foreach ($headings as $heading) {
                $haystack1 = $this->strip_separators_and_fold($heading, true);
                $haystack2 = $this->strip_separators_and_fold($heading, false);

                if (strrpos($haystack1, $job['keyword_folded']) !== false) {
                    $found ++;
                } elseif (strrpos($haystack2, $job['keyword_folded']) !== false) {
                    $found ++;
                }
            }
            unset($heading, $haystack1, $haystack2);

            if ($found) {
                $this->save_score_result($results, 9, trans('seo::seo.headings_9', ['found' => $found, 'count' => $headingCount]), 'headings');
            } else {
                $this->save_score_result($results, 3, trans('seo::seo.headings_3'), 'headings');
            }
        }
    }

    /**
     * Check whether the images alt texts contain the keyword.
     *
     * @param array $job     The job array holding both the keyword versions.
     * @param array $results The results array.
     * @param array $imgs    The array with images alt texts.
     */
    public function score_images_alt_text($job, &$results, $imgs) {

        if ($imgs['count'] == 0) {
            $this->save_score_result($results, 3, trans('seo::seo.images_alt_3'), 'images_alt');
        } elseif (count($imgs['alts']) == 0 && $imgs['count'] != 0) {
            $this->save_score_result($results, 5, trans('seo::seo.images_alt_5'), 'images_alt');
        } else {
            $found = false;
            foreach ($imgs['alts'] as $alt) {
                $haystack1 = $this->strip_separators_and_fold($alt, true);
                $haystack2 = $this->strip_separators_and_fold($alt, false);
                if (strrpos($haystack1, $job['keyword_folded']) !== false) {
                    $found = true;
                } elseif (strrpos($haystack2, $job['keyword_folded']) !== false) {
                    $found = true;
                }
            }
            unset($alt, $haystack1, $haystack2);

            if ($found) {
                $this->save_score_result($results, 9, trans('seo::seo.images_alt_9'), 'images_alt');
            } else {
                $this->save_score_result($results, 5, trans('seo::seo.images_alt_5_5'), 'images_alt');
            }
        }
    }

    /**
     * Check whether the document contains outbound links and whether it's anchor text matches the keyword.
     *
     * @param array $job          The job array holding both the keyword versions.
     * @param array $results      The results array.
     * @param array $anchor_texts The array holding all anchors in the document.
     * @param array $count        The number of anchors in the document, grouped by type.
     */
    public function score_anchor_texts($job, &$results, $anchor_texts, $count) {

        if ($count['external']['nofollow'] == 0 && $count['external']['dofollow'] == 0) {
            $this->save_score_result($results, 6, trans('seo::seo.links_6'), 'links');
        } else {
            $found = false;
            if (is_array($anchor_texts) && $anchor_texts !== array()) {
                foreach ($anchor_texts as $anchor_text) {
                    if ($this->strtolower_utf8($anchor_text) == $job['keyword_folded']) {
                        $found = true;
                    }
                }
                unset($anchor_text);
            }
            if ($found) {
                $this->save_score_result($results, 2, trans('seo::seo.links_focus_keyword_2'), 'links_focus_keyword');
            }

            if ($count['external']['nofollow'] == 0 && $count['external']['dofollow'] > 0) {
                $this->save_score_result($results, 9, trans('seo::seo.links_number_9', ['count' => $count['external']['dofollow']]), 'links_number');
            } elseif ($count['external']['nofollow'] > 0 && $count['external']['dofollow'] == 0) {
                $this->save_score_result($results, 7, trans('seo::seo.links_number_7', ['count' => $count['external']['nofollow']]), 'links_number');
            } else {
                $this->save_score_result($results, 8, trans('seo::seo.links_number_8', ['count1' => $count['external']['nofollow'], 'count2' => $count['external']['dofollow']]), 'links_number');
            }
        }
    }

    /**
     * Retrieve the anchor texts used in the current document.
     *
     * @param object $xpath An XPATH object of the current document.
     *
     * @return array
     */
    public function get_anchor_texts(&$dom) {

        $dom_objects = $dom->find('a');

        $anchor_texts = array();

        if (count($dom_objects)) {
            foreach ($dom_objects as $dom_object) {
                if ($dom_object->href) {
                    $href = $dom_object->href;
                    if (substr($href, 0, 4) == 'http') {
                        $anchor_texts['external'] = $dom_object->innertext;
                    }
                }
            }
        }

        return $anchor_texts;
    }

    /**
     * Count the number of anchors and group them by type.
     *
     * @param object $xpath An XPATH object of the current document.
     *
     * @return array
     */
    public function get_anchor_count(&$dom) {
        $dom_objects = $dom->find('a');

        $count = array(
            'total' => 0,
            'internal' => array('nofollow' => 0, 'dofollow' => 0),
            'external' => array('nofollow' => 0, 'dofollow' => 0),
            'other' => array('nofollow' => 0, 'dofollow' => 0),
        );

        if (count($dom_objects)) {
            foreach ($dom_objects as $dom_object) {
                $count['total'] ++;
                if ($dom_object->href) {
                    $href = $dom_object->href;
                    $wpurl = 'http://loacalhost/newdotuae/public';
                    if (self::is_url_relative($href) === true || substr($href, 0, strlen($wpurl)) === $wpurl) {
                        $type = 'internal';
                    } elseif (substr($href, 0, 4) == 'http') {
                        $type = 'external';
                    } else {
                        $type = 'other';
                    }

                    if ($dom_object->rel) {
                        $link_rel = $dom_object->rel;
                        if (stripos($link_rel, 'nofollow') !== false) {
                            $count[$type]['nofollow'] ++;
                        } else {
                            $count[$type]['dofollow'] ++;
                        }
                    } else {
                        $count[$type]['dofollow'] ++;
                    }
                }
            }
        }

        return $count;
    }

    /**
     * Lowercase a sentence while preserving "weird" characters.
     *
     * This should work with Greek, Russian, Polish & French amongst other languages...
     *
     * @param string $string String to lowercase
     *
     * @return string
     */
    public function strtolower_utf8($string) {

        // Prevent comparison between utf8 characters and html entities (Ã© vs &eacute;)
        $string = html_entity_decode($string);

        $convert_to = array(
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z',
            'Ã ',
            'Ã¡',
            'Ã¢',
            'Ã£',
            'Ã¤',
            'Ã¥',
            'Ã¦',
            'Ã§',
            'Ã¨',
            'Ã©',
            'Ãª',
            'Ã«',
            'Ã¬',
            'Ã­',
            'Ã®',
            'Ã¯',
            'Ã°',
            'Ã±',
            'Ã²',
            'Ã³',
            'Ã´',
            'Ãµ',
            'Ã¶',
            'Ã¸',
            'Ã¹',
            'Ãº',
            'Ã»',
            'Ã¼',
            'Ã½',
            'Ð°',
            'Ð±',
            'Ð²',
            'Ð³',
            'Ð´',
            'Ðµ',
            'Ñ‘',
            'Ð¶',
            'Ð·',
            'Ð¸',
            'Ð¹',
            'Ðº',
            'Ð»',
            'Ð¼',
            'Ð½',
            'Ð¾',
            'Ð¿',
            'Ñ€',
            'Ñ?',
            'Ñ‚',
            'Ñƒ',
            'Ñ„',
            'Ñ…',
            'Ñ†',
            'Ñ‡',
            'Ñˆ',
            'Ñ‰',
            'ÑŠ',
            'Ñ‹',
            'ÑŒ',
            'Ñ?',
            'ÑŽ',
            'Ñ?',
            'Ä…',
            'Ä‡',
            'Ä™',
            'Å‚',
            'Å„',
            'Ã³',
            'Å›',
            'Åº',
            'Å¼',
        );
        $convert_from = array(
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'Ã€',
            'Ã?',
            'Ã‚',
            'Ãƒ',
            'Ã„',
            'Ã…',
            'Ã†',
            'Ã‡',
            'Ãˆ',
            'Ã‰',
            'ÃŠ',
            'Ã‹',
            'ÃŒ',
            'Ã?',
            'ÃŽ',
            'Ã?',
            'Ã?',
            'Ã‘',
            'Ã’',
            'Ã“',
            'Ã”',
            'Ã•',
            'Ã–',
            'Ã˜',
            'Ã™',
            'Ãš',
            'Ã›',
            'Ãœ',
            'Ã?',
            'Ð?',
            'Ð‘',
            'Ð’',
            'Ð“',
            'Ð”',
            'Ð•',
            'Ð?',
            'Ð–',
            'Ð—',
            'Ð˜',
            'Ð™',
            'Ðš',
            'Ð›',
            'Ðœ',
            'Ð?',
            'Ðž',
            'ÐŸ',
            'Ð ',
            'Ð¡',
            'Ð¢',
            'Ð£',
            'Ð¤',
            'Ð¥',
            'Ð¦',
            'Ð§',
            'Ð¨',
            'Ð©',
            'Ðª',
            'Ðª',
            'Ð¬',
            'Ð­',
            'Ð®',
            'Ð¯',
            'Ä„',
            'Ä†',
            'Ä˜',
            'Å?',
            'Åƒ',
            'Ã“',
            'Åš',
            'Å¹',
            'Å»',
        );

        return str_replace($convert_from, $convert_to, $string);
    }

    /**
     * Retrieve the body from the post.
     *
     * @param object $post The post object.
     *
     * @return string The post content.
     */
    public function get_body($content) {
        // Strip shortcodes, for obvious reasons, if plugins think their content should be in the analysis, they should
        // hook into the above filter.
        $content = $this->trim_nbsp_from_string($this->strip_shortcode($content));

        if (trim($content) == '') {
            return '';
        }

        $htmdata3 = preg_replace('`<(?:\x20*script|script).*?(?:/>|/script>)`', '', $content);
        if ($htmdata3 == null) {
            $htmdata3 = $content;
        } else {
            unset($content);
        }

        $htmdata4 = preg_replace('`<!--.*?-->`', '', $htmdata3);
        if ($htmdata4 == null) {
            $htmdata4 = $htmdata3;
        } else {
            unset($htmdata3);
        }

        $htmdata5 = preg_replace('`<(?:\x20*style|style).*?(?:/>|/style>)`', '', $htmdata4);
        if ($htmdata5 == null) {
            $htmdata5 = $htmdata4;
        } else {
            unset($htmdata4);
        }

        return $htmdata5;
    }

    /**
     * Strip out the shortcodes with a filthy regex, because people don't properly register their shortcodes.
     *
     * @static
     *
     * @param string $text Input string that might contain shortcodes
     *
     * @return string $text string without shortcodes
     */
    public static function strip_shortcode($text) {
        return preg_replace('`\[[^\]]+\]`s', '', $text);
    }

    /**
     * Retrieve the first paragraph from the post.
     *
     * @param string $body The post content to retrieve the first paragraph from.
     *
     * @return string
     */
    public function get_first_paragraph($body) {
        // To determine the first paragraph we first need to autop the content, then match the first paragraph and return.
        if (preg_match('`<p[.]*?>(.*)</p>`s', $this->wpautop($body), $matches)) {
            return $matches[1];
        }

        return false;
    }

    /**
     * Replaces double line-breaks with paragraph elements.
     *
     * A group of regex replaces used to identify text formatted with newlines and
     * replace double line-breaks with HTML paragraph tags. The remaining line-breaks
     * after conversion become <<br />> tags, unless $br is set to '0' or 'false'.
     *
     * @since 0.71
     *
     * @param string $pee The text which has to be formatted.
     * @param bool   $br  Optional. If set, this will convert all remaining line-breaks
     *                    after paragraphing. Default true.
     * @return string Text which has been converted into correct paragraph tags.
     */
    public function wpautop($pee, $br = true) {
        $pre_tags = array();

        if (trim($pee) === '')
            return '';

        // Just to make things a little easier, pad the end.
        $pee = $pee . "\n";

        /*
         * Pre tags shouldn't be touched by autop.
         * Replace pre tags with placeholders and bring them back after autop.
         */
        if (strpos($pee, '<pre') !== false) {
            $pee_parts = explode('</pre>', $pee);
            $last_pee = array_pop($pee_parts);
            $pee = '';
            $i = 0;

            foreach ($pee_parts as $pee_part) {
                $start = strpos($pee_part, '<pre');

                // Malformed html?
                if ($start === false) {
                    $pee .= $pee_part;
                    continue;
                }

                $name = "<pre wp-pre-tag-$i></pre>";
                $pre_tags[$name] = substr($pee_part, $start) . '</pre>';

                $pee .= substr($pee_part, 0, $start) . $name;
                $i++;
            }

            $pee .= $last_pee;
        }
        // Change multiple <br>s into two line breaks, which will turn into paragraphs.
        $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);

        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

        // Add a single line break above block-level opening tags.
        $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);

        // Add a double line break below block-level closing tags.
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

        // Standardize newline characters to "\n".
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee);

        // Strip newlines from all elements.
        $pee = $this->wp_replace_in_html_tags($pee, array("\n" => " "));

        // Collapse line breaks before and after <option> elements so they don't get autop'd.
        if (strpos($pee, '<option') !== false) {
            $pee = preg_replace('|\s*<option|', '<option', $pee);
            $pee = preg_replace('|</option>\s*|', '</option>', $pee);
        }

        /*
         * Collapse line breaks inside <object> elements, before <param> and <embed> elements
         * so they don't get autop'd.
         */
        if (strpos($pee, '</object>') !== false) {
            $pee = preg_replace('|(<object[^>]*>)\s*|', '$1', $pee);
            $pee = preg_replace('|\s*</object>|', '</object>', $pee);
            $pee = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee);
        }

        /*
         * Collapse line breaks inside <audio> and <video> elements,
         * before and after <source> and <track> elements.
         */
        if (strpos($pee, '<source') !== false || strpos($pee, '<track') !== false) {
            $pee = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee);
            $pee = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee);
            $pee = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee);
        }

        // Remove more than two contiguous line breaks.
        $pee = preg_replace("/\n\n+/", "\n\n", $pee);

        // Split up the contents into an array of strings, separated by double line breaks.
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

        // Reset $pee prior to rebuilding.
        $pee = '';

        // Rebuild the content as a string, wrapping every bit with a <p>.
        foreach ($pees as $tinkle) {
            $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
        }

        // Under certain strange conditions it could create a P of entirely whitespace.
        $pee = preg_replace('|<p>\s*</p>|', '', $pee);

        // Add a closing <p> inside <div>, <address>, or <form> tag if missing.
        $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);

        // If an opening or closing block element tag is wrapped in a <p>, unwrap it.
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

        // In some cases <li> may get wrapped in <p>, fix them.
        $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);

        // If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
        $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
        $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);

        // If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);

        // If an opening or closing block element tag is followed by a closing <p> tag, remove it.
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

        // Optionally insert line breaks.
        if ($br) {
//            // Replace newlines that shouldn't be touched with a placeholder.
//            $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', $this->_autop_newline_preservation_helper(), $pee);
            // Replace any new line characters that aren't preceded by a <br /> with a <br />.
            $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);

            // Replace newline placeholders with newlines.
            $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
        }

        // If a <br /> tag is after an opening or closing block tag, remove it.
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);

        // If a <br /> tag is before a subset of opening or closing block tags, remove it.
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        $pee = preg_replace("|\n</p>$|", '</p>', $pee);

        // Replace placeholder <pre> tags with their original content.
        if (!empty($pre_tags))
            $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

        return $pee;
    }

    /**
     * Newline preservation help function for wpautop
     *
     * @since 3.1.0
     * @access private
     *
     * @param array $matches preg_replace_callback matches array
     * @return string
     */
//    public function _autop_newline_preservation_helper($matches) {
//        return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
//    }

    /**
     * Replace characters or phrases within HTML elements only.
     *
     * @since 4.2.3
     *
     * @param string $haystack The text which has to be formatted.
     * @param array $replace_pairs In the form array('from' => 'to', ...).
     * @return string The formatted text.
     */
    public function wp_replace_in_html_tags($haystack, $replace_pairs) {
        // Find all elements.
        $comments = '!'           // Start of comment, after the <.
                . '(?:'         // Unroll the loop: Consume everything until --> is found.
                . '-(?!->)' // Dash not followed by end of comment.
                . '[^\-]*+' // Consume non-dashes.
                . ')*+'         // Loop possessively.
                . '(?:-->)?';   // End of comment. If not found, match all input.

        $regex = '/('              // Capture the entire match.
                . '<'           // Find start of element.
                . '(?(?=!--)'   // Is this a comment?
                . $comments // Find end of comment.
                . '|'
                . '[^>]*>?' // Find end of element. If not found, match all input.
                . ')'
                . ')/s';

        $textarr = preg_split($regex, $haystack, -1, PREG_SPLIT_DELIM_CAPTURE);
        $changed = false;

        // Optimize when searching for one item.
        if (1 === count($replace_pairs)) {
            // Extract $needle and $replace.
            foreach ($replace_pairs as $needle => $replace)
                ;

            // Loop through delimeters (elements) only.
            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                if (false !== strpos($textarr[$i], $needle)) {
                    $textarr[$i] = str_replace($needle, $replace, $textarr[$i]);
                    $changed = true;
                }
            }
        } else {
            // Extract all $needles.
            $needles = array_keys($replace_pairs);

            // Loop through delimeters (elements) only.
            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                foreach ($needles as $needle) {
                    if (false !== strpos($textarr[$i], $needle)) {
                        $textarr[$i] = strtr($textarr[$i], $replace_pairs);
                        $changed = true;
                        // After one strtr() break out of the foreach loop and look at next element.
                        break;
                    }
                }
            }
        }

        if ($changed) {
            $haystack = implode($textarr);
        }

        return $haystack;
    }

    /**
     * Trim whitespace and NBSP (Non-breaking space) from string
     *
     * @param string $string
     *
     * @return string
     */
    public static function trim_nbsp_from_string($string) {
        $find = array('&nbsp;', chr(0xC2) . chr(0xA0));
        $string = str_replace($find, ' ', $string);
        $string = trim($string);

        return $string;
    }

    /**
     * Save the score result to the results array.
     *
     * @param array  $results      The results array used to store results.
     * @param int    $scoreValue   The score value.
     * @param string $scoreMessage The score message.
     * @param string $scoreLabel   The label of the score to use in the results array.
     * @param string $rawScore     The raw score, to be used by other filters.
     */
    public function save_score_result(&$results, $scoreValue, $scoreMessage, $scoreLabel, $rawScore = null) {
        $score = array(
            'val' => $scoreValue,
            'msg' => $scoreMessage,
            'raw' => $rawScore,
        );
        $results[$scoreLabel] = $score;
    }

    /**
     * Properly strip all HTML tags including script and style
     *
     * This differs from strip_tags() because it removes the contents of
     * the `<script>` and `<style>` tags. E.g. `strip_tags( '<script>something</script>' )`
     * will return 'something'. wp_strip_all_tags will return ''
     *
     * @since 2.9.0
     *
     * @param string $string String containing HTML tags
     * @param bool $remove_breaks optional Whether to remove left over line breaks and white space chars
     * @return string The processed string.
     */
    public function wp_strip_all_tags($string, $remove_breaks = false) {
        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string);

        if ($remove_breaks)
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);

        return trim($string);
    }

    /**
     * Fetch all headings and return their content.
     *
     * @param string $postcontent Post content to find headings in.
     *
     * @return array Array of heading texts.
     */
    public function get_headings($postcontent) {
        $headings = array();

        preg_match_all('`<h([1-6])(?:[^>]+)?>(.*?)</h\\1>`si', $postcontent, $matches);

        if (isset($matches[2]) && is_array($matches[2]) && $matches[2] !== array()) {
            foreach ($matches[2] as $heading) {
                $headings[] = $this->strtolower_utf8($heading);
            }
        }

        return $headings;
    }

    /**
     * Check whether a url is relative
     *
     * @static
     *
     * @param string $url
     *
     * @return bool
     */
    public static function is_url_relative($url) {
        return ( strpos($url, 'http') !== 0 && strpos($url, '//') !== 0 );
    }

    /**
     * Retrieve the alt texts from the images.
     *
     * @param int    $id The post to find images in.
     * @param string $body    The post content to find images in.
     * @param array  $imgs    The array holding the image information.
     *
     * @return array The updated images array.
     */
    public function get_images_alt_text($id, $body, $imgs) {
        $imgs['alts'] = array();
        if (preg_match_all('`<img[^>]+>`im', $body, $matches)) {
            foreach ($matches[0] as $img) {
                if (preg_match('`alt=(["\'])(.*?)\1`', $img, $alt) && isset($alt[2])) {
                    $imgs['alts'][] = $this->strtolower_utf8($alt[2]);
                }
            }
            unset($img, $alt);
        }
        unset($matches);

//        if (strpos($body, '[gallery') !== false) {
//            $attachments = get_children(array(
//                'post_parent' => $id,
//                'post_status' => 'inherit',
//                'post_type' => 'attachment',
//                'post_mime_type' => 'image',
//                'fields' => 'ids',
//                    ));
//            if (is_array($attachments) && $attachments !== array()) {
//                foreach ($attachments as $att_id) {
//                    $alt = get_post_meta($att_id, '_wp_attachment_image_alt', true);
//                    if ($alt && !empty($alt)) {
//                        $imgs['alts'][] = $alt;
//                    }
//                    $imgs['count'] ++;
//                }
//            }
//        }

        return $imgs;
    }

    /**
     * Do simple reliable math calculations without the risk of wrong results
     * @see   http://floating-point-gui.de/
     * @see   the big red warning on http://php.net/language.types.float.php
     *
     * In the rare case that the bcmath extension would not be loaded, it will return the normal calculation results
     *
     * @static
     *
     * @since 1.5.0
     *
     * @param mixed  $number1   Scalar (string/int/float/bool)
     * @param string $action    Calculation action to execute. Valid input:
     *                            '+' or 'add' or 'addition',
     *                            '-' or 'sub' or 'subtract',
     *                            '*' or 'mul' or 'multiply',
     *                            '/' or 'div' or 'divide',
     *                            '%' or 'mod' or 'modulus'
     *                            '=' or 'comp' or 'compare'
     * @param mixed  $number2   Scalar (string/int/float/bool)
     * @param bool   $round     Whether or not to round the result. Defaults to false.
     *                          Will be disregarded for a compare operation
     * @param int    $decimals  Decimals for rounding operation. Defaults to 0.
     * @param int    $precision Calculation precision. Defaults to 10.
     *
     * @return mixed            Calculation Result or false if either or the numbers isn't scalar or
     *                          an invalid operation was passed
     *                          - for compare the result will always be an integer
     *                          - for all other operations, the result will either be an integer (preferred)
     *                            or a float
     */
    public static function calc($number1, $action, $number2, $round = false, $decimals = 0, $precision = 10) {
        static $bc;

        if (!is_scalar($number1) || !is_scalar($number2)) {
            return false;
        }

        if (!isset($bc)) {
            $bc = extension_loaded('bcmath');
        }

        if ($bc) {
            $number1 = number_format($number1, 10, '.', '');
            $number2 = number_format($number2, 10, '.', '');
        }

        $result = null;
        $compare = false;

        switch ($action) {
            case '+':
            case 'add':
            case 'addition':
                $result = ( $bc ) ? bcadd($number1, $number2, $precision) /* string */ : ( $number1 + $number2 );
                break;

            case '-':
            case 'sub':
            case 'subtract':
                $result = ( $bc ) ? bcsub($number1, $number2, $precision) /* string */ : ( $number1 - $number2 );
                break;

            case '*':
            case 'mul':
            case 'multiply':
                $result = ( $bc ) ? bcmul($number1, $number2, $precision) /* string */ : ( $number1 * $number2 );
                break;

            case '/':
            case 'div':
            case 'divide':
                if ($bc) {
                    $result = bcdiv($number1, $number2, $precision); // string, or NULL if right_operand is 0
                } elseif ($number2 != 0) {
                    $result = ( $number1 / $number2 );
                }

                if (!isset($result)) {
                    $result = 0;
                }
                break;

            case '%':
            case 'mod':
            case 'modulus':
                if ($bc) {
                    $result = bcmod($number1, $number2, $precision); // string, or NULL if modulus is 0.
                } elseif ($number2 != 0) {
                    $result = ( $number1 % $number2 );
                }

                if (!isset($result)) {
                    $result = 0;
                }
                break;

            case '=':
            case 'comp':
            case 'compare':
                $compare = true;
                if ($bc) {
                    $result = bccomp($number1, $number2, $precision); // returns int 0, 1 or -1
                } else {
                    $result = ( $number1 == $number2 ) ? 0 : ( ( $number1 > $number2 ) ? 1 : - 1 );
                }
                break;
        }

        if (isset($result)) {
            if ($compare === false) {
                if ($round === true) {
                    $result = round(floatval($result), $decimals);
                    if ($decimals === 0) {
                        $result = (int) $result;
                    }
                } else {
                    $result = ( intval($result) == $result ) ? intval($result) : floatval($result);
                }
            }

            return $result;
        }

        return false;
    }

    /**
     * Converts all accent characters to ASCII characters.
     *
     * If there are no accent characters, then the string given is just returned.
     *
     * @since 1.2.1
     *
     * @param string $string Text that might have accent characters
     * @return string Filtered string with replaced "nice" characters.
     */
    public function remove_accents($string) {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;

        if ($this->seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(194) . chr(170) => 'a', chr(194) . chr(186) => 'o',
                chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
                chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
                chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
                chr(195) . chr(134) => 'AE', chr(195) . chr(135) => 'C',
                chr(195) . chr(136) => 'E', chr(195) . chr(137) => 'E',
                chr(195) . chr(138) => 'E', chr(195) . chr(139) => 'E',
                chr(195) . chr(140) => 'I', chr(195) . chr(141) => 'I',
                chr(195) . chr(142) => 'I', chr(195) . chr(143) => 'I',
                chr(195) . chr(144) => 'D', chr(195) . chr(145) => 'N',
                chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
                chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
                chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
                chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
                chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
                chr(195) . chr(158) => 'TH', chr(195) . chr(159) => 's',
                chr(195) . chr(160) => 'a', chr(195) . chr(161) => 'a',
                chr(195) . chr(162) => 'a', chr(195) . chr(163) => 'a',
                chr(195) . chr(164) => 'a', chr(195) . chr(165) => 'a',
                chr(195) . chr(166) => 'ae', chr(195) . chr(167) => 'c',
                chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
                chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
                chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
                chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
                chr(195) . chr(176) => 'd', chr(195) . chr(177) => 'n',
                chr(195) . chr(178) => 'o', chr(195) . chr(179) => 'o',
                chr(195) . chr(180) => 'o', chr(195) . chr(181) => 'o',
                chr(195) . chr(182) => 'o', chr(195) . chr(184) => 'o',
                chr(195) . chr(185) => 'u', chr(195) . chr(186) => 'u',
                chr(195) . chr(187) => 'u', chr(195) . chr(188) => 'u',
                chr(195) . chr(189) => 'y', chr(195) . chr(190) => 'th',
                chr(195) . chr(191) => 'y', chr(195) . chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
                chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
                chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
                chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
                chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
                chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
                chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
                chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
                chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
                chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
                chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
                chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
                chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
                chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
                chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
                chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
                chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
                chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
                chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
                chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
                chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
                chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
                chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
                chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
                chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
                chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
                chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
                chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
                chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
                chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
                chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
                chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
                chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
                chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
                chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
                chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
                chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
                chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
                chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
                chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
                chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
                chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
                chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
                chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
                chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
                chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
                chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
                chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
                chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
                chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
                chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
                chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
                chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
                chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
                chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
                chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
                chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
                chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
                chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
                chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
                chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
                chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
                chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
                chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200) . chr(152) => 'S', chr(200) . chr(153) => 's',
                chr(200) . chr(154) => 'T', chr(200) . chr(155) => 't',
                // Euro Sign
                chr(226) . chr(130) . chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194) . chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198) . chr(160) => 'O', chr(198) . chr(161) => 'o',
                chr(198) . chr(175) => 'U', chr(198) . chr(176) => 'u',
                // grave accent
                chr(225) . chr(186) . chr(166) => 'A', chr(225) . chr(186) . chr(167) => 'a',
                chr(225) . chr(186) . chr(176) => 'A', chr(225) . chr(186) . chr(177) => 'a',
                chr(225) . chr(187) . chr(128) => 'E', chr(225) . chr(187) . chr(129) => 'e',
                chr(225) . chr(187) . chr(146) => 'O', chr(225) . chr(187) . chr(147) => 'o',
                chr(225) . chr(187) . chr(156) => 'O', chr(225) . chr(187) . chr(157) => 'o',
                chr(225) . chr(187) . chr(170) => 'U', chr(225) . chr(187) . chr(171) => 'u',
                chr(225) . chr(187) . chr(178) => 'Y', chr(225) . chr(187) . chr(179) => 'y',
                // hook
                chr(225) . chr(186) . chr(162) => 'A', chr(225) . chr(186) . chr(163) => 'a',
                chr(225) . chr(186) . chr(168) => 'A', chr(225) . chr(186) . chr(169) => 'a',
                chr(225) . chr(186) . chr(178) => 'A', chr(225) . chr(186) . chr(179) => 'a',
                chr(225) . chr(186) . chr(186) => 'E', chr(225) . chr(186) . chr(187) => 'e',
                chr(225) . chr(187) . chr(130) => 'E', chr(225) . chr(187) . chr(131) => 'e',
                chr(225) . chr(187) . chr(136) => 'I', chr(225) . chr(187) . chr(137) => 'i',
                chr(225) . chr(187) . chr(142) => 'O', chr(225) . chr(187) . chr(143) => 'o',
                chr(225) . chr(187) . chr(148) => 'O', chr(225) . chr(187) . chr(149) => 'o',
                chr(225) . chr(187) . chr(158) => 'O', chr(225) . chr(187) . chr(159) => 'o',
                chr(225) . chr(187) . chr(166) => 'U', chr(225) . chr(187) . chr(167) => 'u',
                chr(225) . chr(187) . chr(172) => 'U', chr(225) . chr(187) . chr(173) => 'u',
                chr(225) . chr(187) . chr(182) => 'Y', chr(225) . chr(187) . chr(183) => 'y',
                // tilde
                chr(225) . chr(186) . chr(170) => 'A', chr(225) . chr(186) . chr(171) => 'a',
                chr(225) . chr(186) . chr(180) => 'A', chr(225) . chr(186) . chr(181) => 'a',
                chr(225) . chr(186) . chr(188) => 'E', chr(225) . chr(186) . chr(189) => 'e',
                chr(225) . chr(187) . chr(132) => 'E', chr(225) . chr(187) . chr(133) => 'e',
                chr(225) . chr(187) . chr(150) => 'O', chr(225) . chr(187) . chr(151) => 'o',
                chr(225) . chr(187) . chr(160) => 'O', chr(225) . chr(187) . chr(161) => 'o',
                chr(225) . chr(187) . chr(174) => 'U', chr(225) . chr(187) . chr(175) => 'u',
                chr(225) . chr(187) . chr(184) => 'Y', chr(225) . chr(187) . chr(185) => 'y',
                // acute accent
                chr(225) . chr(186) . chr(164) => 'A', chr(225) . chr(186) . chr(165) => 'a',
                chr(225) . chr(186) . chr(174) => 'A', chr(225) . chr(186) . chr(175) => 'a',
                chr(225) . chr(186) . chr(190) => 'E', chr(225) . chr(186) . chr(191) => 'e',
                chr(225) . chr(187) . chr(144) => 'O', chr(225) . chr(187) . chr(145) => 'o',
                chr(225) . chr(187) . chr(154) => 'O', chr(225) . chr(187) . chr(155) => 'o',
                chr(225) . chr(187) . chr(168) => 'U', chr(225) . chr(187) . chr(169) => 'u',
                // dot below
                chr(225) . chr(186) . chr(160) => 'A', chr(225) . chr(186) . chr(161) => 'a',
                chr(225) . chr(186) . chr(172) => 'A', chr(225) . chr(186) . chr(173) => 'a',
                chr(225) . chr(186) . chr(182) => 'A', chr(225) . chr(186) . chr(183) => 'a',
                chr(225) . chr(186) . chr(184) => 'E', chr(225) . chr(186) . chr(185) => 'e',
                chr(225) . chr(187) . chr(134) => 'E', chr(225) . chr(187) . chr(135) => 'e',
                chr(225) . chr(187) . chr(138) => 'I', chr(225) . chr(187) . chr(139) => 'i',
                chr(225) . chr(187) . chr(140) => 'O', chr(225) . chr(187) . chr(141) => 'o',
                chr(225) . chr(187) . chr(152) => 'O', chr(225) . chr(187) . chr(153) => 'o',
                chr(225) . chr(187) . chr(162) => 'O', chr(225) . chr(187) . chr(163) => 'o',
                chr(225) . chr(187) . chr(164) => 'U', chr(225) . chr(187) . chr(165) => 'u',
                chr(225) . chr(187) . chr(176) => 'U', chr(225) . chr(187) . chr(177) => 'u',
                chr(225) . chr(187) . chr(180) => 'Y', chr(225) . chr(187) . chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201) . chr(145) => 'a',
                // macron
                chr(199) . chr(149) => 'U', chr(199) . chr(150) => 'u',
                // acute accent
                chr(199) . chr(151) => 'U', chr(199) . chr(152) => 'u',
                // caron
                chr(199) . chr(141) => 'A', chr(199) . chr(142) => 'a',
                chr(199) . chr(143) => 'I', chr(199) . chr(144) => 'i',
                chr(199) . chr(145) => 'O', chr(199) . chr(146) => 'o',
                chr(199) . chr(147) => 'U', chr(199) . chr(148) => 'u',
                chr(199) . chr(153) => 'U', chr(199) . chr(154) => 'u',
                // grave accent
                chr(199) . chr(155) => 'U', chr(199) . chr(156) => 'u',
            );

            // Used for locale-specific rules
            $locale = app()->getLocale();

            if ('de_DE' == $locale) {
                $chars[chr(195) . chr(132)] = 'Ae';
                $chars[chr(195) . chr(164)] = 'ae';
                $chars[chr(195) . chr(150)] = 'Oe';
                $chars[chr(195) . chr(182)] = 'oe';
                $chars[chr(195) . chr(156)] = 'Ue';
                $chars[chr(195) . chr(188)] = 'ue';
                $chars[chr(195) . chr(159)] = 'ss';
            } elseif ('da_DK' === $locale) {
                $chars[chr(195) . chr(134)] = 'Ae';
                $chars[chr(195) . chr(166)] = 'ae';
                $chars[chr(195) . chr(152)] = 'Oe';
                $chars[chr(195) . chr(184)] = 'oe';
                $chars[chr(195) . chr(133)] = 'Aa';
                $chars[chr(195) . chr(165)] = 'aa';
            }

            $string = strtr($string, $chars);
        } else {
            $chars = array();
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                    . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                    . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                    . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                    . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                    . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                    . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                    . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                    . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                    . chr(252) . chr(253) . chr(255);

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = array();
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }

    /**
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     *       has Bytes Sequences with a maximum length of 4.
     *
     * @author bmorel at ssi dot fr (modified)
     * @since 1.2.1
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    public function seems_utf8($str) {
        $this->mbstring_binary_safe_encoding();
        $length = strlen($str);
        $this->reset_mbstring_encoding();
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80)
                $n = 0; // 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0)
                $n = 1; // 110bbbbb
            elseif (($c & 0xF0) == 0xE0)
                $n = 2; // 1110bbbb
            elseif (($c & 0xF8) == 0xF0)
                $n = 3; // 11110bbb
            elseif (($c & 0xFC) == 0xF8)
                $n = 4; // 111110bb
            elseif (($c & 0xFE) == 0xFC)
                $n = 5; // 1111110b
            else
                return false; // Does not match any model
            for ($j = 0; $j < $n; $j++) { // n bytes matching 10bbbbbb follow ?
                if (( ++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    /**
     * Reset the mbstring internal encoding to a users previously set encoding.
     *
     * @see mbstring_binary_safe_encoding()
     *
     * @since 3.7.0
     */
    public function reset_mbstring_encoding() {
        $this->mbstring_binary_safe_encoding(true);
    }

    /**
     * Set the mbstring internal encoding to a binary safe encoding when func_overload
     * is enabled.
     *
     * When mbstring.func_overload is in use for multi-byte encodings, the results from
     * strlen() and similar functions respect the utf8 characters, causing binary data
     * to return incorrect lengths.
     *
     * This function overrides the mbstring encoding to a binary-safe encoding, and
     * resets it to the users expected encoding afterwards through the
     * `reset_mbstring_encoding` function.
     *
     * It is safe to recursively call this function, however each
     * `mbstring_binary_safe_encoding()` call must be followed up with an equal number
     * of `reset_mbstring_encoding()` calls.
     *
     * @since 3.7.0
     *
     * @see reset_mbstring_encoding()
     *
     * @param bool $reset Optional. Whether to reset the encoding back to a previously-set encoding.
     *                    Default false.
     */
    public function mbstring_binary_safe_encoding($reset = false) {
        static $encodings = array();
        static $overloaded = null;

        if (is_null($overloaded))
            $overloaded = function_exists('mb_internal_encoding') && ( ini_get('mbstring.func_overload') & 2 );

        if (false === $overloaded)
            return;

        if (!$reset) {
            $encoding = mb_internal_encoding();
            array_push($encodings, $encoding);
            mb_internal_encoding('ISO-8859-1');
        }

        if ($reset && $encodings) {
            $encoding = array_pop($encodings);
            mb_internal_encoding($encoding);
        }
    }

    /**
     * Convert a value to non-negative integer.
     *
     * @since 2.5.0
     *
     * @param mixed $maybeint Data you wish to have converted to a non-negative integer.
     * @return int A non-negative integer.
     */
    public function absint($maybeint) {
        return abs(intval($maybeint));
    }

    /**
     * Sort an array by a given key.
     *
     * @param array  $array Array to sort, array is returned sorted.
     * @param string $key   Key to sort array by.
     */
    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }

}
