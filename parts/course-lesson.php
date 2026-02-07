
<div class="data-lesson">
    <h4>คอร์สนี้เหมาะสำหรับ</h4>
    <div class="sec-box">
        <div>
            <?php if ( have_rows( 'suitable' ) ) : ?>
            <?php while ( have_rows( 'suitable' ) ) : the_row(); ?>
            <ul>
                <li> <?php the_sub_field( 'suitable_for' ); ?></li>
            </ul>
            <?php endwhile; ?>
            <?php else : ?>
                <?php // No rows found ?>
            <?php endif; ?>
        </div>
        <div>
        <p><b>จำนวนบทเรียน</b> : <span><?php the_field( 'number lessons' ); ?></span>  <br class="_mobile"> <b>เวลารวม</b>  : <span><?php the_field( 'time' ); ?></span></p>
        </div>
    </div>
</div>

<div class="entry-lesson">
    <h2 class="s-title">บทเรียน</h2>
    <h4 class="header-lessons">บทเรียนทั้งหมด</h4>
    <?php 
        $arg = array(
            'post_type' => 'course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post_parent' => get_the_ID(),
            'orderby' => 'menu_order',
        );
        $childs = new WP_Query($arg);
        if ($childs->have_posts()) {
            echo '<div class="s-grid">';
            while ($childs->have_posts()) {
                $childs->the_post();
                get_template_part('parts/content','lesson-list');

            }
            echo '</div>';
        }
        wp_reset_postdata();
    ?>
    <div class="data-lesson">
        <b>เอกสารประกอบ</b>
        
        <?php if ( have_rows( 'file_download' ) ) : ?>
            <?php while ( have_rows( 'file_download' ) ) : the_row(); ?>
                <?php $file = get_sub_field( 'file' ); ?>
                <?php if ( $file ) : ?>
                    <p> 
                    <a href="<?php echo esc_url( $file['url'] ); ?>"><?php echo $pdf_title = $file[ 'title' ]; ?></a>
                    </p> 
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <?php // No rows found ?>
        <?php endif; ?>       
        
    </div>

    
    <div class="lerning-recomment">
        <h3 class="s-title">แหล่งความรู้แนะนำ เพื่อศึกษาเพิ่มเติม</h3>
        <div class="s-grid -d3">
            <?php 
            $lerning_list = get_field('lerning_recommend'); 
            if ( is_array( $lerning_list ) && ! empty( $lerning_list ) ) :
                foreach ( $lerning_list as $data ) : ?>
                <article <?php post_class('s-content s-content-card'); ?>>
                    <div class="entry-pic entry-pic-card">
                        <a href="<?php echo $data['title']; ?>" title="Permalink to ">
                            <?php
                                $pic = $data['thumbnail'];
                                echo wp_get_attachment_image( $pic, 'full' );
                            ?>
                        </a>
                    </div>
                    <div class="entry-info entry-info-card">
                        <h2 class="entry-title">
                            <a href="<?php echo $data['link']; ?>"><?php echo $data['title']; ?></a>
                        </h2>
                        <div class="entry-more"><a href="<?php echo $data['link']; ?>" class="btn-readmore -underline"><span></span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a></div>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>