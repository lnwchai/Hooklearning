<article id="post-<?php the_ID(); ?>" <?php post_class('s-content s-content-card'); ?>>
    <div class="s-contant-list">
        <div class="entry-header">
            <h2>Design Thinking for Student Life</h2>
            แนะแนวชีวิตด้วยแนวคิดนักออกแบบ
            โดย เมษ์ ศรีพัฒนาสกุล
            <a href="<?php the_permalink(); ?>">
                ดูทั้งหมด
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.98962 2.25784C5.99483 2.45575 6.07556 2.64325 6.21879 2.78127L15.4401 12L6.21879 21.2188C6.07556 21.362 5.99223 21.5547 5.99223 21.7578C5.99223 22.0625 6.17712 22.3386 6.46098 22.4531C6.74223 22.5677 7.06775 22.5 7.28129 22.2813L17.0313 12.5313C17.323 12.237 17.323 11.763 17.0313 11.4688L7.28129 1.71877C7.06514 1.49742 6.73702 1.42711 6.45056 1.5469C6.1641 1.66669 5.98181 1.94794 5.98962 2.25784Z"
                        fill="#6842EF" />
                </svg>
            </a>
        </div>
        <div class="entry-card">
            <?php 
                $argc = array(
                    'post_type' => 'lesson',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $query = new WP_Query($argc);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        get_template_part('parts/content','card');
                    }
                }
            ?>
        </div>
    </div>
</article>