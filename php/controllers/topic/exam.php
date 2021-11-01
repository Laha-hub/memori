<?php

namespace controller\topic\exam;

use db\QuestionQuery;
use db\TopicQuery;
use lib\Exam;
use lib\Msg;
use model\QuestionModel;
use model\TopicModel;
use Throwable;

function get() {

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null, false);

    $topic = TopicQuery::fetchById($topic);
    $questions = QuestionQuery::fetchByTopicId($topic);

    \view\topic\exam\index($topic, $questions);

}

function post() {

    try {
        $topic = new TopicModel;
        $topic->id = getParam('topic_id', null);

        $question = new QuestionModel;
        $question->id = getParam('question_id', null);
        $question = QuestionQuery::fetchByQuestionId($question);

        if(!is_array(Exam::getSession())) {
            Exam::answerInit();
        }

        $answer = $_POST['input'] === $question->answer ? CORRECT : INCORRECT;

        Exam::pushAnswer($question, $answer);
        Exam::pushInput($question, getParam('input', null));

        redirect('topic/exam?topic_id=' . $question->topic_id);

    } catch (Throwable $e) {

        Msg::push(Msg::ERROR, $e->getMessage());

    }

}
