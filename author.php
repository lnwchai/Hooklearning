<?php 
    get_header(); 

    //get user
    $author = get_user_by('slug', get_query_var('author_name'));
    
    //get acf
    $user_field_ID = 'user_'.$author->ID;
    $position = get_field('position', $user_field_ID);
    $subject = get_field('subject', $user_field_ID);
    $about = get_field('about', $user_field_ID);
    $facbook_link = get_field('facbook', $user_field_ID);
    $twitter_link = get_field('twitter', $user_field_ID);
    $mail_link = get_field('mail', $user_field_ID);
    $line_link = get_field('line', $user_field_ID);

    //get icon
    $i_book = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2.75 3.5C1.79167 3.5 1 4.29167 1 5.25V18.75C1 19.7083 1.79167 20.5 2.75 20.5H10.2812C10.625 21.0964 11.2604 21.5 12 21.5C12.7396 21.5 13.375 21.0964 13.7188 20.5H21.25C22.2083 20.5 23 19.7083 23 18.75V5.25C23 4.29167 22.2083 3.5 21.25 3.5H14C13.2083 3.5 12.5026 3.85156 12 4.39583C11.4974 3.85156 10.7917 3.5 10 3.5H2.75ZM2.75 5H10C10.6979 5 11.25 5.55208 11.25 6.25V19H2.75C2.60156 19 2.5 18.8984 2.5 18.75V5.25C2.5 5.10156 2.60156 5 2.75 5ZM14 5H21.25C21.3984 5 21.5 5.10156 21.5 5.25V18.75C21.5 18.8984 21.3984 19 21.25 19H12.75V6.25C12.75 5.55208 13.3021 5 14 5ZM4.75 7.75C4.47917 7.7474 4.22917 7.88802 4.09115 8.1224C3.95573 8.35677 3.95573 8.64323 4.09115 8.8776C4.22917 9.11198 4.47917 9.2526 4.75 9.25H9C9.27083 9.2526 9.52083 9.11198 9.65885 8.8776C9.79427 8.64323 9.79427 8.35677 9.65885 8.1224C9.52083 7.88802 9.27083 7.7474 9 7.75H4.75ZM15 7.75C14.7292 7.7474 14.4792 7.88802 14.3411 8.1224C14.2057 8.35677 14.2057 8.64323 14.3411 8.8776C14.4792 9.11198 14.7292 9.2526 15 9.25H19.25C19.5208 9.2526 19.7708 9.11198 19.9089 8.8776C20.0443 8.64323 20.0443 8.35677 19.9089 8.1224C19.7708 7.88802 19.5208 7.7474 19.25 7.75H15ZM4.75 11.25C4.47917 11.2474 4.22917 11.388 4.09115 11.6224C3.95573 11.8568 3.95573 12.1432 4.09115 12.3776C4.22917 12.612 4.47917 12.7526 4.75 12.75H9C9.27083 12.7526 9.52083 12.612 9.65885 12.3776C9.79427 12.1432 9.79427 11.8568 9.65885 11.6224C9.52083 11.388 9.27083 11.2474 9 11.25H4.75ZM15 11.25C14.7292 11.2474 14.4792 11.388 14.3411 11.6224C14.2057 11.8568 14.2057 12.1432 14.3411 12.3776C14.4792 12.612 14.7292 12.7526 15 12.75H19.25C19.5208 12.7526 19.7708 12.612 19.9089 12.3776C20.0443 12.1432 20.0443 11.8568 19.9089 11.6224C19.7708 11.388 19.5208 11.2474 19.25 11.25H15ZM4.75 14.75C4.47917 14.7474 4.22917 14.888 4.09115 15.1224C3.95573 15.3568 3.95573 15.6432 4.09115 15.8776C4.22917 16.112 4.47917 16.2526 4.75 16.25H9C9.27083 16.2526 9.52083 16.112 9.65885 15.8776C9.79427 15.6432 9.79427 15.3568 9.65885 15.1224C9.52083 14.888 9.27083 14.7474 9 14.75H4.75ZM15 14.75C14.7292 14.7474 14.4792 14.888 14.3411 15.1224C14.2057 15.3568 14.2057 15.6432 14.3411 15.8776C14.4792 16.112 14.7292 16.2526 15 16.25H18.25C18.5208 16.2526 18.7708 16.112 18.9089 15.8776C19.0443 15.6432 19.0443 15.3568 18.9089 15.1224C18.7708 14.888 18.5208 14.7474 18.25 14.75H15Z" fill="#6842EF"/>
    </svg>
    ';

    $i_fb = '<svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M11.4998 1.83325C6.21559 1.83325 1.9165 5.94542 1.9165 10.9999C1.9165 15.586 5.45946 19.3851 10.0623 20.052V13.2916H8.14567C7.88117 13.2916 7.6665 13.0867 7.6665 12.8333V11.4583C7.6665 11.2048 7.88117 10.9999 8.14567 10.9999H10.0623V9.33525C10.0623 7.15771 11.2253 5.95825 13.337 5.95825C14.1928 5.95825 14.8679 6.01509 14.8962 6.01738C15.1434 6.03846 15.3332 6.23646 15.3332 6.47388V8.02075C15.3332 8.27421 15.1185 8.47909 14.854 8.47909H13.8957C13.3671 8.47909 12.9373 8.89021 12.9373 9.39575V10.9999H14.854C14.9915 10.9999 15.1223 11.0563 15.2134 11.1548C15.3044 11.2538 15.3466 11.3849 15.3298 11.5151L15.1501 12.8901C15.1199 13.1193 14.9158 13.2916 14.6743 13.2916H12.9373V20.052C17.5402 19.3851 21.0832 15.586 21.0832 10.9999C21.0832 5.94542 16.7841 1.83325 11.4998 1.83325Z" fill="#6842EF"/>
    </svg>
    ';

    $i_tw = '<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M20.496 4.72313C20.3608 4.58333 20.1527 4.54346 19.9753 4.62504L19.9001 4.65942C19.8364 4.68875 19.7727 4.71808 19.7086 4.74696C19.8951 4.4495 20.0431 4.13142 20.1454 3.80233C20.2022 3.62083 20.1403 3.42238 19.99 3.30504C19.8396 3.18771 19.6325 3.17533 19.4698 3.27479C18.9468 3.59242 18.4445 3.82113 17.9252 3.98063C17.1414 3.22025 16.074 2.75 14.8956 2.75C12.4907 2.75 10.5414 4.69929 10.5414 7.10417C10.5414 7.10646 10.5414 7.19721 10.5414 7.33333L10.0836 7.29667C5.62719 6.76958 4.35852 3.77208 4.30581 3.64283C4.22056 3.42742 4.03264 3.27021 3.80577 3.223C3.57935 3.17488 3.34423 3.24592 3.18014 3.40954C3.08939 3.50075 2.29144 4.345 2.29144 5.95833C2.29144 7.10783 2.80385 8.04008 3.46706 8.76517C3.15814 8.57679 2.97802 8.42417 2.97344 8.42004C2.76214 8.23579 2.45964 8.19729 2.20848 8.32471C1.95823 8.45258 1.81064 8.71979 1.83585 8.99983C1.84456 9.09654 2.03981 10.9308 4.15869 12.3159L3.77231 12.386C3.5381 12.4286 3.34239 12.5895 3.25531 12.8113C3.16869 13.0336 3.2026 13.2843 3.3456 13.475C3.39373 13.5396 4.28885 14.7033 6.23264 15.3725C5.19452 15.7185 3.76819 16.0417 2.06227 16.0417C1.79277 16.0417 1.54756 16.1993 1.43619 16.445C1.32435 16.6907 1.36698 16.979 1.54481 17.1815C1.6186 17.2663 3.40748 19.25 8.0206 19.25C15.6807 19.25 19.2498 12.139 19.2498 7.33333V7.10417C19.2498 7.03633 19.2424 6.96987 19.2397 6.90296C20.1985 5.97621 20.5592 5.28092 20.5766 5.24654C20.6633 5.07237 20.6312 4.86246 20.496 4.72313Z" fill="#6842EF"/>
    </svg>
    ';

    $i_mail = '<svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M4.7915 3.66675C3.28692 3.66675 2.05045 4.77591 1.92586 6.18758L11.4998 11.1326L21.0738 6.18758C20.9492 4.77591 19.7128 3.66675 18.2082 3.66675H4.7915ZM1.9165 7.74162V15.5834C1.9165 17.1005 3.20546 18.3334 4.7915 18.3334H18.2082C19.7942 18.3334 21.0832 17.1005 21.0832 15.5834V7.74162L11.8405 12.5219C11.7351 12.5769 11.6196 12.6042 11.4998 12.6042C11.38 12.6042 11.2646 12.5769 11.1592 12.5219L1.9165 7.74162Z" fill="#6842EF"/>
    </svg>
    ';

    $i_line = '<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M11.5133 20.4056C10.5444 20.9381 10.5857 20.1539 10.6274 19.9124C10.6521 19.7685 10.7649 19.0933 10.7649 19.0933C10.797 18.8486 10.8309 18.47 10.7342 18.2285C10.6265 17.9626 10.1998 17.8242 9.88625 17.7568C5.26167 17.1486 1.83838 13.9334 1.83838 10.0949C1.83838 5.81314 6.15588 2.32935 11.4611 2.32935C16.7663 2.32935 21.0833 5.81314 21.0833 10.0949C21.0833 14.9037 15.983 17.948 11.5133 20.4056ZM8.41913 11.8457C8.41913 11.5891 8.20875 11.3805 7.95025 11.3805H6.64125V8.31976C6.64125 8.0631 6.43088 7.85455 6.17238 7.85455C5.91342 7.85455 5.7035 8.0631 5.7035 8.31976V11.8462C5.7035 12.1033 5.91388 12.3118 6.17238 12.3118H7.95025C8.20875 12.3123 8.41913 12.1028 8.41913 11.8457ZM9.78863 8.31976C9.78863 8.0631 9.57825 7.85455 9.31975 7.85455C9.0608 7.85455 8.85088 8.0631 8.85088 8.31976V11.8462C8.85088 12.1033 9.06125 12.3118 9.31975 12.3118C9.57871 12.3118 9.78863 12.1028 9.78863 11.8462V8.31976ZM14.0695 8.31976C14.0695 8.0631 13.8591 7.85455 13.6006 7.85455C13.3416 7.85455 13.1308 8.0631 13.1308 8.31976V10.5019L11.3075 8.0411C11.2195 7.92468 11.0788 7.85501 10.9326 7.85501C10.8822 7.85501 10.8323 7.86235 10.7837 7.87885C10.5916 7.94255 10.4628 8.11993 10.4628 8.32022V11.8466C10.4628 12.1038 10.6737 12.3123 10.9326 12.3123C11.192 12.3123 11.4024 12.1033 11.4024 11.8466V9.66543L13.2248 12.1262C13.3128 12.2426 13.453 12.3123 13.5997 12.3123C13.6496 12.3123 13.7 12.3041 13.7486 12.288C13.9411 12.2252 14.0695 12.0478 14.0695 11.8466V8.31976ZM16.9469 9.61776H15.6379V8.78497H16.9469C17.2063 8.78497 17.4167 8.57643 17.4167 8.31976C17.4167 8.0631 17.2058 7.85455 16.9469 7.85455H15.169C14.91 7.85455 14.7001 8.0631 14.7001 8.31976C14.7001 8.32022 14.7001 8.32022 14.7001 8.32114V10.0821V10.0825C14.7001 10.0825 14.7001 10.0825 14.7001 10.083V11.8453C14.7001 12.1024 14.911 12.3109 15.169 12.3109H16.9469C17.2058 12.3109 17.4167 12.1019 17.4167 11.8453C17.4167 11.5886 17.2058 11.3801 16.9469 11.3801H15.6379V10.5473H16.9469C17.2063 10.5473 17.4167 10.3387 17.4167 10.0821C17.4167 9.82493 17.2058 9.61639 16.9469 9.61639V9.61776Z" fill="#6842EF"/>
    </svg>
    ';

    //loop course for this teacher
    // Cache the results to improve performance
    $cache_key = 'author_courses_' . $author->ID;
    $parent_course = wp_cache_get( $cache_key, 'author_courses' );
    
    if ( false === $parent_course ) {
        $args = array(
            'post_type' => 'course',
            'post_parent' => 0,
            'posts_per_page' => -1,
            'author' => $author->ID,
            'fields' => 'ids'
        );
        $parent_course = get_posts( $args );
        // Cache for 1 hour
        wp_cache_set( $cache_key, $parent_course, 'author_courses', HOUR_IN_SECONDS );
    }
?>

<div class="page-banner alignfull">
    <img src="/wp-content/uploads/2023/03/banner-page.webp" alt="banner">
</div>

<main id="main" class="site-main -wide">
    <header class="hide page-header header-author <?php echo plant_page_title_css(); ?>">
        <div class="author-pic">
            <?php $author = get_user_by('slug', get_query_var('author_name')); ?>
            <?php echo get_avatar($author->ID, apply_filters('author_bio_avatar_size', 80)); ?>
        </div>
        <div class="author-info">
            <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description _space">', '</div>');
            ?>
        </div>
    </header>

    <div class="page-content">

        <div class="user-item s-grid -d2 -teacher">
            <div class="pic">
                <?php echo get_avatar($author->ID, apply_filters('author_bio_avatar_size', 254)); ?>
                <p class="badge"><?php echo $position; ?></p>
                <h2 class="name"><?php echo $author->display_name; ?></h2>
                <p class="subject"><?php echo $subject; ?></p>
                <div class="lessons">
                    <p><?php echo $i_book.$the_query->post_count; ?> Lessons</p>
                </div>
                <div class="social">
                    <?php if($facbook_link): ?><a
                        href="<?php echo $facbook_link; ?>"><?php echo $i_fb; ?></a><?php endif; ?>
                    <?php if($twitter_link): ?><a
                        href="<?php echo $twitter_link; ?>"><?php echo $i_tw; ?></a><?php endif; ?>
                    <?php if($mail_link): ?><a
                        href="<?php echo $mail_link; ?>"><?php echo $i_mail; ?></a><?php endif; ?>
                    <?php if($line_link): ?><a
                        href="<?php echo $line_link; ?>"><?php echo $i_line; ?></a><?php endif; ?>
                </div>
            </div>
            <div class="info">
                <h3 class="s-title">เกี่ยวกับผู้สอน</h3>
                <div class="about">
                    <?php the_archive_description(); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="author-course s-course s-sec">
        <h3 class="s-title">คอร์สเรียนทั้งหมด</h3>
        <div class="teacher-course s-grid -m1 -t2 -d4">
            <?php 
            foreach( $parent_course as $ids ){
                $args = [
                    'post_type' => 'course',
                    'post_parent' => $ids,
                    'posts_per_page' => -1,
                    'order' => 'ASC'
                ];
                $teach_course = new WP_Query( $args );
                while ( $teach_course->have_posts() ) {
                    $teach_course->the_post();
                    get_template_part( 'parts/content', 'course' );
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <div class="s-course s-sec">
        <h3 class="s-title">บทความทั้งหมด</h3>
        <div class="teacher-course s-grid -m1 -t2 -d3">
            <?php 
                // Filter to modify the meta query for teacher articles
                function teacher_article_where( $where ) {
                    $where = str_replace("meta_key = 'teachers_$", "meta_key LIKE 'teachers_%", $where);
                    return $where;
                }
                add_filter('posts_where', 'teacher_article_where');

                // Query for articles by this teacher
                $args = [
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'meta_query' => [
                        [
                            'key' => 'teachers_$_teacher_select',
                            'value' => $author->ID,
                            'compare' => 'IN'
                        ]
                    ]
                ];
                $teach_article = new WP_Query( $args );
                while ( $teach_article->have_posts() ) {
                    $teach_article->the_post();
                    get_template_part( 'parts/content', 'card' );
                }
                wp_reset_postdata();
                remove_filter('posts_where', 'teacher_article_where');
            ?>
        </div>
    </div>
    <?php
    /**if (have_posts()) {
        $term = get_queried_object();
        echo '<div class="s-grid ' . plant_grid_columns_css($term) . '">';
        $vars = plant_content_vars();
        while (have_posts()) {
            the_post();
            get_template_part('parts/content', plant_content_template($term), $vars);
        }
        echo '</div>';
        echo plant_paging();
    } else {
        get_template_part('parts/content', 'none');
    }**/
    ?>
</main>
<?php get_footer(); ?>