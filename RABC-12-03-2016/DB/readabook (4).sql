-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2016 at 07:59 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `readabook`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_info`
--

CREATE TABLE `book_info` (
  `id` int(11) NOT NULL,
  `physical_form` enum('Book','Journal','CD/DVD','Manuscript','Others') CHARACTER SET utf8 NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `author` text CHARACTER SET utf8 NOT NULL,
  `subtitle` varchar(100) CHARACTER SET utf8 NOT NULL,
  `edition_year` date NOT NULL,
  `publisher` varchar(100) CHARACTER SET utf8 NOT NULL,
  `series` varchar(100) CHARACTER SET utf8 NOT NULL,
  `size1` enum('Medium','Large','Huge','Small','Tiny') CHARACTER SET utf8 NOT NULL,
  `price` varchar(100) CHARACTER SET utf8 NOT NULL,
  `call_no` varchar(100) CHARACTER SET utf8 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 NOT NULL,
  `clue_page` varchar(100) CHARACTER SET utf8 NOT NULL,
  `category_id` varchar(100) CHARACTER SET utf8 NOT NULL,
  `editor` varchar(100) CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `edition` varchar(100) CHARACTER SET utf8 NOT NULL,
  `publishing_year` date NOT NULL,
  `publication_place` varchar(100) CHARACTER SET utf8 NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `number_of_books` int(11) NOT NULL,
  `dues` varchar(100) CHARACTER SET utf8 NOT NULL,
  `isbn` varchar(100) CHARACTER SET utf8 NOT NULL,
  `source_details` enum('Local Purchase','University','World Bank Donation','Personal Donation','Others') CHARACTER SET utf8 NOT NULL,
  `notes` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cover` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT 'cover_default.jpg',
  `pdf` text CHARACTER SET utf8,
  `is_uploaded` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `deleted` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `status` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '1',
  `add_date` datetime NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_info`
--

INSERT INTO `book_info` (`id`, `physical_form`, `vendor`, `author`, `subtitle`, `edition_year`, `publisher`, `series`, `size1`, `price`, `call_no`, `location`, `clue_page`, `category_id`, `editor`, `title`, `edition`, `publishing_year`, `publication_place`, `number_of_pages`, `number_of_books`, `dues`, `isbn`, `source_details`, `notes`, `cover`, `pdf`, `is_uploaded`, `deleted`, `status`, `add_date`, `group_id`) VALUES
(19, '', 'Rishav', 'Stephen W. Hawking', 'From the Big Bang to Black Holes', '1989-01-01', 'Bantam', '', '', '', '', '', '', '35', '', 'A Brief History of Time', '', '1989-01-01', '', 211, 1, '', '9780553176988', '', '', 'http://books.google.com/books/content?id=u5daSQAACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:32:17', 0),
(20, 'Book', 'Rishav', 'Stephen W Hawking', '', '2016-10-02', 'Jaico', '', '', '', '', '', '', '35', '', 'The theory of everything', '', '0000-00-00', '', 0, 1, '', '9788179925911', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 05:34:04', 0),
(21, '', 'Rishav', 'John Keay', 'A History: from the Earliest Civilisations to the Boom of the Twenty-first Century', '0000-00-00', '', '', '', '', '', '', '', '36', '', 'India', '', '0000-00-00', '', 658, 1, '', '9780802145581', '', '', 'http://books.google.com/books/content?id=RwYPngEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:39:01', 0),
(22, '', 'Rishav', 'J. D. Viharini', 'The Essential Handbook', '2010-01-01', 'Tara Satara Press', '', '', '', '', '', '', '37', '', 'Enjoying India', '', '2010-01-01', '', 306, 1, '', '9780981950303', '', '', 'http://books.google.com/books/content?id=ouDPQgAACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:40:12', 0),
(23, '', 'Rishav', 'Sarina Singh', '', '2013-01-10', 'Lonely Planet', '', '', '', '', '', '', '37', '', 'India', '', '2013-01-10', '', 1248, 1, '', '9781742204123', '', '', 'http://books.google.com/books/content?id=jSOekQEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:40:55', 0),
(24, '', 'Rishav', 'Lonely Planet, Andrew Bain', 'Our List of the 500 Best Places on the Planet - Ranked', '2015-10-20', 'Lonely Planet', '', '', '', '', '', '', '37', '', 'Lonely Planet\'s Ultimate Travel', '', '2015-10-20', '', 328, 1, '', '9781760342777', '', '', 'http://books.google.com/books/content?id=nBEGswEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:42:59', 0),
(25, '', 'Rishav', 'Somini Sengupta', 'Hope and Fury Among India\'s Young', '2016-03-07', 'W. W. Norton', '', '', '', '', '', '', '', '', 'The End of Karma', '', '2016-03-07', '', 256, 1, '', '9780393071009', '', '', 'http://books.google.com/books/content?id=S5_msgEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:44:30', 0),
(26, '', 'Rishav', 'Anja Manuel', 'India, China and the United States', '2016-05-10', 'Simon and Schuster', '', '', '', '', '', '', '38', '', 'This Brave New World', '', '2016-05-10', '', 368, 1, '', '9781501121975', '', '', 'http://books.google.com/books/content?id=qAccDAAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:44:53', 0),
(27, '', 'Rishav', 'Stephan Weaver', '', '2015-11-20', 'Createspace Independent Publishing Platform', '', '', '', '', '', '', '', '', 'The History of India in 50 Events', '', '2015-11-20', '', 84, 1, '', '9781519395375', '', '', 'http://books.google.com/books/content?id=z3vvjgEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:46:24', 0),
(28, '', 'Rishav', 'Gregory David Roberts', 'A Novel', '2005-10-01', 'Macmillan', '', '', '', '', '', '', '39', '', 'Shantaram', '', '2005-10-01', '', 944, 1, '', '9780312330538', '', '', 'http://books.google.com/books/content?id=VdMFmq92Fa8C&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:46:56', 0),
(29, '', 'Rishav', 'Lonely Planet, John Noble, Trent Holden', '', '2015-10-01', '', '', '', '', '', '', '', '37', '', 'Lonely Planet South India & Kerala', '', '2015-10-01', '', 544, 1, '', '9781743216774', '', '', 'http://books.google.com/books/content?id=UqoQrgEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:47:32', 0),
(30, '', 'Rishav', 'Edward Luce', 'The Rise of Modern India', '0000-00-00', 'Anchor', '', '', '', '', '', '', '36', '', 'In Spite of the Gods', '', '0000-00-00', '', 383, 1, '', '9781400079773', '', '', 'http://books.google.com/books/content?id=R-55tgAACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:48:20', 0),
(31, '', 'Rishav', 'Akash Kapur', 'A Portrait of Life in Modern India', '2013-03-05', 'Riverhead Trade (Paperbacks)', '', '', '', '', '', '', '38', '', 'India Becoming', '', '2013-03-05', '', 319, 1, '', '9781594486531', '', '', 'http://books.google.com/books/content?id=ghw2LwEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:48:48', 0),
(32, '', 'Rishav', 'Meera Sodha', 'Recipes from an Indian Family Kitchen', '2015-09-15', 'Macmillan', '', '', '', '', '', '', '40', '', 'Made in India', '', '2015-09-15', '', 320, 1, '', '9781250071019', '', '', 'http://books.google.com/books/content?id=0zieCQAAQBAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:52:46', 0),
(33, '', 'Rishav', 'Jon Wilson', 'The British Raj and the Conquest of India', '2016-10-25', '', '', '', '', '', '', '', '36', '', 'The Chaos of Empire', '', '2016-10-25', '', 584, 1, '', '9781610392938', '', '', 'http://books.google.com/books/content?id=CEl0jwEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:55:53', 0),
(34, '', 'Rishav', 'John K.', 'The Land of Mystery, Mysticism, Mythology, Miracles, Multiculturalism, and Mightiness', '2016-05-28', 'Createspace Independent Publishing Platform', '', '', '', '', '', '', '', '', 'India', '', '2016-05-28', '', 84, 1, '', '9781515297130', '', '', 'http://books.google.com/books/content?id=uowNkAEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:56:16', 0),
(35, '', 'Rishav', 'Bobbie Kalman', 'The People', '2009-08-01', '', '', '', '', '', '', '', '41', '', 'India', '', '2009-08-01', '', 32, 1, '', '9780778796565', '', '', 'http://books.google.com/books/content?id=QzB_PwAACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 05:56:51', 0),
(36, '', 'Rishav', 'Srinath Raghavan', 'World War II and the Making of Modern South Asia', '2016-05-10', '', '', '', '', '', '', '', '', '', 'India\'s War', '', '2016-05-10', '', 560, 1, '', '9780465030224', '', '', 'http://books.google.com/books/content?id=FsAtjgEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:06:16', 0),
(37, '', 'Rishav', 'Avul Pakir Jainulabdeen Abdul Kalam, Arun Tiwari', 'An Autobiography', '1999-01-01', 'Universities Press', '', '', '', '', '', '', '42', '', 'Wings of Fire', '', '1999-01-01', '', 180, 1, '', '9788173711466', '', '', 'http://books.google.com/books/content?id=c3qmIZtWUjAC&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:08:09', 0),
(38, '', 'Rishav', 'Avul Pakir Jainulabdeen Abdul Kalam', 'Transforming Dreams Into Actions', '2014-09-01', 'Rupa Publications', '', '', '', '', '', '', '43', '', 'My Journey', '', '2014-09-01', '', 160, 1, '', '9788129124913', '', '', 'http://books.google.com/books/content?id=96XCAgAAQBAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:08:32', 0),
(39, '', 'Rishav', 'A P J Abdul Kalam, Arun Tiwari', '', '2015-06-20', 'Element India', '', '', '', '', '', '', '44', '', 'Transcendence: My Spiritual Experiences with Pramukh Swamiji', '', '2015-06-20', '', 256, 1, '', '9789351774051', '', '', 'http://books.google.com/books/content?id=MqAfswEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:09:20', 0),
(40, '', 'Rishav', 'Avul Pakir Jainulabdeen Abdul Kalam', 'A Journey Through Challenges', '0000-00-00', 'HarperCollins', '', '', '', '', '', '', '45', '', 'Turning Points', '', '0000-00-00', '', 182, 1, '', '9789350293478', '', '', 'http://books.google.com/books/content?id=hy16MwEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:09:49', 0),
(41, '', 'Rishav', 'Nameless', '', '2015-08-17', 'CreateSpace', '', '', '', '', '', '', '46', '', 'Ignited Quotes of Dr Apj Abdul Kalam', '', '2015-08-17', '', 104, 1, '', '9781516926350', '', '', 'http://books.google.com/books/content?id=uL8gswEACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:10:09', 0),
(42, '', 'Rishav', 'Apj Abdul Kalam', '', '0000-00-00', 'Rajpal & Sons', '', '', '', '', '', '', '46', '', 'Inspiring Thoughts', '', '0000-00-00', '', 104, 1, '', '9788170286844', '', '', 'http://books.google.com/books/content?id=Q7mrNIqyA8UC&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api', NULL, '1', '0', '1', '2016-11-02 06:15:37', 0),
(43, '', 'Rishav', 'rewrw', '', '0000-00-00', '', '', '', '', '', '', '', '41', '', '534rewrew', '', '0000-00-00', '', 0, 1, '', '53453454', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:54:51', 0),
(44, '', 'Rishav', 'dfgdgf', '', '0000-00-00', '', '', '', '', '', '', '', '42', '', 'erewrewr', '', '0000-00-00', '', 0, 1, '', '35423423423', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:55:01', 0),
(45, '', 'Rishav', 'gdfg', '', '0000-00-00', '', '', '', '', '', '', '', '35', '', 'Dgdg', '', '0000-00-00', '', 0, 1, '', '55345345345', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:55:10', 0),
(46, '', 'Rishav', 'gdfg', '', '0000-00-00', '', '', '', '', '', '', '', '37', '', 'dtgdggfgdf', '', '0000-00-00', '', 0, 1, '', '534534534543', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:55:18', 0),
(47, '', 'Rishav', 'hgfhgfh', '', '0000-00-00', '', '', '', '', '', '', '', '38', '', 'hgfhgfh', '', '0000-00-00', '', 0, 1, '', '46546465', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:55:27', 0),
(48, '', 'Rishav', 'gfdgdfg', '', '0000-00-00', '', '', '', '', '', '', '', '43', '', 'gdfgdfg', '', '0000-00-00', '', 0, 1, '', '9879678567647', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:55:36', 0),
(49, '', 'Rishav', 'gdfgd', '', '0000-00-00', '', '', '', '', '', '', '', '43', '', 'gdfgdgdfs', '', '0000-00-00', '', 0, 1, '', '5345345345345345345', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:55:52', 0),
(50, '', 'Rishav', 'fghaf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'fdsaf', '', '0000-00-00', '', 0, 1, '', '62646326546', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:56:31', 0),
(51, '', 'Rishav', 'dasfds', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'fsdafsf', '', '0000-00-00', '', 0, 1, '', '53453454355', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:56:38', 0),
(52, '', 'Rishav', 'gdfgdfggdf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'gdfgd', '', '0000-00-00', '', 0, 1, '', 'wrw2353453453', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:56:47', 0),
(53, '', 'Rishav', 'asdf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'tewtrret', '', '0000-00-00', '', 0, 1, '', '325434', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:56:57', 0),
(54, '', 'Rishav', 'tretet', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'retretret', '', '0000-00-00', '', 0, 1, '', '34535', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:05', 0),
(55, '', 'Rishav', 'dsfasf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'fasfsf', '', '0000-00-00', '', 0, 1, '', '5345345345', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:11', 0),
(56, '', 'Rishav', 'fdsf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'fdsff', '', '0000-00-00', '', 0, 1, '', '5345', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:20', 0),
(57, '', 'Rishav', 'dsfsdfa', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'sdfsfa', '', '0000-00-00', '', 0, 1, '', '23423424', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:25', 0),
(58, '', 'Rishav', 'fadsa', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'dsfas', '', '0000-00-00', '', 0, 1, '', '2342342342', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:32', 0),
(59, '', 'Rishav', 'fdsfdsa', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'sdfadf', '', '0000-00-00', '', 0, 1, '', '234234234234', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:38', 0),
(60, '', 'Rishav', 'sdfds', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'dsfdsf', '', '0000-00-00', '', 0, 1, '', '234234234234234234', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:43', 0),
(61, '', 'Rishav', 'dsfas', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'fdsafds', '', '0000-00-00', '', 0, 1, '', '234242342', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:48', 0),
(62, '', 'Rishav', 'sdfsdf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'dsfafdsf', '', '0000-00-00', '', 0, 1, '', '24234234', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:57:55', 0),
(63, '', 'Rishav', 'dfgdfgdfg', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'gdfgsd', '', '0000-00-00', '', 0, 1, '', '534544', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:58:08', 0),
(64, '', 'Rishav', 'rewrw', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'rewrewr', '', '0000-00-00', '', 0, 1, '', '234234', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:58:41', 0),
(65, '', 'Rishav', 'fdsaf', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'fsdafasd', '', '0000-00-00', '', 0, 1, '', '222', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:58:46', 0),
(66, '', 'Rishav', 'dgdsg', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'gadfg', '', '0000-00-00', '', 0, 1, '', '546546', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:58:53', 0),
(67, '', 'Rishav', 'gdfsg', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'dgfsgd', '', '0000-00-00', '', 0, 1, '', '35435345345', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:58:58', 0),
(68, '', 'Rishav', 'gdfgdfg', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 'gdggfdg', '', '0000-00-00', '', 0, 1, '', '4434', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-02 12:59:04', 0),
(69, '', 'vijay3-VI13', '13', '213', '0000-00-00', '', '', '', '', '', '', '', '43', '', '3213', '', '0000-00-00', '', 0, 1, '', '2323', '', '', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', NULL, '1', '0', '1', '2016-11-03 15:52:28', 0),
(70, '', 'lingeswaran Manoharan-3', 'A. Behrouz Forouzan', '', '0000-00-00', 'Tata McGraw-Hill Education', '', '', '', '', '', '', '47', '', 'Data Communications & Networking (sie)', '', '0000-00-00', '', 1134, 1, '', '9780070634145', '', '', 'http://books.google.com/books/content?id=6HaNKmfBK1oC&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api', NULL, '1', '0', '1', '2016-11-04 05:28:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `deleted` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `category_image`, `deleted`) VALUES
(35, 'Astronomy', '', '0'),
(36, 'History', '', '0'),
(37, 'Travel', '', '0'),
(38, 'Business & Economics', '', '0'),
(39, 'Fiction', '', '0'),
(40, 'Cooking', '', '0'),
(41, 'Juvenile Nonfiction', '', '0'),
(42, 'Aerospace engineers', '', '0'),
(43, 'Biography & Autobiography', '', '0'),
(44, 'Religion', '', '0'),
(45, 'Presidents', '', '0'),
(46, 'Ex-presidents', '', '0'),
(47, 'Computer networks', 'http://192.168.1.104/Readabookchallange/PHP/secureadmin/upload/cover_images/cover_default.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `circulation`
--

CREATE TABLE `circulation` (
  `id` int(11) NOT NULL,
  `member_id` varchar(99) NOT NULL,
  `book_id` varchar(99) NOT NULL,
  `issue_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `return_date` date NOT NULL,
  `fine_amount` double NOT NULL,
  `is_returned` tinyint(1) NOT NULL,
  `is_expired` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circulation`
--

INSERT INTO `circulation` (`id`, `member_id`, `book_id`, `issue_date`, `expire_date`, `return_date`, `fine_amount`, `is_returned`, `is_expired`) VALUES
(1, '2', '5', '2016-09-01', '2016-10-31', '2016-10-18', 0, 1, '0'),
(2, '2', '2', '2016-10-17', '1970-01-01', '2016-10-18', 0, 1, '1'),
(3, '2', '1', '2016-10-17', '1970-01-01', '0000-00-00', 0, 0, '0'),
(4, '1', '4', '2016-10-17', '1970-01-01', '2016-10-18', 0, 1, '1'),
(5, '1', '5', '2016-10-17', '1970-01-01', '2016-10-18', 0, 1, '0'),
(6, '1', '4', '2016-10-18', '1970-01-01', '2016-10-18', 0, 1, '1'),
(7, '1', '5', '2016-10-18', '1970-01-01', '2016-10-18', 0, 1, '0'),
(8, '1', '4', '2016-10-18', '0000-00-00', '2016-10-18', 0, 1, '1'),
(9, '1', '5', '2016-10-18', '0000-00-00', '2016-10-18', 0, 1, '0'),
(10, '1', '4', '2016-10-18', '2016-11-18', '2016-10-18', 0, 1, '1'),
(11, '1', '5', '2016-10-18', '1970-01-01', '2016-10-18', 0, 1, '0'),
(12, '1', '4', '2016-10-18', '1970-01-01', '2016-10-18', 0, 1, '1'),
(13, '1', '5', '2016-10-18', '2016-11-18', '2016-10-18', 0, 1, '0'),
(14, '1', '4', '2016-10-18', '2016-11-18', '2016-10-18', 0, 1, '1'),
(15, '1', '4', '2016-10-18', '2016-11-18', '2016-10-18', 0, 1, '1'),
(16, '1', '5', '2016-10-18', '2016-11-18', '2016-10-18', 0, 1, '0'),
(17, '1', '4', '2016-10-18', '2016-11-18', '2016-10-18', 0, 1, '1'),
(18, '1', '5', '2016-10-18', '2016-11-18', '0000-00-00', 0, 0, '0'),
(19, '1', '4', '2016-10-18', '2016-11-18', '0000-00-00', 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `circulation_config`
--

CREATE TABLE `circulation_config` (
  `id` int(11) NOT NULL,
  `member_type_id` varchar(99) NOT NULL,
  `issue_day_limit` varchar(99) NOT NULL,
  `issu_book_limit` int(11) NOT NULL,
  `fine_per_day` double NOT NULL,
  `deleted` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circulation_config`
--

INSERT INTO `circulation_config` (`id`, `member_type_id`, `issue_day_limit`, `issu_book_limit`, `fine_per_day`, `deleted`) VALUES
(1, '1', '1', 2, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(200) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `user_agent` varchar(199) NOT NULL,
  `last_activity` varchar(199) NOT NULL,
  `user_data` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('03e049a00d5e8c0963b6a513cb41adcd', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476372423', 'a:15:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:10:"vijaykamal";s:14:"book_list_isbn";s:0:"";s:17:"book_list_book_id";s:0:"";s:15:"book_list_title";s:0:"";s:16:"book_list_author";s:0:"";s:18:"book_list_category";s:0:"";s:19:"book_list_from_date";s:0:"";s:17:"book_list_to_date";s:0:"";s:19:"book_isbn_file_name";i:1;s:25:"flash:old:success_message";i:1;}'),
('051e8e42ad16df5b0e2acae6b4f8cb16', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476720030', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('070fec8c9b102ad4121084d9a4ff7a81', '192.168.1.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476276530', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('12776b2c3979b8b9c16cc62af9ce2d23', '192.168.1.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.87 Safari/537.36', '1478164561', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('27ad35c3e59c23d8413e5345b49dc386', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476277524', ''),
('280b6028ffc20adbf2e3ddb114449dbd', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1477059326', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:6:"Rishav";}'),
('319773f9fadd4a6dfb7c78f7051eb2e5', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1477491631', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}'),
('36c9f39e7346074af3558a7211d0edf3', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476511801', 'a:12:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:21:"lingeswaran Manoharan";s:15:"public_lb_title";b:0;s:16:"public_lb_author";b:0;s:23:"public_lb_category_name";s:2:"10";s:16:"public_lb_search";i:1;s:21:"vendor_list_unique_id";s:0:"";s:16:"vendor_list_name";s:5:"vijay";}'),
('3a8cdefa03996c2949e21c11c4f29f40', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477661756', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}'),
('40c6058051a94b3b7f83138e8d6ff110', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478067209', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('4ce899dbbe19f16cdb9db8405bfc2aee', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478236899', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:23:"lingeswaran Manoharan-3";}'),
('4d5272b7857707fecb070d28d4166dee', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478185474', 'a:7:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:9:"vendor_id";s:2:"24";s:6:"vendor";s:10:"vijay-VI24";}'),
('4e9597ebaa112dd5eab9ffd8d9de16d6', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1477059037', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:6:"Rishav";}'),
('51379d1276050930c45ff19bc4e0353a', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477564361', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}'),
('51a228c28e0f194767dbf900887e7c22', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478099659', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:6:"Rishav";}'),
('61dc8ef95099a29e55d3f22f7fa8cace', '192.168.1.169', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478072681', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('67437bd61b604278cf9f10675bd9905a', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476856003', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('69bf73e8c3862fd02875355403cf7df4', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476796403', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:16:"srarch_member_id";s:1:"2";}'),
('75b986aa16efb4ea73a88ab6611e0046', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476511779', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('7aaa92c6a718ff722037aec495dac7bd', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476370872', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('7ce94621ab5006c2758e8525a88bc6ec', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477493552', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}'),
('84341eada6945ea840d36b8f167cce5b', '192.168.1.195', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.3', '1477057951', 'a:7:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;s:6:"vendor";s:6:"Rishav";}'),
('85a4a725c131694ae4e4fd52c3426ffd', '192.168.1.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476963068', ''),
('8c344d815e63b95c76d5e7ab6d5d15ba', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1477313980', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:6:"Rishav";}'),
('906995bdbf449525d1f5ba73d4601c4f', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476971276', 'a:7:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:10:"vijaykamal";s:20:"is_consumer_template";i:0;}'),
('994879757fff9717f3c5ecbedf7ea009', '192.168.1.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/602.2.14 (KHTML, like Gecko) Version/10.0.1 Safari/602.2.14', '1478159502', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('9b854d674a880f540c8af7481bfbc00f', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477723572', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('9bacea741a5dc0adfdee9b827273761c', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476456746', 'a:9:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;s:6:"vendor";s:6:"Rishav";s:17:"deliver_list_city";s:2:"ba";s:17:"deliver_list_area";s:5:"HSR 1";}'),
('9d1cbcec21e9b399a1aaa2c644982012', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476278766', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:25:"flash:old:success_message";i:1;}'),
('9e64f6bb543361bd2c0a0536edfd0c8d', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478065409', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:6:"Rishav";}'),
('9ec78da092ea56bdb3e12f134df4e3eb', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476967781', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}'),
('a102073a6984f8b0e1b36572ede69117', '192.168.1.35', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478171386', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:17:"deliver_list_area";s:0:"";}'),
('a354dbb207057b1c651bc9b26bddb322', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1477407535', 'a:8:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:6:"Rishav";s:9:"user_name";i:1;s:20:"is_consumer_template";i:0;}'),
('a460f7a7c668e0fbe176a9f175ea652c', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476699313', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:11:"Lingeswaran";s:9:"user_type";s:6:"Member";s:9:"member_id";s:1:"2";}'),
('a506c53f06afe82e2cad73057c306331', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476436492', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:11:"Lingeswaran";s:9:"user_type";s:6:"Member";s:9:"member_id";s:1:"2";}'),
('a7882cb9527747360306523c2d4dfccd', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477584734', 'a:13:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:14:"book_list_isbn";s:0:"";s:17:"book_list_book_id";s:2:"11";s:15:"book_list_title";s:0:"";s:16:"book_list_author";s:0:"";s:18:"book_list_category";s:0:"";s:19:"book_list_from_date";s:0:"";s:17:"book_list_to_date";s:0:"";s:6:"vendor";s:6:"Rishav";}'),
('a994d9c62d65510967105cf5171975c5', '192.168.1.22', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478158155', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('a9dbfcc6e33eba64e1a9dd08f489bbbd', '192.168.1.148', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477911056', 'a:7:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:17:"deliver_list_city";s:0:"";s:17:"deliver_list_area";s:3:"HSR";}'),
('ae2ce16617ae43be6cfbc9367898cfa8', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478188317', 'a:13:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:14:"book_list_isbn";s:0:"";s:17:"book_list_book_id";s:0:"";s:15:"book_list_title";s:0:"";s:16:"book_list_author";s:0:"";s:18:"book_list_category";s:2:"40";s:19:"book_list_from_date";s:0:"";s:17:"book_list_to_date";s:0:"";s:6:"vendor";s:11:"vijay3-VI13";}'),
('afbfcbfba4ff3a2600881ca3b661ed98', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477923949', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('b178bfe10ce0360778656e973490fdd5', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476796264', 'a:17:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:16:"srarch_member_id";s:1:"1";s:24:"circulation_data_book_id";s:0:"";s:21:"circulation_data_name";s:0:"";s:27:"circulation_data_book_title";s:0:"";s:23:"circulation_data_author";s:0:"";s:26:"circulation_data_from_date";s:0:"";s:24:"circulation_data_to_date";s:0:"";s:23:"circulation_data_status";s:6:"issued";s:20:"is_consumer_template";i:0;s:25:"change_member_password_id";s:1:"1";s:9:"user_name";i:1;s:17:"deliver_list_area";s:5:"97399";}'),
('be68c2ff619e652ddc045949cece27d0', '192.168.1.32', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1478182270', ''),
('be7bcbb28e584f5893188644ddf9d934', '192.168.1.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476861988', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:9:"user_name";i:1;}'),
('cfd459287a6e40786622adf8de5981ae', '192.168.1.22', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', '1478159072', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('d79215c93f6e6c89152b0fa5c9fba6ff', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476467534', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:6:"vendor";s:21:"lingeswaran Manoharan";}'),
('df36a8e0d934ba426aeb56135bf256f0', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476281487', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('e43ff5211eb6e9750f61cfaf0def2b53', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476710780', 'a:7:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:25:"change_member_password_id";s:1:"2";s:16:"srarch_member_id";s:1:"1";}'),
('e98203aa255fbb26dd2e164075b8a60f', '192.168.1.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '1477652617', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}'),
('e9c68a15a563ede0a95ba12b41bda8b5', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476451999', 'a:14:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:14:"book_list_isbn";s:0:"";s:17:"book_list_book_id";s:0:"";s:15:"book_list_title";s:0:"";s:16:"book_list_author";s:0:"";s:18:"book_list_category";s:0:"";s:19:"book_list_from_date";s:0:"";s:17:"book_list_to_date";s:0:"";s:20:"is_consumer_template";i:0;s:6:"vendor";s:10:"vijaykamal";}'),
('eca9866c46c8a308609dcf28c3129f7e', '192.168.1.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476440709', 'a:5:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";}'),
('f0dcdb72e1272178ce633e593ffd1b30', '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '1476862635', 'a:7:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:9:"user_name";i:1;s:17:"deliver_list_area";s:2:"gf";}'),
('f85dcbfb3c366a99e08ad038afc8eee0', '192.168.1.154', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.3', '1476362630', 'a:6:{s:9:"user_data";s:0:"";s:9:"logged_in";i:1;s:8:"username";s:18:"Readabookchallenge";s:9:"user_type";s:5:"Admin";s:9:"member_id";s:1:"1";s:20:"is_consumer_template";i:0;}');

-- --------------------------------------------------------

--
-- Table structure for table `daily_read_material`
--

CREATE TABLE `daily_read_material` (
  `id` int(11) NOT NULL,
  `book_id` varchar(99) NOT NULL,
  `read_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_read_material`
--

INSERT INTO `daily_read_material` (`id`, `book_id`, `read_at`) VALUES
(1, '1', '2016-10-14 10:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_areas`
--

CREATE TABLE `delivery_areas` (
  `id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `city` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_areas`
--

INSERT INTO `delivery_areas` (`id`, `area`, `city`, `status`, `created_date`) VALUES
(1, '560038', 1, 1, '2016-10-14 04:38:09'),
(2, '560102', 1, 1, '2016-10-14 09:19:40'),
(3, '560103', 1, 1, '2016-10-14 09:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_city`
--

CREATE TABLE `delivery_city` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_city`
--

INSERT INTO `delivery_city` (`id`, `city_name`, `status`) VALUES
(1, 'Bangalore', 1),
(2, 'Mumbai', 0);

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_address` varchar(250) NOT NULL,
  `smtp_host` varchar(250) NOT NULL,
  `smtp_port` varchar(100) NOT NULL,
  `smtp_user` varchar(100) NOT NULL,
  `smtp_password` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forget_password`
--

CREATE TABLE `forget_password` (
  `id` int(12) NOT NULL,
  `confirmation_code` varchar(15) CHARACTER SET latin1 NOT NULL,
  `email` varchar(250) CHARACTER SET latin1 NOT NULL,
  `success` int(11) NOT NULL DEFAULT '0',
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs_wallet`
--

CREATE TABLE `logs_wallet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `actions` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs_wallet`
--

INSERT INTO `logs_wallet` (`id`, `user_id`, `actions`, `created_date`) VALUES
(1, 3, 'User Add', '2016-10-31 07:10:32'),
(2, 3, 'User Edit', '2016-10-31 07:10:32'),
(3, 1, 'Admin Add', '2016-10-31 07:16:04'),
(4, 1, 'Admin Edit', '2016-10-31 07:16:04'),
(5, 1, 'Auto renewal Dedection by system', '2016-11-02 07:38:55'),
(6, 1, 'Auto renewal Dedection by system', '2016-11-02 07:40:09'),
(7, 1, 'Auto renewal Dedection by system', '2016-11-02 07:45:31'),
(8, 1, 'Auto renewal Dedection by system', '2016-11-02 07:45:38'),
(9, 1, 'Auto renewal Dedection by system', '2016-11-03 07:59:34'),
(10, 1, 'Auto renewal Dedection by system', '2016-11-03 09:17:19'),
(11, 1, 'Auto renewal Dedection by system', '2016-11-03 11:57:08'),
(12, 1, 'Auto renewal Dedection by system', '2016-11-03 11:57:13'),
(13, 1, 'Auto renewal Dedection by system', '2016-11-03 12:52:10'),
(14, 1, 'Auto renewal Dedection by system', '2016-11-03 12:53:21'),
(15, 1, 'Auto renewal Dedection by system', '2016-11-03 13:04:49'),
(16, 1, 'Auto renewal Dedection by system', '2016-11-03 13:05:19'),
(17, 1, 'Auto renewal Dedection by system', '2016-11-03 13:18:47'),
(18, 1, 'Auto renewal Dedection by system', '2016-11-03 13:19:15'),
(19, 1, 'Auto renewal Dedection by system', '2016-11-03 13:19:33'),
(20, 1, 'Auto renewal Dedection by system', '2016-11-03 13:19:50'),
(21, 1, 'Auto renewal Dedection by system', '2016-11-03 13:19:52'),
(22, 1, 'Auto renewal Dedection by system', '2016-11-03 13:20:51'),
(23, 1, 'Auto renewal Dedection by system', '2016-11-03 13:21:20'),
(24, 1, 'Auto renewal Dedection by system', '2016-11-03 13:22:07'),
(25, 1, 'Auto renewal Dedection by system', '2016-11-03 13:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `name` varchar(99) CHARACTER SET utf8 NOT NULL,
  `type_id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `password` varchar(99) NOT NULL,
  `address` text CHARACTER SET utf8 NOT NULL,
  `user_type` enum('Member','Admin') NOT NULL,
  `status` enum('1','0') NOT NULL,
  `add_date` date NOT NULL,
  `deleted` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `name`, `type_id`, `email`, `mobile`, `password`, `address`, `user_type`, `status`, `add_date`, `deleted`) VALUES
(1, 'Readabookchallenge', 0, 'admin', '', '827ccb0eea8a706c4c34a16891f84e7b', 'Bangalore', 'Admin', '1', '2016-04-10', '0'),
(2, 'Lingeswaran', 0, 'lingeswrn@gmail.com', '9739965150', 'e10adc3949ba59abbe56e057f20f883e', 'bangalore', 'Member', '1', '2016-10-13', '1');

-- --------------------------------------------------------

--
-- Table structure for table `member_type`
--

CREATE TABLE `member_type` (
  `id` int(11) NOT NULL,
  `member_type_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `deleted` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_type`
--

INSERT INTO `member_type` (`id`, `member_type_name`, `deleted`) VALUES
(1, 'sa', '0');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `books_nos` int(11) NOT NULL,
  `genres` varchar(255) NOT NULL,
  `price` float(12,2) NOT NULL,
  `delivery_charges` float(12,2) NOT NULL,
  `pickup_charges` float(12,2) NOT NULL,
  `total` float(12,2) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `transaction_id` varchar(155) NOT NULL,
  `coupon` varchar(155) NOT NULL,
  `coupon_amount` float(12,2) NOT NULL,
  `payment_method` enum('COD','Online') NOT NULL,
  `payment_type` enum('CC','DC','Net Banking','wallet') NOT NULL,
  `delivery_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `requested_date` datetime NOT NULL,
  `shipping_mode` enum('delivery','pickup & delivery') NOT NULL,
  `status` enum('selection','packaging','labeling','returned','closed','open','pickup','on transits','due','auto') NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `user_id`, `books_nos`, `genres`, `price`, `delivery_charges`, `pickup_charges`, `total`, `phone_number`, `ip_address`, `transaction_id`, `coupon`, `coupon_amount`, `payment_method`, `payment_type`, `delivery_date`, `due_date`, `requested_date`, `shipping_mode`, `status`, `created_date`) VALUES
(1, 'LM-001', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', '', '2016-11-03 00:00:00', '2016-12-03 11:34:35', '0000-00-00 00:00:00', 'delivery', 'pickup', '2016-11-01 09:33:15'),
(2, 'LM-002', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'Online', '', '2016-11-03 00:00:00', '2016-11-10 02:49:51', '0000-00-00 00:00:00', 'delivery', 'on transits', '2016-11-01 09:33:15'),
(3, 'LM-003', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'Online', '', '2016-11-03 00:00:00', '2016-11-10 02:53:34', '0000-00-00 00:00:00', 'delivery', 'due', '2016-11-01 09:33:15'),
(4, '54564546', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 11:57:08', '0000-00-00 00:00:00', 'delivery', 'open', '2016-11-01 09:33:15'),
(5, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 11:57:13', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(6, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 12:52:10', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(7, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 12:53:21', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(8, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:04:49', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(9, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:05:18', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(10, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:18:47', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(11, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:15', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(12, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:33', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(13, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:50', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(14, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:52', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(15, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:20:51', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(16, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:21:20', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(17, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:22:07', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(18, 'LM-18', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:45:40', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(19, 'LM-18', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:45:40', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(20, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:22:07', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(21, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:21:20', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(22, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:20:51', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(23, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:52', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(24, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:50', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15'),
(25, 'LM-2', 1, 2, '43,38', 450.00, 25.00, 25.00, 500.00, '9739965150', '192.168.1.104', '', '', 0.00, 'COD', 'wallet', '2016-11-03 00:00:00', '2016-12-03 01:19:33', '0000-00-00 00:00:00', 'delivery', 'closed', '2016-11-01 09:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `orders_address`
--

CREATE TABLE `orders_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(25) NOT NULL,
  `area` varchar(100) NOT NULL,
  `landmark` varchar(150) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `billing_address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_address`
--

INSERT INTO `orders_address` (`id`, `order_id`, `address`, `city`, `area`, `landmark`, `pincode`, `billing_address`) VALUES
(33, 1, '#1212, 22nd cross,', 'Bangalore', 'HSR Layout', 'Near born babies', '560102', 0),
(34, 2, '#1212, 22nd cross,', 'Bangalore', 'HSR Layout', 'Near born babies', '560102', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_extend`
--

CREATE TABLE `order_extend` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `extend_time` varchar(255) NOT NULL,
  `amount` float(12,2) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`) VALUES
(9, 2, 20),
(10, 2, 26),
(11, 1, 19),
(12, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `paytm_details`
--

CREATE TABLE `paytm_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone_number` varchar(250) NOT NULL,
  `email_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paytm_details`
--

INSERT INTO `paytm_details` (`id`, `user_id`, `phone_number`, `email_id`) VALUES
(1, 1, '9739965152', 'lingeswrn@gmail.com'),
(2, 3, '9944425916', 'vijay@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan`, `status`) VALUES
(1, '100', 0),
(2, '300', 1),
(3, '400', 0);

-- --------------------------------------------------------

--
-- Table structure for table `request_book`
--

CREATE TABLE `request_book` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_title` text CHARACTER SET utf8 NOT NULL,
  `author` text CHARACTER SET utf8 NOT NULL,
  `edition` varchar(200) CHARACTER SET utf8 NOT NULL,
  `note` text CHARACTER SET utf8 NOT NULL,
  `request_date` date NOT NULL,
  `reply` text CHARACTER SET utf8 NOT NULL,
  `request_status` varchar(55) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_book`
--

INSERT INTO `request_book` (`id`, `member_id`, `book_title`, `author`, `edition`, `note`, `request_date`, `reply`, `request_status`) VALUES
(1, 2, 'test', 'test', '2nd', 'etst', '2016-10-14', 'Thanks! for your request. We have accepted your request.', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `sms_config`
--

CREATE TABLE `sms_config` (
  `id` int(11) NOT NULL,
  `name` enum('planet','plivo','twilio','clickatell','nexmo') CHARACTER SET utf8 NOT NULL,
  `auth_id` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `api_id` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_config`
--

INSERT INTO `sms_config` (`id`, `name`, `auth_id`, `token`, `api_id`, `phone_number`) VALUES
(1, 'clickatell', 'lingeswrn', 'lingu@2016', '3630716', '919739965150');

-- --------------------------------------------------------

--
-- Table structure for table `sms_email_history`
--

CREATE TABLE `sms_email_history` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `type` enum('SMS','Email','Notification') NOT NULL,
  `sent_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_email_history`
--

INSERT INTO `sms_email_history` (`id`, `member_id`, `title`, `message`, `type`, `sent_at`) VALUES
(1, 2, 'test', 'testsgdgdfgdfgfdgfdgdfg', 'SMS', '2016-10-17 11:15:55'),
(2, 2, 'test', 'testsgdgdfgdfgfdgfdgdfg', 'SMS', '2016-10-17 11:16:09'),
(3, 2, 'test', 'bring book ASAP', 'SMS', '2016-10-25 15:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_condition`
--

CREATE TABLE `terms_and_condition` (
  `id` int(11) NOT NULL,
  `terms_and_condition` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terms_and_condition`
--

INSERT INTO `terms_and_condition` (`id`, `terms_and_condition`) VALUES
(1, '<ul>\r\n <li><strong>All copyright, trade marks, design rights,</strong> patents and other intellectual property rights (registered and unregistered) in and on LMS Online Services and LMS Content belong to the LMS and/or third parties (which may include you or other users.)</li>\r\n <li>The LMS reserves all of its rights in LMS Content and LMS Online Services. Nothing in the Terms grants you a right or licence to use any trade mark, design right or copyright owned or controlled by the LMS or any other third party except as expressly provided in the Terms.</li>\r\n</ul>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `alt_phone_number` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `gplus_id` varchar(255) DEFAULT NULL,
  `twitter_id` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `wallet` float(6,2) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email_id`, `phone_number`, `alt_phone_number`, `age`, `facebook_id`, `gplus_id`, `twitter_id`, `profile_image`, `wallet`, `created_date`, `updated_date`, `status`) VALUES
(1, 'Lingeswaran', 'Manoharan', 'lingeswrn@gmail.com', '919739965150', '', 'adult', '1012688022157994', 'dasdasdasdasd', '', 'https://scontent.xx.fbcdn.net/v/t1.0-1/p240x240/12065755_910131582413639_6443092754265093195_n.jpg?oh=9f7abd4d3855d425396da64a2847d998&oe=58D483C9', 500.00, '2016-10-17 12:04:14', '0000-00-00 00:00:00', 1),
(3, 'Vijaykamal', 'R', 'vijay@vibrant-info.com', '9615232562', '', 'child', '23655658488454584', 'dasdasdasdasd', '', '', 3000.00, '2016-10-17 12:04:14', '0000-00-00 00:00:00', 1),
(4, 'Lingeswaran', 'Manoharan', 'lingeswrn@gmail.com', NULL, NULL, NULL, '1012688022157994', NULL, NULL, 'https://scontent.xx.fbcdn.net/v/t1.0-1/p240x240/12065755_910131582413639_6443092754265093195_n.jpg?oh=9f7abd4d3855d425396da64a2847d998&oe=58D483C9', NULL, '2016-11-04 08:19:01', NULL, 1),
(5, 'Ranjith', 'VS', 'ranjith3592@gmail.com', NULL, NULL, NULL, '900997513368428', NULL, NULL, 'https://scontent.xx.fbcdn.net/v/t1.0-1/s240x240/12049503_762307390570775_8579192834482258679_n.jpg?oh=8779776b73983e48338a5025487a67ab&oe=588E746D', NULL, '2016-11-04 09:58:20', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_currently_reading`
--

CREATE TABLE `users_currently_reading` (
  `id` int(11) NOT NULL,
  `book_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_genre`
--

CREATE TABLE `users_genre` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_genre`
--

INSERT INTO `users_genre` (`id`, `user_id`, `category_id`) VALUES
(1, 1, 38),
(2, 1, 43);

-- --------------------------------------------------------

--
-- Table structure for table `users_library`
--

CREATE TABLE `users_library` (
  `id` int(11) NOT NULL,
  `book_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_wishlists`
--

CREATE TABLE `users_wishlists` (
  `id` int(11) NOT NULL,
  `book_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_wishlists`
--

INSERT INTO `users_wishlists` (`id`, `book_info_id`, `user_id`) VALUES
(1, 19, 1),
(2, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `landmark` varchar(255) NOT NULL,
  `pincode` varchar(25) NOT NULL,
  `billing_address` tinyint(4) DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upadated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address`, `city`, `area`, `landmark`, `pincode`, `billing_address`, `created_date`, `upadated_date`) VALUES
(4, 1, '#1212, 22nd main, HSR layout', 'Bangalore', 'HSR layout', 'Near Born babies', '560102', 0, '2016-10-25 13:57:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_info`
--

CREATE TABLE `vendor_info` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=inactive,1=active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor_info`
--

INSERT INTO `vendor_info` (`id`, `unique_id`, `name`, `email`, `phone`, `address`, `password`, `created_on`, `updated_on`, `status`) VALUES
(1, '1', 'Rishav', 'test@test.com', '976365626', 'bamgalore', '', '2016-10-13 11:56:19', '0000-00-00 00:00:00', 1),
(2, '2', 'vijaykamal', 'vijaykamalr@gmail.com', '9629410156', 'Bangalore', '', '2016-10-13 14:18:15', '0000-00-00 00:00:00', 1),
(3, '3', 'lingeswaran Manoharan', 'lingu@gmail.com', '97396551250', 'bangalore', '', '2016-10-13 14:36:45', '0000-00-00 00:00:00', 1),
(4, 'sdasds', 'ad', 'dsda@a.ss', 'sadsadasd', 'dsfdfsfd', '', '2016-11-03 12:55:35', '0000-00-00 00:00:00', 1),
(5, '', 'vijaySDS', 'vijaykamalrr@gmail.comDASFSD', '9629410155DASFSD', 'DS', '', '2016-11-03 13:21:28', '0000-00-00 00:00:00', 1),
(6, '', 'vijaySDSsd', 'vijaykamalrr@gmail.comDASFSD a', '9629410155DASFSDa', 'DS', '', '2016-11-03 13:28:31', '0000-00-00 00:00:00', 1),
(7, '', 'vijaysa', 'vijaykamaslr@gmail.com', '96294101562', 'sd', '', '2016-11-03 13:29:13', '0000-00-00 00:00:00', 1),
(8, '', 'vijaysaa', 'vijaykamaslr@gmail.coma', '96294101562a', 'sd', '', '2016-11-03 13:31:04', '0000-00-00 00:00:00', 1),
(9, '', 'vijay', 'vijaykamalr@gmail.comm', '9629410157', 'sadasdas', '', '2016-11-03 13:33:53', '0000-00-00 00:00:00', 1),
(10, '', 'vijayww', 'dasdasda', 'dasdas', 'dasdas', '', '2016-11-03 13:35:17', '0000-00-00 00:00:00', 1),
(11, '', 'vijay1', 'vijaykam2alr@gmail.com', '96294101561', 'dsadas', '', '2016-11-03 13:36:12', '0000-00-00 00:00:00', 1),
(12, '', 'vijay12', 'vijaykam2alr@gmail.com2', '962941015612', 'dsadas2', '', '2016-11-03 13:37:23', '0000-00-00 00:00:00', 1),
(13, 'VI13', 'vijay3', 'vijaykama2lr@gmail.com', '962941015621', '12', '', '2016-11-03 13:38:17', '0000-00-00 00:00:00', 1),
(14, 'VI14', 'vijay35', 'vijaykama2lr@gmail.com6', '9629410156215', '123', '', '2016-11-03 13:38:46', '0000-00-00 00:00:00', 1),
(15, 'DA15', 'Dass', 'dasd.das@fas.dsafsd', '96294101566', 'dasdafs', '', '2016-11-03 13:59:07', '0000-00-00 00:00:00', 1),
(16, 'VI16', 'vijay', 'sdas@fdf.fdgd', '234324344324', 'das', '', '2016-11-03 14:03:41', '0000-00-00 00:00:00', 1),
(17, 'VI17', 'vijay', 'vijaykamalra@gmail.com', '962941015666', 'dsadasdas', '', '2016-11-03 14:05:32', '0000-00-00 00:00:00', 1),
(18, 'DF18', 'dfdsf', 'sdfsdf@fsd.com', '21321312312312312', 'dfssdsdsa', '', '2016-11-03 14:06:22', '0000-00-00 00:00:00', 1),
(19, 'VI19', 'vijaysdffds', 'fadfsdf@fds.fsd', '963-365-6966', 'dfsdfsd', '', '2016-11-03 14:08:24', '0000-00-00 00:00:00', 1),
(20, 'VI20', 'vijay', 'vijaykamaalr@gmail.com', '96294101556', '', '', '2016-11-03 14:44:54', '0000-00-00 00:00:00', 1),
(21, 'LI21', 'Lingeswaran', 'lingeswrn@gmail.com', '97396551251', 'bangalore', '', '2016-11-03 15:03:49', '0000-00-00 00:00:00', 1),
(22, 'RK22', 'Ranjith Kumar', 'ranjith@gmail.com', '97696965662', '', '', '2016-11-03 15:04:46', '0000-00-00 00:00:00', 1),
(24, 'VI24', 'vijay', 'vijaykamalrr@gmail.com', '9629410156666', '', '', '2016-11-03 15:36:28', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wallet_request`
--

CREATE TABLE `wallet_request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `paytm_phone_number` varchar(100) NOT NULL,
  `paytm_email_id` varchar(150) NOT NULL,
  `status` enum('pending','done','','') NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet_request`
--

INSERT INTO `wallet_request` (`id`, `user_id`, `paytm_phone_number`, `paytm_email_id`, `status`, `created_date`) VALUES
(1, 1, '9739965150', 'lingeswrn@gmail.com', 'done', '2016-10-29 05:43:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_info`
--
ALTER TABLE `book_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circulation`
--
ALTER TABLE `circulation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circulation_config`
--
ALTER TABLE `circulation_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_type_id` (`member_type_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `daily_read_material`
--
ALTER TABLE `daily_read_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_areas`
--
ALTER TABLE `delivery_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city` (`city`);

--
-- Indexes for table `delivery_city`
--
ALTER TABLE `delivery_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forget_password`
--
ALTER TABLE `forget_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_wallet`
--
ALTER TABLE `logs_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_type`
--
ALTER TABLE `member_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_type_name` (`member_type_name`,`deleted`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `orders_address`
--
ALTER TABLE `orders_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_extend`
--
ALTER TABLE `order_extend`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `paytm_details`
--
ALTER TABLE `paytm_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_book`
--
ALTER TABLE `request_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_config`
--
ALTER TABLE `sms_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_email_history`
--
ALTER TABLE `sms_email_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_and_condition`
--
ALTER TABLE `terms_and_condition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_currently_reading`
--
ALTER TABLE `users_currently_reading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_info_id` (`book_info_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_genre`
--
ALTER TABLE `users_genre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users_library`
--
ALTER TABLE `users_library`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_info_id` (`book_info_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_wishlists`
--
ALTER TABLE `users_wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_info_id` (`book_info_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vendor_info`
--
ALTER TABLE `vendor_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_request`
--
ALTER TABLE `wallet_request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_info`
--
ALTER TABLE `book_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `circulation`
--
ALTER TABLE `circulation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `circulation_config`
--
ALTER TABLE `circulation_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `daily_read_material`
--
ALTER TABLE `daily_read_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `delivery_areas`
--
ALTER TABLE `delivery_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `delivery_city`
--
ALTER TABLE `delivery_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forget_password`
--
ALTER TABLE `forget_password`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs_wallet`
--
ALTER TABLE `logs_wallet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `member_type`
--
ALTER TABLE `member_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `orders_address`
--
ALTER TABLE `orders_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `paytm_details`
--
ALTER TABLE `paytm_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `request_book`
--
ALTER TABLE `request_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sms_config`
--
ALTER TABLE `sms_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sms_email_history`
--
ALTER TABLE `sms_email_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `terms_and_condition`
--
ALTER TABLE `terms_and_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users_currently_reading`
--
ALTER TABLE `users_currently_reading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_genre`
--
ALTER TABLE `users_genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_library`
--
ALTER TABLE `users_library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_wishlists`
--
ALTER TABLE `users_wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vendor_info`
--
ALTER TABLE `vendor_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `wallet_request`
--
ALTER TABLE `wallet_request`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_areas`
--
ALTER TABLE `delivery_areas`
  ADD CONSTRAINT `fk_delivery_city` FOREIGN KEY (`city`) REFERENCES `delivery_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_address`
--
ALTER TABLE `orders_address`
  ADD CONSTRAINT `orders_address_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_currently_reading`
--
ALTER TABLE `users_currently_reading`
  ADD CONSTRAINT `users_currently_reading_ibfk_1` FOREIGN KEY (`book_info_id`) REFERENCES `book_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_currently_reading_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_genre`
--
ALTER TABLE `users_genre`
  ADD CONSTRAINT `users_genre_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_genre_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_library`
--
ALTER TABLE `users_library`
  ADD CONSTRAINT `users_library_ibfk_1` FOREIGN KEY (`book_info_id`) REFERENCES `book_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_library_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_wishlists`
--
ALTER TABLE `users_wishlists`
  ADD CONSTRAINT `users_wishlists_ibfk_1` FOREIGN KEY (`book_info_id`) REFERENCES `book_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_wishlists_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallet_request`
--
ALTER TABLE `wallet_request`
  ADD CONSTRAINT `wallet_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
