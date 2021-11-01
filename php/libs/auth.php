<?php

namespace lib;

use db\DataSource;
use db\QuestionQuery;
use db\TopicQuery;
use db\UserQuery;
use model\UserModel;
use Throwable;

class Auth {
    // 認証処理（入力内容チェック）
    public static function login($id, $pwd) {

        try {
            if(!(UserModel::validateId($id) * UserModel::validatePwd($pwd))) {
                return false;
            }

            $is_success = false;

            $user = UserQuery::fetchById($id);

            if(!empty($user) && $user->del_flg !== 1) {
                if(password_verify($pwd, $user->pwd)) {
                    $is_success = true;
                    UserModel::setSession($user);
                } else {
                    Msg::push(Msg::ERROR, 'パスワードが一致しません。');
                }
            } else {
                Msg::push(Msg::ERROR, 'ユーザーが見つかりません。');
            }

        } catch (Throwable $e) {
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ログイン処理でエラーが発生しました。少し時間をおいてから再度お試しください。');

        }

        return $is_success;
    }

    // ユーザー登録処理
    public static function regist($user) {

        try {

            $db = new DataSource;
            $db->begin();

            if(!($user->isValidId() * $user->isValidPwd() * $user->isValidName()) ) {
                return false;
            }

            $is_success = false;

            $exist_user = UserQuery::fetchById($user->id);

            if(!empty($exist_user)) {
                Msg::push(Msg::ERROR, 'ユーザーが既に存在します。');
                $is_success = false;
                return $is_success;
            }

            $is_success = UserQuery::insert($user);

        } catch (Throwable $e) {

            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました。少し時間をおいてから再度お試しください。');

        } finally {

            if ($is_success) {
                $db->commit();
                UserModel::setSession($user);
            } else {
                $db->rollback();
            }

        return $is_success;

        }

    }

    // ログイン確認
    public static function isLogin() {

        try {
            $user = UserModel::getSession();
        } catch (Throwable $e) {
            UserModel::clearSession();
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが発生しました。再度、ログインを行ってください。');
            return false;
        }

        return isset($user);

    }

    // ログアウト処理
    public static function logout() {
        try {
            UserModel::clearSession();
        } catch (Throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            return false;
        }

        return true;

    }

    // ログイン要求
    public static function requireLogin() {
        if(!static::isLogin()) {
            Msg::push(Msg::ERROR, 'ログインが必要です。');
            redirect('login');
        }
    }

    // 編集権限の有無チェック
    public static function hasPermission($topic_id, $user) {
        return TopicQuery::isUserOwnTopic($topic_id, $user);
    }

    // 編集権限確認
    public static function requirePermission($topic_id, $user) {
        if(!static::hasPermission($topic_id, $user)) {
            Msg::push(Msg::ERROR, '編集権限がありません。ログインして再度試してみてください。');
            redirect('login');
        }
    }

    // 退会処理
    public static function closeAccount($user) {

        try {

            $db = new DataSource;
            $db->begin();

            $is_success = UserQuery::closeAccount($user)
                * TopicQuery::deleteTopicsByUserId($user)
                * QuestionQuery::deleteQuestionsByUserId($user);

        } catch (Throwable $e) {

            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, '退会処理でエラーが発生しました。少し時間をおいてから再度お試しください。');

        } finally {

            if ($is_success) {
                $db->commit();
            } else {
                $db->rollback();
            }

        return $is_success;

        }

    }

}
