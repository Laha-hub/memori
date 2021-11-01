<?php

namespace controller\register;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get() {

    \view\register\index();

}

function post() {

    $user = new UserModel;
    $user->id = getParam('id', '');
    $user->pwd = getParam('pwd', '');
    $user->name = getParam('name', '');
    $user->name = escape($user->name);

    if(Auth::regist($user)) {

        Msg::push(Msg::INFO, "{$user->name}さん、ようこそ。");
        redirect(GO_HOME);

    } else {

        redirect(GO_REFERER);

    }

}

