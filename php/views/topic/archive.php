<?php

namespace view\topic\archive;

function index($topics) {

    $topics = escape($topics);

?>

    <h1 class="h2 mb-3">編集</h1>
    
    <?php if(!empty($topics)) : ?>
        <ul class="container">
            <?php
                foreach($topics as $topic) {

                    $url = getUrl('topic/edit?topic_id=' . $topic->id);
                    \partials\topicListItem($topic, $url, true);

                }
            ?>
        </ul>
        <?php else : ?>
            <?php
                $str = '登録されているトピックがありません。';
                \partials\notExist($str);
            ?>
        <?php endif; ?>

    <?php \partials\back(GO_HOME); ?>

<?php

}
