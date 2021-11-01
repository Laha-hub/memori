<?php

namespace model;

use lib\Msg;

class QuestionModel extends AbstractModel {

    public int $id;
    public int $topic_id;
    public string $body;
    public string $answer;
    public string $user_id;
    public string $name;
    public int $del_flg;

    protected static $SESSION_NAME = '_question';

    public function isValidId() {

        return static::validateId($this->id);

    }

    public static function validateId($val) {

        $res = true;

        if (empty($val) || !is_numeric($val)) {

            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            $res = false;

        }

        return $res;

    }

    public function isValidAgree() {

        return static::validateAgree($this->ok);

    }

    public static function validateAgree($val) {

        $res = true;

        if (!isset($val)) {
            Msg::push(Msg::ERROR, '賛成か反対か選択してください。');

            if (!($val == 0 || $val == 1)) {
                Msg::push(Msg::ERROR, '賛成か反対、どちらかの値を選択してください。');
            }

            $res = false;
        }

        return $res;

    }

    public function isValidBody() {

        return static::validateBody($this->body);

    }

    public static function validateBody($val) {

        $res = true;

        if (mb_strlen($val) > 50 || mb_strlen($val) <= 0) {

            Msg::push(Msg::ERROR, '問題は1文字以上50文字以内で入力してください。');
            $res = false;

        }

        return $res;

    }

    public function isValidAnswer() {

        return static::validateAnswer($this->answer);

    }

    public static function validateAnswer($val) {

        $res = true;

        if (mb_strlen($val) > 50 || mb_strlen($val) <= 0) {

            Msg::push(Msg::ERROR, '解答は1文字以上50文字以内で入力してください。');
            $res = false;

        }

        return $res;

    }

    public function isValidTopicId() {

        return TopicModel::validateId($this->topic_id);

    }

}

