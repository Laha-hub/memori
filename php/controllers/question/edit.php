<?php

namespace controller\question\edit;

use db\QuestionQuery;
use db\TopicQuery;
use lib;
use lib\Auth;
use model\QuestionModel;
use model\TopicModel;
use model\UserModel;

function get() {
    Auth::requireLogin();

    // 直前入力内容を保持（入力エラー時）
    $before_topic = TopicModel::getSessionAndFlush();
    $before_questions = QuestionModel::getSessionAndFlush();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null, false);

    $selected_topic = $before_topic ?? TopicQuery::fetchById($topic);
    $questions = $before_questions ?? QuestionQuery::fetchByTopicId($topic);

    $user = UserModel::getSession();
    Auth::requirePermission($selected_topic->id, $user);

    \view\question\edit\index($selected_topic, $questions, true);
}

function post() {
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null);
    $topic = TopicQuery::fetchById($topic);
    $topic->title = getParam('title', $topic->title);

    $questions = QuestionQuery::fetchByTopicId($topic);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    if($_POST['type'] === '問題編集') {

        \view\question\edit\index($topic, $questions, true, null);

    } elseif ($_POST['type'] === '問題更新') {

        $question = $questions[getParam('question_no', null)];
        $question->body= getParam('body', null);
        $question->answer = getParam('answer', null);

        lib\updateQuestion($questions, $question);

    } elseif ($_POST['type'] === '問題削除') {

        lib\deleteQuestion($topic, $questions);

    }

}
