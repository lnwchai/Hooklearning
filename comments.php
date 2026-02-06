<?php

/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package seed
 */

/*
 * Disabled by default. Can be enabled in Customizer.
 */
if (is_single()) {
    if (!get_theme_mod('single_show_comment', false)) {
        return;
    }
} elseif (is_page()) {
    if (!get_theme_mod('page_show_comment', false)) {
        return;
    }
} else {
    if (!get_theme_mod('single_show_comment', false) and !get_theme_mod('page_show_comment', false)) {
        return;
    }
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php comment_form(); ?>
    <?php
    if (have_comments()) : ?>
    <h2 class="comments-title">
        <?php esc_html_e('Comments', 'plant'); ?>
    </h2><!-- .comments-title -->
    <?php the_comments_navigation(); ?>
    <ol class="comment-list">
        <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
            ));
        ?>
    </ol>
    <?php
        the_comments_navigation();
    // If comments are closed and there are comments, let's leave a little note, shall we?
        if (! comments_open()) :
            ?>
    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'plant'); ?></p>
    <?php endif; ?>
    <?php endif; // Check for have_comments(). ?>
</div>