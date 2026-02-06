<?php 
global $post;
$parents = get_post_ancestors($post->ID);
$root_id = ($parents) ? $parents[count($parents) - 1] : $post->ID;


// get lesson
$youtube = get_field('youtube', $post->ID);
$file_download = get_field('file_download',$post->ID);

// get posttype course_log
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
$root_id_log = new WP_Query($arg);
$lessons_id_complete = array();
while($root_id_log->have_posts()) {
    $root_id_log->the_post();
    // string to array
    $lessons_id_complete = explode(',', get_field('lessons_id_complete', get_the_ID()));
}
wp_reset_postdata();

$arg = array(
    'post_type' => 'course',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post_parent' => $root_id,
    'orderby' => 'menu_order',
);
$lessons = new WP_Query($arg);

$lesson_list_html = '';
$count_lession = $lessons->post_count;
if($lessons) {
    $lesson_list_html .= '<ul class="course-sitebar-list">';
    $lesson_list_html .= '<li>รายละเอียด คอร์ส</li>';
    while($lessons->have_posts()) {
        $lessons->the_post();
        $class = '';
        if (get_the_ID() == $lesson) {
            $class = 'current';
        }
        elseif (in_array(get_the_ID(), $lessons_id_complete)) {
            $class = 'complete';
        }
        $lesson_list_html .=  '<li class="'. $class .'"><a href="?lesson='.get_the_ID().'">';
        ob_start();
        seed_icon('i-play');
        // seed_icon('i-check');
        $lesson_list_html .=  ob_get_clean();
        $lesson_list_html .=  get_the_title();
        $lesson_list_html .=  '</a></li>';
    }
    $lesson_list_html .=  '</ul>';
}
wp_reset_postdata();
?>
<div class="course-area">
    <div class="course-sitebar">
        <div class="course-sitebar-header">
            <div class="course-tag">
                <a href="/course">คอร์ส</a>
            </div>
            <p><?php echo get_the_title($root_id); ?></p>
            <div class="lesson-complate">
                <?php printf( __( '%1$s/%2$s Complete', 'plant' ), count($lessons_id_complete), $count_lession );?>

            </div>
        </div>
        <?php echo $lesson_list_html; ?>
    </div>
    <div class="course-content">
        <div class="content-video s-lg">
            <?php 
                if ($youtube) {
                    echo '<a data-src="https://www.youtube.com/watch?v=' . $youtube . '&mute=0" title="Permalink to ' . get_the_title($lesson) . '">';
                    echo '<img src="https://img.youtube.com/vi/' . $youtube . '/maxresdefault.jpg" alt="">';
                    echo '</a>';
                }
                ?>
        </div>
        <div class="course-info">
            <div class="s-flex justify-between">
                <h3 class="s-title">
                    รายละเอียดคอร์ส
                </h3>
                <div class="share">
                    <?php if(function_exists('seed_social')) { seed_social();} ?>
                </div>
            </div>
            <?php echo get_post_field('post_content', $post->ID); ?>
        </div>
        <?php if( have_rows( 'file_download', $post->ID )): ?>
        <div class="course-document">
            <h3 class="s-title">
                เอกสารประกอบการเรียน
            </h3>
            <div class="documents-download">
                <?php  while( have_rows('file_download', $post->ID) ) : the_row();  ?>
                <?php $file = get_sub_field('file'); ?>

                <div class="s-flex justify-between">
                    <span>
                        <?php echo $file['name']; ?>
                    </span>
                    <a href="<?php echo $file['url']; ?>" class="s-flex items-center">
                        ดาวน์โหลด
                        <?php seed_icon('i-download'); ?>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>