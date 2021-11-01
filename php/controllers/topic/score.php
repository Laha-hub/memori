<?php

namespace controller\topic\score;

use db\QuestionQuery;
use db\TopicQuery;
use lib\Auth;
use model\TopicModel;
use model\UserModel;

function get() {

    $user = Auth::isLogin() ? UserModel::getSession() : null;

    $topic = new TopicModel;
    $topic->id = getParam('topic_id', null, false);
    $topic = TopicQuery::fetchById($topic);

    $questions = QuestionQuery::fetchByTopicId($topic);

    \view\topic\score\index($topic, $questions, $user);

}
