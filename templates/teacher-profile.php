<?php
/**
 * Template Name: Teacher Profile
 */


get_header(); 

?>

<main id="main" class="site-main <?php echo plant_content_width(); ?>">
    <?php// echo plant_page_title(); ?>

    <!-- banner -->
    <div class="banner alignfull">
        <img src="https://hook.todsorb.dev/wp-content/uploads/2023/03/banner-page.png" alt="banner">
    </div>

    <div class="s-container teacher-profile">
        <div class="profile">
            <!-- image -->
            <img  class="profile-img" src="https://hook.todsorb.dev/wp-content/uploads/2023/04/img-todsorb.webp" alt="">

            <!-- badge -->
            <p class="badge">Teacher</p>

            <!-- name and rating -->
            <div class="name">

                <!-- name -->
                <h3>Jessie P.</h3>

                <!-- rating -->
                <img src="/wp-content/themes/hook/assets/img/star.svg">
                <p>4.1</p>

            </div>

            <!-- subject -->
            <p class="subject">Psychology</p>

            <!-- lessons  -->
            <div class="lessons">
                <img src="/wp-content/themes/hook/assets/img/study.svg">
                <p>3 Lessons</p>
            </div>

            <!-- social -->
            <div class="social">
                <a src="#">
                    <img src="/wp-content/themes/hook/assets/img/facebook.svg">
                </a>
                <a src="#"> 
                    <img src="/wp-content/themes/hook/assets/img/twitter.svg">
                </a>
                <a src="#">                    
                    <img src="/wp-content/themes/hook/assets/img/mail.svg">
                </a>
                <a src="#">                    
                    <img src="/wp-content/themes/hook/assets/img/line.svg">
                </a>
            </div>
        </div>
        <div class="about">
            <h2 class="heading">เกี่ยวกับฉัน</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua</p>
        </div>
    </div>


    <div class="" style="height:1000px">
        <h2 class="heading">คอร์สเรียนทั้งหมด</h2>

        <?php 
            do_shortcode('[s_loop template="card" category_name="library" posts_per_page="3" css="s-grid -d3"]');
        ?>

        <div>

</main>

<?php 
    get_footer();                                     
?>