<?php

namespace view\question\edit;

function index($topic, $questions, $is_edit) {

    $topic = escape($topic);
    $questions = escape($questions);

    \partials\questionTemplate($topic, $questions, $is_edit);

}
