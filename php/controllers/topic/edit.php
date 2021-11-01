<?php

namespace controller\topic\edit;

use db\TopicQuery;
use lib;
use lib\Auth;
use model\TopicModel;
use model\UserModel;

function get() {
    Auth::requireLogin();

    // 直前入力内容を保持（入力エラー時）
    $before_input_topic = TopicModel::getSessionAndFlush();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null, false);

    $topic = $before_input_topic ?? TopicQuery::fetchById($topic);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    \view\topic\edit\index($topic, true);
}

function post() {
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null);
    $topic = TopicQuery::fetchById($topic);
    $topic->title = getParam('title', $topic->title); // getParamの第２引数はトピック更新時のため
    $topic->published = getParam('published', $topic->published); // 同上

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    if($_POST['type'] === '更新') {

        lib\updateTopic($topic);

    } elseif ($_POST['type'] === '削除') {

        lib\deleteTopic($topic);

    }

}
