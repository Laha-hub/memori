<?php

namespace partials;

use db\QuestionQuery;
use lib\Auth;
use model\UserModel;

function topicListItem($topic, $title_url, $with_status) {

    $published_label = $topic->published ? '公開' : '非公開';
    $published_cls = $topic->published ? 'badge-primary' : 'badge-danger';
    $questions = QuestionQuery::fetchByTopicId($topic);
    $user = UserModel::getSession();

?>

    <li class="topic row bg-white shadow-sm mb-3 rounded-lg p-3">
        <div class="col-md d-flex align-items-center">
            <h2 class="mb-2 mb-md-0">
                <?php if($with_status) : ?>
                    <span class="badge mr-1 mb-1 align-bottom <?php echo $published_cls; ?>"><?php echo $published_label; ?></span>
                <?php endif; ?>
                <form action="<?php echo $title_url; ?>" method="GET">
                    <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                    <?php if(!$with_status) : ?>
                        <input type="hidden" name="init" value="1">
                    <?php endif; ?>
                    <input class="bg-white like-anchor text-body" type="submit" value="<?php echo $topic->title; ?>">
                </form>
            </h2>
        </div>

        <div class="col-auto mx-auto">
            <div class="text-center row">
                <div class="question col-auto min-w-100">
                    <div class="h1 mb-0"><?php echo count($questions); ?></div>
                    <div class="mb-0">問題</div>
                </div>
                <?php if(Auth::isLogin() && Auth::hasPermission($topic->id, $user)) : ?>
                    <div class="memori-green col-auto min-w-100">
                        <div class="h1 mb-0"><?php echo $topic->challenges; ?></div>
                        <div class="mb-0">挑戦</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </li>

<?php

}
