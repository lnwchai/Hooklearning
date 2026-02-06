<?php 
get_header(); 
global $post;
$parents = get_post_ancestors($post->ID);

if( $parents || isset($_GET['type']) ){
    $add_class = '-wide';
}
?>
<main id="main" class="site-main single-main <?php echo $add_class; ?>">

</main>

<?php 
get_footer(); 
?>