<?php

namespace view\question\create;

function index($topic, $questions, $is_edit, $before_question) {

    $topic = escape($topic);
    $questions = escape($questions);

    \partials\questionTemplate($topic, $questions, $is_edit, $before_question);

}
