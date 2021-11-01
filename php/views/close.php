<?php

namespace view\close;

function index() {

?>

    <h1 class="sr-only">退会</h1>

    <div class="mt-5">

        <?php echo \partials\logo(); ?>

        <div class="login-form bg-white p-4 shadow mx-auto rounded-lg">

            <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST">
                <div class="form-group">
                    <span class="h4">退会しますか？</span>
                </div>
                <div class="d-flex align-items-center justify-content-center mt-5 mb-4">
                    <input type="submit" value="退会する" class="btn btn-secondary shadow-sm" />
                </div>
            </form>

            <?php \partials\back(GO_HOME); ?>

        </div>
    </div>


<?php

}
