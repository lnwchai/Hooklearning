<?php

// Get lesson data
$youtube = get_field('youtube', $lesson);
$file_download = get_field('file_download', $lesson);

// Get course log for the current user
$arg = array(
    'post_type' => 'course_log',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => 'student',
            'value' => get_current_user_id(),
            'compare' => '=',
        ),
    ),
);
$course_log = new WP_Query($arg);
$lessons_id_complete = array();

// Process course log data
if ($course_log->have_posts()) {
    while($course_log->have_posts()) {
        $course_log->the_post();
        // Convert comma-separated string to array
        $lessons_id_complete = explode(',', get_field('lessons_id_complete', get_the_ID()));
    }
    wp_reset_postdata();
}

// Get all lessons for this course
$arg = array(
    'post_type' => 'course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post_parent' => $course,
    'orderby' => 'menu_order',
);
$lessons = new WP_Query($arg);

// Generate lesson list HTML
$lesson_list_html = '';
$count_lession = $lessons->post_count;

if ($lessons->have_posts()) {
    $lesson_list_html .= '<ul class="course-sitebar-list">';
    $lesson_list_html .= '<li>รายละเอียด คอร์ส</li>';
    
    while($lessons->have_posts()) {
        $lessons->the_post();
        $class = '';
        $lesson_id = get_the_ID();
        
        // Determine CSS class for the lesson
        if ($lesson_id == $lesson) {
            $class = 'current';
        } elseif (in_array($lesson_id, $lessons_id_complete)) {
            $class = 'complete';
        }
        
        // Build lesson list item
        $lesson_list_html .= '<li class="' . $class . '"><a href="?lesson=' . $lesson_id . '">';
        ob_start();
        seed_icon('i-play');
        $lesson_list_html .= ob_get_clean();
        $lesson_list_html .= get_the_title();
        $lesson_list_html .= '</a></li>';
    }
    
    $lesson_list_html .= '</ul>';
    wp_reset_postdata();
}



get_header(); 
?>
<main id="main" class="site-main single-main">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('parts/title','minimal');
            echo '<div class="single-content">';
            do_action('plant_before_single_content');

            the_content();
            
            do_action('plant_after_single_content');
            edit_post_link('EDIT', '', '', null, 'btn-edit');
            echo '</div>';
        }
    }
    
    ?>
</main>

<?php 
get_footer(); 
?>