<?php

namespace controller\topic\archive;

use lib\Auth;
use db\TopicQuery;
use lib\Msg;
use model\UserModel;

function get() {

    Auth::requireLogin();

    $user = UserModel::getSession();

    $topics = TopicQuery::fetchByUserId($user);

    if($topics === false) {
        Msg::push(Msg::ERROR, 'ログインが必要です。');
        redirect('login');
    }

    \view\topic\archive\index($topics);

}
