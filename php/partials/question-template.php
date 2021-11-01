<?php

namespace partials;

use model\QuestionModel;

function questionTemplate($topic, $questions, $is_edit, $before_input = null) {

    $header_title = $is_edit ? '問題編集' : '問題作成';

?>

    <h1 class="h2 mb-3"><?php echo "{$header_title} 「 {$topic->title} 」"; ?></h1>
    <div class="bg-white p-4 shadow mx-auto rounded-lg">
        <?php

        if($is_edit) {

            if(!empty($questions)) {
                questionMain($topic, $questions, $is_edit);
            } else {
                $str = '登録されている問題がありません。';
                \partials\notExist($str);
            }

        } else {
            questionMain($topic, $questions, $is_edit, $before_input);
        }

        questionBelow($topic, $is_edit);

        ?>
    </div>

<?php
}


function questionMain($topic, $questions, $is_edit, $before_input = null) {
?>

    <ul class="list-unstyled mb-4">
        <?php
            if($is_edit) {

                foreach($questions as $question_no => $question) {
                    questionForm($topic, $is_edit, $question_no, $question);
                }

            } else {

                $new_question_no = $questions ? count($questions) + 1 : 1;

                if(!$before_input) {
                    $before_input = new QuestionModel;
                    $before_input->body = '';
                    $before_input->answer = '';
                }

                questionForm($topic, $is_edit, $new_question_no, $before_input);

                if(!empty($questions)) {
                    printExistingQuestion($questions);
                }

            }
        ?>
    </ul>

<?php
}


function questionForm($topic, $is_edit, $question_no, $question) {
?>

    <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">
        <li class="bg-white topic shadow-sm mb-3 rounded-lg p-3">
            <div class="form-group">
                <?php questionBody($is_edit, $question_no, $question->body); ?>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <?php questionAnswer($question->answer); ?>
                <div class="invalid-feedback"></div>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <div>
                    <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                    <?php if($is_edit) : ?>
                        <input type="hidden" name="question_no" value="<?php echo $question_no; ?>">
                        <input type="submit" name="type" value="問題更新" class="btn btn-primary my-2 mr-3 shadow-sm" >
                        <input type="submit" name="type" value="問題削除" class="btn btn-light my-2 shadow-sm" >
                    <?php else : ?>
                        <input type="submit" name="type" value="問題作成" class="btn btn-primary my-2 mr-3 shadow-sm" >
                    <?php endif; ?>
                </div>
            </div>
        </li>
    </form>

<?php
}


function questionBody($is_edit, $question_no, $question_body) {
?>

    <?php if($is_edit) : ?>
        <label for="question">問題 <?php echo $question_no + 1; ?></label>
    <?php else : ?>
        <label for="question">問題 <?php echo $question_no; ?></label>
    <?php endif; ?>
    <input type="text" id="question" name="body" value="<?php echo $question_body; ?>" class="form-control validate-target" placeholder="問題を入力してください。" maxlength="50" autofocus required/>


<?php
}


function questionAnswer($question_answer) {
?>

    <label for="answer">解答</label>
    <input type="text" id="answer" name="answer" value="<?php echo $question_answer; ?>" class="form-control validate-target" placeholder="解答を入力してください。" maxlength="50" required/>

<?php
}


function printExistingQuestion($questions) {
?>

    <ul class="list-unstyled my-5">
        <?php foreach($questions as $question_no => $question) : ?>
            <li class="bg-light shadow-sm mb-3 rounded-lg p-3">
                <div class="form-group">
                    <label for="question">問題 <?php echo $question_no + 1; ?></label>
                    <input type="text" id="question" name="body" value="<?php echo $question->body; ?>" class="form-control" disabled/>
                </div>
                <div class="form-group">
                    <label for="answer">解答</label>
                    <input type="text" id="answer" name="answer" value="<?php echo $question->answer; ?>" class="form-control" disabled/>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

<?php
}


function questionBelow($topic, $is_edit) {

    $action = 'question/create?topic_id=' . $topic->id;
    $value = '問題追加';
    $href_true = 'topic/edit?topic_id=' . $topic->id;
    $href_false = 'question/edit?topic_id=' . $topic->id;

    \partials\below($topic, $is_edit, $action, $value, $href_true, $href_false);

?>
<?php
}

