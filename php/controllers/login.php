<?php

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get() {

    \view\login\index();

}

function post() {

    $id = getParam('id', '');
    $pwd = getParam('pwd', '');

    if(Auth::login($id, $pwd)) {

        $user = UserModel::getSession();
        $user->name = escape($user->name);
        Msg::push(Msg::INFO, "{$user->name}さん、ようこそ。");
        redirect(GO_HOME);

    } else {

        redirect(GO_REFERER);

    }

}
