<style>
.title-space {
    height: 24px;
}
</style>
<?php $author_id = get_the_author_ID(); ?>
<header class="s-title-minimal">
    <div class="title-space"></div>
    <div class="single-header-meta">
        <div class="single-cat">
            <?php echo plant_cat(); ?>
        </div>
    </div>
    <h1><?php the_title(); ?></h1>
    <div class="author-name">โดย <a href="<?php echo get_author_posts_url($author_id); ?>"> <?php the_author_meta( 'display_name', $author_id ); ?></a></div>
    <?php 
        $reference = get_field('reference');
        $photographer = get_field('photographer');
        if($reference && $photographer){
            echo '<p>ที่มา: '.$reference.' / ภาพ: '.$photographer.'</p>';
        }
        else if($reference){
            echo '<p>ที่มา: '.$reference.'</p>';
        }
        else if($photographer){
            echo '<p>ภาพ: '.$photographer.'</p>';
        }
        
    ?>
    <div class="s-flex justify-between entry-meta single-meta">
        <div class="s-flex items-center s-title">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.20833 2.5C3.72024 2.5 2.5 3.72024 2.5 5.20833V14.7917C2.5 16.2798 3.72024 17.5 5.20833 17.5H14.7917C16.2798 17.5 17.5 16.2798 17.5 14.7917V5.20833C17.5 3.72024 16.2798 2.5 14.7917 2.5H5.20833ZM5.20833 3.75H14.7917C15.6045 3.75 16.25 4.39546 16.25 5.20833V5.83333H3.75V5.20833C3.75 4.39546 4.39546 3.75 5.20833 3.75ZM3.75 7.08333H16.25V14.7917C16.25 15.6045 15.6045 16.25 14.7917 16.25H5.20833C4.39546 16.25 3.75 15.6045 3.75 14.7917V7.08333ZM6.45833 8.75C5.88356 8.75 5.41667 9.21689 5.41667 9.79167C5.41667 10.3664 5.88356 10.8333 6.45833 10.8333C7.03311 10.8333 7.5 10.3664 7.5 9.79167C7.5 9.21689 7.03311 8.75 6.45833 8.75ZM10 8.75C9.42522 8.75 8.95833 9.21689 8.95833 9.79167C8.95833 10.3664 9.42522 10.8333 10 10.8333C10.5748 10.8333 11.0417 10.3664 11.0417 9.79167C11.0417 9.21689 10.5748 8.75 10 8.75ZM13.5417 8.75C12.9669 8.75 12.5 9.21689 12.5 9.79167C12.5 10.3664 12.9669 10.8333 13.5417 10.8333C14.1164 10.8333 14.5833 10.3664 14.5833 9.79167C14.5833 9.21689 14.1164 8.75 13.5417 8.75ZM6.45833 12.5C5.88356 12.5 5.41667 12.9669 5.41667 13.5417C5.41667 14.1164 5.88356 14.5833 6.45833 14.5833C7.03311 14.5833 7.5 14.1164 7.5 13.5417C7.5 12.9669 7.03311 12.5 6.45833 12.5ZM10 12.5C9.42522 12.5 8.95833 12.9669 8.95833 13.5417C8.95833 14.1164 9.42522 14.5833 10 14.5833C10.5748 14.5833 11.0417 14.1164 11.0417 13.5417C11.0417 12.9669 10.5748 12.5 10 12.5Z"
                    fill="#333333" />
            </svg>
            <?php echo plant_date(); ?>
        </div>
        <div class="s-flex items-center">
            <?php _e('Share','hook'); ?>
            <?php if(function_exists('seed_social')) { seed_social();} ?>
        </div>
        <?php do_action('plant_end_single_date'); ?>
    </div>

</header>