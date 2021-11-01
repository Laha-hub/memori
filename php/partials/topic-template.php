<?php

namespace partials;

function topicTemplate($topic, $is_edit) {

    $header_title = $is_edit ? 'トピック編集' : 'トピック作成';

?>

    <h1 class="h2 mb-3"><?php echo $header_title; ?></h1>

    <div class="bg-white p-4 shadow mx-auto rounded-lg">
        <?php topicMain($topic, $is_edit); ?>
        <?php topicBelow($topic, $is_edit); ?>
    </div>

<?php
}


function topicMain($topic, $is_edit) {
?>
    <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title" value="<?php echo $topic->title; ?>" class="form-control validate-target" maxlength="30" autofocus required/>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="published">ステータス</label>
            <select name="published" id="published" class="form-control">
                <option value="1" <?php echo $topic->published ? 'selected' : ''; ?>>公開</option>
                <option value="0" <?php echo $topic->published ? '' : 'selected'; ?>>非公開</option>
            </select>
        </div>
        <div class="d-flex align-items-center justify-content-end">
            <div>
                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                <?php if($is_edit) : ?>
                    <input type="submit" name="type" value="更新" class="btn btn-primary shadow-sm mr-2" />
                    <input type="submit" name="type" value="削除" class="btn btn-light shadow-sm mr-2" />
                <?php else : ?>
                    <input type="submit" name="type" value="作成" class="btn btn-primary shadow-sm mr-2" />
                <?php endif; ?>
            </div>
        </div>
    </form>
<?php
}


function topicBelow($topic, $is_edit) {

    $action = 'question/edit?topic_id=' . $topic->id;
    $value = '問題編集';
    $href_true = 'topic/archive';
    $href_false = GO_HOME;

    \partials\below($topic, $is_edit, $action, $value, $href_true, $href_false);

?>

<?php
}
