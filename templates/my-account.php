<?php 
/**
 * Template Name: My Account
 */

if( is_user_logged_in() ){

    get_header(); 

    //get data user
    $current_user = wp_get_current_user();

    //get icon
    $i_finish = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M10.25 1.5C9.10156 1.5 8.15365 2.38281 8.02604 3.5H6.25C5.01042 3.5 4 4.50781 4 5.75V19.25C4 20.4896 5.01042 21.5 6.25 21.5H12.3828C12.026 21.0443 11.7266 20.5417 11.5 20H6.25C5.83594 20 5.5 19.6641 5.5 19.25V5.75C5.5 5.33594 5.83594 5 6.25 5H8.38542C8.79167 5.60156 9.47656 6 10.25 6H13.75C14.5234 6 15.2083 5.60156 15.6146 5H17.75C18.1641 5 18.5 5.33594 18.5 5.75V11.0859C19.0234 11.1667 19.526 11.3021 20 11.5V5.75C20 4.50781 18.9896 3.5 17.75 3.5H15.974C15.8464 2.38281 14.8984 1.5 13.75 1.5H10.25ZM10.25 3H13.75C14.1745 3 14.5 3.32552 14.5 3.75C14.5 4.17448 14.1745 4.5 13.75 4.5H10.25C9.82552 4.5 9.5 4.17448 9.5 3.75C9.5 3.32552 9.82552 3 10.25 3ZM8.25 8C7.97917 7.9974 7.72917 8.13802 7.59115 8.3724C7.45573 8.60677 7.45573 8.89323 7.59115 9.1276C7.72917 9.36198 7.97917 9.5026 8.25 9.5H15.75C16.0208 9.5026 16.2708 9.36198 16.4089 9.1276C16.5443 8.89323 16.5443 8.60677 16.4089 8.3724C16.2708 8.13802 16.0208 7.9974 15.75 8H8.25ZM8.25 11C7.97917 10.9974 7.72917 11.138 7.59115 11.3724C7.45573 11.6068 7.45573 11.8932 7.59115 12.1276C7.72917 12.362 7.97917 12.5026 8.25 12.5H11.75C12.0208 12.5026 12.2708 12.362 12.4089 12.1276C12.5443 11.8932 12.5443 11.6068 12.4089 11.3724C12.2708 11.138 12.0208 10.9974 11.75 11H8.25ZM17.5 12C14.4635 12 12 14.4635 12 17.5C12 20.5365 14.4635 23 17.5 23C20.5365 23 23 20.5365 23 17.5C23 14.4635 20.5365 12 17.5 12ZM20.5 15C20.6276 15 20.7552 15.0495 20.8542 15.1458C21.0495 15.3411 21.0495 15.6589 20.8542 15.8542L16.8542 19.8542C16.7552 19.9505 16.6276 20 16.5 20C16.3724 20 16.2448 19.9505 16.1458 19.8542L14.1458 17.8542C13.9505 17.6589 13.9505 17.3411 14.1458 17.1458C14.3411 16.9505 14.6589 16.9505 14.8542 17.1458L16.5 18.7943L20.1458 15.1458C20.2448 15.0495 20.3724 15 20.5 15Z" fill="#6842EF"/>
    </svg>
    ';

    $i_cert = '<svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2.7 0C1.2114 0 0 1.21779 0 2.71425V16.5871C0 18.0836 1.2114 19.3013 2.7 19.3013H8.60977C8.00797 18.8122 7.51636 18.1945 7.16836 17.4918H2.7C2.2038 17.4918 1.8 17.0859 1.8 16.5871V2.71425C1.8 2.21543 2.2038 1.8095 2.7 1.8095H21.3C21.7962 1.8095 22.2 2.21543 22.2 2.71425V16.5871C22.2 17.0859 21.7962 17.4918 21.3 17.4918H16.8316C16.4836 18.1945 15.992 18.8122 15.3902 19.3013H21.3C22.7886 19.3013 24 18.0836 24 16.5871V2.71425C24 1.21779 22.7886 0 21.3 0H2.7ZM5.1 4.22217C4.98074 4.22047 4.86233 4.24262 4.75166 4.28733C4.64099 4.33204 4.54026 4.39841 4.45533 4.48259C4.3704 4.56678 4.30295 4.66709 4.25692 4.7777C4.21089 4.88831 4.18718 5.00702 4.18718 5.12692C4.18718 5.24682 4.21089 5.36553 4.25692 5.47614C4.30295 5.58675 4.3704 5.68707 4.45533 5.77125C4.54026 5.85543 4.64099 5.9218 4.75166 5.96651C4.86233 6.01122 4.98074 6.03337 5.1 6.03167H18.9C19.0193 6.03337 19.1377 6.01122 19.2483 5.96651C19.359 5.9218 19.4597 5.85543 19.5447 5.77125C19.6296 5.68707 19.697 5.58675 19.7431 5.47614C19.7891 5.36553 19.8128 5.24682 19.8128 5.12692C19.8128 5.00702 19.7891 4.88831 19.7431 4.7777C19.697 4.66709 19.6296 4.56678 19.5447 4.48259C19.4597 4.39841 19.359 4.33204 19.2483 4.28733C19.1377 4.24262 19.0193 4.22047 18.9 4.22217H5.1ZM6.3 7.84117C6.18074 7.83948 6.06233 7.86163 5.95166 7.90633C5.84099 7.95104 5.74026 8.01742 5.65533 8.1016C5.5704 8.18578 5.50295 8.28609 5.45692 8.3967C5.41089 8.50731 5.38718 8.62602 5.38718 8.74592C5.38718 8.86583 5.41089 8.98453 5.45692 9.09515C5.50295 9.20576 5.5704 9.30607 5.65533 9.39025C5.74026 9.47443 5.84099 9.54081 5.95166 9.58551C6.06233 9.63022 6.18074 9.65237 6.3 9.65067H17.7C17.8193 9.65237 17.9377 9.63022 18.0483 9.58551C18.159 9.54081 18.2597 9.47443 18.3447 9.39025C18.4296 9.30607 18.497 9.20576 18.5431 9.09515C18.5891 8.98453 18.6128 8.86583 18.6128 8.74592C18.6128 8.62602 18.5891 8.50731 18.5431 8.3967C18.497 8.28609 18.4296 8.18578 18.3447 8.1016C18.2597 8.01742 18.159 7.95104 18.0483 7.90633C17.9377 7.86163 17.8193 7.83948 17.7 7.84117H6.3ZM12 10.857C9.69106 10.857 7.8 12.7581 7.8 15.0792C7.8 16.5047 8.51477 17.77 9.6 18.5356V20.8093C9.6 21.132 9.77046 21.4299 10.0477 21.5915C10.3255 21.7538 10.6681 21.7555 10.9465 21.595L12 20.9895L13.0535 21.595C13.1915 21.6747 13.3458 21.714 13.5 21.714C13.656 21.714 13.8125 21.6735 13.9523 21.5915C14.2295 21.4299 14.4 21.132 14.4 20.8093V18.5356C15.4852 17.77 16.2 16.5047 16.2 15.0792C16.2 12.7581 14.3089 10.857 12 10.857ZM12 12.6665C13.3361 12.6665 14.4 13.736 14.4 15.0792C14.4 16.4224 13.3361 17.4918 12 17.4918C10.6639 17.4918 9.6 16.4224 9.6 15.0792C9.6 13.736 10.6639 12.6665 12 12.6665Z" fill="#6842EF"/>
    </svg>
    ';

    $i_study = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M6.25 2C5.01042 2 4 3.01042 4 4.25V19.75C4 20.9896 5.01042 22 6.25 22H17.75C18.9896 22 20 20.9896 20 19.75V4.25C20 3.09375 19.1224 2.15104 18 2.02604V3.54687C18.2917 3.65104 18.5 3.92448 18.5 4.25V19.75C18.5 20.1641 18.1641 20.5 17.75 20.5H6.25C5.83594 20.5 5.5 20.1641 5.5 19.75V4.25C5.5 3.83594 5.83594 3.5 6.25 3.5H9V2H6.25ZM10 2V10.25C10 10.5156 10.1406 10.7604 10.3672 10.8958C10.5938 11.0286 10.8776 11.0339 11.1094 10.9089L13.5 9.60417L15.8906 10.9089C16.1224 11.0339 16.4062 11.0286 16.6328 10.8958C16.8594 10.7604 17 10.5156 17 10.25V2H10ZM11.5 3.5H15.5V8.98698L13.8594 8.09115C13.6354 7.96875 13.3646 7.96875 13.1406 8.09115L11.5 8.98698V3.5ZM8.75 12.5C8.47917 12.4974 8.22917 12.638 8.09115 12.8724C7.95573 13.1068 7.95573 13.3932 8.09115 13.6276C8.22917 13.862 8.47917 14.0026 8.75 14H15.25C15.5208 14.0026 15.7708 13.862 15.9089 13.6276C16.0443 13.3932 16.0443 13.1068 15.9089 12.8724C15.7708 12.638 15.5208 12.4974 15.25 12.5H8.75ZM8.75 16C8.47917 15.9974 8.22917 16.138 8.09115 16.3724C7.95573 16.6068 7.95573 16.8932 8.09115 17.1276C8.22917 17.362 8.47917 17.5026 8.75 17.5H13.25C13.5208 17.5026 13.7708 17.362 13.9089 17.1276C14.0443 16.8932 14.0443 16.6068 13.9089 16.3724C13.7708 16.138 13.5208 15.9974 13.25 16H8.75Z" fill="#6842EF"/>
    </svg>
    ';

    // get role user 
    $user = new WP_User( $current_user->ID );
    $role = implode(', ', $user->roles);

    //other data
    $lesson_finish_num = '0';
    $lesson_cert_num = [];
    $lesson_study_num = '0';
    $courses_id = array();

    //loop course log for this student
    $args = array(
        'post_type' => 'course_log',
        'post_parent' => 0,
        'posts_per_page' => -1,
        'meta_key'      => 'student',
        'meta_value'    => $current_user->ID
    );

    $the_status = new WP_Query( $args );
    while ( $the_status->have_posts() ) {
        $the_status->the_post();

        $lessons_id_complete = get_field('lessons_id_complete');
        $course_status = get_field('course_status');
        $course_id = get_field('course_id');

        //count course status
        if($course_status){
            $lesson_finish_num += 1;
        }else{
            $lesson_study_num += 1;
        }

        //get course id
        if($course_id){
            $courses_id[] = $course_id->ID;
        }
    }                
    wp_reset_postdata();

    // Course Complete
    $args = array(
        'post_type' => 'course_log',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'student',
                'value' => $current_user->ID,
            ),
            array(
                'key' => 'course_status',
                'value' => true,
            )
        )
    );

    $log_complete = new WP_Query( $args );
    while ( $log_complete->have_posts() ) {
        $log_complete->the_post();
        $course_id = get_field('course_id');
        $args = array(
            'post_type' => 'question_log',
            'posts_per_page' => 1,
            'author' => $current_user->ID,
            'meta_query' => array(
                array(
                    'key' => 'course_id',
                    'value' => $course_id->ID
                )
            )
        );
        $quesion_log = get_posts($args);
        if( !empty($quesion_log) ){
            $lesson_cert_num[] = get_the_ID();
        }
    }                
    wp_reset_postdata();


?>
<div class="page-banner alignfull">
    <img src="/wp-content/uploads/2023/03/banner-page.webp" alt="banner">
</div>

<main id="main" class="site-main <?php echo plant_content_width(); ?>">
    <?php echo plant_page_title(); ?>
    <div class="page-content">

        <div class="user-item s-grid -d2">
            <div class="pic">
                <?php echo get_avatar( $current_user->ID, '254', '', '', $args = array( 'class' => 'avatar' ) ); ?>
                <h2 class="name"><?php echo $current_user->first_name; ?> <?php echo $current_user->last_name; ?></h2>
                <div class="edit">
                    <a href="#" class="edit-name">
                        <h4>แก้ไขชื่อ-นามสกุล</h4>
                    </a>
                    <a href="<?php echo wp_logout_url('/my-account'); ?>" class="logout">
                        <h4>ออกจากระบบ</h4>
                    </a>
                </div>
            </div>
            <div class="info">
                <h3 class="s-title">เกี่ยวกับฉัน</h3>
                <div class="about s-grid">
                    <div class="item">
                    <p>ชื่อ: <?php echo esc_html( get_user_meta($current_user->ID, 'first_name', true) ); ?></p>
                    <p>นามสกุล: <?php echo esc_html( get_user_meta($current_user->ID, 'last_name', true) ); ?></p>
                    <p>อายุ: <?php echo esc_html( get_user_meta($current_user->ID, 'age', true) ); ?></p>
                    <p>เพศ: <?php echo esc_html( get_user_meta($current_user->ID, 'gender', true) ); ?></p>
                    <p>อาชีพ: <?php echo esc_html( get_user_meta($current_user->ID, 'job', true) ); ?></p>
                    <p>สังกัด: <?php echo esc_html( get_user_meta($current_user->ID, 'organization', true) ); ?></p>
                    <p>เกี่ยวข้องกับเด็ก: <?php echo esc_html( get_user_meta($current_user->ID, 'child_role', true) ); ?></p>
                    <p>เป้าหมายในการใช้เว็บไซต์: <?php echo esc_html( get_user_meta($current_user->ID, 'goal_hook_learning', true) ); ?></p>
                    <p>
                    <?php
                        $privacy_values = get_field('privacy_policy', 'user_' . get_current_user_id());

                        if (!empty($privacy_values)) :
                            foreach ($privacy_values as $value) :
                        ?>
                                <p>✔ <?php echo esc_html($value); ?></p>
                        <?php
                            endforeach;
                        else :
                        ?>
                            <p>✘ ยังไม่ยอมรับข้อกำหนด</p>
                        <?php endif; ?>
                    </p>
                    </div>
                </div>
                <h3 class="s-title">เกี่ยวคอร์สเรียน</h3>
                <div class="about s-grid -d2">
                    <div class="item">
                        <?php echo $i_finish.$lesson_finish_num.'<span>คอร์ส เรียนสำเร็จ</span>';?>
                    </div>
                    <div class="item">
                        <?php echo $i_cert.count($lesson_cert_num).'<span>ประกาศนียบัตร</span>';?>
                    </div>
                    <div class="item">
                        <?php echo $i_study.$lesson_study_num.'<span>คอร์ส กำลังเรียนอยู่</span>';?>
                    </div>
                </div>
            </div>
        </div>

        <div class="s-course s-sec">
            <h3 class="s-title">คอร์สเรียนของฉัน</h3>
            <div class="s-grid -m1 -d3 s-courses">
                <?php
                    if( count($courses_id) > 0 ){ 
                        $args = array(
                            'post_type' => 'course',
                            'post_parent' => 0,
                            'posts_per_page' => -1,
                            'post__in' => $courses_id
                        );
                        $the_query = new WP_Query( $args );
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            get_template_part( 'parts/content', 'card' );
                        }
                        wp_reset_postdata();
                    }else{
                        echo '<p>ไม่มีคอร์สเรียนของฉัน</p>';
                    }
                ?>
            </div>
        </div>

        <div class="s-cert s-sec">
            <h3 class="s-title">ประกาศนียบัตร</h3>
            <div class="s-grid -m1 -d3">
                <?php    
                if( count($lesson_cert_num) > 0 ){         
                    $args = array(
                        'post_type' => 'course_log',
                        'posts_per_page' => -1,
                        'post__in' => $lesson_cert_num
                    );
                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        get_template_part( 'parts/content', 'certificate' );
                    }
                    wp_reset_postdata();
                }else{
                    echo '<p>ไม่มีประกาศนียบัตร</p>';
                }
                ?>
            </div>
        </div>

    </div>
</main>

<div class="form-edit-name" style="display: none;">
    <form class="edit-users">
        <h3>แก้ไขชื่อ-นามสกุล</h3>
        <input type="hidden" name="action" value="update_user_name">
        <div class="input-group">
            <label for="">ชื่อ</label>
            <input type="text" name="firstname">
        </div>
        <div class="input-group">
            <label for="">นามสกุล</label>
            <input type="text" name="lastname">
        </div>
        <div class="btn-group s-grid -t2 -d2">
            <a href="#" class="clsoe"><h4>ยกเลิก</h4></a>
            <button type="submit">บันทึก</button>
        </div>
    </form>
</div>

<?php
$lastname = get_user_meta($current_user->ID, 'last_name', true);
$age = get_user_meta($current_user->ID, 'age', true);
$job = get_user_meta($current_user->ID, 'job', true);

if ($lastname  == '' && $age == '' && $job == '')  : ?>
<div id="survey-modal" class="s-modal-survey-wrap">
    <div class="s-modal-survey-bg"></div>
    <div class="s-modal-survey" role="dialog" aria-modal="true" aria-labelledby="survey-modal-title">
        <button type="button" class="btn-close-modal s-modal-survey-close" aria-label="Close">&times;</button>
        <h2 id="survey-modal-title" class="s-modal-survey-title">ข้อมูลส่วนตัว</h2>
        <div class="s-modal-survey-content">
            <?php echo do_shortcode( '[gravityform id="15" title="false" description="false" ajax="false"]' ); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('gform_confirmation_loaded', function () {
    const popup = document.getElementById('profile-popup');
    if (popup) popup.remove();
});
</script>

<?php get_footer();                                     
}else{
    wp_redirect( '/login-signup' );
}

?>