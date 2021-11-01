<?php

namespace view\topic\score;

use db\TopicQuery;
use lib\Auth;
use lib\Exam;

function index($topic, $questions, $user) {

    $topic = escape($topic);
    $questions = escape($questions);

?>

<h1 class="h2 mb-3">テスト結果 <?php echo "「 {$topic->title} 」"; ?></h1>

<div class="bg-white p-4 shadow mx-auto rounded-lg form-group">

    <?php scoreUpper($topic, $questions, $user); ?>
    <?php scoreLower($questions); ?>

    <?php \partials\back(GO_HOME); ?>

</div>

<?php
}


function scoreUpper($topic, $questions, $user) {

    $questions_count = count($questions);
    $correct_count = printScore();

?>
    <div class="h4 ml-2 py-3">
        <?php
            if(Auth::isLogin() && Auth::hasPermission($topic->id, $user)) {
                TopicQuery::incrementChallengeCount($topic);
            }
        ?>
        <div class="d-flex flex-md-nowrap flex-wrap justify-content-center align-items-center">
            <?php // 左側 ?>
            <div class="text-center h">
                <p class="mb-md-3 mb-2">全問回答終了しました！</p>
                <p>
                    <?php echo "全 {$questions_count} 問中、"; ?>
                        <span class="<?php echo $correct_count ? 'alert-primary' : 'alert-danger'; ?>">
                            <?php echo "&nbsp;{$correct_count} 問 "; ?>
                        </span>
                    <?php echo "&nbsp;正解"; ?>
                </p>
            </div>

            <?php // 右側 ?>
            <div width="200" class="pl-md-3 mt-3 mt-md-0">
                <canvas
                    id="chart"
                    width="200"
                    height="200"
                    data-corrects="<?php echo $correct_count; ?>"
                    data-incorrects="<?php echo $questions_count - $correct_count; ?>"
                >
                </canvas>
            </div>
        </div>
    </div>
<?php
}


function printScore() {

    $exam_result = Exam::getSession();

    if(is_null($exam_result)) {
        return;
    }

    $result_separate = array_count_values($exam_result['answer']);
    $score = $result_separate[CORRECT] ?? 0;

    return $score;
?>

<?php
}


function scoreLower($questions) {

    $exam_result = Exam::getSession();
    $exam_result = escape($exam_result);

    ksort($exam_result['answer']);
    ksort($exam_result['input']);

?>
    <div class="container h6 text-right pr-1">
        <span class="mr-3"><span class="mr-1" style="color: #d7e6fd;">&#9632;</span>正解</span>
        <span class="pr-1 pr-md-2"><span class="mr-1" style="color: #ffd9d7;">&#9632;</span>不正解</span>
    </div>

    <div class="container table-responsive mt-2 px-1">
        <table class="table table-borderless text-center h5">

            <thead class="table-secondary">
                <tr>
                    <th nowrap style="vertical-align: middle">問題</th>
                    <th nowrap style="vertical-align: middle">あなたの回答</th>
                    <th nowrap style="vertical-align: middle">正解</th>
                </tr>
            </thead>
            <?php foreach($questions as $question) : ?>
                <?php if($exam_result['answer'][$question->id] === CORRECT) : ?>
                    <tr class="alert-primary table-bordered border-white score-table-border">
                <?php else : ?>
                    <tr class="alert-danger table-bordered border-white score-table-border">
                <?php endif; ?>
                    <td nowrap style="vertical-align: middle"><?php echo $question->body; ?></td>
                    <td nowrap style="vertical-align: middle"><?php echo $exam_result['input'][$question->id]; ?></td>
                    <td nowrap style="vertical-align: middle"><?php echo $question->answer; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php
}
