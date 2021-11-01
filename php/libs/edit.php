<?php

namespace lib;

use db\DataSource;
use db\QuestionQuery;
use db\TopicQuery;
use lib\Msg;
use model\QuestionModel;
use model\TopicModel;
use Throwable;


function updateTopic($topic) {

    try {

        $db = new DataSource;
        $db->begin();

        if(isUniqueTopicTitle($topic)) {
            $is_success = TopicQuery::update($topic);
        } else {
            $is_success = false;
        }

    } catch (Throwable $e) {

        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, 'トピック更新処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        $is_success = false;

    } finally {

        if($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
            redirect('topic/archive');
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');
            TopicModel::setSession($topic);
            redirect(GO_REFERER);
        }

    }

}


function deleteTopic($topic) {

    try {

        $db = new DataSource;
        $db->begin();

        $is_success = TopicQuery::delete($topic) * QuestionQuery::deleteQuestions($topic);

    } catch (Throwable $e) {

        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, 'トピック削除処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        $is_success = false;

    } finally {

        if($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, 'トピックの削除に成功しました。');
            redirect('topic/archive');
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, 'トピックの削除に失敗しました。');
            redirect(GO_REFERER);
        }

    }

}


function updateQuestion($questions, $question) {

    try {

        $db = new DataSource;
        $db->begin();

        $is_success = QuestionQuery::update($question);

    } catch (Throwable $e) {

        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, '問題更新処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        $is_success = false;

    } finally {

        if($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, '問題の更新に成功しました。');
            redirect('question/edit?topic_id=' . $question->topic_id);
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, '問題の更新に失敗しました。');
            QuestionModel::setSession($questions);
            redirect(GO_REFERER);
        }

    }

}


function deleteQuestion($topic, $questions) {

    try {

        $db = new DataSource;
        $db->begin();

        $is_success = QuestionQuery::delete($questions[getParam('question_no', null)]);

    } catch (Throwable $e) {

        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, '問題削除処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        $is_success = false;

    } finally {

        if($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, '問題の削除に成功しました。');
            $latest_questions = QuestionQuery::fetchByTopicId($topic);
            if(count($latest_questions) === 0) {
                TopicQuery::resetChallengeCount($topic);
            }
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, '問題の削除に失敗しました。');
        }
        redirect(GO_REFERER);

    }

}
