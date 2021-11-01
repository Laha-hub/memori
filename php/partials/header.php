<?php

namespace partials;

use lib\Auth;
use lib\Msg;


function header() {

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>暗記アプリ - memori -</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="//fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@500&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo BASE_CSS_PATH; ?>style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body>
        <div id="container">
            <header class="container my-2">
                <nav class="row align-items-center py-2">
                    <div class="col-md mb-3 mb-md-0 d-flex">
                        <a href="<?php theUrl('/'); ?>" class="d-flex align-items-center">
                            <img width="50" class="mr-2" src="<?php echo BASE_IMAGE_PATH; ?>memori_logo.svg" alt="暗記アプリmemori サイトロゴ" />
                            <span class="h2 font-weight-bold">memori</span>
                        </a>
                    </div>
                    <div class="col-md-auto">
                        <?php if(Auth::isLogin()) : ?>
                            <?php // ログイン時の処理; ?>
                            <a href="<?php theUrl('topic/create'); ?>" class="btn btn-primary mr-4">作成</a>
                            <a href="<?php theUrl('topic/archive'); ?>" class="mr-4">編集</a>
                            <a href="<?php theUrl('logout'); ?>" class="mr-4">ログアウト</a>
                            <a href="<?php theUrl('close'); ?>" class="text-secondary">退会</a>
                        <?php else: ?>
                            <a href="<?php theUrl('register'); ?>" class="btn btn-primary mr-4">登録</a>
                            <a href="<?php theUrl('login'); ?>">ログイン</a>
                        <?php endif; ?>
                    </div>
                </nav>
            </header>

            <main class="container py-3">

<?php

Msg::flush();

}
