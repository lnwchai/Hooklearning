<?php 
get_header(); 
global $post;
$parents = get_post_ancestors($post->ID);

if( $parents || isset($_GET['type']) ){
    $add_class = '-wide';
}
?>
<main id="main" class="site-main single-main <?php echo $add_class; ?>">

    <?php 
        if( $parents ) {
            get_template_part('parts/single', 'content-lesson');
        }else {
            if(isset($_GET['type']) && $_GET['type'] == 'questions'){
                get_template_part('parts/single', 'content-questions');
            }else if(isset($_GET['type']) && $_GET['type'] == 'certificate'){
                get_template_part('parts/single', 'content-certificate');
            }else if(isset($_GET['type']) && $_GET['type'] == 'pre_test'){
                get_template_part('parts/single', 'content-pre-test');
            }else if(isset($_GET['type']) && $_GET['type'] == 'post_test'){
                get_template_part('parts/single', 'content-post-test');
            }else{
                get_template_part('parts/single', 'content-course');
            }
        }
        edit_post_link('EDIT', '', '', null, 'btn-edit');
    ?>
    <div class="_space"></div>
</main>

<?php 
$survay = get_survey_form_entry ();
$course_log = user_course_log();
if(count($course_log) > 0 && count($survay) == 0 ) : ?>
<div id="survey-modal" class="s-modal-survey-wrap">
    <div class="s-modal-survey-bg"></div>
    <div class="s-modal-survey" role="dialog" aria-modal="true" aria-labelledby="survey-modal-title">
        <button type="button" class="btn-close-modal s-modal-survey-close" aria-label="Close">&times;</button>
        <h2 id="survey-modal-title" class="s-modal-survey-title">แบบประเมินความพึงพอใจ</h2>
        <div class="s-modal-survey-content">
            <?php echo do_shortcode( '[gravityform id="16" title="false" description="false" ajax="false"]' ); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php 
get_footer(); 
?>