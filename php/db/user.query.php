<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery {
    // ユーザー情報の取得
    public static function fetchById($id) {
        $db = new DataSource;
        $sql = '
        select
            *
        from
            users
        where
            id = :id;
        ';
        $result = $db->selectOne($sql, [
            ':id' => $id
        ], DataSource::CLS, UserModel::class);

        return $result;
    }

    // ユーザーの新規追加
    public static function insert($user) {
        $db = new DataSource;
        $sql = '
        insert into users
            (id, pwd, name)
        values
            (:id, :pwd, :name);
        ';
        $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);
        return $db->execute($sql, [
            ':id' => $user->id,
            ':pwd' => $user->pwd,
            ':name' => $user->name
        ]);

    }

    // ユーザーの退会処理
    public static function closeAccount($user) {

        $db = new DataSource;

        $sql = '
        delete
        from
            users
        where id = :id;
        ';

        return $db->execute($sql, [
            ':id' => $user->id,
        ]);

    }

}
