-- phpMyAdmin SQL Dump
-- version 3.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 11, 2010 at 12:04 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raacs`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `questions_quiz_id` int(11) NOT NULL,
  `answer_media` varchar(50) default NULL,
  `duration` double NOT NULL,
  `answer_type` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `grade` double default NULL,
  `total_points` double default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=254 ;

--
-- Dumping data for table `answers`
--


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `answer_id` int(11) default NULL,
  `creator_id` int(11) default NULL,
  `media_type` int(11) default NULL,
  `comment` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL auto_increment,
  `group_name` varchar(50) default NULL,
  `unique` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `unique`) VALUES
(1, 'Fake Class', '2009900000');

-- --------------------------------------------------------

--
-- Table structure for table `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `groups_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL auto_increment,
  `creator_id` int(11) NOT NULL,
  `title` varchar(50) default NULL,
  `text` text,
  `picture` varchar(50) default NULL,
  `answer_type` int(11) default NULL,
  `shared` tinyint(4) default NULL,
  `keywords` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `keywords` (`keywords`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `creator_id`, `title`, `text`, `picture`, `answer_type`, `shared`, `keywords`) VALUES
(1, 1, 'Job Interview', 'Suppose you are in a job interview situation inwhich your prospective boss asks you to tell him or her about yourself, especially things that are relevant to the job you are interested in.', NULL, 1, 1, NULL),
(2, 1, 'Dry Cleaners', 'Luz, a Spanish friend of yours, has just finished telling you about an experience she had today at the dry cleaners. This reminds you of an amusing incident that happened to Arturo, another friend of yours.  Luz asks you to tell her about the incident.  Based on the story shown in the pictures, recount for Luz exactly what happened to Arturo.  After Luz asks her question, you should begin to tell your story. ', '../images/IMAGE4_lg.jpg', 1, 1, NULL),
(3, 1, 'College Orientation', 'A group of high school students has arrived from Colombia to spend a summer session at a community college in Texas.  You have been asked to give a brief talk as part of their orientation on two or three recent events in Texas that you feel are important.  After your talk is introduced, brief the group on these recent events.', NULL, 1, 1, NULL),
(4, 1, 'Camping Trip', 'You are leading a group of Latin American high school students on a visit to Texas.  The plans for the weekend call for a camping trip, but, due to heavy rains, the trip seems inadvisable.  As an alternative, some students want to spend the weekend shopping in the city. Others desire to stay with their host families.  Hoping the rain will end soon, some others still want to go camping.  They ask you what they will be doing.  Making a strong case for your proposal, present your plans for the weekend to the group.', NULL, 1, 1, NULL),
(5, 1, 'Official Language', 'You are at a board meeting of professionals from different areas and someone asks you what you think of the proposal of "English as the Official Language of Texas" policy.  State your opinion and supporting reasons.', NULL, 1, 1, NULL),
(6, 1, 'Describe your Town', 'You have been assigned to be a group leader for several South American educators who have come to the U.S. to observe American culture and life.   They ask you where you are from, and what your town/city is like.  Describe your city to them, mentioning not only highlights of special interest but also things that are typical of American cities and towns.', NULL, 1, 1, NULL),
(7, 1, 'Rancho Feliz', 'You are a travel agent who will make a big commission if you attract customers to spend their vacation at Rancho Feliz, a resort on the South Texas coast.  A gentleman from Argentina calls you to ask abut family vacation resorts, so you will try to get him intersted in Rancho Feliz.  Give him as much detail of this place as you can, based on all the pictures you have before you.', 'assets/images/rancho-feliz.png', 1, 1, NULL),
(8, 1, 'Library Computers', 'A professor from South America, Dr. Parras, who has come to study at UT as a Visiting Scholar, asks you how to use the computer terminals in the library to locate a book he must  read.  Tell him the steps he must follow with as many details as possible.', NULL, 1, 1, NULL),
(9, 1, 'Found Money', 'You are a teacher at a high school and  have been assigned to report on the event shown below for your school radio program.  You should use the facts shown below in your report, but all the events must be reported in the PAST TENSE.  Try to make the report interesting for your audience of high school students, but also objective.\rMONEY FOUND\r1.  Maria Gomez, a student at the University of Texas, finds $8,000 in an envelope in the street near her apartment in Hyde Park.\r2.  She is from a very poor family of 9.\r3.  She takes the money to the police, who say that after one year she can claim it if no one else does.\r4.  After only one day, four different people have come in to claim it, all neighbors of Maria Gomez.\r5.  Gomez says that God gave the money to her, and that He knows she is an honest person with many needs, and believes that she deserves it.  She also says that the others who say that the money is theirs are lying.\r6.  She already has plans to invest a portion of the money in the Texas lottery, in hopes of increasing her fortune.  ', NULL, 1, 1, NULL),
(10, 1, 'Accident Witness', 'You have just witnessed the accident shown in the picture, and you even spoke to the victim, Juan Garcia, later in the hospital.  A policeman who arrived after the incident asks you to describe as much as you can about what happened.  You may also quote what Garcia told you, which was basically that he was just riding his bike across the street when someone hit him without any warning.  ', 'assets/images/accident.png', 1, 1, NULL),
(11, 1, 'Teacher Introduction', 'As the newly-hired teacher, you have just been invited to speak to a group of parents who want to know who you are and why they can have confidence in you as the teacher of their children.  Introduce yourself to them and describe what your background is and what  kind of person you are (do not discuss what you will do in the classroom, e.g., activities, curriculum).  ', NULL, 1, 1, NULL),
(12, 1, 'Spending a Donation', 'Imagine that you are the leader of a group discussion on spending a $5,000 donation from an anonymous donor to your organization, an environmental group, to be spent as your group saw fit.  During the discussion, the following suggestions are given:\ra.  Office equipment to help in fund-raising efforts;\rb.  More announcements and advertisements to raise the public consciousness;\rc.  Take a powerful local politician and his wife to a great dinner;\rd.  A party for the volunteer workers;\re.  Donate the money to a more well-known, national organization.  \rAs group leader, your task is to synthesize these points, and also to offer your opinion as to the best use for the money.', NULL, 1, 1, NULL),
(13, 1, 'Mexican Tour Group', 'You are in charge of a tour group from Texas who came to Ixtapa, Mexico, to spend a week at the Sheraton Hotel and to enjoy sun and fun at the beach.  When you arrive there, you find that your hotel reservations were changed to a second-class hotel in a neighboring town, Zihua, and all the tour members are angry.  Half of them want to go right back to Texas, and the other half wants to go to the Sheraton to demand rooms.  Take a position, and then argue in favor of it, trying to persuade all members to follow your belief.', NULL, 1, 1, NULL),
(14, 1, '8th Grade Dance', 'Final 4:  You are the teacher of an eighth grade class which is deciding on the rules for the upcoming dance.  The following suggestions are on the floor:\ra.  not to allow any adults inside;\rb.  no alcohol or drugs;\rc.  a slow dance only at the very end;\rd.  boys must wear ties and jackets, girls must wear dresses.\rThe last proposal is in hot debate, so you must formulate a set of rules that are practical but popular with the majority.  You are the authority figure but must not sound dictatorial.', NULL, 1, 1, NULL),
(15, 1, 'Oscar Jara Gonzales', 'You want to summarize for your high school class the story you heard about Oscar Jara Gonzalez, the Chilean armored truck driver who drove off with the money and hid it, only to be caught a short time later.  Remember that his plan was to hide most of it and spend it once he was released from jail.  Present the story in a way that captures the interest of your listeners.  ', NULL, 1, 1, NULL),
(16, 1, 'Year Round School', 'Sr. Juan Delgado, a prominent government official of Panama who is in charge of educational policies in his country for all high schools, tells you that he is seriously thinking of mandating that all students attend classes eleven and a half months out of the year.  He asks you what you think of this idea.  State your opinion and support it well.', NULL, 1, 1, NULL),
(17, 1, 'Bicycles vs. Motorcycles', 'While talking with some of your friends in Mexico, one of them says that people should use bicycles as their major means of transportation, while another friend says that motorcycles would solve many problems.  Then the others present ask what you think.  Try to present your position logically by comparing advantages and disadvantages of the bicycle/motorcycle issue.', NULL, 1, 1, NULL),
(18, 1, 'Women in Power', 'Imagine you are in a talk show situation with a local talk show host, who asks you what you think of having mostly women instead of men in key administrative positions in the government, at local, national, and international levels, as well as in other public arenas, such as school principals and directors of multi-national corporations.  You should support your opinion as well as you can, perhaps giving reasons, comparisons, etc.', NULL, 1, 1, NULL),
(19, 1, 'Directions', 'You  are working at the Texaco gas station in the upper left hand corner of the map, when two elderly people approach you to ask how they could get to the bus station.  Following the route delineated on the map, tell them how to get there in great detail, naming landmarks they will see along the way.  \r', '../images/map.png', 1, 1, NULL),
(22, 1, 'Classroom Management', 'You are with a group of teachers who are discussing how to maintain order and discipline in the classroom.  Explain your own ideas on the subject giving supporting details.', NULL, 1, 1, NULL),
(33, 1, 'Test Video Question', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dui mi, aliquam nec mattis at, ornare sit amet ligula. Fusce nulla lacus, dapibus ut gravida eu, scelerisque vel nulla. Duis feugiat tincidunt lacinia. Suspendisse ultricies nisi vitae sapien rhoncus at congue nibh laoreet. Duis eget nulla arcu, ac ultrices turpis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque iaculis semper felis et consequat. Fusce sagittis imperdiet consectetur. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque in tellus eget turpis aliquet consectetur. Cras bibendum enim bibendum elit adipiscing sit amet dignissim nunc tempor. Curabitur a nisi nec urna venenatis sagittis viverra eu nisl.\r\n\r\n', NULL, 1, 1, NULL),
(31, 1, 'Test Question #1', 'This is only a test', 'assets/images/accident.png', 1, 1, NULL),
(32, 1, 'Test Question #2', 'This is another test.', 'assets/images/accident.png', 1, 1, NULL),
(34, 1, 'Emily - Intro', 'Watch the video clip and record your response.', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions_quizzes`
--

CREATE TABLE IF NOT EXISTS `questions_quizzes` (
  `id` int(11) NOT NULL auto_increment,
  `quiz_id` int(11) default NULL,
  `question_id` int(11) default NULL,
  `think_time` double default NULL,
  `record_time` double default NULL,
  `max_takes` int(11) default NULL,
  `total_points` double default NULL,
  `order` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `questions_quizzes`
--

INSERT INTO `questions_quizzes` (`id`, `quiz_id`, `question_id`, `think_time`, `record_time`, `max_takes`, `total_points`, `order`) VALUES
(1, 1, 33, 10, 10, 1, 10, 1),
(2, 1, 32, 10, 10, 1, 10, 2),
(3, 2, 31, 10, 10, 1, 10, 1),
(4, 2, 4, 10, 10, 1, 10, 2),
(5, 2, 5, 10, 10, 1, 10, 3),
(6, 2, 6, 10, 10, 1, 10, 4),
(7, 2, 7, 19, 10, 1, 10, 5),
(8, 2, 8, 10, 10, 1, 10, 6),
(9, 3, 7, NULL, NULL, NULL, NULL, 1),
(11, 3, 10, NULL, NULL, NULL, NULL, 2),
(13, 4, 34, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_parts`
--

CREATE TABLE IF NOT EXISTS `question_parts` (
  `id` int(11) NOT NULL auto_increment,
  `question_id` int(11) NOT NULL,
  `part_order` int(11) NOT NULL,
  `media` varchar(50) default NULL,
  `media_type` int(11) default NULL,
  `in_point` double default NULL,
  `out_point` double default NULL,
  `duration` double default NULL,
  `stop_at_end` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `question_parts`
--

INSERT INTO `question_parts` (`id`, `question_id`, `part_order`, `media`, `media_type`, `in_point`, `out_point`, `duration`, `stop_at_end`) VALUES
(1, 1, 1, 'job_interview', 1, 0, 0, 13.189, 0),
(2, 1, 2, NULL, 8, NULL, NULL, 2, 0),
(3, 1, 3, 'job_interview_prompt', 1, 0, 0, 2.096, 0),
(4, 1, 4, NULL, 5, NULL, NULL, 2, 0),
(5, 2, 1, 'dry_cleaners', 1, 0, 0, 24.847, 0),
(6, 2, 2, NULL, 8, NULL, NULL, 2, 0),
(7, 2, 3, 'dry_cleaners_prompt', 1, 0, 0, 4.649, 0),
(8, 2, 4, NULL, 5, NULL, NULL, 2, 0),
(9, 3, 1, 'college_orientation', 1, 0, 0, 18.356, 0),
(10, 3, 2, NULL, 8, NULL, NULL, 2, 0),
(11, 3, 3, 'college_orientation_prompt', 1, 0, 0, 8.176, 0),
(12, 3, 4, NULL, 5, NULL, NULL, 2, 0),
(13, 4, 1, 'camping_trip', 1, 0, 0, 30.223, 0),
(14, 4, 2, NULL, 8, NULL, NULL, 2, 0),
(15, 4, 3, 'camping_trip_prompt', 1, 0, 0, 3.578, 0),
(16, 4, 4, NULL, 5, NULL, NULL, 2, 0),
(17, 5, 1, 'official_language', 1, 0, 0, 15.975, 0),
(18, 5, 2, NULL, 8, NULL, NULL, 2, 0),
(19, 5, 3, 'official_language_prompt', 1, 0, 0, 5.805, 0),
(20, 5, 4, NULL, 5, NULL, NULL, 2, 0),
(21, 6, 1, 'describe_your_town', 1, 0, 0, 20.898, 0),
(22, 6, 2, NULL, 8, NULL, NULL, 2, 0),
(23, 6, 3, 'describe_your_town_prompt', 1, 0, 0, 3.901, 0),
(24, 6, 4, NULL, 5, NULL, NULL, 2, 0),
(25, 7, 1, 'rancho_feliz', 1, 0, 0, 30.513, 0),
(26, 7, 2, NULL, 8, NULL, NULL, 15, 0),
(27, 7, 3, 'rancho_feliz_prompt', 1, 0, 0, 4.179, 0),
(28, 7, 4, NULL, 5, NULL, NULL, 15, 0),
(29, 8, 1, 'library_computers', 1, 0, 0, 18.53, 0),
(30, 8, 2, NULL, 8, NULL, NULL, 2, 0),
(31, 8, 3, 'library_computers_prompt', 1, 0, 0, 5.433, 0),
(32, 8, 4, NULL, 5, NULL, NULL, 2, 0),
(33, 9, 1, 'found_money', 1, 0, 0, 64.691, 0),
(34, 9, 2, NULL, 8, NULL, NULL, 2, 0),
(35, 9, 3, 'found_money_prompt', 1, 0, 0, 4.597, 0),
(36, 9, 4, NULL, 5, NULL, NULL, 2, 0),
(37, 10, 1, 'accident_witness', 1, 0, 0, 24.382, 0),
(38, 10, 2, NULL, 8, NULL, NULL, 15, 0),
(39, 10, 3, 'accident_witness_prompt', 1, 0, 0, 5.759, 0),
(40, 10, 4, NULL, 5, NULL, NULL, 15, 0),
(41, 11, 1, 'teacher_introduction', 1, 0, 0, 23.499, 0),
(42, 11, 2, NULL, 8, NULL, NULL, 2, 0),
(43, 11, 3, 'teacher_introduction_prompt', 1, 0, 0, 4.226, 0),
(44, 11, 4, NULL, 5, NULL, NULL, 2, 0),
(45, 12, 1, 'spending_a_donation', 1, 0, 0, 49.644, 0),
(46, 12, 2, NULL, 8, NULL, NULL, 2, 0),
(47, 12, 3, 'spending_a_donation_prompt', 1, 0, 0, 4.69, 0),
(48, 12, 4, NULL, 5, NULL, NULL, 2, 0),
(49, 13, 1, 'mexican_tour_group', 1, 0, 0, 35.852, 0),
(50, 13, 2, NULL, 8, NULL, NULL, 2, 0),
(51, 13, 3, 'mexican_tour_group_prompt', 1, 0, 0, 6.13, 0),
(52, 13, 4, NULL, 5, NULL, NULL, 2, 0),
(53, 14, 1, '8th_grade_dance', 1, 0, 0, 31.294, 0),
(54, 14, 2, NULL, 8, NULL, NULL, 2, 0),
(55, 14, 3, '8th_grade_dance_prompt', 1, 0, 0, 5.48, 0),
(56, 14, 4, NULL, 5, NULL, NULL, 2, 0),
(57, 15, 1, 'oscar_jara_gonzales', 1, 0, 0, 24.195, 0),
(58, 15, 2, NULL, 8, NULL, NULL, 2, 0),
(59, 15, 3, 'oscar_jara_gonzales_prompt', 1, 0, 0, 4.783, 0),
(60, 15, 4, NULL, 5, NULL, NULL, 2, 0),
(61, 16, 1, 'year_round_school', 1, 0, 0, 23.359, 0),
(62, 16, 2, NULL, 8, NULL, NULL, 2, 0),
(63, 16, 3, 'year_round_school_prompt', 1, 0, 0, 5.154, 0),
(64, 16, 4, NULL, 5, NULL, NULL, 2, 0),
(65, 17, 1, 'bicycles_vs_motorcycles', 1, 0, 0, 25.356, 0),
(66, 17, 2, NULL, 8, NULL, NULL, 2, 0),
(67, 17, 3, 'bicycles_vs_motorcycles_prompt', 1, 0, 0, 5.944, 0),
(68, 17, 4, NULL, 5, NULL, NULL, 2, 0),
(69, 18, 1, 'women_in_power', 1, 0, 0, 29.769, 0),
(70, 18, 2, NULL, 8, NULL, NULL, 2, 0),
(71, 18, 3, 'women_in_power_prompt', 1, 0, 0, 2.976, 0),
(72, 18, 4, NULL, 5, NULL, NULL, 2, 0),
(73, 19, 1, 'directions', 1, 0, 0, 23.174, 0),
(74, 19, 2, NULL, 8, NULL, NULL, 2, 0),
(75, 19, 3, 'directions_prompt', 1, 0, 0, 4.924, 0),
(76, 19, 4, NULL, 5, NULL, NULL, 2, 0),
(77, 22, 1, 'classroom_management', 1, 0, 0, 12.636, 0),
(78, 22, 2, NULL, 8, NULL, NULL, 2, 0),
(79, 22, 3, 'classroom_management_prompt', 1, 0, 0, 4.923, 0),
(80, 22, 4, NULL, 5, NULL, NULL, 2, 0),
(105, 31, 1, 'mp3:tq-1', 1, 0, 0, 1.802, 0),
(106, 31, 2, NULL, 8, NULL, NULL, 2, NULL),
(107, 31, 3, 'mp3:tp-1', 1, 0, 0, 2.168, 0),
(117, 34, 1, '1-emily-intro', 3, 0, 0, 74.866, 0),
(109, 32, 1, 'mp3:tq-2', 1, 0, 0, 1.933, 0),
(110, 32, 2, NULL, 8, NULL, NULL, 2, NULL),
(111, 32, 3, 'mp3:tp-2', 1, 0, 0, 2.507, 0),
(112, 32, 4, NULL, 5, NULL, NULL, 3, NULL),
(113, 33, 1, 'test-vid', 3, 0, 0, 4.284, 0),
(114, 33, 2, NULL, 8, NULL, NULL, 5, NULL),
(116, 33, 4, NULL, 5, 0, 0, 3, 0),
(118, 34, 2, NULL, 8, NULL, NULL, 10, NULL),
(119, 34, 3, NULL, 5, NULL, NULL, 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(11) NOT NULL auto_increment,
  `creator_id` int(11) NOT NULL,
  `title` varchar(50) default NULL,
  `instructions` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `creator_id`, `title`, `instructions`) VALUES
(1, 1, 'Test Quiz #1', 'Listen & speak carefully!'),
(2, 1, 'Test Quiz #2', 'Listen carefully!'),
(3, 1, 'Audio Example Quiz', 'This is an example of a quiz with audio and picture based questions.  After the scenario is presented you will have some time to think and then you will record your answer.'),
(4, 1, 'Video Example Quiz', 'The material for this quiz is in video format.  Watch the video then record your response.');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes_users`
--

CREATE TABLE IF NOT EXISTS `quizzes_users` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `quiz_id` int(11) default NULL,
  `publish_start` datetime default NULL,
  `publish_end` datetime default NULL,
  `grade` double default NULL,
  `status` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `quizzes_users`
--

INSERT INTO `quizzes_users` (`id`, `user_id`, `quiz_id`, `publish_start`, `publish_end`, `grade`, `status`) VALUES
(4, 1, 1, '2010-01-26 16:41:31', '2010-09-30 16:41:38', NULL, 1),
(5, 1, 2, '2010-01-26 16:41:51', '2010-11-24 16:41:58', NULL, 1),
(6, 1, 3, NULL, NULL, NULL, 1),
(7, 1, 4, NULL, NULL, NULL, 1),
(9, 17, 3, NULL, NULL, NULL, 1),
(10, 17, 4, NULL, NULL, NULL, 1),
(22, 23, 4, NULL, NULL, NULL, 1),
(21, 23, 3, NULL, NULL, NULL, 1),
(20, 22, 4, NULL, NULL, NULL, 1),
(19, 22, 3, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `last_name` varchar(30) default NULL,
  `first_name` varchar(30) default NULL,
  `eid` varchar(10) default NULL,
  `uin` varchar(16) default NULL,
  `role` int(11) default NULL,
  `password` varchar(40) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `eid`, `uin`, `role`, `password`) VALUES
(1, 'Herrick', 'Clifford', 'csh2583', 'F2768A6307322846', 3, NULL),
(17, 'Gallner', 'John', 'gallnerj', NULL, 1, NULL);
