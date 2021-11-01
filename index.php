<?php

require_once 'config.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';

// Model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';
require_once SOURCE_BASE . 'models/topic.model.php';
require_once SOURCE_BASE . 'models/question.model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// Exam
require_once SOURCE_BASE . 'libs/exam.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';
require_once SOURCE_BASE . 'db/topic.query.php';
require_once SOURCE_BASE . 'db/question.query.php';

// Library(create, edit)
require_once SOURCE_BASE . 'libs/create.php';
require_once SOURCE_BASE . 'libs/edit.php';

// Partial
require_once SOURCE_BASE . 'partials/topic-list-item.php';
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';
require_once SOURCE_BASE . 'partials/topic-template.php';
require_once SOURCE_BASE . 'partials/question-template.php';
require_once SOURCE_BASE . 'partials/below.php';
require_once SOURCE_BASE . 'partials/id-and-pass.php';
require_once SOURCE_BASE . 'partials/logo.php';
require_once SOURCE_BASE . 'partials/not-exist.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/login.php';
require_once SOURCE_BASE . 'views/register.php';
require_once SOURCE_BASE . 'views/close.php';
require_once SOURCE_BASE . 'views/topic/archive.php';
require_once SOURCE_BASE . 'views/topic/create.php';
require_once SOURCE_BASE . 'views/topic/edit.php';
require_once SOURCE_BASE . 'views/topic/exam.php';
require_once SOURCE_BASE . 'views/topic/score.php';
require_once SOURCE_BASE . 'views/question/create.php';
require_once SOURCE_BASE . 'views/question/edit.php';

use function lib\route;

session_start();

// Print-Exam-Answer
require_once SOURCE_BASE . 'libs/print-exam-answer.php';

try {
    \partials\header();

    $url = parse_url(CURRENT_URI);
    $rpath = str_replace(BASE_CONTEXT_PATH, '', $url['path']);
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    route($rpath, $method);
    \partials\footer();

} catch (Throwable $e) {
    die('<h1>何かが非常におかしいようです。</h1>');
}
