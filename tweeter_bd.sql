-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 01, 2020 at 12:40 PM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `tweeter_follow`
--

CREATE TABLE `tweeter_follow` (
  `id` int(11) NOT NULL,
  `follower` int(11) NOT NULL,
  `followee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweeter_follow`
--

INSERT INTO `tweeter_follow` (`id`, `follower`, `followee`) VALUES
(1, 10, 9),
(2, 10, 6),
(3, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tweeter_like`
--

CREATE TABLE `tweeter_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweeter_like`
--

INSERT INTO `tweeter_like` (`id`, `user_id`, `tweet_id`) VALUES
(1, 10, 63);

-- --------------------------------------------------------

--
-- Table structure for table `tweeter_tweet`
--

CREATE TABLE `tweeter_tweet` (
  `id` int(11) NOT NULL,
  `text` varchar(256) NOT NULL,
  `author` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweeter_tweet`
--

INSERT INTO `tweeter_tweet` (`id`, `text`, `author`, `score`, `created_at`, `updated_at`) VALUES
(49, 'Off to Waterloo. Wish me luck.', 7, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(50, 'Logic will get you from A to B. Imagination will take you everywhere.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(51, 'Man who jump off cliff, jump to conclusion!', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(52, ' have spoken w/ @GovAbbott of Texas and @LouisianaGov Edwards. Closely monitoring #HurricaneHarvey developments & here to assist as needed.', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(53, 'Man who not poop for many days must take care of back log.', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(54, 'All Tweeters are Created Equal', 4, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(55, 'He who drops watch in toilet has shitty time', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(56, 'Going to a Cabinet Meeting (tele-conference) at 11:00 A.M. on #Harvey. Even experts have said they\'ve never seen one like this!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(57, 'HISTORIC rainfall in Houston, and all over Texas. Floods are unprecedented, and more rain coming. Spirit of the people is incredible.Thanks!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(58, 'Be yourself; everyone else is already taken.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(59, 'To live is the rarest thing in the world. Most people exist, that is all.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(60, 'For those at the back who obviously can\'t hear me, I said that they may take out lives, but they\'ll never take our freedom', 5, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(61, 'With Mexico being one of the highest crime Nations in the world, we must have THE WALL. Mexico will pay for it through reimbursement/other.', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(62, 'Man who sneezes without tissue takes matters in own hands.', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(63, 'I am so clever that sometimes I don\'t understand a single word of what I am saying.', 9, 1, '2017-10-08 12:07:37', '0000-00-00 00:00:00'),
(64, 'I am pleased to inform you that I have just granted a full Pardon to 85 year old American patriot Sheriff Joe Arpaio. He kept Arizona safe!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(65, 'Only two things are infinite, the universe and human stupidity, and I\'m not sure about the former.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(66, 'The true sign of intelligence is not knowledge but imagination.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(67, 'It is the supreme art of the teacher to awaken joy in creative expression and knowledge.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(68, 'Busted through that wall like it was paper #sorrynotsorry', 6, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(69, 'A person who never made a mistake never tried anything new.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(70, 'Always forgive your enemies; nothing annoys them so much.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(71, 'Hello world of tweeter #ImNewatThis', 10, 0, '2017-09-01 12:57:48', '0000-00-00 00:00:00'),
(72, 'Is there anybody out here ? #ImLonely', 10, 0, '2017-09-01 13:00:39', '0000-00-00 00:00:00'),
(73, 'Still nobody ??? #ImLonely', 10, 0, '2017-09-01 13:04:39', '0000-00-00 00:00:00'),
(74, 'This place sucks.', 10, 0, '2017-09-01 13:10:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tweeter_user`
--

CREATE TABLE `tweeter_user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(512) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `level` int(11) NOT NULL,
  `followers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweeter_user`
--

INSERT INTO `tweeter_user` (`id`, `fullname`, `username`, `password`, `level`, `followers`) VALUES
(1, 'Donald J. Trump', 'donald', '', 100, 0),
(2, 'Conficius', 'conficius', '', 100, 1),
(3, 'Master Yoda', 'yoda', '', 100, 0),
(4, 'Martin Luther King', 'martin', '', 100, 0),
(5, 'William Wallace', 'will', '', 100, 0),
(6, 'Genghis Khan', 'mongoldude', '', 100, 1),
(7, 'Napoleon Bonaparte', 'napoleon', '', 100, 0),
(8, 'Albert Einstein', 'albert', '', 100, 0),
(9, 'Oscar Wilde', 'oscar', '', 100, 1),
(10, 'John Doe', 'johny', '$2y$10$9xy1A.dN0.eppTrLciPCn.hiMBHm2WAr1ykbgqcvaX6Uc66A7il8C', 100, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweeter_follow`
--
ALTER TABLE `tweeter_follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tweeter_like`
--
ALTER TABLE `tweeter_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tweeter_tweet`
--
ALTER TABLE `tweeter_tweet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tweeter_user`
--
ALTER TABLE `tweeter_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweeter_follow`
--
ALTER TABLE `tweeter_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tweeter_like`
--
ALTER TABLE `tweeter_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tweeter_tweet`
--
ALTER TABLE `tweeter_tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tweeter_user`
--
ALTER TABLE `tweeter_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
