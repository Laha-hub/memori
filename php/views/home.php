<?php

namespace view\home;

function index($topics) {

    $topics = escape($topics);

?>

    <?php if(count($topics) > 0) : ?>
        <ul class="container">
            <?php
                foreach($topics as $topic) {

                    $url = getUrl('topic/exam?topic_id=' . $topic->id);
                    \partials\topicListItem($topic, $url, false);

                }
            ?>
        </ul>
        <?php else : ?>
            <?php
                $str = '表示できるトピックがありません。';
                \partials\notExist($str);
            ?>
        <?php endif; ?>

<?php

}
