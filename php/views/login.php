<?php

namespace view\login;

function index() {

?>

    <h1 class="sr-only">ログイン</h1>

    <div class="mt-5">

        <?php echo \partials\logo(); ?>

        <div class="login-form bg-white p-4 shadow mx-auto rounded-lg">
            <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">

                <?php echo \partials\idAndPass(); ?>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?php theUrl('register'); ?>">アカウント登録</a>
                    </div>
                    <div>
                        <input type="submit" value="ログイン" class="btn btn-primary mr-2 shadow-sm"/>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php

}
