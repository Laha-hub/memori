<?php

namespace controller\question\create;

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
    $before_input = QuestionModel::getSessionAndFlush();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null, false);
    $topic = TopicQuery::fetchById($topic);
    $questions = QuestionQuery::fetchByTopicId($topic);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    \view\question\create\index($topic, $questions, false, $before_input);
}

function post() {
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null);
    $topic = TopicQuery::fetchById($topic);

    $questions = QuestionQuery::fetchByTopicId($topic);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    if ($_POST['type'] === '問題追加') {

        \view\question\create\index($topic, $questions, false, null);

    } elseif ($_POST['type'] === '問題作成') {

        $question = new QuestionModel;
        $question->topic_id = getParam('topic_id', null);
        $question->body = getParam('body', null);
        $question->answer = getParam('answer', null);

        lib\createQuestion($question, $user);

    }

}
