<?php

namespace controller\close;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get() {

    $user = UserModel::getSession();

    \view\close\index($user);

}


function post() {

    $user = UserModel::getSession();

    if(Auth::closeAccount($user)) {

        Msg::push(Msg::INFO, 'アカウント登録を削除し、退会しました。');

    } else {

        Msg::push(Msg::ERROR, '退会に失敗しました。');

    }

    UserModel::clearSession();
    redirect(GO_HOME);

}
