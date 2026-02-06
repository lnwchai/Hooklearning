<article id="post-<?php the_ID(); ?>" <?php post_class('s-content s-content-overview'); ?>>
    <div class="entry-pic entry-pic">
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>">
            <?php echo plant_placeholder('medium_large');?>
        </a>
    </div>
    <div class="entry-info entry-info-course">
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <div class="more s-flex justity-between">
            <div class="author">
                <?php echo plant_author($s_author, get_the_author_meta('ID'), $s_shortcode); ?>
            </div>
            <div class="lesson">

            </div>
        </div>
    </div>
</article>