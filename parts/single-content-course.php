<?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('parts/title','minimal');
            echo '<div class="single-content">';
            do_action('plant_before_single_content');
            the_content();
            get_template_part('parts/course','lesson');
            do_action('plant_after_single_content');
            edit_post_link('EDIT', '', '', null, 'btn-edit');
            echo '</div>';
        }
    }
    ?>
<?php
    get_template_part('parts/single', 'meta');
    get_template_part('parts/single', 'author');

    if (comments_open() || get_comments_number()) :
        comments_template();
    endif;

    get_template_part('parts/single', 'related');
?>