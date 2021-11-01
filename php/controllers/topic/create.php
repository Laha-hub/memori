<?php

namespace controller\topic\create;

use lib;
use lib\Auth;
use model\TopicModel;
use model\UserModel;

function get() {
    Auth::requireLogin();

    // 直前入力内容を保持（入力エラー時）
    $before_input_topic = TopicModel::getSessionAndFlush();

    $topic = new TopicModel;
    $topic->id = -1;
    $topic->title = '';
    $topic->published = 1;

    $topic = $before_input_topic ?? $topic;

    \view\topic\create\index($topic, false);
}

function post() {
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null);
    $topic->title= getParam('title', null);
    $topic->published = getParam('published', null);

    $user = UserModel::getSession();

    if($_POST['type'] === '作成') {

        lib\createTopic($topic, $user);

    }

}
