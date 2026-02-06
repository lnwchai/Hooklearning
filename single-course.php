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
            }else{
                get_template_part('parts/single', 'content-course');
            }
        }
        edit_post_link('EDIT', '', '', null, 'btn-edit');
    ?>
    <div class="_space"></div>
</main>

<?php 
get_footer(); 
?>