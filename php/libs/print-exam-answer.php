<?php

namespace lib;

use db\QuestionQuery;
use model\QuestionModel;
use model\TopicModel;

if(!empty($_GET['pea'])) {
    printExamAnswerBackEnd();
}

function printExamAnswerBackEnd() {

    $input = $_POST['input'];
    $topic_id = $_POST['topic_id'];
    $question_id = $_POST['question_id'];

    $topic = new TopicModel;
    $topic->id = $topic_id;

    $question = new QuestionModel;
    $question->id = $question_id;
    $question = QuestionQuery::fetchByQuestionId($question);

    $cls[] = "alert";

    if($input === $question->answer) {
        $answer = CORRECT;
        $answer_text = "正解！";
        $cls[] = "alert-primary";
    } else {
        $answer = INCORRECT;
        $answer_text = "不正解...正解は「 {$question->answer} 」です。";
        $cls[] = "alert-danger";
    }

    Exam::pushAnswer($question, $answer);
    Exam::pushInput($question, $input);

    $arry = array(
        "answer_text" => $answer_text,
        "cls" => $cls,
    );

    header("Content-type: application/json;charset=UTF-8");
    echo json_encode($arry);

    exit;

}
