<?php

namespace view\topic\create;

function index($topic, $is_edit) {

    $topic = escape($topic);

    \partials\topicTemplate($topic, $is_edit);

}
