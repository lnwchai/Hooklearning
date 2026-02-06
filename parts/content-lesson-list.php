<article id="post-<?php the_ID(); ?>" <?php post_class('s-lesson-list'); ?>>
    <div class="entry-pic">
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>">
            <?php
           
                if (has_post_thumbnail()) {
                    the_post_thumbnail('medium_large');
                } else {
                    echo plant_placeholder('medium_large');
                }
            ?>
        </a>
    </div>
    <div class="entry-info">
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <div class="detail">
            <?php 
            the_excerpt();
            ?>
        </div>
    </div>
</article>