<?php
/**
 * Template Name: Download cert
 */

if( !is_user_logged_in() ){
    wp_redirect( '/account' );
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class('landing-page'); ?>>
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'seed' ); ?></a>
        <div id="page" class="site">
            <div id="content" class="site-content">
                <!-- <div class="s-container"> -->
                    <div id="primary" class="content-area">
                        <main id="main">

                        <?php
                            $cer_id = intval( $_GET['logid'] );
                            $uid = get_field('student', $cer_id);
                            $user_data = get_userdata( $uid );

                            $first_name = $user_data->first_name;
                            $last_name = $user_data->last_name;
                        ?>

                        <div class="cert-content" id="capture">
                            <img src="https://hooklearning.com/wp-content/uploads/2023/07/cer-03.jpg" alt="">
                            <div class="info">
                                <h4><?php echo get_the_title( get_field('course_id', $cer_id) ); ?></h4>
                                <h3><?php echo $first_name.' '.$last_name; ?></h3>
                                <h4>ได้เข้าร่วมอบรมหลักสูตรดังกล่าวในวันที่ <?php echo date_i18n( 'd F Y' ); ?></h4>
                            </div>   
                        </div>

                        </main>
                    </div>
                <!-- </div> -->
            </div>
        </div>

        <script>
            function doCapture() {
                // window.scrollTo(0, 0);  
                html2canvas(document.getElementById("capture")).then(function (canvas) {
                    // Create an AJAX object
                    var ajax = new XMLHttpRequest();
                    ajax.open("POST", "/wp-admin/admin-ajax.php", true);
                    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajax.send("action=get_image_capture&image=" + canvas.toDataURL("image/jpeg", 1.0));
                    ajax.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    };
                });
            }
        </script>
        
        <button onclick="doCapture();">Capture</button>
        <?php wp_footer(); ?>

    </body>
</html>