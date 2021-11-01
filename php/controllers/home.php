<?php

namespace controller\home;

use db\TopicQuery;
use lib\Auth;
use model\UserModel;

function get() {

    $topics = TopicQuery::fetchPublishedTopics();

    if(Auth::isLogin()) {

        $user = UserModel::getSession();
        $user_topic = [];
        $other_topic = [];

        foreach($topics as $topic) {

            $topic->user_id === $user->id
                ? $user_topic[] = $topic
                : $other_topic[] = $topic;

        }

        $topics = [...$user_topic, ...$other_topic];

    }

    \view\home\index($topics);

}




