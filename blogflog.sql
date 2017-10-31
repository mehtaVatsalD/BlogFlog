-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 31, 2017 at 04:53 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogflog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(255) NOT NULL,
  `title` varchar(40) NOT NULL,
  `blog` varchar(10000) NOT NULL,
  `blogger` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usefull` int(255) NOT NULL,
  `wastefull` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `blog`, `blogger`, `time`, `usefull`, `wastefull`) VALUES
(1, 'Om', '<pre>Shivaay!</pre>', 'ppatel', '2017-09-28 17:18:44', 0, 0),
(2, 'Mane aje block kari deva ma avelo hato', '<pre>We will see later</pre>', 'ppatel', '2017-09-28 17:26:54', 0, 0),
(3, 'fgfg', '<pre>fdfdfd\ndf\nf\nf\nsdf</pre>', 'ppatel', '2017-09-28 17:27:02', 0, 0),
(4, 'fgfdgdfg', '<pre>gmigryt\r\ntyt\r\nyt\r\nyty\r\ny\r\nty\r\nrty</pre>', 'ppatel', '2017-09-28 17:27:08', 2, 0),
(6, 'fgdfg111', '<pre>fgfdg1dsdrwererr\ndfdsfdsfdsfsdf\ndfssssdf\n\nRegard,\nTeam Blogflog\n\nFounder,\nVdmm</pre>', 'ppatel', '2017-09-28 17:36:07', 1, 1),
(8, 'Oh gbc', '<pre>oh gbc(gendo bc)</pre>', 'akhopatel', '2017-09-28 21:10:15', 1, 0),
(9, 'ojxdfvodjsl', '<pre>;;dmfo;dsf;p</pre>', 'vdmehta', '2017-09-28 21:41:42', 0, 0),
(10, 'Hellox', '<pre>nsafkjfsf\r\nsdsa\r\ndsadas\r\ndsa\r\ndas</pre>', 'adminbro', '2017-10-26 11:42:37', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(255) NOT NULL,
  `commenter` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `commenter`, `comment`, `time`) VALUES
(2, 'akhopatel', 'Admin haramkhor', '2017-09-28 21:18:11'),
(6, 'jigneshSir', 'Hello world', '2017-09-29 09:00:40'),
(6, 'jigneshSir', 'jjfdlksfjsdlk', '2017-09-29 09:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `following` varchar(50) NOT NULL,
  `follower` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`following`, `follower`) VALUES
('vdmehta', 'ppatel'),
('ppatel', 'vdmehta'),
('vdmehta', 'owner1'),
('akshPatel', 'akhopatel'),
('vdmehta', 'akhopatel'),
('ppatel', 'akhopatel'),
('ppatel', 'jigneshSir');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notify` varchar(50) NOT NULL,
  `notifier` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `notification` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `readBy` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notify`, `notifier`, `category`, `data`, `notification`, `time`, `readBy`) VALUES
('ppatel', 'vdmehta', 'comment', '4', 'vdmehta commented on your Blog...\"sdsadsad\"', '2017-09-27 18:27:51', 1),
('ppatel', 'vdmehta', 'follow', 'vdmehta', 'vdmehta started following you.', '2017-09-27 18:35:28', 1),
('vdmehta', 'owner1', 'follow', 'owner1', 'owner1 started following you.', '2017-09-27 18:49:56', 1),
('ppatel', 'vdmehta', 'like', '4', 'vdmehta found your blog usefull', '2017-09-27 19:02:23', 1),
('ppatel', 'owner1', 'like', '4', 'owner1 found your blog usefull', '2017-09-27 19:02:50', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-27 19:06:15', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-27 19:06:55', 1),
('vdmehta', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 17:15:24', 1),
('', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 17:15:30', 0),
('vdmehta', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 17:15:37', 1),
('vdmehta', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 17:15:46', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 17:15:58', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 17:18:18', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 18:04:58', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 18:05:01', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 18:05:09', 1),
('ppatel', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-28 20:53:58', 1),
('adminbro', 'akhopatel', 'like', '7', 'akhopatel found your blog usefull', '2017-09-28 21:14:37', 1),
('adminbro', 'akhopatel', 'like', '7', 'akhopatel found your blog usefull', '2017-09-28 21:14:39', 1),
('adminbro', 'akhopatel', 'like', '7', 'akhopatel found your blog usefull', '2017-09-28 21:14:43', 1),
('adminbro', 'akhopatel', 'comment', '7', 'akhopatel commented on your Blog...\"Haramkhor\"', '2017-09-28 21:14:54', 1),
('akshPatel', 'akhopatel', 'follow', 'akhopatel', 'akhopatel started following you.', '2017-09-28 21:16:38', 1),
('vdmehta', 'akhopatel', 'follow', 'akhopatel', 'akhopatel started following you.', '2017-09-28 21:16:50', 1),
('ppatel', 'akhopatel', 'like', '4', 'akhopatel found your blog usefull', '2017-09-28 21:17:13', 1),
('ppatel', 'akhopatel', 'comment', '2', 'akhopatel commented on your Blog...\"Admin haramkhor\"', '2017-09-28 21:18:11', 1),
('ppatel', 'akhopatel', 'follow', 'akhopatel', 'akhopatel started following you.', '2017-09-28 21:18:40', 1),
('ppatel', 'vdmehta', 'like', '4', 'vdmehta found your blog usefull', '2017-09-28 21:24:29', 1),
('ppatel', 'jigneshSir', 'follow', 'jigneshSir', 'jigneshSir started following you.', '2017-09-29 08:58:43', 1),
('ppatel', 'jigneshSir', 'like', '6', 'jigneshSir found your blog usefull', '2017-09-29 08:59:50', 1),
('ppatel', 'jigneshSir', 'like', '6', 'jigneshSir found your blog usefull', '2017-09-29 09:00:00', 1),
('ppatel', 'jigneshSir', 'like', '6', 'jigneshSir found your blog usefull', '2017-09-29 09:00:04', 1),
('ppatel', 'jigneshSir', 'comment', '6', 'jigneshSir commented on your Blog...\"Hello world\"', '2017-09-29 09:00:40', 1),
('ppatel', 'jigneshSir', 'comment', '6', 'jigneshSir commented on your Blog...\"jjfdlksfjsdlk\"', '2017-09-29 09:00:47', 1),
('jigneshSir', 'adminbro', 'delete', '0', 'adminbro found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.', '2017-09-29 09:05:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usefull`
--

CREATE TABLE `usefull` (
  `id` int(255) NOT NULL,
  `userName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usefull`
--

INSERT INTO `usefull` (`id`, `userName`) VALUES
(8, 'akhopatel'),
(4, 'akhopatel'),
(4, 'vdmehta'),
(6, 'jigneshSir');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `propic` varchar(50) NOT NULL,
  `block` tinyint(1) NOT NULL DEFAULT '0',
  `verified` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `password`, `mail`, `propic`, `block`, `verified`) VALUES
(1, 'adminbro', 'adminbro', 'admin@blogflog.com', 'adminbro.png', 0, 'verified'),
(2, 'vdmehta', '123456', 'comebackgogo7@gmail.com', 'default.png', 0, 'verified'),
(3, 'ppatel', '987654', 'parthpatel@gmail.com', 'default.png', 0, 'verified'),
(4, 'owner1', '123456', 'aaaaaa@asad.sad', 'default.png', 0, 'verified'),
(5, 'akhopatel', '123456', 'batuk@askdada.com', 'default.png', 0, 'verified'),
(6, 'akshPatel', '112233445566', 'akshPatel@gmail.com', 'akshPatel.jpg', 0, 'verified'),
(7, 'naisut', '123456', 'vdm@vdm.com', 'naisut.jpg', 0, 'verified'),
(8, 'tanush', '123456', 'tanush@blogflog.com', 'tanush.jpg', 0, 'verified'),
(9, 'trishan', '123456', 'trishan@blogflog.com', 'trishan.jpg', 0, 'verified'),
(10, 'jigneshSir', '12345678', 'mehtavatsald02@gmail.com', 'default.png', 0, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `wastefull`
--

CREATE TABLE `wastefull` (
  `id` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wastefull`
--

INSERT INTO `wastefull` (`id`, `userName`) VALUES
(6, 'akhopatel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
