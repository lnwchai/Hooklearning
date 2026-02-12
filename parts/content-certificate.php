<?php
    // Default template vars (part may be included without $args)
    $s_cat_float = $s_cat = $s_cat_style = $s_date = $s_excerpt = $s_author = $s_shortcode = $s_more = null;
    if ( ! empty( $args ) && is_array( $args ) ) {
        if ( array_key_exists( 's_cat_float', $args ) ) $s_cat_float = $args['s_cat_float'];
        if ( array_key_exists( 's_cat', $args ) ) $s_cat = $args['s_cat'];
        if ( array_key_exists( 's_cat_style', $args ) ) $s_cat_style = $args['s_cat_style'];
        if ( array_key_exists( 's_date', $args ) ) $s_date = $args['s_date'];
        if ( array_key_exists( 's_excerpt', $args ) ) $s_excerpt = $args['s_excerpt'];
        if ( array_key_exists( 's_author', $args ) ) $s_author = $args['s_author'];
        if ( array_key_exists( 's_shortcode', $args ) ) $s_shortcode = $args['s_shortcode'];
        if ( array_key_exists( 's_more', $args ) ) $s_more = $args['s_more'];
    }

    //get icon
    $i_arrow_down = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M1.6665 10C1.6665 14.5942 5.40565 18.3334 9.99984 18.3334C14.594 18.3334 18.3332 14.5942 18.3332 10C18.3332 5.40586 14.594 1.66671 9.99984 1.66671C5.40565 1.66671 1.6665 5.40586 1.6665 10ZM2.9165 10C2.9165 6.08077 6.08057 2.91671 9.99984 2.91671C13.9191 2.91671 17.0832 6.08077 17.0832 10C17.0832 13.9193 13.9191 17.0834 9.99984 17.0834C6.08057 17.0834 2.9165 13.9193 2.9165 10ZM6.86833 10.6381C6.87484 10.7987 6.94211 10.9527 7.05713 11.0677L9.55713 13.5677C9.80235 13.8108 10.1973 13.8108 10.4425 13.5677L12.9425 11.0677C13.1053 10.9093 13.1704 10.6771 13.114 10.4579C13.0576 10.2388 12.8861 10.0673 12.6669 10.0109C12.4478 9.95447 12.2155 10.0196 12.0571 10.1823L10.6248 11.6168L10.6248 6.87504C10.627 6.64935 10.5098 6.44101 10.3145 6.326C10.1192 6.21315 9.88048 6.21315 9.68517 6.326C9.48985 6.44101 9.37267 6.64935 9.37484 6.87504L9.37484 11.6168L7.94255 10.1823C7.76242 9.99787 7.48682 9.94362 7.25027 10.0434C7.01373 10.1433 6.86182 10.3798 6.86833 10.6381Z" fill="#6842EF"/>
    </svg> 
    ';

    //get acf
    $course = get_field('course_id', get_the_ID());
    $link_download = get_permalink( $course )."/?type=certificate";
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('s-content s-content-card s-content-cert'); ?>>
    <div class="entry-pic entry-pic-card">
        <?php echo plant_cat($s_cat_float, $s_cat_style); ?>
        <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('medium_large');
            } else {
                echo '<img src="https://hooklearning.com/wp-content/uploads/2023/07/cer-03.jpg" alt="" srcset="">';
            }
        ?>
    </div>
    <div class="entry-info entry-info-card">
        <?php
            echo plant_cat($s_cat, $s_cat_style);
            echo '<h2 class="entry-title">'.get_the_title( $course ).'</h2>';
            echo plant_date($s_date);
            echo plant_excerpt($s_excerpt);
            //echo plant_author($s_author, get_the_author_meta('ID'), $s_shortcode);
            //echo plant_readmore($s_more);
            //if($link_download){
                echo '<div class="entry-more"><a class="button button-download" href="'.$link_download.'">ดาวน์โหลด'.$i_arrow_down.'</a></div>';
            //}
        ?>
    </div>
</article>

