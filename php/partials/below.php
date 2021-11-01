<?php

namespace partials;

function below($topic, $is_edit, $action, $value, $href_true, $href_false) {

?>

    <?php if($is_edit) : ?>
        <form action="<?php theUrl($action); ?>" method="POST">
            <div class="form-group mt-5">
                <div class="text-right">
                    <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                    <input type="submit" name="type" value="<?php echo $value; ?>" class="btn btn-success mx-1 shadow-sm" >
                </div>
            </div>
        </form>

        <?php back($href_true); ?>

    <?php else : ?>

        <?php back($href_false); ?>

    <?php endif; ?>

<?php

}


function back($href) {

?>

    <div class="d-flex align-items-center">
        <div class="h5 ml-2 mt-4">
            <a href="<?php theUrl($href); ?>">戻る</a>
        </div>
    </div>

<?php

}
