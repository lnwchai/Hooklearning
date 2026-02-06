<?php

// ENQUEUE CSS_JS
function fruit_scripts()
{
    $ver = wp_get_theme()->get('Version');
    $url = get_stylesheet_directory_uri() . '/assets/';
    wp_enqueue_style('f-m', $url . 'css/style-m.css', [], $ver);
    wp_enqueue_style('f-d', $url . 'css/style-d.css', [], $ver, '(min-width: 1024px)');
    wp_enqueue_script('f', $url . 'js/main.js', [], $ver, true);
    wp_enqueue_script('f-player', 'https://player.vimeo.com/api/player.js', [], $ver, false);
    wp_enqueue_script('f-vimeo', $url . 'js/vimeo.js', [], $ver, true);
    wp_enqueue_script('f-cavas', $url . 'js/html2canvas.js', [], $ver);
}
add_action('wp_enqueue_scripts', 'fruit_scripts', 20);

// Change slug author to teacher
add_action('init', 'wp_custom_author_urlbase');
function wp_custom_author_urlbase() {
    global $wp_rewrite;
    $author_slug = 'teacher'; // the new slug name
    $wp_rewrite->author_base = $author_slug;
}

//
add_action( 'wp_ajax_complete_lesson_action', 'complete_lesson_action' );
function complete_lesson_action(){
	$user = wp_get_current_user();
    
    // Check if user is logged in
    if ( !is_user_logged_in() ) {
        wp_die( 'User not logged in' );
    }
    
    $course_id = sanitize_text_field( $_POST['course_id'] );
    $lesson_id = sanitize_text_field( $_POST['lesson_id'] );
    
    // Validate required data
    if ( empty( $course_id ) || empty( $lesson_id ) ) {
        wp_die( 'Missing required data' );
    }
    
    // Check nonce if provided
    if ( isset( $_POST['nonce'] ) ) {
        if ( !wp_verify_nonce( $_POST['nonce'], 'complete_lesson_action' ) ) {
            wp_die( 'Security check failed' );
        }
    }

    $check = check_has_lerning_course($user->ID, $course_id);
    if( $check > 0 ){
        $lesson =  get_field('lessons_id_complete', $check);
        if($lesson) {
            $lesson_array = explode(',', $lesson);
            if(!in_array($lesson_id, $lesson_array)) {
                $lesson .= ',' . $lesson_id;
                update_field('lessons_id_complete', $lesson , $check);
            }
        }else {
            update_field('lessons_id_complete', $lesson_id , $check);
        }
        $pid = $check;
    }else{
        $title = get_the_title( $course_id ) .' '. ' ( ' . $user->display_name . ' )';
        $post = array(
            'post_title' => $title,
            'post_type' => 'course_log',
            'post_status' => 'publish'
        );
        
        $pid = wp_insert_post($post);
        update_field('student', $user->ID , $pid);
        update_field('lessons_id_complete', $lesson_id , $pid);
        update_field('course_id', $course_id , $pid);
    }

    
    $lessons = get_posts(
        array(
            'post_type' => 'course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post_parent' => $course_id,
            'orderby' => 'menu_order',
            'fields' => 'ids'
        )
    );
    
    $key = array_search( $lesson_id, $lessons );
    if( intval($key + 1) < count($lessons) ){
        $next_lesson_id = $lessons[$key + 1];
    }else{
        $next_lesson_id = $lesson_id;
    }

    if($next_lesson_id && $next_lesson_id != $lesson_id) {
        $next_post_url = get_permalink( $next_lesson_id );
        $respone = array('status' => 'next','next_lesson_url' => $next_post_url);
        echo json_encode( $respone );
    }else{
        update_field('course_status', true , $pid);
        echo json_encode( array('status' => 'completed') );
    }
    
    exit();
}

//
add_action( 'wp_ajax_update_user_name', 'update_user_name' );
function update_user_name(){
    $user = wp_get_current_user();
    $first = sanitize_text_field( $_POST['fname'] );
    $last = sanitize_text_field( $_POST['lname'] );

    wp_update_user([
        'ID' => $user->ID, // this is the ID of the user you want to update.
        'first_name' => $first,
        'last_name' => $last,
    ]);
    exit();
}

//
add_action( 'wp_ajax_complete_lesson_action_not_end', 'complete_lesson_action_not_end' );
function complete_lesson_action_not_end(){
	$user = wp_get_current_user();
    
    // Check if user is logged in
    if ( !is_user_logged_in() ) {
        wp_die( 'User not logged in' );
    }
    
    $course_id = sanitize_text_field( $_POST['course_id'] );
    $lesson_id = sanitize_text_field( $_POST['lesson_id'] );
    
    // Validate required data
    if ( empty( $course_id ) || empty( $lesson_id ) ) {
        wp_die( 'Missing required data' );
    }
    
    // Check nonce if provided
    if ( isset( $_POST['nonce'] ) ) {
        if ( !wp_verify_nonce( $_POST['nonce'], 'complete_lesson_action_not_end' ) ) {
            wp_die( 'Security check failed' );
        }
    }

    $check = check_has_lerning_course($user->ID, $course_id);
    if( $check > 0 ){
        $lesson =  get_field('lessons_id_complete', $check);
        if($lesson) {
            $lesson_array = explode(',', $lesson);
            if(!in_array($lesson_id, $lesson_array)) {
                $lesson .= ',' . $lesson_id;
                update_field('lessons_id_complete', $lesson , $check);
            }
        }else {
            update_field('lessons_id_complete', $lesson_id , $check);
        }
        $pid = $check;
    }else{
        $title = get_the_title( $course_id ) .' '. ' ( ' . $user->display_name . ' )';
        $post = array(
            'post_title' => $title,
            'post_type' => 'course_log',
            'post_status' => 'publish'
        );
        
        $pid = wp_insert_post($post);
        update_field('student', $user->ID , $pid);
        update_field('lessons_id_complete', $lesson_id , $pid);
        update_field('course_id', $course_id , $pid);
    }
    
    $lessons = get_posts(
        array(
            'post_type' => 'course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post_parent' => $course_id,
            'orderby' => 'menu_order',
            'fields' => 'ids'
        )
    );
    
    $key = array_search( $lesson_id, $lessons );
    if( intval($key + 1) < count($lessons) ){
        $next_lesson_id = $lessons[$key + 1];
    }else{
        $next_lesson_id = $lesson_id;
    }

    if($next_lesson_id == $lesson_id) {
        update_field('course_status', true , $pid);
    }
    
    echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48698 2 2 6.48698 2 12C2 17.513 6.48698 22 12 22C17.513 22 22 17.513 22 12C22 6.48698 17.513 2 12 2ZM12 3.5C16.7031 3.5 20.5 7.29687 20.5 12C20.5 16.7031 16.7031 20.5 12 20.5C7.29687 20.5 3.5 16.7031 3.5 12C3.5 7.29687 7.29687 3.5 12 3.5ZM15.7344 8.99219C15.5417 9 15.3568 9.08073 15.2187 9.21875L10.75 13.6901L8.78125 11.7187C8.59115 11.5234 8.3125 11.4453 8.04948 11.513C7.78646 11.5807 7.58073 11.7865 7.51302 12.0495C7.44531 12.3125 7.52344 12.5911 7.71875 12.7812L10.2187 15.2812C10.513 15.5729 10.987 15.5729 11.2812 15.2812L16.2812 10.2812C16.5026 10.0651 16.5677 9.73437 16.4479 9.45052C16.3281 9.16667 16.0443 8.98437 15.7344 8.99219Z" fill="currentColor" /></svg>'.get_the_title( $lesson_id );
    exit();
}

// Check has lerning course
function check_has_lerning_course( $user_id, $course_id ){
    $args = array(
        'post_type' => 'course_log',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'student',
                'value'   => $user_id
            ),
            array(
                'key'     => 'course_id',
                'value'   => $course_id
            )
        )
    );

    $log = get_posts( $args );
    return $log[0];
}

add_action( 'wp_ajax_question_answer', 'question_answer' );
function question_answer(){

    // Check if user is logged in
    if ( !is_user_logged_in() ) {
        wp_die( 'User not logged in' );
    }

    if ( !wp_verify_nonce( $_REQUEST['nonce'], "question_answer")) {
        wp_die("No naughty business please");
    }  
    $lesson_id = intval( $_POST['lesson_id'] );
    $answer_data = sanitize_text_field( $_POST['data'] );
    
    // Validate required data
    if ( empty( $lesson_id ) || empty( $answer_data ) ) {
        wp_die( 'Missing required data' );
    }

    // json stringtify to array
    $tempData = html_entity_decode($answer_data);
    $answers = json_decode(stripslashes($tempData));
    
    
    $user = wp_get_current_user();
    $title = get_the_title( $lesson_id ) .' '. ' ( ' . $user->display_name . ' )';

    $post = array(
        'post_title' => $title,
        'post_type' => 'question_log',
        'post_status' => 'publish'
    );
    $pid = post_exists($title);
    if($pid == 0) {
        $pid = wp_insert_post($post);
        update_field('lesson_id', $lesson_id , $pid);
        foreach($answers as $data){
            $row = array(
                'answer' => $data->answer,
                'question' => $data->question
            );
            add_row('answers', $row , $pid);
        }
    }
    $respone = array('message' => __('Successfully','hook'), 'status' => 'success', 'data' => $answer_data);
    echo json_encode( $respone );
    wp_die();
}


// Add shortcode for latest course
add_shortcode('s_latest_course', 'latest_course');
function latest_course($atts){
    $atts = shortcode_atts( array(
        'course_id' => null,
    ), $atts, 's_latest_course' );

    if($atts['course_id'] == null) {
        return;
    }

    $course_id = (int) $atts['course_id'];
    // get course by id
    $course = get_posts(array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'p' => $course_id
    ));
    $arg = array(
        'post_type' => 'course',
        'posts_per_page' => 3,
        'post_parent' => $course_id,
        'order' => 'ASC'

    );
    $lessons = new WP_Query($arg);

    // get permalink
    $course_url = get_permalink( $course_id );
    $author_name = get_the_author_meta( 'display_name', $course[0]->post_author );

    $html = '<div class="s-latest-course">';
    $html .= '<div class="entry-header">';

    $html .= '<h2><a href="'. $course_url .'">'. $course[0]->post_title .'</a></h2>';
    $html .= '<h3>โดย '. $author_name .'</h3>';
    $html .= '</div>';
    $html .= '<div class="entry-content s-grid -d3">';
    while($lessons->have_posts()) {
        $lessons->the_post();
        ob_start();
        get_template_part('parts/content','lesson');
        $html .= ob_get_clean();
    }
    $html .= '</div>';
    $html .= '</div>';
    wp_reset_postdata();
    return $html;
}

add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
    if ( is_singular( 'course' ) ) {
        $post_id = get_the_ID();
        $parents = get_post_ancestors($post->ID);
        if($parents) {
            $classes[] = 's-single-lesson';
        }
        if(isset($_GET['type']) && $_GET['type'] == 'questions'){
            $classes[] = 's-single-questions';
        }
        if(isset($_GET['type']) && $_GET['type'] == 'certificate'){
            $classes[] = 's-single-certificate';
        }
    }
	return $classes;
}

/**
 * This function is update lesson time.
 */
function hook_lesson_time_update(){
    // Check if user is logged in
    if ( !is_user_logged_in() ) {
        wp_die( 'User not logged in' );
    }
    
    $pid = isset( $_POST['pid'] ) ? sanitize_text_field( $_POST['pid'] ) : '';
    $time = isset( $_POST['time'] ) ? floatval( $_POST['time'] ) : 0;

    // Validate required data
    if ( empty( $pid ) ) {
        wp_die( 'Missing required data' );
    }

    $lesson_time_log = get_user_meta( get_current_user_id(), 'lesson_time_log', true );
    $log_array = (array) json_decode($lesson_time_log);

    $log_array[$pid] = $time;    
    update_user_meta( get_current_user_id(), 'lesson_time_log', json_encode($log_array) );
    exit();
}
add_action('wp_ajax_hook_lesson_time_update', 'hook_lesson_time_update');
add_action('wp_ajax_nopriv_hook_lesson_time_update', 'hook_lesson_time_update');

/**
 * 
 */
add_action( 'gform_after_submission', 'create_question_logs', 10, 2 );
function create_question_logs( $entry, $form ) {
    $entry_id = $entry['id'];
    $course_id = rgar( $entry, '3' );
    if ($form['id'] == 12) {
        $course_id = rgar( $entry, '20' );
    }

    $user = wp_get_current_user();
    $title = get_the_title( $course_id ) .' '. ' ( ' . $user->display_name . ' )';

    $post = array(
        'post_title' => $title,
        'post_type' => 'question_log',
        'post_status' => 'publish',
        'post_author' => $user->ID
    );

    $pid = wp_insert_post($post);
    update_field('answers_entry_id', $entry_id , $pid);
    update_field('course_id', $course_id , $pid);
}

add_shortcode( 's_account_login', 'account_login' );
function account_login() {
    // check login wp
    if ( is_user_logged_in() ) {
        // get name login
        $user = wp_get_current_user();
        $name = $user->display_name;
        $html = '<div class="s-account-login">';
        $html .= '<div class="s-account-login__avatar">';
        $html .= '<a href="/my-account/">';
        $html .= '<p>';
        $html .= $user->display_name;
        $html .= '</p>';
        $html .= get_avatar( $user->ID, 50 );
        $html .= '</a>';
        $html .= '</div>';
    }
    else {
        $html = '<div class="s-account-unlogin">';
        $html .= '<a href="/my-account/">เข้าสู่ระบบ/สมาชิก</a>';
        $html .= '</div>';
    }
    return $html;
}



function hook_set_comment_form_defaults( $defaults ) {
	//Here you are able to change the $defaults[]
	//For example: 
	$defaults['title_reply'] = 'แชร์ความเห็นกันหน่อย!';
	
	return $defaults;
}
add_filter( 'comment_form_defaults', 'hook_set_comment_form_defaults' );

//
function get_image_capture(){
    $img = isset( $_POST['image'] ) ? $_POST['image'] : '';
    
    $image = explode(";", $img)[1];
    $image = explode(",", $image )[1];
    $image = str_replace(" ", "+", $image);
    
    $image = base64_decode($image);
    file_put_contents(STYLESHEETPATH."/certificate/cer-".date('Ymdhi').".jpeg", $image);
    
    echo "https://hooklearning.com/wp-content/themes/hook/certificate/cer-".date('Ymdhi').".jpeg";
    exit();
}
add_action('wp_ajax_get_image_capture', 'get_image_capture');
add_action('wp_ajax_nopriv_get_image_capture', 'get_image_capture');




define('PLANT_DISABLE_ACF', true);




//Popup ข้อมูลเพิ่มเติม//
add_filter( 'gform_field_value_user_email', function() {
    $user = wp_get_current_user();
    return $user->user_email;
});

add_filter( 'gform_field_value_user_job', function() {
    return get_user_meta( get_current_user_id(), 'job', true );
});

add_filter( 'gform_field_value_user_age', function() {
    return get_user_meta( get_current_user_id(), 'age', true );
});

add_filter( 'gform_field_value_full_name', function() {
    $user = wp_get_current_user();
    if ( ! $user || ! $user->ID ) {
        return '';
    }
    return trim( $user->first_name . ' ' . $user->last_name );
});
//Popup ข้อมูลเพิ่มเติม//



//แบบประเมิณ

// ส่งสถานะ survey → JS
add_action('wp_footer', function () {

    if (!is_user_logged_in()) return;
    if (!is_singular('course')) return;

    $done = get_field('form_survey', 'user_' . get_current_user_id());
    ?>
    <script>
        window.formSurveyCompleted = <?php echo $done ? 'true' : 'false'; ?>;
    </script>
    <?php
}, 20);

// บันทึกหลังส่ง Gravity Form
add_action('gform_after_submission_16', function () {

    if (!is_user_logged_in()) return;

    update_field(
        'form_survey',
        1,
        'user_' . get_current_user_id()
    );

});





//แบบประเมิณ


