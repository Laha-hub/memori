<?php

namespace lib;

use db\DataSource;
use db\QuestionQuery;
use db\TopicQuery;
use lib\Msg;
use model\QuestionModel;
use model\TopicModel;
use Throwable;


function createTopic($topic, $user) {

    try {

        $db = new DataSource;
        $db->begin();

        if(isUniqueTopicTitle($topic)) {
            $is_success = TopicQuery::create($topic, $user);
        } else {
            $is_success = false;
        }

    } catch (Throwable $e) {

        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, 'トピック作成処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        $is_success = false;

    } finally {

        if($is_success) {
            $last_insert_topic_id = $db->fetchLastInsertId();
            $db->commit();
            Msg::push(Msg::INFO, 'トピックの作成に成功しました。');
            redirect('topic/edit?topic_id=' . $last_insert_topic_id);
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, 'トピックの作成に失敗しました。');
            TopicModel::setSession($topic);
            redirect(GO_REFERER);
        }

    }

}


function isUniqueTopicTitle($topic) {

    try {

        $is_success = false;

        $exist_topic = TopicQuery::fetchByTitle($topic);

        if(!empty($exist_topic) && $topic->id !== $exist_topic->id) {
            Msg::push(Msg::ERROR, '同名のトピックが既に存在します。');
            return false;
        }

        $is_success = true;

    } catch (Throwable $e) {
        $is_success = false;
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, 'トピック登録でエラーが発生しました。少し時間をおいてから再度お試しください。');
    }

    return $is_success;

}


function createQuestion($question, $user) {

    try {

        $db = new DataSource;
        $db->begin();

        $is_success = QuestionQuery::create($question, $user);

    } catch (Throwable $e) {

        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, '問題追加処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        $is_success = false;

    } finally {

        if($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, '問題の作成に成功しました。');
            redirect('question/edit?topic_id=' . $question->topic_id);
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, '問題の作成に失敗しました。');
            QuestionModel::setSession($question);
            redirect(GO_REFERER);
        }

    }

}

