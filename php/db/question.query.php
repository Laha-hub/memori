<?php

namespace db;

use db\DataSource;
use model\QuestionModel;

class QuestionQuery {

    // $topic->idをキーに問題群１つを取得
    public static function fetchByTopicId($topic) {

        if(!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        select
            q.*, u.name
        from
            questions q
        inner join users u
            on q.user_id = u.id
        where
            q.topic_id = :id
            and q.del_flg != 1
            and u.del_flg != 1;
        ';
        $result = $db->select($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, QuestionModel::class);

        return $result;
    }

    // $question->idをキーに問題１問のみ取得
    public static function fetchByQuestionId($question) {

        if(!$question->isValidId()) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        select
            q.*
        from
            questions q
        where
            q.id = :id
            and q.del_flg != 1;
        ';
        $result = $db->selectOne($sql, [
            ':id' => $question->id
        ], DataSource::CLS, QuestionModel::class);

        return $result;
    }

    public static function update($question) {

        // 値のチェック
        if(!($question->isValidId()
            * $question->isValidBody()
            * $question->isValidAnswer()
            * $question->isValidTopicId())) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        update
            questions q
        set
            q.body = :body,
            q.answer = :answer
        where
            q.id = :id;
        ';
        return $db->execute($sql, [
            ':body' => $question->body,
            ':answer' => $question->answer,
            ':id' => $question->id,
        ]);

    }

    public static function create($question, $user) {

        // 値のチェック
        if(!($question->isValidTopicId()
            * $question->isValidBody()
            * $question->isValidAnswer()
            * $user->isValidId())) {
            return false;
        }

        $db = new DataSource;
        $sql = '
        insert into questions
            (topic_id, body, answer, user_id)
        values
            (:topic_id, :body, :answer, :user_id);
        ';
        return $db->execute($sql, [
            ':topic_id' => $question->topic_id,
            ':body' => $question->body,
            ':answer' => $question->answer,
            ':user_id' => $user->id,
        ]);

    }

    // $question->idをキーに問題１問のみ削除
    public static function delete($question) {

        $db = new DataSource;
        $sql = '
        delete
        from
            questions
        where
            id = :id;
        ';
        return $db->execute($sql, [
            ':id' => $question->id,
        ]);

    }

    // $topic->idをキーに問題群一式を削除
    public static function deleteQuestions($topic) {

        $db = new DataSource;
        $sql = '
        delete
        from
            questions
        where
            topic_id = :topic_id;
        ';
        return $db->execute($sql, [
            ':topic_id' => $topic->id,
        ]);

    }

    // $user->idをキーに$userが作成した問題群一式を削除
    public static function deleteQuestionsByUserId($user) {

        $db = new DataSource;
        $sql = '
        delete
        from
            questions
        where
            user_id = :user_id;
        ';
        return $db->execute($sql, [
            ':user_id' => $user->id,
        ]);

    }

}

