<?php 
// check if user is login
if(!is_user_logged_in()) {
    wp_redirect( '/login-signup' );
    exit;
}
global $post;
$current_id = $post->ID;
$parents = get_post_ancestors($current_id);
$root_id = ($parents) ? $parents[count($parents) - 1] : $current_id;
$youtube = get_field('youtube', $current_id);
$file_download = get_field('file_download',$current_id);

// get posttype course_log
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
while($root_id_log->have_posts()) {
    $root_id_log->the_post();
    // string to array
    $lessons_id_complete = explode(',', get_field('lessons_id_complete', get_the_ID()));
}
wp_reset_postdata();

$arg = array(
    'post_type' => 'course',
    'posts_per_page' => -1,
    'post_parent' => $root_id,
    'orderby' => 'menu_order',
);
$lessons = new WP_Query($arg);

$lesson_list_html = '';
$count_lession = $lessons->post_count;

// Question log for pre-test (type = pre)
$args_pre_test = array(
    'post_type' => 'question_log',
    'posts_per_page' => 1,
    'author' => get_current_user_id(),
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'course_id',
            'value' => $root_id,
            'compare' => '=',
        ),
        array(
            'key' => 'type',
            'value' => 'pre',
            'compare' => 'LIKE',
        ),
    ),
);
$pre_test_log = get_posts($args_pre_test);

// Question log for post-test (type = post)
$args_post_test = array(
    'post_type' => 'question_log',
    'posts_per_page' => 1,
    'author' => get_current_user_id(),
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'course_id',
            'value' => $root_id,
            'compare' => '=',
        ),
        array(
            'key' => 'type',
            'value' => 'post',
            'compare' => 'LIKE',
        ),
    ),
);
$post_test_log = get_posts($args_post_test);

// Question log for regular questions (exclude pre/post)
$args_questions = array(
    'post_type' => 'question_log',
    'posts_per_page' => 1,
    'author' => get_current_user_id(),
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'course_id',
            'value' => $root_id,
            'compare' => '=',
        ),
        array(
            'relation' => 'OR',
            array(
                'key' => 'type',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'relation' => 'AND',
                array(
					'key' => 'type',
					'value' => 'pre',
					'compare' => 'NOT LIKE',
				),
				array(
					'key' => 'type',
					'value' => 'post',
					'compare' => 'NOT LIKE',
				),
            ),
        ),
    ),
);
$quesion_log = get_posts($args_questions);

if($lessons) {
    $lesson_list_html .= '<ul class="course-sitebar-list">';
    $lesson_list_html .= '<li>รายละเอียด คอร์ส</li>';
    
    $pre_test = get_field('pre_test', $root_id);
    if($pre_test) {
        $lesson_list_html .= '<li><a href="'.get_permalink( $root_id ).'?type=pre_test">';
        if( !empty($pre_test_log) ){
            $lesson_list_html .= ' <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48698 2 2 6.48698 2 12C2 17.513 6.48698 22 12 22C17.513 22 22 17.513 22 12C22 6.48698 17.513 2 12 2ZM12 3.5C16.7031 3.5 20.5 7.29687 20.5 12C20.5 16.7031 16.7031 20.5 12 20.5C7.29687 20.5 3.5 16.7031 3.5 12C3.5 7.29687 7.29687 3.5 12 3.5ZM15.7344 8.99219C15.5417 9 15.3568 9.08073 15.2187 9.21875L10.75 13.6901L8.78125 11.7187C8.59115 11.5234 8.3125 11.4453 8.04948 11.513C7.78646 11.5807 7.58073 11.7865 7.51302 12.0495C7.44531 12.3125 7.52344 12.5911 7.71875 12.7812L10.2187 15.2812C10.513 15.5729 10.987 15.5729 11.2812 15.2812L16.2812 10.2812C16.5026 10.0651 16.5677 9.73437 16.4479 9.45052C16.3281 9.16667 16.0443 8.98437 15.7344 8.99219Z" fill="#2accc8" /> </svg>';
        } else {
            $lesson_list_html .= '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 0C4.90687 0 3.99937 0.9075 3.99937 2.00062V15.9994C3.99937 17.0925 4.90687 18 6 18H15.9994C17.0925 18 18 17.0925 18 15.9994V2.00062C18 0.9075 17.0925 0 15.9994 0H6ZM0 0.999375V17.0006H2.00062V0.999375H0ZM6 2.00062H15.9994V15.9994H6V2.00062ZM11.0006 3.99937C10.0931 3.99937 9.285 4.38 8.7675 4.9575C8.25 5.53312 8.00062 6.26813 8.00062 6.99937H9.99937C9.99937 6.73313 10.0987 6.46687 10.2562 6.2925C10.4119 6.12 10.605 6 11.0006 6C11.4056 6 11.5987 6.11812 11.7506 6.28312C11.9006 6.44812 12 6.705 12 6.99937C12 7.56563 11.73 7.90313 11.2444 8.46375C10.7587 9.0225 9.99937 9.79688 9.99937 11.0006H12C12 10.665 12.2419 10.3669 12.7556 9.77437C13.2712 9.18 14.0006 8.28563 14.0006 6.99937C14.0006 6.25688 13.7513 5.5125 13.2281 4.93687C12.705 4.36313 11.8969 3.99937 11.0006 3.99937ZM9.99937 12V14.0006H12V12H9.99937Z" fill="#999999"/>
        </svg>';
        }
        $lesson_list_html .= 'แบบประเมินก่อนเรียน</a></li>';
    }
    
    while($lessons->have_posts()) {
        $lessons->the_post();
        if (get_the_ID() == $current_id ) {
            ob_start();
            $lesson_list_html .=  '<li class="current"><a href="'. get_permalink() .'">';
            seed_icon('i-play');
            $lesson_list_html .=  ob_get_clean();
            $lesson_list_html .=  get_the_title();
            $lesson_list_html .=  '</a></li>';
        }
        elseif (in_array(get_the_ID(), $lessons_id_complete)) {
            ob_start();
            $lesson_list_html .=  '<li class="complete"><a href="'. get_permalink() .'">';
            seed_icon('i-check');
            $lesson_list_html .=  ob_get_clean();
            $lesson_list_html .=  get_the_title();
            $lesson_list_html .=  '</a></li>';
        }
        else {
            ob_start();
            $lesson_list_html .=  '<li class=""><a href="'. get_permalink() .'">';
            seed_icon('i-play');
            $lesson_list_html .=  ob_get_clean();
            $lesson_list_html .=  get_the_title();
            $lesson_list_html .=  '</a></li>';
        }
    }
    $lesson_list_html .= '<li class="current"><a href="'.get_permalink( $root_id ).'?type=questions">';
    if( empty($quesion_log) ){
        $lesson_list_html .= '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 0C4.90687 0 3.99937 0.9075 3.99937 2.00062V15.9994C3.99937 17.0925 4.90687 18 6 18H15.9994C17.0925 18 18 17.0925 18 15.9994V2.00062C18 0.9075 17.0925 0 15.9994 0H6ZM0 0.999375V17.0006H2.00062V0.999375H0ZM6 2.00062H15.9994V15.9994H6V2.00062ZM11.0006 3.99937C10.0931 3.99937 9.285 4.38 8.7675 4.9575C8.25 5.53312 8.00062 6.26813 8.00062 6.99937H9.99937C9.99937 6.73313 10.0987 6.46687 10.2562 6.2925C10.4119 6.12 10.605 6 11.0006 6C11.4056 6 11.5987 6.11812 11.7506 6.28312C11.9006 6.44812 12 6.705 12 6.99937C12 7.56563 11.73 7.90313 11.2444 8.46375C10.7587 9.0225 9.99937 9.79688 9.99937 11.0006H12C12 10.665 12.2419 10.3669 12.7556 9.77437C13.2712 9.18 14.0006 8.28563 14.0006 6.99937C14.0006 6.25688 13.7513 5.5125 13.2281 4.93687C12.705 4.36313 11.8969 3.99937 11.0006 3.99937ZM9.99937 12V14.0006H12V12H9.99937Z" fill="#999999"/>
        </svg>';
    }else{
        $lesson_list_html .= ' <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48698 2 2 6.48698 2 12C2 17.513 6.48698 22 12 22C17.513 22 22 17.513 22 12C22 6.48698 17.513 2 12 2ZM12 3.5C16.7031 3.5 20.5 7.29687 20.5 12C20.5 16.7031 16.7031 20.5 12 20.5C7.29687 20.5 3.5 16.7031 3.5 12C3.5 7.29687 7.29687 3.5 12 3.5ZM15.7344 8.99219C15.5417 9 15.3568 9.08073 15.2187 9.21875L10.75 13.6901L8.78125 11.7187C8.59115 11.5234 8.3125 11.4453 8.04948 11.513C7.78646 11.5807 7.58073 11.7865 7.51302 12.0495C7.44531 12.3125 7.52344 12.5911 7.71875 12.7812L10.2187 15.2812C10.513 15.5729 10.987 15.5729 11.2812 15.2812L16.2812 10.2812C16.5026 10.0651 16.5677 9.73437 16.4479 9.45052C16.3281 9.16667 16.0443 8.98437 15.7344 8.99219Z" fill="#2accc8" /> </svg>';
    }
    $lesson_list_html .= 'คำถามท้ายบทเรียน</a></li>';
    
    $post_test = get_field('post_test', $root_id);
    if($post_test) {
        $lesson_list_html .= '<li><a href="'.get_permalink( $root_id ).'?type=post_test">';
        if( !empty($post_test_log) ){
            $lesson_list_html .= ' <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48698 2 2 6.48698 2 12C2 17.513 6.48698 22 12 22C17.513 22 22 17.513 22 12C22 6.48698 17.513 2 12 2ZM12 3.5C16.7031 3.5 20.5 7.29687 20.5 12C20.5 16.7031 16.7031 20.5 12 20.5C7.29687 20.5 3.5 16.7031 3.5 12C3.5 7.29687 7.29687 3.5 12 3.5ZM15.7344 8.99219C15.5417 9 15.3568 9.08073 15.2187 9.21875L10.75 13.6901L8.78125 11.7187C8.59115 11.5234 8.3125 11.4453 8.04948 11.513C7.78646 11.5807 7.58073 11.7865 7.51302 12.0495C7.44531 12.3125 7.52344 12.5911 7.71875 12.7812L10.2187 15.2812C10.513 15.5729 10.987 15.5729 11.2812 15.2812L16.2812 10.2812C16.5026 10.0651 16.5677 9.73437 16.4479 9.45052C16.3281 9.16667 16.0443 8.98437 15.7344 8.99219Z" fill="#2accc8" /> </svg>';
        } else {
            $lesson_list_html .= '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 0C4.90687 0 3.99937 0.9075 3.99937 2.00062V15.9994C3.99937 17.0925 4.90687 18 6 18H15.9994C17.0925 18 18 17.0925 18 15.9994V2.00062C18 0.9075 17.0925 0 15.9994 0H6ZM0 0.999375V17.0006H2.00062V0.999375H0ZM6 2.00062H15.9994V15.9994H6V2.00062ZM11.0006 3.99937C10.0931 3.99937 9.285 4.38 8.7675 4.9575C8.25 5.53312 8.00062 6.26813 8.00062 6.99937H9.99937C9.99937 6.73313 10.0987 6.46687 10.2562 6.2925C10.4119 6.12 10.605 6 11.0006 6C11.4056 6 11.5987 6.11812 11.7506 6.28312C11.9006 6.44812 12 6.705 12 6.99937C12 7.56563 11.73 7.90313 11.2444 8.46375C10.7587 9.0225 9.99937 9.79688 9.99937 11.0006H12C12 10.665 12.2419 10.3669 12.7556 9.77437C13.2712 9.18 14.0006 8.28563 14.0006 6.99937C14.0006 6.25688 13.7513 5.5125 13.2281 4.93687C12.705 4.36313 11.8969 3.99937 11.0006 3.99937ZM9.99937 12V14.0006H12V12H9.99937Z" fill="#999999"/>
        </svg>';
        }
        $lesson_list_html .= 'แบบประเมินหลังเรียน</a></li>';
    }
    
    $lesson_list_html .= '<li><a href="'.get_permalink( $root_id ).'?type=certificate">';
    $lesson_list_html .= '<svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2.62583 0C1.17858 0 0 1.17858 0 2.62583V11.7016C0 13.1489 1.17858 14.3292 2.62583 14.3292H10.9851V13.5268C10.8419 13.3262 10.7183 13.1148 10.609 12.8963H2.62583C1.96669 12.8963 1.43292 12.3607 1.43292 11.7016V2.62583C1.43292 1.96669 1.96669 1.43292 2.62583 1.43292H16.4786C17.1378 1.43292 17.6715 1.96669 17.6715 2.62583V5.82662C18.2124 6.10246 18.6943 6.46606 19.1044 6.90131V2.62583C19.1044 1.17858 17.9259 0 16.4786 0H2.62583ZM4.53699 3.82053C4.27907 3.81695 4.03905 3.95307 3.9083 4.17518C3.77754 4.39907 3.77754 4.67491 3.9083 4.8988C4.03905 5.12091 4.27907 5.25703 4.53699 5.25345H14.5675C14.8254 5.25703 15.0654 5.12091 15.1961 4.8988C15.3269 4.67491 15.3269 4.39907 15.1961 4.17518C15.0654 3.95307 14.8254 3.81695 14.5675 3.82053H4.53699ZM15.2839 6.68638C13.1829 6.68638 11.4634 8.40588 11.4634 10.5069C11.4634 11.4688 11.8252 12.3482 12.4181 13.0235V17.4333C12.4181 17.6984 12.5632 17.9402 12.796 18.0656C13.0288 18.1892 13.3119 18.1766 13.5322 18.0297L15.2839 16.8619L17.0357 18.0297C17.256 18.1766 17.539 18.1892 17.7718 18.0656C18.0047 17.9402 18.1498 17.6984 18.1498 17.4333V13.0235C18.7426 12.3482 19.1044 11.4688 19.1044 10.5069C19.1044 8.40588 17.3849 6.68638 15.2839 6.68638ZM15.2839 8.1193C16.6112 8.1193 17.6715 9.17966 17.6715 10.5069C17.6715 11.8342 16.6112 12.8963 15.2839 12.8963C13.9567 12.8963 12.8963 11.8342 12.8963 10.5069C12.8963 9.17966 13.9567 8.1193 15.2839 8.1193ZM4.53699 9.07398C4.27907 9.0704 4.03905 9.20653 3.9083 9.43042C3.77754 9.65252 3.77754 9.92836 3.9083 10.1523C4.03905 10.3762 4.27907 10.5105 4.53699 10.5069H8.83576C9.09369 10.5105 9.3337 10.3762 9.46445 10.1523C9.59521 9.92836 9.59521 9.65252 9.46445 9.43042C9.3337 9.20653 9.09369 9.0704 8.83576 9.07398H4.53699ZM13.851 14.0462C14.2934 14.2271 14.777 14.3292 15.2839 14.3292C15.7908 14.3292 16.2744 14.2271 16.7168 14.0462V16.0953L15.6815 15.4039C15.4415 15.2445 15.1263 15.2445 14.8863 15.4039L13.851 16.0953V14.0462Z" fill="#999999"/>
    </svg>';
    $lesson_list_html .= 'ประกาศนียบัตร</a></li>';
    $lesson_list_html .=  '</ul>';
}
wp_reset_postdata();
?>
<div class="_space"></div>

<div class="course-area">
    <div class="course-sitebar">
        <div class="course-sitebar-header">
            <div class="course-tag">
                <a href="/course">คอร์ส</a>
            </div>
            <?php 
                echo '<a href="'.get_permalink($root_id).'">'. get_the_title($root_id) .'</a>';
            ?>
            <div class="lesson-complate">
                <?php printf( __( '%1$s/%2$s Complete', 'plant' ), count($lessons_id_complete), $count_lession );?>
            </div>
        </div>
        <?php echo $lesson_list_html; ?>
    </div>

    <div class="course-content">
        <div class="card course-info">
            <div class="s-flex justify-between">
                <h3 class="s-title">
                    คำถามท้ายบทเรียน
                </h3>
                <div class="share">
                    <?php if(function_exists('seed_social')) { seed_social();} ?>
                </div>
            </div>
            <div class="questions-forms">
                <?php 
                if( empty($quesion_log) ){
                    $form_question = get_field('questions_forms', $root_id); 
                    echo do_shortcode( '[gravityform id="'.$form_question.'" title="false" description="false" ajax="false"]' );
                }else{
                    echo '<h4 class="text-center">คุณได้ส่งคำตอบเรียบร้อยแล้ว</h4>';
                }
                ?>
            </div>
        </div>
    </div>
</div>