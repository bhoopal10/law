-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2014 at 12:37 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lawyerz`
--
CREATE DATABASE IF NOT EXISTS `lawyerz` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lawyerz`;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_link` varchar(20) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `from_date` varchar(20) NOT NULL,
  `to_date` varchar(20) NOT NULL,
  `lawyers` varchar(20) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`appointment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `case_link`, `event_name`, `contact_person`, `location`, `from_date`, `to_date`, `lawyers`, `lawyer_id`, `status`, `date_created`, `date_updated`) VALUES
(1, '11', 'eqweqweqweqwe', 'bhoopal', 'NHFGHFHG', '2014-01-15 8:30 PM', '2014-01-21 7:10 PM', '10', 3, 1, '2014-01-04 09:16:54', '2014-01-04 09:18:05'),
(2, '6', 'rdgerterter', 'retewrtewrt', 'hgdfhfh', '2014-01-30 8:30 PM', '2014-01-25 7:21 PM', '9', 3, 2, '2014-01-04 09:18:06', '2014-01-04 09:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `case`
--

CREATE TABLE IF NOT EXISTS `case` (
  `case_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `lawyer_id` text NOT NULL,
  `case_name` varchar(100) NOT NULL,
  `case_no` varchar(50) NOT NULL,
  `case_type` varchar(50) NOT NULL,
  `case_subject` varchar(100) NOT NULL,
  `party_type` varchar(50) NOT NULL,
  `opp_party_name` varchar(50) NOT NULL,
  `opp_party_type` varchar(50) NOT NULL,
  `opp_advocate` varchar(50) NOT NULL,
  `brief_given_by` varchar(50) NOT NULL,
  `court_name` varchar(100) NOT NULL,
  `claim` varchar(100) NOT NULL,
  `citation_referred` text NOT NULL,
  `case_description` text NOT NULL,
  `case_color` varchar(20) NOT NULL,
  `associate_lawyer` varchar(50) NOT NULL,
  `status` int(2) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date_of_filling` date NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`case_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `case`
--

INSERT INTO `case` (`case_id`, `client_id`, `lawyer_id`, `case_name`, `case_no`, `case_type`, `case_subject`, `party_type`, `opp_party_name`, `opp_party_type`, `opp_advocate`, `brief_given_by`, `court_name`, `claim`, `citation_referred`, `case_description`, `case_color`, `associate_lawyer`, `status`, `updated_by`, `date_of_filling`, `created_on`) VALUES
(1, 1, '2', 'lao', '88', 'rta', 'nad', 'oawjwa', 'kahdj', 'ossj', 'kuja', 'gaha', 'kalaio', 'mana', 'maragauajk', 'marchu', 'red', '4', 0, 2, '2013-12-23', '2013-12-30 11:29:11'),
(2, 1, '2', 'lao', '88', 'rta', 'nad', 'oawjwa', 'kahdj', 'ossj', 'kuja', 'gaha', 'kalaio', 'mana', 'maragauajk', 'marchu', 'red', '4', 0, 2, '2013-12-23', '2013-12-30 11:29:12'),
(3, 1, '3', 'crime', '23456', 'fgdffdhdf', 'jhgjfghhgfh', 'edgtrtgdfddfs', 'hjghjbngdfghdfs', 'dfskj', 'juhghjggfhsdf', 'hgfhfdfgdgfhbgc', 'fds', 'jmbkjgh', 'kjhkjhkjhgfh', 'kjhkjhkjhgh', 'yellow', '6', 2, 3, '2013-12-13', '2013-12-30 12:35:36'),
(4, 1, '3', 'two', 'one', 'three', 'four', 'gsdg', 'dfsg', 'gdfsg', 'wadfasf', 'fgdf', 'gdfsgsd', 'fdsgdfs', 'gfgdfsg', 'sdfgsgsg', 'green', '6', 2, 3, '2013-12-26', '2013-12-30 16:50:38'),
(5, 1, '3', 'gjhghjg', 'jgjh', 'hjghj', 'ghjgjhg', 'jhkj', 'hkjhk', 'hkjh', 'mjgku', 'nbmjbhkj', 'kjh', 'mhgkjgj', 'hgjmg', 'hjgjh', 'yellow', '6', 2, 3, '2013-12-25', '2013-12-30 16:54:12'),
(6, 1, '3', 'hgjhfhjf', 'jhfhjgju', 'hjfhj', 'fhj', 'ghfhg', 'hfvnhf', 'fghf', 'mnvn', 'jhghjg', 'hjfnhj', 'mhfjhgj', 'hghj', 'ghjgf', 'green', '6', 2, 3, '2013-12-24', '2013-12-30 17:07:48'),
(7, 1, '6', 'bhoop', 'bhoopal123', 'kghjg', 'hjghj', 'ghfhgfghfh', 'fhgdfhgf', 'gfghfhgf', 'ngfhg', 'hgfhjgfh', 'hgfhgfhg', 'ngfhgfr', 'hgfhgf', 'ghfghf', 'green', '6', 0, 3, '2013-12-04', '2013-12-30 17:09:53'),
(8, 1, '6', 'bhoopal', '1223', 'kjhkjh', 'kjh', 'ghjg', 'hjghj', 'hjghj', ',ghjg', 'hkjh', 'ghj', 'mnbkj', 'kgh', 'jgkjg', 'green', ' ', 0, 3, '2013-12-25', '2013-12-30 17:11:48'),
(9, 1, '3', 'kjhkjhkjh', 'hjkjh', 'kjhkjhkjh', 'kjhkjhkjh', 'kjhkjhkj', 'kjkjkjh', 'hkjh', ',mb', 'jhgjkg', 'kjhkjh', 'jhkj', 'hkjhkjh', 'kjhkjhk', 'green', '6,7', 1, 3, '2013-12-31', '2013-12-30 17:45:37'),
(10, 1, '3', 'jkjkhkj', 'uu77', 'jkhjkl', 'hjkhk', 'kljkl', 'jkklj', 'jklj', 'lkjlkjkl', 'ikuyiuyi', 'lkjl', 'huuiui', 'yuiyiuiu', 'uiuiyiu', 'green', '6,7', 0, 7, '2013-12-31', '2013-12-30 18:13:42'),
(11, 1, '3', 'uuyugtu', 'ygyu', 'ygyufuyguy', 'gyugyugyu', 'jhghj', 'hjghjg', 'ghjghjg', 'jgjhv', 'juhguhyjgyju', 'jhgjhgjh', 'hgh', 'jhgjhgjhgj', 'hghjghjgj', 'red', '7', 1, 7, '2014-01-22', '2014-01-02 17:24:15'),
(12, 1, '3', 'kjhkjhkj', 'bhoo', 'kjhkjhkjh', 'kjhkjhkjh', 'hkjhkjhkj', 'gkjhkjhkjhkj', 'hkjhkjhkjh', 'mnbvjbkjbkj', 'kjhkhkjh', 'kjhkjhkjh', 'kjgjkjgkj', 'gkjgkjghjghj', 'ghjgjhghj', 'yellow', '6,7', 0, 3, '2014-01-25', '2014-01-02 17:32:42'),
(13, 1, '3', 'hkjh', 'jgkj', 'kjh', 'kjh', 'hjghj', 'hjgjhg', 'ghjg', 'mjg', 'jgjugjhgfyu', 'hjg', 'jhghjg', 'jghjghjg', 'hjghj', 'green', '7', 0, 7, '2014-01-22', '2014-01-03 06:05:17'),
(14, 0, '3', 'two', 'one', 'three', 'four', '', '', '', '', '', '', '', '', '', '', '', 0, 3, '0000-00-00', '2014-01-15 20:52:12'),
(15, 1, '3', 'kjh', 'jhkjhkj', 'kjhkj', 'hkj', 'tyut', 'jhygfytuyt', 'utyiu', 'mjhgjugt', 'jhbhjghjg', 'jutuyg', 'njhtryf', 'hgfhg', 'fhgfy', 'green', '7', 0, 3, '2014-01-16', '2014-01-19 17:24:32'),
(16, 2, '3', 'two', 'one', 'three', 'four', 'fghfghfghf', 'hgfghfhgfgh', 'ghfhgfghf', 'nhfhjgfhgf', 'hgfhgfhg', 'ghfghfghf', 'nghfrtdty', 'dtyytrtyrytrty', 'ytrtyrtyrty', 'green', '6,7', 0, 3, '2014-01-20', '2014-01-19 17:26:49'),
(17, 2, '3', 'hjgjhgjhgj', 'jhghjg', 'hghjghjghj', 'ghjghjghjg', 'hjghj', 'hgjhgjhg', 'gjhg', 'jhgjhgfjhg', 'hgfghfghf', 'hjghjg', 'jhfj', 'gfhjfg', 'hjghj', 'yellow', '6,7', 0, 3, '2014-01-15', '2014-01-19 17:34:43'),
(18, 2, '3', 'kjhkjh', 'nkjbkj', 'kjhkj', 'hkj', 'jgj', 'gjhgjhg', 'gjhgjhg', 'mhj', 'kjhkjhkj', 'gjhghjg', 'njhfhjgf', 'hjfjgfgh', 'jjfhjgfgh', 'green', '7', 0, 3, '2014-01-22', '2014-01-19 16:51:17'),
(19, 2, '3', 'hghj', 'jhgj', 'ghjg', 'hjg', 'hjghj', 'ghjg', 'ghjg', 'jhghj', 'jghkj', 'hjghjghj', 'jhf', 'hjgfhj', 'gfhjf', 'green', '6', 0, 3, '2014-01-23', '2014-01-19 16:54:12'),
(20, 2, '3', 'jhgfhj', 'mhjg', 'ghjg', 'hjg', 'gfhgfghfghf', 'fghfhgfh', 'hgfhgfhgf', 'nhgfhg', 'hfhjfgh', 'fhgfhf', 'jgfjf', 'hgfghfghf', 'ghfhgfhgfhg', 'green', '7', 0, 3, '2014-01-20', '2014-01-19 16:59:50'),
(21, 2, '3', 'hgjhgj', 'onejhgj', 'hgjhg', 'hjg', 'jhgjhghj', 'hjghjgjhg', 'ggjhghj', 'ghjgf', 'jhgtjuygtuy', 'gjhghjg', 'kmjgkjg', 'kjghjgj', 'hgjhgj', 'green', '7', 0, 3, '2014-01-16', '2014-01-19 17:02:39'),
(22, 0, '3', 'two', 'one', 'three', 'four', '', '', '', '', '', '', '', '', '', '', '', 0, 3, '0000-00-00', '2014-01-19 17:06:12'),
(23, 0, '3', 'two', 'one', 'three', 'four', '', '', '', '', '', '', '', '', '', '', '', 0, 3, '0000-00-00', '2014-01-19 17:08:10'),
(24, 2, '3', 'hjghjgjhg', 'nvhjhg', 'hjghjghjg', 'hgffhjg', 'gjhgjhghj', 'gjhghj', 'hghjgjh', 'jghjgjh', 'jhgjhgj', 'hgjhg', 'jhgfhjg', 'jhgjhghjg', 'jgjgjhgj', 'green', '6', 0, 3, '2014-01-17', '2014-01-19 17:09:38'),
(25, 0, '3', 'kjgjh', 'bjg', 'gjh', 'ghjg', 'fghf', 'ghfhg', 'ghf', 'bfvhgf', '', 'hggh', '', '', '', '', '6', 0, 3, '0000-00-00', '2014-01-19 17:11:07'),
(26, 2, '3', 'jkgkj', 'jghkjgh', 'gkjgh', 'kjgh', 'yiuyi', 'uiu', 'ugjh', 'jgjug', 'jhgjhghjgjh', 'bgjmghg', 'jhyfjhgfhjg', 'jhghjgjgjhg', 'hghjghjghjg', 'red', '6', 0, 6, '2014-01-22', '2014-01-19 17:30:27'),
(27, 2, '3', 'test', '432', 'jmhgjh', 'bhooo', 'gjhg', 'hgfhjghjghj', 'jhfjhygfjhb', 'jugj', 'hgfghfhgf', 'hjgfhjjgjh', 'jgjhu', 'gjhgjhghj', 'gjhghjghj', 'green', '6,7', 0, 3, '2014-01-11', '2014-01-19 17:30:36'),
(28, 2, '3', 'bhoo', '3333', 'hkjhkj', 'hkjhkj', 'gjhg', 'fjhgfhj', 'hjg', 'mhgfjh', 'dsfasdfsdf', 'hjghjgjhgj', 'kjgkj', 'gjhg', 'hjgjhg', 'green', '6,7', 0, 6, '2014-01-15', '2014-01-19 16:38:50'),
(29, 2, '3', 'jgjhg', 'mvjhgvnh', 'hjgj', 'hghj', 'hjfhj', 'fhjf', 'gfhjgfjhgfhj', 'hjdfh', 'ghfyjuhfjhytyju', 'hjgfhjgfhjgf', 'nmhfjhygfj', 'gjhgjhghj', 'ghjghjgjh', 'green', '6', 0, 6, '2014-01-30', '2014-01-24 12:23:52'),
(30, 1, '3', '', '12eee', 'rrr', 'four', 'fdf', 'ggrerer', 'ff', 'ffg', 'fffk', 'ffgerer', 'gfgf', 'fgfgererer', 'gfgf', 'yellow', '10', 0, 3, '2014-01-09', '2014-01-24 11:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `case_history`
--

CREATE TABLE IF NOT EXISTS `case_history` (
  `case_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `history` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`case_history_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `case_history`
--

INSERT INTO `case_history` (`case_history_id`, `case_id`, `history`, `created_date`) VALUES
(1, 19, '[{"uid":"3","modify":"initial","time":"2014-01-19 17:11:08"}]', '2014-01-19 16:54:12'),
(2, 21, '[{"uid":"3","modify":"initial","time":"2014-01-19 17:11:08"}]', '2014-01-19 17:02:39'),
(3, 24, '[{"uid":"3","modify":"initial","time":"2014-01-19 17:11:08"}]', '2014-01-19 17:09:39'),
(4, 25, '[{"uid":"3","modify":"initial","time":"2014-01-19 17:11:08"}]', '2014-01-19 17:11:08'),
(5, 26, '[{"uid":"6","modify":"initial","time":"2014-01-19 17:30:28"}]', '2014-01-19 17:30:28'),
(6, 27, '[{"uid":"3","modify":"initial","time":"2014-01-19 17:30:36"},{"uid":"3","modify":{"case_no":"testhtfhjyft"},"time":"2014-01-19 17:32:33"},{"uid":"3","modify":{"case_subject":"bhooo","opp_party_type":"jhfjhygfjhb"},"time":"2014-01-19 17:34:15"},{"uid":"6","modify":{"lawyer_id":"6","case_no":"45445","associate_lawyer":" "},"time":"2014-01-19 16:37:17"},{"uid":"3","modify":{"case_no":"432"},"time":"2014-01-20 10:45:58"},{"uid":"3","modify":{"associate_lawyer":"6,7"},"time":"2014-01-20 10:50:07"}]', '2014-01-19 17:30:36'),
(7, 28, '[{"uid":"6","modify":"initial","time":"2014-01-19 16:38:50"},{"uid":"6","modify":{"lawyer_id":"6","brief_given_by":"dsfasdfsdf"},"time":"2014-01-19 16:40:34"},{"uid":"6","modify":{"case_no":"btest12"},"time":"2014-01-20 10:36:05"},{"uid":"6","modify":{"case_no":"1235555","case_name":"bhggg"},"time":"2014-01-20 10:38:52"},{"uid":"3","modify":{"case_no":"123","associate_lawyer":"6,7"},"time":"2014-01-20 10:51:06"},{"uid":"6","modify":{"case_no":"3333","case_name":"bhoo"},"time":"2014-01-20 12:15:34"}]', '2014-01-19 16:38:50'),
(8, 29, '[{"uid":"6","modify":"initial","time":"2014-01-24 12:23:52"}]', '2014-01-24 12:23:52'),
(9, 30, '[{"uid":"3","modify":"initial","time":"2014-01-24 11:51:28"},{"uid":"3","modify":{"case_no":"12eee","case_name":"eerrerer","client_id":"1","opp_party_name":"ggrerer","court_name":"ffgerer","citation_referred":"fgfgererer","case_color":"yellow","associate_lawyer":"10"},"time":"2014-01-24 11:53:22"},{"uid":"3","modify":{"case_name":"","brief_given_by":"fffk"},"time":"2014-01-24 11:54:50"}]', '2014-01-24 11:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `case_statics`
--

CREATE TABLE IF NOT EXISTS `case_statics` (
  `uid` int(11) NOT NULL,
  `total_case` int(10) NOT NULL,
  `pending_case` int(10) NOT NULL,
  `processing_case` int(10) NOT NULL,
  `completed_case` int(10) NOT NULL,
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `case_statics`
--

INSERT INTO `case_statics` (`uid`, `total_case`, `pending_case`, `processing_case`, `completed_case`) VALUES
(1, 30, 24, 2, 4),
(2, 2, 2, 0, 0),
(3, 26, 20, 2, 4),
(4, 0, 0, 0, 0),
(5, 0, 0, 0, 0),
(6, 2, 2, 0, 0),
(7, 0, 0, 0, 0),
(8, 0, 0, 0, 0),
(9, 0, 0, 0, 0),
(10, 0, 0, 0, 0),
(11, 0, 0, 0, 0),
(12, 0, 0, 0, 0),
(13, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(45) DEFAULT NULL,
  `mobile` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(20) NOT NULL,
  `pincode` int(10) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `mobile`, `phone`, `address`, `city`, `state`, `pincode`, `created`) VALUES
(1, 'pavan', '7829696302', '08055698565', 'bangallore', 'bangalore', 'kartanataka', 560073, '2013-12-30 11:26:33'),
(2, 'bhoopal', '6546546546', '6546545645', 'hghgfhgfghfhg', 'fghf', 'ghfghf', 453564, '2014-01-19 17:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `contact_details` text NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `user_id`, `contact_details`) VALUES
(1, 2, '[{"first_name":"pavan","last_name":"kumar","mobile":"7829696109","phone":"08055698565","email":"pavan@gmail.com","group":"kagh","city":"bangalore","address":"bagalagunte"},{"first_name":"linga","last_name":"raju","mobile":"7829696302","phone":"08099258765","email":"linu@gmail.com","group":"hatys","city":"bangalore","address":"dasarahalli"}]'),
(2, 3, '[{"first_name":"bhoopal","last_name":";lk;lk;","mobile":"k;lk;lk","phone":";ll","email":"lmk","group":"kl","city":"mkmk","address":"k"},{"first_name":"ashes","last_name":"vats","mobile":"75687687","phone":"8768768768","email":"ashes@gmail.com","group":"mobil","city":"llkjl","address":"hgfghfh"},{"first_name":"gcnnnn","last_name":"bnb","mobile":"235342563425","phone":"321432432","email":"sdzsfs@dfdf.dfsfd","group":"sadf","city":"dsafasdf","address":"sadfsadf"}]'),
(3, 6, '[{"first_name":"bhoopal","last_name":"kjlkj","mobile":"lkj","phone":"lkj","email":"lkjl","group":"kjl","city":"kjlkj","address":"klj"}]');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_case_no` varchar(10) NOT NULL,
  `doc_name` varchar(50) NOT NULL,
  `doc_file_name` varchar(100) NOT NULL,
  `doc_description` text NOT NULL,
  `lawyer_id` int(10) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `backup_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gdrive_fileID` varchar(50) NOT NULL,
  `file_size` varchar(50) NOT NULL,
  PRIMARY KEY (`doc_id`),
  KEY `updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`doc_id`, `doc_case_no`, `doc_name`, `doc_file_name`, `doc_description`, `lawyer_id`, `updated_by`, `create_date`, `backup_date`, `gdrive_fileID`, `file_size`) VALUES
(15, '1', 'dfgdf', '_0801150328ashas.docx', 'dfgdfgdfg', 2, 2, '2014-01-08 15:03:34', '0000-00-00 00:00:00', '0B4t6RvVF7erSSnl5bnAtVTdOdU0', '0AIt6RvVF7erSUk9PVA'),
(16, '2', 'jmhjk', '_0801160324ashas.docx', '', 2, 2, '2014-01-08 16:03:26', '0000-00-00 00:00:00', '0B4t6RvVF7erSZ0FuSHhpNXhGTm8', '0AIt6RvVF7erSUk9PVA'),
(17, '2', '', '_0801160414ashas.docx', '', 2, 2, '2014-01-08 16:04:20', '0000-00-00 00:00:00', '0B4t6RvVF7erSUnhIZmk2TjBmYmM', '0AIt6RvVF7erSUk9PVA'),
(18, '1', 'hgjhg', '_0801161128ashas.docx', 'jhgfjg', 2, 2, '2014-01-08 16:11:36', '0000-00-00 00:00:00', '0B4t6RvVF7erSNHRUdjFiS0FQa28', '0AIt6RvVF7erSUk9PVA'),
(19, '1', 'kjgjh', '_0901054319ashas.docx', 'jhgjhghj', 2, 2, '2014-01-09 05:43:25', '0000-00-00 00:00:00', '0B4t6RvVF7erSM0poWGFZTWY0ZGs', '0AIt6RvVF7erSUk9PVA'),
(20, '2', 'nbgnfv', '_0901054911ashas.docx', 'nvgnhjfhj', 2, 2, '2014-01-09 05:49:19', '0000-00-00 00:00:00', '0B4t6RvVF7erSWktkU0REMVRzTm8', '0AIt6RvVF7erSUk9PVA');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `uid1` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uid` (`uid1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`uid1`, `uid2`, `created_date`) VALUES
(1, 0, '2013-12-30 10:52:47'),
(2, 1, '2013-12-30 11:09:48'),
(3, 1, '2013-12-30 11:16:55'),
(4, 2, '2013-12-30 11:22:55'),
(5, 2, '2013-12-30 11:23:48'),
(6, 3, '2013-12-30 11:33:01'),
(7, 3, '2013-12-30 17:59:55'),
(8, 1, '2014-01-04 05:14:38'),
(9, 3, '2014-01-21 13:09:50'),
(10, 3, '2014-01-21 13:10:25'),
(11, 3, '2014-01-21 13:11:04'),
(12, 3, '2014-01-21 13:11:38'),
(13, 3, '2014-01-24 11:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `hearing`
--

CREATE TABLE IF NOT EXISTS `hearing` (
  `hearing_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `doc_no` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `court_hall` varchar(50) NOT NULL,
  `judge` varchar(50) NOT NULL,
  `stage` varchar(50) NOT NULL,
  `hearing_date` varchar(10) DEFAULT NULL,
  `next_hearing_date` varchar(10) DEFAULT NULL,
  `sms_deliver` int(2) NOT NULL DEFAULT '3',
  `action_plan` text NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hearing_id`),
  KEY `case_no` (`case_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `hearing`
--

INSERT INTO `hearing` (`hearing_id`, `case_id`, `lawyer_id`, `doc_no`, `description`, `court_hall`, `judge`, `stage`, `hearing_date`, `next_hearing_date`, `sms_deliver`, `action_plan`, `updated_by`, `created_date`) VALUES
(9, 8, 3, '51', 'khklhkljh', 'hhfjhgjkhjhgkj', 'klhjlk', 'jlk', '2014-01-28', '2014-01-08', 4, 'jlk', 6, '2014-01-09 21:29:13'),
(13, 5, 3, '50', 'xcbxcb', 'bxcbx', 'xcbxcb', 'xcbxcb', '2014-01-15', '2014-01-30', 4, 'xbcxcbcxb', 6, '2014-01-21 13:00:00'),
(14, 16, 3, '50', 'dfgdfgdfg', 'gdfgdfgd', 'fgdfgdfgd', 'dgdfgdfg', '2014-01-21', '2014-01-22', 4, 'fdgdfgdfg', 3, '2014-01-21 13:07:27'),
(15, 19, 3, '50', 'dfgdsfg', 'dfsgsdf', 'sdfgdsf', 'dsfgsdfg', '2014-01-20', '2014-01-29', 4, 'dsfgdsfg', 3, '2014-01-21 13:07:42'),
(16, 10, 3, '50', 'adasdfasf', 'safasfa', 'asfasfas', 'asfasf', '2014-01-09', '2014-01-29', 3, 'asffasfasfa', 6, '2014-01-24 11:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_case`
--

CREATE TABLE IF NOT EXISTS `lawyer_case` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `permission` int(5) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `lawyer_case`
--

INSERT INTO `lawyer_case` (`permission_id`, `uid`, `case_id`, `permission`) VALUES
(1, 4, 1, 5),
(2, 4, 2, 7),
(3, 5, 3, 1),
(4, 6, 4, 2),
(6, 6, 6, 2),
(7, 6, 7, 2),
(8, 6, 8, 2),
(9, 6, 9, 2),
(10, 7, 10, 0),
(12, 6, 12, 2),
(13, 7, 12, 1),
(14, 6, 10, 2),
(20, 7, 11, 1),
(21, 7, 13, 2),
(22, 7, 15, 0),
(23, 6, 16, 2),
(24, 7, 16, 0),
(25, 6, 17, 2),
(26, 7, 17, 0),
(27, 7, 18, 0),
(28, 6, 19, 2),
(29, 7, 20, 0),
(30, 7, 21, 0),
(34, 6, 5, 0),
(35, 6, 26, 0),
(37, 6, 25, 0),
(38, 6, 24, 0),
(53, 6, 27, 0),
(54, 7, 27, 0),
(55, 6, 28, 0),
(56, 7, 28, 0),
(57, 6, 29, 0),
(60, 10, 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_id` varchar(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `to_status` smallint(6) NOT NULL,
  `from_status` tinyint(4) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `to_id`, `from_id`, `text`, `status`, `to_status`, `from_status`, `date`) VALUES
(1, '7', 3, 'bfdgfdgfdhgjmguhy', 0, 0, 1, '2014-01-04 09:39:22'),
(2, '7', 3, 'jhfjghjfh', 0, 0, 0, '2014-01-04 09:40:51'),
(3, '', 7, 'dsgsdg', 0, 0, 0, '2014-01-04 09:41:38'),
(4, '6', 7, 'hgdchgdgh', 0, 1, 0, '2014-01-04 09:58:56'),
(5, '3', 7, 'shdfhdfh', 0, 1, 0, '2014-01-04 10:06:47'),
(6, '3', 6, 'sadaslkdhklah', 0, 1, 1, '2014-01-09 21:28:39'),
(7, '7', 3, 'dsadasfdasfasfasfasfa', 0, 0, 0, '2014-01-21 02:36:52'),
(8, '6,7', 3, 'asfasfasgfasasdgadsgadsgadsgdasgadsg', 0, 0, 0, '2014-01-21 02:37:19'),
(9, '3,7', 6, 'sadfafadsgfadsgag', 0, 0, 1, '2014-01-21 02:38:33'),
(10, '3', 6, 'asdassaasddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 0, 1, 1, '2014-01-21 02:39:17'),
(11, '7', 6, 'easfwerwrewrewrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 0, 0, 0, '2014-01-21 02:40:29'),
(12, '6,7', 3, 'bhoopal', 0, 0, 0, '2014-01-21 03:14:15'),
(13, '7', 3, 'bhoop', 0, 0, 0, '2014-01-21 03:14:58'),
(14, '6', 3, 'bhoo123', 0, 1, 0, '2014-01-21 12:16:11'),
(15, '7', 3, 'bhoo123', 0, 1, 0, '2014-01-21 12:16:11'),
(16, '6', 3, 'bhghgfhghyghg', 0, 1, 1, '2014-01-21 12:18:48'),
(17, '7', 3, 'bhghgfhghyghg', 0, 0, 1, '2014-01-21 12:18:48'),
(18, '3', 6, 'safasdfasfgadsfasdgfadsgadsga', 0, 1, 1, '2014-01-21 13:09:17'),
(19, '3', 6, 'asdasdfasfadsfadsfasdfasdfsaf', 0, 1, 1, '2014-01-21 13:04:09'),
(20, '7', 6, 'asdasfasfa', 0, 0, 1, '2014-01-21 12:33:47'),
(21, '3', 6, 'asdasfasfa', 0, 1, 0, '2014-01-21 12:33:47'),
(22, '3', 6, 'dfhd', 0, 1, 1, '2014-01-21 12:33:59'),
(23, '6', 6, 'sdfsdgdfg', 0, 1, 1, '2014-01-21 12:39:55'),
(24, '3', 6, 'sdfsdgdfg', 0, 1, 1, '2014-01-21 12:39:55'),
(25, '6', 3, 'mjghjbvhjgjhgjhbg', 0, 1, 1, '2014-01-24 11:38:01'),
(26, '3', 6, 'sadnhmgasjghdahfasfasf', 0, 1, 0, '2014-01-24 12:24:50'),
(27, '6', 3, 'jhyygfjhgfhjfhjf', 0, 1, 1, '2014-01-24 11:38:42'),
(28, '6', 3, 'mhfhjfhjf', 0, 0, 1, '2014-01-24 11:38:58'),
(29, '7', 3, 'mhfhjfhjf', 0, 0, 1, '2014-01-24 11:38:58'),
(30, '11', 3, 'assmabsmgjh', 0, 0, 1, '2014-01-24 11:39:20'),
(31, '3', 6, 'fdxgdfsgdsfgdsfg', 0, 1, 0, '2014-01-24 11:56:41'),
(32, '3', 6, 'xcbxzcbzxcbzx', 0, 1, 0, '2014-01-24 11:56:49'),
(33, '3', 6, 'zxZcxzCxZc', 0, 0, 0, '2014-01-24 12:06:11'),
(34, '3', 6, 'zxczxczxcvz', 0, 0, 0, '2014-01-24 12:11:21'),
(35, '3', 6, 'dsfsdafs\r\nsdf\r\nadsf\r\nsadf\r\nasd\r\nf\r\nsa', 0, 1, 0, '2014-01-24 12:13:54'),
(36, '3', 6, 'zxCzXC\r\nasds\r\nADSS\r\n\r\nSD\r\nSdf\r\ns\r\nFSFASFASFASF\r\nSAFSAFASFASFASF\r\nASFASFASF', 0, 1, 0, '2014-01-24 12:16:19'),
(37, '6', 3, 'DSFDSAFSADFADSFADSFDS', 0, 0, 0, '2014-01-24 12:21:46'),
(38, '7', 3, 'DSFDSAFSADFADSFADSFDS', 0, 0, 0, '2014-01-24 12:21:46'),
(39, '6', 3, 'zscfasfasfasfasf', 0, 0, 0, '2014-01-24 12:24:06'),
(40, '6', 3, 'safasffsdfsdfdsafsadfasdfsd', 0, 1, 0, '2014-01-24 12:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid1` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `event_id` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `read_status` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `uid1`, `uid2`, `event_id`, `text`, `read_status`, `created_date`) VALUES
(1, 1, 6, '8', 'New case added', 0, '2013-12-30 17:11:48'),
(2, 1, 6, '9', 'New case added', 0, '2013-12-30 17:45:38'),
(3, 3, 7, '#10', 'New Case Added', 1, '2013-12-30 18:13:43'),
(4, 3, 7, '#11', 'New Case Added', 1, '2014-01-02 17:24:15'),
(5, 3, 7, '#13', 'New Case Added', 1, '2014-01-03 06:05:17'),
(6, 3, 6, '#26', 'New Case Added', 1, '2014-01-19 17:30:28'),
(7, 3, 6, '#28', 'New Case Added', 1, '2014-01-19 16:38:50'),
(8, 6, 3, '@16', 'New Message', 1, '2014-01-21 12:18:48'),
(9, 3, 7, '@17', 'New Message', 1, '2014-01-21 12:18:48'),
(10, 3, 6, '@18', 'New Message', 1, '2014-01-21 13:09:18'),
(11, 3, 6, '@19', 'New Message', 1, '2014-01-21 13:04:10'),
(12, 7, 6, '@20', 'New Message', 0, '2014-01-21 12:33:47'),
(13, 3, 6, '@21', 'New Message', 1, '2014-01-21 12:33:47'),
(14, 6, 6, '@22', 'New Message', 1, '2014-01-21 12:33:59'),
(15, 6, 6, '@23', 'New Message', 1, '2014-01-21 12:39:55'),
(16, 3, 6, '@24', 'New Message', 1, '2014-01-21 12:39:55'),
(17, 6, 3, '@25', 'New Message', 1, '2014-01-24 11:38:01'),
(18, 3, 6, '#29', 'New Case Added', 1, '2014-01-24 12:23:52'),
(19, 3, 6, '@26', 'New Message', 1, '2014-01-24 12:24:50'),
(20, 6, 3, '@27', 'New Message', 1, '2014-01-24 11:38:42'),
(21, 6, 3, '@28', 'New Message', 1, '2014-01-24 11:38:58'),
(22, 7, 3, '@29', 'New Message', 0, '2014-01-24 11:38:58'),
(23, 11, 3, '@30', 'New Message', 0, '2014-01-24 11:39:20'),
(24, 3, 6, '@31', 'New Message', 1, '2014-01-24 11:56:41'),
(25, 3, 6, '@32', 'New Message', 1, '2014-01-24 11:56:49'),
(26, 3, 6, '@33', 'New Message', 1, '2014-01-24 12:06:11'),
(27, 3, 6, '@34', 'New Message', 1, '2014-01-24 12:11:22'),
(28, 3, 6, '@35', 'New Message', 1, '2014-01-24 12:13:54'),
(29, 3, 6, '@36', 'New Message', 1, '2014-01-24 12:16:19'),
(30, 6, 3, '@37', 'New Message', 1, '2014-01-24 12:21:46'),
(31, 7, 3, '@38', 'New Message', 0, '2014-01-24 12:21:46'),
(32, 6, 3, '@39', 'New Message', 1, '2014-01-24 12:24:06'),
(33, 6, 3, '@40', 'New Message', 1, '2014-01-24 12:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `setting_table`
--

CREATE TABLE IF NOT EXISTS `setting_table` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `auto_upload` int(2) NOT NULL,
  `auto_backup` int(2) NOT NULL,
  `sms_credit` int(15) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `sms_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`sms_id`, `client_id`, `lawyer_id`, `message`, `created_date`) VALUES
(1, 1, 6, 'hearing date remaining 4 days', '2014-01-24 06:40:16'),
(2, 1, 6, 'hearing date remaining 4 days', '2014-01-24 06:40:56'),
(3, 1, 6, 'hearing date remaining 4 days', '2014-01-24 06:57:11'),
(4, 1, 6, 'hearing date remaining 4 days', '2014-01-24 06:57:14'),
(5, 1, 6, 'hearing date remaining 4 days', '2014-01-24 06:57:17'),
(6, 1, 6, 'hearing date remaining 4 days', '2014-01-24 11:32:19'),
(7, 1, 6, 'hearing date remaining 4 days', '2014-01-24 11:44:17'),
(8, 1, 6, 'hearing date remaining 4 days', '2014-01-24 11:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `lawyer_id` varchar(20) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_role` int(10) NOT NULL,
  `user_log` text NOT NULL,
  `lawyer_subject` varchar(50) NOT NULL,
  `mobile` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exp_date` varchar(20) NOT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `case_case_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `lawyer_id`, `user_email`, `password`, `user_role`, `user_log`, `lawyer_subject`, `mobile`, `phone`, `address`, `city`, `pincode`, `updated_by`, `reg_date`, `exp_date`, `payment`, `case_case_id`) VALUES
(1, 'bhoopal12', 't12', 'bnb12', 'bhoopal@gmail.com', '$2a$08$rWmqyypEFz7RmVNXXYjyYOSKMwf7BNtEYhSJwH4pyKza.BOJLDSxm', 1, '', 'civil', '1243545456', '', '', '', 0, 0, '2013-12-30 10:52:47', '', 'paid', 0),
(2, 'manju', 'nath', 'man45', 'manju@gmail.com', '$2a$08$unsxRTuI1KIxbblW5ddDhefJT3gNLftgWh8GbxZ0jaxx8ksBYWr7a', 2, '', 'lopa', '9848681859', '', '', '', 0, 1, '2013-12-30 11:09:48', '', 'paid', 0),
(3, 'ashes', 'vats', 'bb34', 'ashes@gmail.com', '$2a$08$az9CcwVUXXpO4KkupgHk3ulSQjsWFd03G89Q39Fe3YwmkVQ6yoDJ.', 2, '', 'family', '989878787', '', '', '', 0, 1, '2013-12-30 11:16:55', '', 'paid', 0),
(4, 'linga', 'raju', 'linga11', 'lingu@gmail.com', '$2a$08$JGsOr1BaW.HNhBMnV.tDCejSU0ePIGRvRiAlUMivE9Cpa4iDdSMKq', 0, '', 'polo', '7353969610', '', '', '', 0, 2, '2013-12-30 11:22:55', '', 'paid', 0),
(5, 'pavan', 'kumar', 'pavan', 'pavan@gmail.com', '$2a$08$mxQ2O.IRj/z4DQRBdn6zc.i6TyUi0Hhp/kODWwhuP/P9tKuHcKZ2i', 0, '', 'pavi', '7829696109', '', '', '', 0, 2, '2013-12-30 11:23:48', '', 'paid', 0),
(6, 'ramesh', 'n', 'jkj67', 'bhoo@locura.in', '$2a$08$0uLxpT276lFYUCy6d2rBeOxHnTmqDhgDhUHhzycfnH.bRk0u5C8je', 3, '', 'mjkjkj', '912123434545', '', '', '', 0, 3, '2013-12-30 11:33:01', '', 'paid', 0),
(7, 'ramu', 'ar', '87981j', 'ramu@gmail.com', '$2a$08$M.rGGHu0.R5jSLzgLNlfSOR5iCrbyalGRM7d8/zcRtJPEhgGiK4JG', 3, '', 'civil', '9898787878', '', '', '', 0, 3, '2013-12-30 17:59:55', '', 'paid', 0),
(8, 'saroj', 'sah', '1234', 'saroj4u2702@gmail.com', '$2a$08$az3HcVKnjTGBpoq2dKfgj.VgrHphN4STZNPjF7HFle1OlzpdwuHJ6', 2, '', 'asdf', '8088601307', '', '', '', 0, 1, '2014-01-04 05:14:38', '2014-01-19', 'trail', 0),
(9, 'qqqqqqqqqqqqqq', 'aas', '6565ggfh', 'bhoo@gmail.com', '$2a$08$dz14Ksw4nNORqK37JB6qxOCaWuVxy9KH/DlXcsGySSJrbgLMs660K', 3, '', 'bhgfh', '687676686786', '', '', '', 0, 3, '2014-01-21 13:09:50', '', 'paid', 0),
(10, 'tbhoopal', 'tbhoo', '87687jhgjhg', 'tbhoo@gmail.com', '$2a$08$cUjpNDebwjf1zQxUXZOTU.TfI/VMenXN4i7ZMHvIwujQkaWk9MZ2q', 3, '', 'hjgjkgjh', '6876878678', '', '', '', 0, 3, '2014-01-21 13:10:25', '', 'paid', 0),
(11, 'bht', 'tyyty', '6757', 'bhoopa@gmail.com', '$2a$08$HBpTJXeT2VEKvtKrR8BqteQryHULryJQq3aFfIfiEZ0.GpCss/XFq', 0, '', 'jhgjhg', '87687687', '', '', '', 0, 3, '2014-01-21 13:11:04', '', 'paid', 0),
(12, 'bhooo', 'bhooo', 'uytuytuy', 'bhoo@jj.com', '$2a$08$BxoNRdu/uadqWMOtY4ZCYOAHBhhyZ9vwIP8BLgWBa./xhq7qj8tw.', 0, '', 'jhbgjhgh', '6765876879687', '', '', '', 0, 3, '2014-01-21 13:11:38', '', 'paid', 0),
(13, 'bjhbjhbgjh', 'kjkjhkjhk', 'khkjhkjh', 'bhoop@jkjk.hkj', '$2a$08$AsLtXPVNiJbwU2JIMocDsOTG0nHajsQFge1JqRiO8KIUkpPxFUnQe', 0, '', 'kjkjhkjh', '6768768', '', '', '', 0, 3, '2014-01-24 11:37:10', '', 'paid', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`, `reg_date`) VALUES
(1, 'admin', '2013-11-06 07:06:19'),
(2, 'lawyer', '2013-11-06 07:06:19'),
(3, 'associate', '2013-11-22 05:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE IF NOT EXISTS `user_settings` (
  `ui` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `document_auto_upload` tinyint(4) NOT NULL,
  `backup_auto_upload` tinyint(4) NOT NULL,
  `message_permission` int(2) NOT NULL,
  `contact_permission` int(2) NOT NULL,
  `calender_permission` int(2) NOT NULL,
  `no_associate` int(10) NOT NULL,
  `no_sms` int(11) NOT NULL,
  UNIQUE KEY `ui` (`ui`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_settings`
--

INSERT INTO `user_settings` (`ui`, `image`, `created_date`, `document_auto_upload`, `backup_auto_upload`, `message_permission`, `contact_permission`, `calender_permission`, `no_associate`, `no_sms`) VALUES
(1, '_0701094553Bhoopal.jpg', '2013-12-30 10:52:47', 0, 0, 0, 0, 0, 0, 0),
(2, '', '2013-12-30 11:09:48', 1, 0, 0, 1, 1, 22, 0),
(3, '_3012112144Bhoopal.jpg', '2013-12-30 11:16:55', 1, 0, 1, 1, 0, 10, 12),
(4, '', '2013-12-30 11:22:55', 0, 0, 0, 0, 0, 0, 0),
(5, '', '2013-12-30 11:23:48', 0, 0, 0, 0, 0, 0, 0),
(6, '_2101121830scan0165.jpg', '2013-12-30 11:33:01', 0, 0, 0, 0, 0, 0, 0),
(7, '', '2013-12-30 17:59:55', 0, 0, 0, 0, 0, 0, 0),
(8, '_0401051634saroj (2).jpg', '2014-01-04 05:14:38', 0, 0, 1, 0, 1, 54, 4),
(9, '', '2014-01-21 13:09:50', 0, 0, 0, 0, 0, 0, 0),
(10, '', '2014-01-21 13:10:25', 0, 0, 0, 0, 0, 0, 0),
(11, '', '2014-01-21 13:11:04', 0, 0, 0, 0, 0, 0, 0),
(12, '', '2014-01-21 13:11:38', 0, 0, 0, 0, 0, 0, 0),
(13, '', '2014-01-24 11:37:10', 0, 0, 0, 0, 0, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case_history`
--
ALTER TABLE `case_history`
  ADD CONSTRAINT `case_history_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `case_statics`
--
ALTER TABLE `case_statics`
  ADD CONSTRAINT `case_statics_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hearing`
--
ALTER TABLE `hearing`
  ADD CONSTRAINT `hearing_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`ui`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
