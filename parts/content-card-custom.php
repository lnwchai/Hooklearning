<?php require('_content.php'); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('s-content s-content-card'); ?>>
    <div class="entry-pic entry-pic-card">
        <?php echo plant_cat($s_cat_float, $s_cat_style); ?>
        <?php do_action('plant_begin_entry_pic'); ?>
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('medium_large');
            } else {
                echo plant_placeholder('medium_large');
            }
            ?>
        </a>
        <?php do_action('plant_end_entry_pic'); ?>
    </div>
    <div class="entry-info entry-info-card">
        <?php
            echo plant_cat($s_cat, $s_cat_style);
            the_title(sprintf('<h2 class="entry-title"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
            echo plant_date($s_date);
            echo plant_excerpt($s_excerpt);
            // echo plant_author($s_author, get_the_author_meta('ID'), $s_shortcode);
            echo plant_readmore($s_more);
        ?>
    </div>
</article>