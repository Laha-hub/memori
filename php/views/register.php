<?php

namespace view\register;

function index() {

?>

    <h1 class="sr-only">アカウント登録</h1>

    <div class="mt-5">

        <?php echo \partials\logo(); ?>

        <div class="login-form bg-white p-4 shadow mx-auto rounded-lg">
            <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">

                <?php echo \partials\idAndPass(); ?>

                <div class="form-group">
                    <label for="name">名前</label>
                    <input id="name" type="text" name="name" class="form-control validate-target" required maxlength="10" />
                    <div class="invalid-feedback"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?php theUrl('login'); ?>">ログイン</a>
                    </div>
                    <div>
                        <input type="submit" value="登録" class="btn btn-primary mr-2 shadow-sm" />
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php

}
