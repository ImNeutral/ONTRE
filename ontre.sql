-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2015 at 08:22 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ontre`
--

-- --------------------------------------------------------

--
-- Table structure for table `adviser`
--

CREATE TABLE IF NOT EXISTS `adviser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fullname` (`fullname`,`dept_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=500707 ;

--
-- Dumping data for table `adviser`
--

INSERT INTO `adviser` (`id`, `fullname`, `dept_id`) VALUES
(500706, 'Christian Lagod Luceno', 1097),
(500703, 'Jamael Cordero Abato ', 1091),
(500702, 'Jazmin Mama', 1050),
(500705, 'Jofil Almendra Israel', 1050),
(500700, 'Mudzna Muin', 1050);

-- --------------------------------------------------------

--
-- Stand-in structure for view `adviser_thesis_view`
--
CREATE TABLE IF NOT EXISTS `adviser_thesis_view` (
`fullname` varchar(50)
,`title` varchar(100)
,`abstract` varchar(350)
);
-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fullname` (`fullname`,`dept_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150115 ;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `fullname`, `dept_id`) VALUES
(150105, 'Christian Luceno Garillo', 1097),
(150100, 'Christian Luceno Garillo Sor', 1051),
(150114, 'Eguiajwkdlwaws', 1052),
(150107, 'Geron Galela Ronquillo', 1050),
(150112, 'Johaira Capatagan', 1050),
(150103, 'Lyka Casamayor', 1103),
(150102, 'Rhodema Sorronda', 1050),
(150104, 'Rico Maglangat Macalangan', 1091),
(150113, 'Saida Omar', 1050);

-- --------------------------------------------------------

--
-- Table structure for table `author_thesis`
--

CREATE TABLE IF NOT EXISTS `author_thesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `author_id` (`author_id`,`thesis_id`),
  KEY `thesis_id` (`thesis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `author_thesis`
--

INSERT INTO `author_thesis` (`id`, `author_id`, `thesis_id`) VALUES
(11, 150100, 2015015),
(20, 150100, 2015017),
(21, 150100, 2015018),
(28, 150100, 2015036),
(31, 150100, 2015037),
(12, 150102, 2015015),
(22, 150102, 2015019),
(17, 150107, 2015008),
(9, 150107, 2015009),
(10, 150107, 2015010),
(13, 150107, 2015015),
(19, 150107, 2015017),
(29, 150112, 2015036),
(30, 150113, 2015036),
(32, 150114, 2015038);

-- --------------------------------------------------------

--
-- Stand-in structure for view `author_thesis_view`
--
CREATE TABLE IF NOT EXISTS `author_thesis_view` (
`fullname` varchar(50)
,`title` varchar(100)
,`abstract` varchar(350)
);
-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5017 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(5000, 'Website', 'All Capstone and Theses must be placed here.'),
(5001, 'Internet', 'All Theses about internet are placed here'),
(5002, 'Species', 'All Theses about Species are placed here'),
(5003, 'Elements', 'All Theses about Elements are placed here'),
(5004, 'Binary Digits', 'All Theses about Binary Digits are placed here'),
(5005, 'Barcode Scanner', 'All Theses about Barcode Scanner are placed here'),
(5006, 'Robotics', 'All Theses about Robotics are placed here'),
(5007, 'Flying Machine', 'All Theses about Flying Machine are placed here'),
(5008, 'Building', 'All Theses about Building are placed here'),
(5009, 'Architectural Design', 'All Theses about Architectural Design are placed here'),
(5010, 'Public Speaking', 'All Theses about Public Speaking are placed here'),
(5011, 'Finance', 'All Theses about Finance are placed here'),
(5012, 'Accounting', 'All Theses about Accounting are placed here'),
(5013, 'Galaxy', 'All Theses about Galaxy are placed here'),
(5014, 'PHP: Hypertext Preprocessor', 'All Thesis about websites that used PHP programming language are placed here.'),
(5015, 'Psychology', 'All thesis about psych must be placed here.'),
(5016, 'Science Of Book Categorization', 'All theses about the science of categorization are placed and organized here. All theses about the science of categorization are placed and organized ');

-- --------------------------------------------------------

--
-- Table structure for table `category_thesis`
--

CREATE TABLE IF NOT EXISTS `category_thesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`,`thesis_id`),
  KEY `thesis_id` (`thesis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `category_thesis`
--

INSERT INTO `category_thesis` (`id`, `category_id`, `thesis_id`) VALUES
(6, 5000, 2015008),
(43, 5000, 2015036),
(44, 5000, 2015037),
(47, 5000, 2015038),
(45, 5001, 2015037),
(31, 5004, 2015019),
(8, 5006, 2015010),
(32, 5006, 2015019),
(7, 5010, 2015009),
(27, 5013, 2015015),
(10, 5014, 2015008),
(30, 5014, 2015018),
(46, 5014, 2015037),
(28, 5015, 2015015),
(29, 5015, 2015017);

-- --------------------------------------------------------

--
-- Stand-in structure for view `category_thesis_view`
--
CREATE TABLE IF NOT EXISTS `category_thesis_view` (
`name` varchar(50)
,`title` varchar(100)
,`abstract` varchar(350)
);
-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE IF NOT EXISTS `college` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `abbreviation` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5019 ;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`id`, `name`, `abbreviation`) VALUES
(5001, 'College of Information Technology', 'CIT'),
(5002, 'College of Agriculture', 'COA'),
(5003, 'Graduate School', 'GS'),
(5004, 'College of Business Administration and Accountancy', 'CBAA'),
(5005, 'College of Education', 'COEd'),
(5006, 'College of Engineering', 'COE'),
(5007, 'College of Fisheries', 'COF'),
(5008, 'College of Forestry and Environmental Studies', 'CFES'),
(5009, 'College of Hotel and Restaurant Management', 'CHARM'),
(5010, 'King Faisal Center for Islamic, Arabic & Asian Studies', 'KFCIAAS'),
(5011, 'College of Natural Sciences and Mathematics', 'CNSM'),
(5012, 'College of Social Sciences and Humanities', 'CSSH'),
(5013, 'College of Sports, Physical Education and Recreation', 'CSPHERE'),
(5014, 'College of Public Affairs', 'CPA'),
(5015, 'College of Law', 'COL'),
(5016, 'College of Health Sciences', 'CHS'),
(5017, 'College of Medicine', 'COM'),
(5018, 'Division of Engineering Technology', 'DET');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) DEFAULT NULL,
  `name` varchar(80) NOT NULL,
  `abbreviation` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `college_id` (`college_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1114 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `college_id`, `name`, `abbreviation`) VALUES
(1050, 5001, 'Computer Studies Department', 'CSD'),
(1051, 5001, 'Information Systems Department', 'ISD'),
(1052, 5001, 'Support Services & Training Department', 'SST'),
(1053, 5001, 'Internet Services Center', 'ISC'),
(1054, 5002, 'Agricultural Engineering Department', ''),
(1055, 5002, 'Animal Science Department', ''),
(1056, 5002, 'Plant Science Department', ''),
(1057, 5002, 'Agribusines Management Department', ''),
(1058, 5002, 'Agricultural Education and Extension Department', ''),
(1059, 5003, 'Graduate (CPA)', ''),
(1060, 5003, 'Graduate (CED)', ''),
(1061, 5003, 'Graduate (KFCIAAS)', ''),
(1062, 5003, 'Graduate (CSPEAR)', ''),
(1063, 5003, 'Graduate (CBA)', ''),
(1064, 5003, 'Graduate (CSSH)', ''),
(1065, 5003, 'Graduate (ISED)', ''),
(1066, 5003, 'Graduate (CHS)', ''),
(1067, 5003, 'Graduate (COA)', ''),
(1068, 5003, 'Graduate (CNSM)', ''),
(1069, 5003, 'Graduate Education Department', ''),
(1070, 5004, 'Accountancy Department', ''),
(1071, 5004, 'Economics Department', ''),
(1072, 5004, 'Management Department', ''),
(1073, 5004, 'Marketing Department', ''),
(1074, 5005, 'Elementary Education Department', ''),
(1075, 5005, 'Home Economics Department', ''),
(1076, 5005, 'Secondary Education Department', ''),
(1077, 5005, 'Integrated Laboratory School', ''),
(1078, 5006, 'Chemical Engineering Department', ''),
(1079, 5006, 'Civil Engineering Department', ''),
(1080, 5006, 'Electrical Engineering Department', ''),
(1081, 5006, 'Mechanical Engineering Department', ''),
(1082, 5007, 'Fisheries Department', ''),
(1083, 5007, 'Fisheries Technology', ''),
(1084, 5008, 'Forestry Department', ''),
(1085, 5008, 'Forestry Technology Department', ''),
(1086, 5008, 'Environmental Science Department', ''),
(1087, 5009, 'Hotel Restaurant Management Department', ''),
(1088, 5010, 'International Relations Department', ''),
(1089, 5010, 'Islamic Studies Department', ''),
(1090, 5010, 'Teaching Arabic Department', ''),
(1091, 5011, 'Biology Department', ''),
(1092, 5011, 'Chemistry Department', ''),
(1093, 5011, 'Mathematics Department', ''),
(1094, 5011, 'Physics Department', ''),
(1095, 5012, 'English Department', ''),
(1096, 5012, 'Filipino Department', ''),
(1097, 5012, 'History Department', ''),
(1098, 5012, 'Library & Information Science Department', ''),
(1099, 5012, 'Philosophy Department', ''),
(1100, 5012, 'Political Science Department', ''),
(1101, 5012, 'Psychology Department', ''),
(1102, 5012, 'Sociology Department', ''),
(1103, 5012, 'Communication & Media Studies Department', ''),
(1104, 5013, 'Physical Education Department', ''),
(1105, 5014, 'Community Development Department', ''),
(1106, 5014, 'Public Administration Department', ''),
(1107, 5014, 'Social Work Department', ''),
(1108, 5015, 'Law Department', ''),
(1109, 5016, 'Midwifery Department', ''),
(1110, 5016, 'Nursing Department', ''),
(1111, 5017, 'Medicine Department', ''),
(1112, 5018, 'Wood Department', ''),
(1113, 5018, 'Metal Department', '');

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75177 ;

--
-- Dumping data for table `keyword`
--

INSERT INTO `keyword` (`id`, `keyword`) VALUES
(75166, 'Aw'),
(75170, 'Book'),
(75171, 'Bookeeping'),
(75172, 'Bookeeping!@$#%^&*'),
(75169, 'BookKeeping'),
(75113, 'Brain'),
(75110, 'Capstone'),
(75111, 'Demo'),
(75114, 'Math'),
(75116, 'Maths'),
(75115, 'Numbers'),
(75168, 'Online'),
(75165, 'Programming'),
(75119, 'Programmings'),
(75109, 'Repository'),
(75117, 'Robot'),
(75173, 'Robotics'),
(75175, 'Security'),
(75176, 'Test'),
(75108, 'Thesis'),
(75167, 'Thesis Aw'),
(75174, 'Web'),
(75100, 'Website');

-- --------------------------------------------------------

--
-- Table structure for table `keyword_thesis`
--

CREATE TABLE IF NOT EXISTS `keyword_thesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword_id` (`keyword_id`,`thesis_id`),
  KEY `thesis_id` (`thesis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `keyword_thesis`
--

INSERT INTO `keyword_thesis` (`id`, `keyword_id`, `thesis_id`) VALUES
(2, 75100, 2015008),
(173, 75108, 2015017),
(5, 75110, 2015008),
(49, 75116, 2015018),
(190, 75117, 2015019),
(191, 75165, 2015019),
(185, 75168, 2015036),
(186, 75171, 2015036),
(192, 75174, 2015037),
(193, 75175, 2015037),
(194, 75176, 2015038);

-- --------------------------------------------------------

--
-- Stand-in structure for view `keyword_thesis_view`
--
CREATE TABLE IF NOT EXISTS `keyword_thesis_view` (
`keyword` varchar(25)
,`id` int(11)
,`title` varchar(100)
,`type` enum('thesis','capstone')
,`thesis_status` int(1)
,`pdf_status` int(1)
);
-- --------------------------------------------------------

--
-- Table structure for table `librarian`
--

CREATE TABLE IF NOT EXISTS `librarian` (
  `college_id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  UNIQUE KEY `college_id` (`college_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `librarian`
--

INSERT INTO `librarian` (`college_id`, `username`, `password`) VALUES
(5001, 'CIT', '201316927'),
(5002, 'COA', 'password'),
(5003, 'GS', 'password'),
(5004, 'CBAA', 'password'),
(5005, 'COEd', 'password'),
(5006, 'COE', 'password'),
(5007, 'COF', 'password'),
(5008, 'CFES', 'password'),
(5009, 'CHARM', 'password'),
(5010, 'KFCIAAS', 'password'),
(5011, 'CNSM', 'password'),
(5012, 'CSSH', 'password'),
(5013, 'CSPHERE', 'password'),
(5014, 'CPA', 'password'),
(5015, 'COL', 'password'),
(5016, 'CHS', 'password'),
(5017, 'COM', 'password'),
(5018, 'DET', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `thesis`
--

CREATE TABLE IF NOT EXISTS `thesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adviser_id` int(11) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `abstract` varchar(350) DEFAULT NULL,
  `filename` varchar(150) DEFAULT NULL,
  `type` enum('thesis','capstone') DEFAULT NULL,
  `thesis_status` int(1) NOT NULL,
  `pdf_status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `title_2` (`title`),
  UNIQUE KEY `filename` (`filename`),
  KEY `adviser_id` (`adviser_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2015039 ;

--
-- Dumping data for table `thesis`
--

INSERT INTO `thesis` (`id`, `adviser_id`, `date_posted`, `title`, `abstract`, `filename`, `type`, `thesis_status`, `pdf_status`) VALUES
(2015008, 500700, '2015-05-28 09:20:19', 'Online Thesis Repository', 'This is a Thesis Repository for Mindanao State University. It is Available Online 24/7 anytime anywhere.This is a Thesis Repository for Mindanao State University. It is Available Online 24/7 anytime anywhere.', 'ONTRE Docu', 'capstone', 1, 1),
(2015009, 500705, '2015-05-28 15:05:45', 'Demodoc', 'This is a demodoc abstract.This is a demodoc abstract.This is a demodoc abstract.This is a demodoc abstract.This is a demodoc abstract.This is a demodoc abstract.\\r\\n', 'demodoc', 'thesis', 1, 0),
(2015010, 500705, '2015-05-28 15:06:54', 'Hello Sor', 'This is the abstract of hello.This is the abstract of hello.This is the abstract of hello.This is the abstract of hello.This is the abstract of hello.This is the abstract of hello.', 'hello', 'thesis', 1, 1),
(2015015, 500702, '2015-04-28 15:44:25', 'Hello Demo', 'Abstract of Hello demo thesis.Abstract of Hello demo thesis.Abstract of Hello demo thesis.Abstract of Hello demo thesis.', 'hello Demo', 'thesis', 1, 0),
(2015017, 500702, '2015-05-29 09:47:08', 'Brain Storming', 'This is a thesis about brain storming and this is very informative.  This is a thesis about brain storming and this is very informative. This is a thesis about brain storming and this is very informative. This is a thesis about brain storming and this is very informative.', 'Brain Storming', 'thesis', 1, 1),
(2015018, 500702, '2015-07-25 23:39:40', 'Online Math Reviewer', ' Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer Online Math Reviewer.', '90b09681a12a3e7b5bd466e3bffc07ce', 'capstone', 1, 1),
(2015019, 500700, '2015-07-29 08:52:39', 'Robot Programming', 'Robot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot ProgrammingRobot Programming.', '393e57433470763c2126aca0b13e9d09294859', 'thesis', 0, 1),
(2015036, 500702, '2015-08-02 00:14:13', 'OnlineBook Keeping', 'OnlineBook KeepingOnlineBook KeepingOnlineBook KeepingOnlineBook KeepingOnlineBook Keeping', 'f2c2dad825a185446940989ea16a032c021413', 'thesis', 1, 0),
(2015037, 500700, '2015-08-04 03:08:39', 'Web Security Checker', 'Web Security CheckerWeb Security CheckerWeb Security CheckerWeb Security CheckerWeb Security CheckerWeb Security CheckerWeb Security Checker.', 'f2c2dad825a185446940989ea16a032c040839', 'thesis', 1, 1),
(2015038, 500705, '2015-08-04 04:07:10', 'test', 'testtesttesttesttesttesttesttesttesttesttesttesttesttest', 'f2c2dad825a185446940989ea16a032c040710', 'capstone', 1, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `thesis_title_view`
--
CREATE TABLE IF NOT EXISTS `thesis_title_view` (
`id` int(11)
,`title` varchar(100)
,`abstract` varchar(350)
);
-- --------------------------------------------------------

--
-- Structure for view `adviser_thesis_view`
--
DROP TABLE IF EXISTS `adviser_thesis_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leaf`@`localhost` SQL SECURITY DEFINER VIEW `adviser_thesis_view` AS select `ad`.`fullname` AS `fullname`,`th`.`title` AS `title`,`th`.`abstract` AS `abstract` from (`thesis` `th` join `adviser` `ad`) where (`th`.`adviser_id` = `ad`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `author_thesis_view`
--
DROP TABLE IF EXISTS `author_thesis_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leaf`@`localhost` SQL SECURITY DEFINER VIEW `author_thesis_view` AS select `a`.`fullname` AS `fullname`,`th`.`title` AS `title`,`th`.`abstract` AS `abstract` from ((`thesis` `th` join `author` `a`) join `author_thesis` `at`) where ((`at`.`thesis_id` = `th`.`id`) and (`at`.`author_id` = `a`.`id`)) order by `a`.`fullname`;

-- --------------------------------------------------------

--
-- Structure for view `category_thesis_view`
--
DROP TABLE IF EXISTS `category_thesis_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leaf`@`localhost` SQL SECURITY DEFINER VIEW `category_thesis_view` AS select `c`.`name` AS `name`,`th`.`title` AS `title`,`th`.`abstract` AS `abstract` from ((`thesis` `th` join `category` `c`) join `category_thesis` `ct`) where ((`ct`.`thesis_id` = `th`.`id`) and (`ct`.`category_id` = `c`.`id`)) order by `c`.`name`;

-- --------------------------------------------------------

--
-- Structure for view `keyword_thesis_view`
--
DROP TABLE IF EXISTS `keyword_thesis_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leaf`@`localhost` SQL SECURITY DEFINER VIEW `keyword_thesis_view` AS select distinct `k`.`keyword` AS `keyword`,`th`.`id` AS `id`,`th`.`title` AS `title`,`th`.`type` AS `type`,`th`.`thesis_status` AS `thesis_status`,`th`.`pdf_status` AS `pdf_status` from ((`thesis` `th` join `keyword` `k`) join `keyword_thesis` `kt`) where ((`kt`.`thesis_id` = `th`.`id`) and (`kt`.`keyword_id` = `k`.`id`)) order by `k`.`keyword`;

-- --------------------------------------------------------

--
-- Structure for view `thesis_title_view`
--
DROP TABLE IF EXISTS `thesis_title_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`leaf`@`localhost` SQL SECURITY DEFINER VIEW `thesis_title_view` AS select `t`.`id` AS `id`,`t`.`title` AS `title`,`t`.`abstract` AS `abstract` from `thesis` `t` order by `t`.`title`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adviser`
--
ALTER TABLE `adviser`
  ADD CONSTRAINT `adviser_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `author_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `author_thesis`
--
ALTER TABLE `author_thesis`
  ADD CONSTRAINT `author_thesis_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `author_thesis_ibfk_2` FOREIGN KEY (`thesis_id`) REFERENCES `thesis` (`id`);

--
-- Constraints for table `category_thesis`
--
ALTER TABLE `category_thesis`
  ADD CONSTRAINT `category_thesis_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `category_thesis_ibfk_2` FOREIGN KEY (`thesis_id`) REFERENCES `thesis` (`id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`);

--
-- Constraints for table `keyword_thesis`
--
ALTER TABLE `keyword_thesis`
  ADD CONSTRAINT `keyword_thesis_ibfk_1` FOREIGN KEY (`keyword_id`) REFERENCES `keyword` (`id`),
  ADD CONSTRAINT `keyword_thesis_ibfk_2` FOREIGN KEY (`thesis_id`) REFERENCES `thesis` (`id`);

--
-- Constraints for table `librarian`
--
ALTER TABLE `librarian`
  ADD CONSTRAINT `librarian_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`);

--
-- Constraints for table `thesis`
--
ALTER TABLE `thesis`
  ADD CONSTRAINT `thesis_ibfk_1` FOREIGN KEY (`adviser_id`) REFERENCES `adviser` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
