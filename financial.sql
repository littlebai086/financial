-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-02-27 18:35:32
-- 伺服器版本： 10.4.21-MariaDB
-- PHP 版本： 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `financial`
--

-- --------------------------------------------------------

--
-- 資料表結構 `bank_trade`
--

CREATE TABLE `bank_trade` (
  `bank_trade_id` int(11) NOT NULL,
  `bank_trade` varchar(50) NOT NULL,
  `default_currency_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `bank_trade`
--

INSERT INTO `bank_trade` (`bank_trade_id`, `bank_trade`, `default_currency_id`) VALUES
(1, '星展銀行 ( 外幣 )', 1),
(2, '華南銀行', 2),
(3, '玉山銀行', 2),
(4, '星展銀行 ( 台幣 )', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `currency`
--

CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `currency`
--

INSERT INTO `currency` (`currency_id`, `currency`) VALUES
(1, 'USD'),
(2, 'TWD'),
(3, 'JPY'),
(4, 'SGD');

-- --------------------------------------------------------

--
-- 資料表結構 `department`
--

CREATE TABLE `department` (
  `department_id` int(255) NOT NULL,
  `department` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `department`
--

INSERT INTO `department` (`department_id`, `department`) VALUES
(1, '管理部'),
(2, '財務部'),
(3, '文件部'),
(4, 'TANK營業部'),
(5, '貨櫃管理部'),
(6, '客服部'),
(8, '船務代理部'),
(9, '資訊部'),
(10, '業務部'),
(11, '人力資源部'),
(12, '稽核部');

-- --------------------------------------------------------

--
-- 資料表結構 `document_file`
--

CREATE TABLE `document_file` (
  `document_file_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `bank_trade_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `pay_money` decimal(10,2) DEFAULT NULL,
  `document` varchar(50) NOT NULL,
  `file` text NOT NULL,
  `dp_check` int(11) DEFAULT NULL,
  `document_file_del` int(11) NOT NULL DEFAULT 0,
  `create_time` date NOT NULL,
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `document_file`
--

INSERT INTO `document_file` (`document_file_id`, `staff_id`, `year`, `month`, `document_type_id`, `bank_trade_id`, `currency_id`, `pay_money`, `document`, `file`, `dp_check`, `document_file_del`, `create_time`, `last_time`) VALUES
(1, 1, 2023, 2, 1, NULL, NULL, NULL, 'TE2302002', 'TE2302002.png', 2, 0, '2023-02-26', '2023-02-26 01:17:57'),
(2, 37, 2023, 2, 1, NULL, NULL, NULL, 'TE2302003', 'TE2302003.png', 2, 0, '2023-02-26', '2023-02-26 01:24:01');

-- --------------------------------------------------------

--
-- 資料表結構 `document_file_record`
--

CREATE TABLE `document_file_record` (
  `document_file_record_id` int(11) NOT NULL,
  `document_file_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `state` varchar(20) NOT NULL,
  `document_type_document_state_id` int(11) DEFAULT NULL,
  `pass` int(11) DEFAULT NULL,
  `file` varchar(50) NOT NULL,
  `document_file_record_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `document_file_record`
--

INSERT INTO `document_file_record` (`document_file_record_id`, `document_file_id`, `staff_id`, `state`, `document_type_document_state_id`, `pass`, `file`, `document_file_record_time`) VALUES
(1, 1, 1, 'upload', NULL, NULL, 'TE2302002.png', '2023-02-26 00:52:57'),
(2, 1, 1, 'update', NULL, NULL, 'TE2302002.png', '2023-02-26 01:17:57'),
(3, 2, 37, 'upload', NULL, NULL, 'TE2302003.png', '2023-02-26 01:24:01'),
(4, 1, 1, 'close_case', 1, NULL, 'TE2302002.png', '2023-02-26 01:44:06'),
(5, 1, 1, 'open_case', 5, NULL, 'TE2302002.png', '2023-02-26 01:45:08'),
(6, 1, 1, 'reset_open_update', NULL, NULL, 'TE2302002.png', '2023-02-26 01:45:08');

-- --------------------------------------------------------

--
-- 資料表結構 `document_state`
--

CREATE TABLE `document_state` (
  `document_state_id` int(11) NOT NULL,
  `document_state_chinese` varchar(20) NOT NULL,
  `document_state_english` varchar(50) NOT NULL,
  `document_state_show_color` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `document_state`
--

INSERT INTO `document_state` (`document_state_id`, `document_state_chinese`, `document_state_english`, `document_state_show_color`) VALUES
(1, '關檔', 'close_case', 'red'),
(2, '開檔', 'open_case', 'green'),
(3, 'DP審核', 'dp_check', '');

-- --------------------------------------------------------

--
-- 資料表結構 `document_type`
--

CREATE TABLE `document_type` (
  `document_type_id` int(11) NOT NULL,
  `permission` varchar(20) NOT NULL,
  `document_type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `document_type`
--

INSERT INTO `document_type` (`document_type_id`, `permission`, `document_type`) VALUES
(1, 'jobno', 'Job No'),
(2, 'subpoena_number', '傳票號碼'),
(3, 'monthly_bill', '月結帳單'),
(4, 'daily_cost', '每日交易');

-- --------------------------------------------------------

--
-- 資料表結構 `document_type_department`
--

CREATE TABLE `document_type_department` (
  `document_type_department_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `document_type_department`
--

INSERT INTO `document_type_department` (`document_type_department_id`, `document_type_id`, `department_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 9),
(7, 1, 12),
(8, 2, 1),
(9, 2, 2),
(10, 2, 9),
(11, 2, 12),
(12, 3, 1),
(13, 3, 2),
(14, 3, 3),
(15, 3, 4),
(16, 3, 5),
(17, 3, 9),
(18, 3, 12),
(19, 4, 1),
(20, 4, 2),
(21, 4, 9);

-- --------------------------------------------------------

--
-- 資料表結構 `document_type_document_state`
--

CREATE TABLE `document_type_document_state` (
  `document_type_document_state_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_state_id` int(11) NOT NULL,
  `document_state_execution_sort` int(11) NOT NULL,
  `document_extra_case_field` varchar(20) DEFAULT NULL,
  `document_extra_case_condition` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `document_type_document_state`
--

INSERT INTO `document_type_document_state` (`document_type_document_state_id`, `document_type_id`, `document_state_id`, `document_state_execution_sort`, `document_extra_case_field`, `document_extra_case_condition`) VALUES
(1, 1, 1, 2, NULL, NULL),
(2, 2, 1, 1, NULL, NULL),
(3, 3, 1, 1, NULL, NULL),
(4, 4, 1, 1, NULL, NULL),
(5, 1, 2, 3, NULL, NULL),
(6, 2, 2, 2, NULL, NULL),
(7, 3, 2, 2, NULL, NULL),
(8, 4, 2, 2, NULL, NULL),
(9, 1, 3, 1, 'dp_check', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `document_type_owner_company`
--

CREATE TABLE `document_type_owner_company` (
  `document_type_owner_company_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `owner_company_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `document_type_owner_company`
--

INSERT INTO `document_type_owner_company` (`document_type_owner_company_id`, `document_type_id`, `owner_company_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 2, 2),
(6, 3, 2),
(7, 4, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `owner_company`
--

CREATE TABLE `owner_company` (
  `owner_company_id` int(11) NOT NULL,
  `company_chinese` varchar(20) NOT NULL,
  `company_english` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `owner_company`
--

INSERT INTO `owner_company` (`owner_company_id`, `company_chinese`, `company_english`) VALUES
(1, '測試股份有限公司', 'TESTCOMPANY'),
(2, '測試二股份有限公司', 'TESTTWOCOMPANY');

-- --------------------------------------------------------

--
-- 資料表結構 `position`
--

CREATE TABLE `position` (
  `position_id` int(255) NOT NULL,
  `position` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `position`
--

INSERT INTO `position` (`position_id`, `position`) VALUES
(1, '試用期職員'),
(2, '職員'),
(3, '儲備幹部'),
(4, '副理'),
(5, '經理'),
(6, '協理'),
(7, '副總經理'),
(8, '總經理');

-- --------------------------------------------------------

--
-- 資料表結構 `qac_document_file`
--

CREATE TABLE `qac_document_file` (
  `qac_document_file_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `bank_trade_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `pay_money` decimal(10,2) DEFAULT NULL,
  `document` varchar(50) NOT NULL,
  `file` text NOT NULL,
  `dp_check` int(11) DEFAULT NULL,
  `qac_document_file_del` int(11) NOT NULL DEFAULT 0,
  `create_time` date NOT NULL,
  `last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `qac_document_file`
--

INSERT INTO `qac_document_file` (`qac_document_file_id`, `staff_id`, `year`, `month`, `document_type_id`, `bank_trade_id`, `currency_id`, `pay_money`, `document`, `file`, `dp_check`, `qac_document_file_del`, `create_time`, `last_time`) VALUES
(1, 1, 2023, 2, 2, NULL, NULL, NULL, 'B230201001', 'B230201001.png', NULL, 0, '2023-02-26', '2023-02-26 02:00:38');

-- --------------------------------------------------------

--
-- 資料表結構 `qac_document_file_record`
--

CREATE TABLE `qac_document_file_record` (
  `qac_document_file_record_id` int(11) NOT NULL,
  `qac_document_file_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `state` varchar(20) NOT NULL,
  `document_type_document_state_id` int(11) DEFAULT NULL,
  `pass` int(11) DEFAULT NULL,
  `file` varchar(50) NOT NULL,
  `qac_document_file_record_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `qac_document_file_record`
--

INSERT INTO `qac_document_file_record` (`qac_document_file_record_id`, `qac_document_file_id`, `staff_id`, `state`, `document_type_document_state_id`, `pass`, `file`, `qac_document_file_record_time`) VALUES
(1, 1, 1, 'upload', NULL, NULL, 'B230201001.png', '2023-02-26 02:00:38');

-- --------------------------------------------------------

--
-- 資料表結構 `staff_account_list`
--

CREATE TABLE `staff_account_list` (
  `staff_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `staff_account_list`
--

INSERT INTO `staff_account_list` (`staff_id`, `username`, `password`) VALUES
(1, 'peter', 'peter123'),
(37, 'meng', 'test1234');

-- --------------------------------------------------------

--
-- 資料表結構 `staff_document_type_document_state`
--

CREATE TABLE `staff_document_type_document_state` (
  `staff_document_type_document_state_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `document_type_document_state_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `staff_document_type_document_state`
--

INSERT INTO `staff_document_type_document_state` (`staff_document_type_document_state_id`, `staff_id`, `document_type_document_state_id`) VALUES
(77, 1, 6),
(76, 1, 2),
(75, 1, 9),
(74, 1, 5),
(73, 1, 1),
(70, 37, 1),
(71, 37, 5),
(72, 37, 9);

-- --------------------------------------------------------

--
-- 資料表結構 `staff_list`
--

CREATE TABLE `staff_list` (
  `staff_id` int(255) NOT NULL,
  `cname` varchar(5) NOT NULL,
  `ename` varchar(10) NOT NULL,
  `elastname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `extension` int(3) NOT NULL,
  `position_id` int(11) NOT NULL,
  `birthday` date DEFAULT NULL,
  `staff_state_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `staff_list`
--

INSERT INTO `staff_list` (`staff_id`, `cname`, `ename`, `elastname`, `gender`, `email`, `extension`, `position_id`, `birthday`, `staff_state_id`, `create_time`) VALUES
(1, '章汶霖', 'Peter', 'Chang', 'male', 'peter777200067@test.com', 127, 4, '1997-07-04', 1, '2023-02-25 17:12:30'),
(37, '王阿明', 'Meng', 'Wang', 'male', 'meng@test.com', 111, 2, '1999-05-01', 1, '2023-02-25 16:48:34');

-- --------------------------------------------------------

--
-- 資料表結構 `staff_list_department`
--

CREATE TABLE `staff_list_department` (
  `staff_list_department_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `staff_list_department`
--

INSERT INTO `staff_list_department` (`staff_list_department_id`, `staff_id`, `department_id`) VALUES
(64, 1, 3),
(65, 1, 9),
(63, 37, 3);

-- --------------------------------------------------------

--
-- 資料表結構 `staff_owner_company`
--

CREATE TABLE `staff_owner_company` (
  `staff_owner_company_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `owner_company_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `staff_owner_company`
--

INSERT INTO `staff_owner_company` (`staff_owner_company_id`, `staff_id`, `owner_company_id`) VALUES
(47, 1, 2),
(46, 1, 1),
(42, 27, 1),
(43, 28, 1),
(44, 30, 1),
(45, 37, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `staff_state`
--

CREATE TABLE `staff_state` (
  `staff_state_id` int(255) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `staff_state`
--

INSERT INTO `staff_state` (`staff_state_id`, `state`) VALUES
(1, '在職'),
(2, '離職'),
(3, '留職停薪');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `bank_trade`
--
ALTER TABLE `bank_trade`
  ADD PRIMARY KEY (`bank_trade_id`);

--
-- 資料表索引 `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- 資料表索引 `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `department_id` (`department_id`);

--
-- 資料表索引 `document_file`
--
ALTER TABLE `document_file`
  ADD PRIMARY KEY (`document_file_id`);

--
-- 資料表索引 `document_file_record`
--
ALTER TABLE `document_file_record`
  ADD PRIMARY KEY (`document_file_record_id`);

--
-- 資料表索引 `document_state`
--
ALTER TABLE `document_state`
  ADD PRIMARY KEY (`document_state_id`);

--
-- 資料表索引 `document_type`
--
ALTER TABLE `document_type`
  ADD PRIMARY KEY (`document_type_id`);

--
-- 資料表索引 `document_type_department`
--
ALTER TABLE `document_type_department`
  ADD PRIMARY KEY (`document_type_department_id`);

--
-- 資料表索引 `document_type_document_state`
--
ALTER TABLE `document_type_document_state`
  ADD PRIMARY KEY (`document_type_document_state_id`);

--
-- 資料表索引 `document_type_owner_company`
--
ALTER TABLE `document_type_owner_company`
  ADD PRIMARY KEY (`document_type_owner_company_id`);

--
-- 資料表索引 `owner_company`
--
ALTER TABLE `owner_company`
  ADD PRIMARY KEY (`owner_company_id`);

--
-- 資料表索引 `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `position_id` (`position_id`);

--
-- 資料表索引 `qac_document_file`
--
ALTER TABLE `qac_document_file`
  ADD PRIMARY KEY (`qac_document_file_id`);

--
-- 資料表索引 `qac_document_file_record`
--
ALTER TABLE `qac_document_file_record`
  ADD PRIMARY KEY (`qac_document_file_record_id`);

--
-- 資料表索引 `staff_account_list`
--
ALTER TABLE `staff_account_list`
  ADD PRIMARY KEY (`staff_id`);

--
-- 資料表索引 `staff_document_type_document_state`
--
ALTER TABLE `staff_document_type_document_state`
  ADD PRIMARY KEY (`staff_document_type_document_state_id`);

--
-- 資料表索引 `staff_list`
--
ALTER TABLE `staff_list`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `staff_state_id` (`staff_state_id`);

--
-- 資料表索引 `staff_list_department`
--
ALTER TABLE `staff_list_department`
  ADD PRIMARY KEY (`staff_list_department_id`);

--
-- 資料表索引 `staff_owner_company`
--
ALTER TABLE `staff_owner_company`
  ADD PRIMARY KEY (`staff_owner_company_id`);

--
-- 資料表索引 `staff_state`
--
ALTER TABLE `staff_state`
  ADD PRIMARY KEY (`staff_state_id`),
  ADD KEY `staff_state_id` (`staff_state_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `bank_trade`
--
ALTER TABLE `bank_trade`
  MODIFY `bank_trade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_file`
--
ALTER TABLE `document_file`
  MODIFY `document_file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_file_record`
--
ALTER TABLE `document_file_record`
  MODIFY `document_file_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_state`
--
ALTER TABLE `document_state`
  MODIFY `document_state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_type`
--
ALTER TABLE `document_type`
  MODIFY `document_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_type_department`
--
ALTER TABLE `document_type_department`
  MODIFY `document_type_department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_type_document_state`
--
ALTER TABLE `document_type_document_state`
  MODIFY `document_type_document_state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `document_type_owner_company`
--
ALTER TABLE `document_type_owner_company`
  MODIFY `document_type_owner_company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `qac_document_file`
--
ALTER TABLE `qac_document_file`
  MODIFY `qac_document_file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `qac_document_file_record`
--
ALTER TABLE `qac_document_file_record`
  MODIFY `qac_document_file_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff_document_type_document_state`
--
ALTER TABLE `staff_document_type_document_state`
  MODIFY `staff_document_type_document_state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff_list`
--
ALTER TABLE `staff_list`
  MODIFY `staff_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff_list_department`
--
ALTER TABLE `staff_list_department`
  MODIFY `staff_list_department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff_owner_company`
--
ALTER TABLE `staff_owner_company`
  MODIFY `staff_owner_company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff_state`
--
ALTER TABLE `staff_state`
  MODIFY `staff_state_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
