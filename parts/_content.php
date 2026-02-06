<?php

$s_cat_float = $s_cat = $s_cat_style = $s_date = $s_excerpt = $s_author = $s_shortcode = $s_more = null;
if ($args) {
    if (array_key_exists('s_cat_float', $args)) {
        $s_cat_float = $args['s_cat_float'];
    }
    if (array_key_exists('s_cat', $args)) {
        $s_cat = $args['s_cat'];
    }
    if (array_key_exists('s_cat_style', $args)) {
        $s_cat_style = $args['s_cat_style'];
    }
    if (array_key_exists('s_date', $args)) {
        $s_date = $args['s_date'];
    }
    if (array_key_exists('s_excerpt', $args)) {
        $s_excerpt = $args['s_excerpt'];
    }
    if (array_key_exists('s_author', $args)) {
        $s_author = $args['s_author'];
    }
    if (array_key_exists('s_shortcode', $args)) {
        $s_shortcode = $args['s_shortcode'];
    }
    if (array_key_exists('s_more', $args)) {
        $s_more = $args['s_more'];
    }
}
