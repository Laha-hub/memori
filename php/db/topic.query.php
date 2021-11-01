<?php

namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery {
    // $user->idをキーに、ユーザーが作成したトピックのみ取得
    public static function fetchByUserId($user) {

        if(!$user->isValidId()) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        select
            *
        from
            topics
        where
            user_id = :id
            and del_flg != 1
        order by id desc;
        ';
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }

    // すべてのトピックを取得（非公開のものを除く）
    public static function fetchPublishedTopics() {

        $db = new DataSource;
        $sql = '
        select
            t.*, u.name
        from
            topics t
        inner join users u
            on t.user_id = u.id
        where
            t.del_flg != 1
            and u.del_flg != 1
            and t.published = 1
        order by t.id desc;
        ';
        $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);

        return $result;
    }

    // $topic->idをキーに、トピック１つを取得
    public static function fetchById($topic) {

        if(!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        select
            t.*, u.name
        from
            topics t
        inner join users u
            on t.user_id = u.id
        where
            t.id = :id
            and t.del_flg != 1
            and u.del_flg != 1
        order by t.id desc;
        ';
        $result = $db->selectOne($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }
    // $topic->titleをキーに、トピック１つを取得
    public static function fetchByTitle($topic) {

        $db = new DataSource;
        $sql = '
        select
            t.*
        from
            topics t
        where BINARY
            t.title = :title
            and t.del_flg != 1
        order by t.id desc;
        ';
        $result = $db->selectOne($sql, [
            ':title' => $topic->title
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }

    // 問題を全回答するごとにchallengesを1カウントアップ
    public static function incrementChallengeCount($topic) {
        if(!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;

        $sql = 'update topics set challenges = challenges + 1 where id = :id;';
        return $db->execute($sql, [
            ':id' => $topic->id
        ]);
    }

    // トピック内の問題を全削除した際にchallengesをリセット
    public static function resetChallengeCount($topic) {
        if(!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;

        $sql = 'update topics set challenges = 0 where id = :id;';
        return $db->execute($sql, [
            ':id' => $topic->id
        ]);
    }

    // トピック作成者とログイン者の一致確認
    public static function isUserOwnTopic($topic_id, $user) {

        if(!(TopicModel::validateId($topic_id) * $user->isValidId())) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        select
            count(1) as count
        from
            topics t
        where
            t.id = :topic_id
            and t.user_id = :user_id
            and t.del_flg != 1;
        ';

        $result = $db->selectOne($sql, [
            ':topic_id' => $topic_id,
            ':user_id' => $user->id
        ]);

        return !empty($result) && $result['count'] != 0;

    }

    public static function update($topic) {

        // 値のチェック
        if(!($topic->isValidId() * $topic->isValidTitle() * $topic->isValidPublished())) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        update
            topics
        set
            published = :published,
            title = :title
        where
            id = :id;
        ';
        return $db->execute($sql, [
            ':published' => $topic->published,
            ':title' => $topic->title,
            ':id' => $topic->id,
        ]);

    }

    public static function create($topic, $user) {

        // 値のチェック
        if(!($user->isValidId() * $topic->isValidTitle() * $topic->isValidPublished())) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        insert into topics
            (title, published, user_id)
        values
            (:title, :published, :user_id);
        ';

        return $db->execute($sql, [
            ':title' => $topic->title,
            ':published' => $topic->published,
            ':user_id' => $user->id
        ]);

    }

    public static function delete($topic) {

        $db = new DataSource;
        $sql = '
        delete
        from
            topics
        where
            id = :id;
        ';

        return $db->execute($sql, [
            ':id' => $topic->id,
        ]);

    }

    // $user->idをキーに、$userが作成したトピックすべてを削除
    public static function deleteTopicsByUserId($user) {

        $db = new DataSource;
        $sql = '
        delete
        from
            topics
        where
            user_id = :user_id;
        ';

        return $db->execute($sql, [
            ':user_id' => $user->id,
        ]);
    }

}

