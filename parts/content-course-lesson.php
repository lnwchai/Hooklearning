<?php
    $i_check = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M9.99984 1.66663C5.40565 1.66663 1.6665 5.40578 1.6665 9.99996C1.6665 14.5941 5.40565 18.3333 9.99984 18.3333C14.594 18.3333 18.3332 14.5941 18.3332 9.99996C18.3332 5.40578 14.594 1.66663 9.99984 1.66663ZM9.99984 2.91663C13.9191 2.91663 17.0832 6.08069 17.0832 9.99996C17.0832 13.9192 13.9191 17.0833 9.99984 17.0833C6.08057 17.0833 2.9165 13.9192 2.9165 9.99996C2.9165 6.08069 6.08057 2.91663 9.99984 2.91663ZM13.1118 7.49345C12.9512 7.49996 12.7971 7.56723 12.6821 7.68225L8.95817 11.4084L7.31755 9.76558C7.15913 9.60282 6.92692 9.53772 6.70774 9.59414C6.48855 9.65057 6.31711 9.82201 6.26069 10.0412C6.20426 10.2604 6.26937 10.4926 6.43213 10.651L8.51546 12.7343C8.76069 12.9774 9.15565 12.9774 9.40088 12.7343L13.5675 8.56767C13.752 8.38755 13.8063 8.11194 13.7064 7.87539C13.6066 7.63885 13.3701 7.48694 13.1118 7.49345Z" fill="#2ACCC8"/>
    </svg>
    ';

    $i_dash = '-';

    $i_arrow = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M10.0002 18.3334C14.5943 18.3334 18.3335 14.5942 18.3335 10C18.3335 5.40586 14.5943 1.66671 10.0002 1.66671C5.40598 1.66671 1.66683 5.40586 1.66683 10C1.66683 14.5942 5.40598 18.3334 10.0002 18.3334ZM10.0002 17.0834C6.08089 17.0834 2.91683 13.9193 2.91683 10C2.91683 6.08077 6.08089 2.91671 10.0002 2.91671C13.9194 2.91671 17.0835 6.08077 17.0835 10C17.0835 13.9193 13.9194 17.0834 10.0002 17.0834ZM10.6382 13.1316C10.7988 13.125 10.9529 13.0578 11.0679 12.9427L13.5679 10.4427C13.8109 10.1975 13.8109 9.80256 13.5679 9.55733L11.0679 7.05733C10.9095 6.89457 10.6772 6.82947 10.4581 6.88589C10.2389 6.94232 10.0674 7.11376 10.011 7.33294C9.95459 7.55212 10.0197 7.78433 10.1825 7.94275L11.6169 9.37504L6.87516 9.37504C6.64947 9.37287 6.44114 9.49006 6.32612 9.68537C6.21327 9.88068 6.21327 10.1194 6.32612 10.3147C6.44114 10.51 6.64947 10.6272 6.87516 10.625L11.6169 10.625L10.1825 12.0573C9.99799 12.2375 9.94374 12.5131 10.0436 12.7496C10.1434 12.9862 10.3799 13.1381 10.6382 13.1316Z" fill="white"/>
    </svg>
    ';

    // AUTHOR
    $author_id = get_the_author_meta('ID');
    $teacher_image = get_avatar_url($author_id);
    $teacher_name = get_the_author_meta('display_name');
    $teacher_link = get_author_posts_url($author_id);

    $root_id = get_the_ID();
    // END LESSONS
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('s-content s-content-course'); ?>>
    <div class="entry-pic entry-pic-course">
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>">
            <?php echo plant_placeholder('medium_large');?>
        </a>
    </div>

    
    <div class="entry-info entry-info-course">
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <?php 

        // COURSE LOG
        $arg = array(
            'post_type' => 'course_log',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'student',
                    'value' => get_current_user_id(),
                    'compare' => '=',
                ),
                array(
                    'key' => 'course_id',
                    'value' => $root_id,
                    'compare' => '=',
                ),
            ),
        );
        $root_id_log = new WP_Query($arg);
        $lessons_id_complete = array();
        $course_status = false;
        while($root_id_log->have_posts()) {
            $root_id_log->the_post();
            // string to array
            $lessons_id_complete = explode(',', get_field('lessons_id_complete', get_the_ID()));
            $course_status = get_field('course_status');
        }
        wp_reset_postdata();
        // END COURSE LOG

        // LESSONS
        $arg = array(
            'post_type' => 'course',
            'posts_per_page' => -1,
            'post_parent' => $root_id,
            'orderby' => 'menu_order',
        );
        $lessons = new WP_Query($arg);
        $next_lesson =  $course_status ? get_the_permalink($root_id) : '';
        if($lessons) {
            echo '<ul class="lesson">';
            while($lessons->have_posts()) {
                $lessons->the_post();
                if(in_array(get_the_ID(), $lessons_id_complete)) {
                echo  '<li><span class="icon">'.$i_check.'</span>'.get_the_title().'</li>';
                }
                else {
                    if( empty( $next_lesson ) ) $next_lesson = get_the_permalink();
                    echo '<li><span class="icon">'.$i_dash.'</span>'.get_the_title().'</li>';
                }
            }
            $html_lessons.= '</ul>';
        }
        wp_reset_postdata();

        ?>
        <div class="more s-grid -d2 -m2">
            <a herf="<?php echo $teacher_link; ?>" class="avatar s-grid -d2 -m2">
                <div class="pic">
                    <img src="<?php echo $teacher_image; ?>" alt="avatar">
                </div>
                <div class="info">
                    <h4 class="name"><?php echo $teacher_name; ?></h4>
                </div>
            </a>
            <div class="readmore">
                <a class="button button-more" href="<?php echo $next_lesson; ?>"
                    title="Permalink to <?php the_title_attribute($root_id); ?>">
                    <?php echo $course_status ? 'ดูอีกครั้ง' : 'เรียนต่อ'; ?>
                    <?php echo $i_arrow; ?>
                </a>
            </div>
        </div>
    </div>
</article>