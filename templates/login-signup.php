<?php
/**
 * Template Name: Login / Sign Up
 */

if( !is_user_logged_in() ){

get_header(); 

?>

    <main id="main" class="site-main <?php echo plant_content_width(); ?>">
        <?php echo plant_page_title(); ?>
        <div class="page-content">
            <div class="login-form _heading">
                <div class="logo">
                    <img src="/wp-content/uploads/2023/03/logo-bg-white.webp" alt="hook-logo">
                </div>
                <?php echo do_shortcode( '[nextend_social_login login="1" align="center" redirect="/my-account/"]' ); ?>
            </div>
        </div>  
    </main>

<?php 
    get_footer();                                     
}else{
    wp_redirect( '/my-account' );
}

?>