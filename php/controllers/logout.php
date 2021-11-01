<?php

namespace controller\logout;

use lib\Auth;
use lib\Msg;

function get() {

    if(Auth::logout()) {

        Msg::push(Msg::INFO, 'ログアウトしました。');

    } else {

        Msg::push(Msg::ERROR, 'ログアウトに失敗しました。');

    }

    redirect(GO_HOME);
    
}
