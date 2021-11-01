<?php

namespace model;

use lib\Msg;

class UserModel  extends AbstractModel {

    public string $id;
    public string $pwd;
    public string $name;
    public int $del_flg;

    protected static $SESSION_NAME = '_user';

    // ユーザー登録の入力idチェック
    public static function validateId($val) {

        $res = true;

        if(empty($val)) {

            Msg::push(Msg::ERROR, 'ユーザーIDを入力してください。');
            $res = false;

        } else {

            if(strlen($val) > 10) {

                Msg::push(Msg::ERROR, 'ユーザーIDは10桁以下で入力してください。');
                $res = false;

            }

            if(!isAlnum($val)) {

                Msg::push(Msg::ERROR, 'ユーザーIDは半角英数字で入力してください。');
                $res = false;

            }

        }

        return $res;

    }

    public function isValidId() {

        return static::validateId($this->id);

    }

    // ユーザー登録の入力pwdチェック
    public static function validatePwd($val) {

        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            $res = false;

        } else {

            if(strlen($val) < 4) {

                Msg::push(Msg::ERROR, 'パスワードは4桁以上で入力してください。');
                $res = false;

            }

            if(!isAlnum($val)) {

                Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
                $res = false;

            }

        }

        return $res;

    }

    public function isValidPwd() {

        return static::validatePwd($this->pwd);

    }

    // ユーザー登録の入力nameチェック
    public static function validateName($val) {

        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, '名前を入力してください。');
            $res = false;

        } else {

            if(mb_strlen($val) > 10) {

                Msg::push(Msg::ERROR, '名前は10桁以下で入力してください。');
                $res = false;

            }
        }

        return $res;

    }

    public function isValidName() {

        return static::validateName($this->name);

    }

}
