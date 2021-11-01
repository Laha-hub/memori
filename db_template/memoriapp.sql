/*
暗記アプリ memori
*/

--
-- Database: memori
--
-- DROP DATABASE memori;
CREATE DATABASE IF NOT EXISTS memori DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE memori;

/* ユーザーに権限の付与 */
-- CREATE USER IF NOT EXISTS 'test_user'@'localhost' IDENTIFIED BY 'pwd';
-- GRANT ALL ON memori.* TO 'test_user'@'localhost';



--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'トピックID',
  `title` varchar(30) NOT NULL COMMENT 'トピックタイトル',
  `published` int(1) NOT NULL COMMENT '公開状態(1: 公開、0: 非公開)',
  `challenges` int(10) NOT NULL DEFAULT '0' COMMENT '挑戦数',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'memori' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '問題ID',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `body` varchar(50) DEFAULT NULL COMMENT '問題',
  `answer` varchar(50) DEFAULT NULL COMMENT '解答',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'memori' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(10) PRIMARY KEY COMMENT 'ユーザーID',
  `pwd` varchar(255) NOT NULL COMMENT 'パスワード',
  `name` varchar(10) NOT NULL COMMENT '画面表示用名',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'memori' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);


START TRANSACTION;

SET time_zone = "+09:00";

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`, `published`, `challenges`, `user_id`, `del_flg`) VALUES
(1, '和風月名', 1, 8, 'test', 0),
(2, '徳川将軍', 1, 12, 'test', 0),
(3, 'OSI参照モデル', 1, 3, 'abcd', 0),
(4, '曜日（英語）', 1, 2, 'abcd', 0),
(5, '数字', 1, 15, '1234', 0);


--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `topic_id`, `body`, `answer`, `user_id`, `del_flg`) VALUES
(1, 1, '1月は？', '睦月', 'test', 0),
(2, 1, '2月は？', '如月', 'test', 0),
(3, 1, '3月は？', '弥生', 'test', 0),
(4, 1, '4月は？', '卯月', 'test', 0),
(5, 1, '5月は？', '皐月', 'test', 0),
(6, 1, '6月は？', '水無月', 'test', 0),
(7, 1, '7月は？', '文月', 'test', 0),
(8, 1, '8月は？', '葉月', 'test', 0),
(9, 1, '9月は？', '長月', 'test', 0),
(10, 1, '10月は？', '神無月', 'test', 0),
(11, 1, '11月は？', '霜月', 'test', 0),
(12, 1, '12月は？', '師走', 'test', 0),
(13, 2, '初代将軍は？', '家康', 'test', 0),
(14, 2, '２代将軍は？', '秀忠', 'test', 0),
(15, 2, '３代将軍は？', '家光', 'test', 0),
(16, 2, '４代将軍は？', '家綱', 'test', 0),
(17, 2, '５代将軍は？', '綱吉', 'test', 0),
(18, 2, '６代将軍は？', '家宣', 'test', 0),
(19, 2, '７代将軍は？', '家継', 'test', 0),
(20, 2, '８代将軍は？', '吉宗', 'test', 0),
(21, 2, '９代将軍は？', '家重', 'test', 0),
(22, 2, '１０代将軍は？', '家治', 'test', 0),
(23, 2, '１１代将軍は？', '家斉', 'test', 0),
(24, 2, '１２代将軍は？', '家慶', 'test', 0),
(25, 2, '１３代将軍は？', '家定', 'test', 0),
(26, 2, '１４代将軍は？', '家茂', 'test', 0),
(27, 2, '１５代将軍は？', '慶喜', 'test', 0),
(28, 3, '第1層は？', '物理層', 'abcd', 0),
(29, 3, '第2層は？', 'データリンク層', 'abcd', 0),
(30, 3, '第3層は？', 'ネットワーク層', 'abcd', 0),
(31, 3, '第4層は？', 'トランスポート層', 'abcd', 0),
(32, 3, '第5層は？', 'セッション層', 'abcd', 0),
(33, 3, '第6層は？', 'プレゼンテーション層', 'abcd', 0),
(34, 3, '第7層は？', 'アプリケーション層', 'abcd', 0),
(35, 4, '日曜日は？', 'Sunday', 'abcd', 0),
(36, 4, '月曜日は？', 'Monday', 'abcd', 0),
(37, 4, '火曜日は？', 'Tuesday', 'abcd', 0),
(38, 4, '水曜日は？', 'Wednesday', 'abcd', 0),
(39, 4, '木曜日は？', 'Thursday', 'abcd', 0),
(40, 4, '金曜日は？', 'Friday', 'abcd', 0),
(41, 4, '土曜日は？', 'Saturday', 'abcd', 0),
(42, 5, '0の次は？', '1', '1234', 0),
(43, 5, '1の次は？', '2', '1234', 0),
(44, 5, '2の次は？', '3', '1234', 0),
(45, 5, '3の次は？', '4', '1234', 0),
(46, 5, '4の次は？', '5', '1234', 0);



--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pwd`, `name`, `del_flg`) VALUES
('test', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー', 0),
('abcd', "$2y$10$d/7G8aBYzEwkMNeT3qAy7OqiuZVSdBNAkjzkZdEaM5d/vi2odU.V2", 'abcdユーザー', 0),
('1234', "$2y$10$nEhyzGkA05NgszZL0OV2teQUf1H62c9e.UUoMVGmSUtIcDQOv2GrS", '1234ユーザー', 0);


COMMIT;

