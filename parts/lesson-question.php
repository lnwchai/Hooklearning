<?php 
$current_id = get_the_ID();
$args = array(
    'post_type' => 'question_log',
    'posts_per_page' => 1,
    'author' => get_current_user_id(),
    'meta_query' => array(
        array(
            'key' => 'lesson_id',
            'value' => $current_id,
            'compare' => '='
        ),
    )
);
$quesion_log = get_posts($args);
?>

<?php if(have_rows('questions')): ?>
<div class="card course-question">
    <h3 class="s-title">คำถามท้ายบทเรียน</h3>
    <div class="questions">
        <?php 
            if($quesion_log){
                echo 'ตอบคำถามแล้ว';
            }
            else {
                $quesion_no = 1;
                while(have_rows('questions')): the_row();
                $answer_type = get_sub_field('answer_type');
                $question = get_sub_field('question');
                echo '<div class="question" data-type="'.$answer_type.'">';
                echo '<div class="question-title">'. $question .'</div>';
                echo '<div class="question-answer">';
                if($answer_type == 'text') {
                    echo '<textarea class="lesson-answer" id="answer-'.$quesion_no.'" rows="5"></textarea>';
                }
                else if(have_rows('choices')) {
                    $choice_no = 1;
                    while(have_rows('choices')) {
                        the_row();
                        $choice = get_sub_field('item');
                        $label = '<label for="choice-'.$quesion_no .'-'.$choice_no.'">'.$choice.'</label>';
                        $checkbox = '<input type="radio" name="choice-'.$quesion_no.'" id="choice-'.$quesion_no .'-'.$choice_no.'" value="'.$choice.'">';
                        echo '<div class="choice-item">';
                        echo $checkbox;
                        echo $label;
                        echo '</div>';
                        $choice_no++;
                    }
                }
                $quesion_no++;
                echo '</div>';
                echo '</div>';
                endwhile;
                
                // SUBMIT ANSWER
                $nonce_answer = wp_create_nonce( 'question_answer' );
                if( !$quesion_log ) :
                    echo '<div class="text-right">';
                    echo '<button class="s-btn btn-answer-question" data-nonce="'.$nonce_answer.'" data-lesson="'.$current_id.'">ส่งคำตอบ</button>';
                    echo '</div>';
                endif;
            }
        ?>
    </div>
</div>
<?php endif; ?>