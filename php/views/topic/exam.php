<?php

namespace view\topic\exam;

use lib\Exam;

function index($topic, $questions) {

    $topic = escape($topic);
    $questions = escape($questions);

?>

    <h1 class="h2 mb-3">テスト中 <?php echo "「 {$topic->title} 」"; ?></h1>

    <div class="bg-white p-4 shadow mx-auto rounded-lg form-group">
        <?php if(!empty($questions)) : ?>
            <ul class="list-unstyled mb-4">
                <?php foreach($questions as $i => $question) : ?>
                    <?php
                        if(!empty($_GET['init'])) {
                            Exam::clearAnswerAndInput();
                        }
                    ?>
                    <li class="bg-white topic shadow-sm mb-3 rounded-lg p-3">
                        <h2 class="h4 mb-2">
                            <span><?php echo $question->body; ?></span>
                            <?php
                                examQuestion($topic, $question, $i);
                            ?>
                        </h2>
                        <div id="answer_disp"></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <?php
                $str = '表示できる問題がありません。';
                \partials\notExist($str);
            ?>
        <?php endif; ?>

        <div class="d-flex align-items-center justify-content-end mx-3">
            <form action="<?php theUrl('topic/score'); ?>" method="GET">
                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                <input type="submit" id="score_btn" class="btn btn-success" value="採点" disabled>
            </form>
        </div>

        <?php \partials\back(GO_HOME); ?>

    </div>

<?php

}


function examQuestion($topic, $question, $i) {
?>
    <form action="" method="">
        <div class="d-flex align-items-center justify-content-between">
            <input class="mt-2 form-control" name="exam_input" type="text" value="<?php echo Exam::flushInput($question); ?>" maxlength="50">
            <div class="mt-2">
                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                <input type="hidden" name="question_id" value="<?php echo $question->id; ?>">
                <input id="<?php echo $i; ?>" name="answer_btn" class="btn btn-primary ml-4" type="submit" value="回答">
            </div>
        </div>
    </form>
<?php
}

