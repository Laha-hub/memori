<?php

namespace lib;

use model\AbstractModel;

class Exam extends AbstractModel {

    protected static $SESSION_NAME = '_exam';

    // 解答の格納
    public static function pushAnswer($question, $answer) {

        if(!is_array(static::getSession())) {
            static::answerInit();
        }

        $answers = static::getSession();
        $answers['answer'][$question->id] = $answer;
        static::setSession($answers);

    }

    // 回答者入力内容の格納
    public static function pushInput($question, $input) {

        if(!is_array(static::getSession())) {
            static::answerInit();
        }

        $inputs = static::getSession();
        $inputs['input'][$question->id] = $input;
        static::setSession($inputs);

    }

    // 解答の出力
    public static function flushAnswer($question) {

        if(!is_array(static::getSession())) {
            return null;
        }
        $answers = static::getSession();
        $answer = $answers['answer'][$question->id] ?? null;
        return $answer;

    }

    // 回答者入力内容の出力
    public static function flushInput($question) {

        if(!is_array(static::getSession())) {
            return null;
        }
        $inputs = static::getSession();
        $input = $inputs['input'][$question->id] ?? null;
        return $input;

    }

    // $_SESSION['_exam']のクリア（解答、回答者入力内容）
    public static function clearAnswerAndInput() {

        static::clearSession(null);

    }

    // 解答の初期化
    public static function answerInit() {

        static::setSession([]);

    }

}
