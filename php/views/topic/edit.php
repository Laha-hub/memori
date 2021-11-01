<?php

namespace view\topic\edit;

function index($topic, $is_edit) {

    $topic = escape($topic);

    \partials\topicTemplate($topic, $is_edit);

}
