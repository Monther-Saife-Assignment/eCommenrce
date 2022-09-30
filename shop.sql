-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2022 at 11:11 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(8, 'Hand Made', 'This Is Hand Made Section We Store Here The Hand Made Items', 0, 1, 1, 1, 1),
(9, 'Computers', 'This Is Computers Section ', 0, 2, 0, 0, 0),
(10, 'Cell Phones', 'This is The Cell Phones Section', 0, 3, 1, 0, 1),
(11, 'Clothing', 'This Is The Clothing & Fashion Section', 0, 4, 0, 0, 0),
(12, 'Tools', 'This Is The Home Tools Section', 0, 5, 0, 0, 0),
(13, 'Play_Station', 'Play_Station Games', 0, 6, 0, 0, 0),
(14, 'Nokia', 'Nokia Cell Phone', 10, 7, 0, 0, 0),
(16, 'Boxes', 'Strong Boxes', 12, 9, 0, 0, 0),
(17, 'Lap-Tops', 'A Set Of New Lap-Tops', 9, 9, 0, 0, 0),
(18, 'Desktop-PC', 'A Set Of New Desktop-PC', 9, 10, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `Item_ID`, `User_ID`) VALUES
(1, 'Amazing T-Shirt    ', 1, '2022-05-18', 11, 18),
(2, 'Amazing I Really Took Benefit From This Item', 1, '2022-05-24', 19, 18),
(8, 'This Is A Very Nice Cap', 1, '2022-05-19', 18, 18),
(10, 'A Nice Trousers', 1, '2022-05-19', 18, 18),
(12, 'A Nice T Shirt', 1, '2022-05-19', 18, 18),
(17, 'Nice Nive', 1, '2022-05-19', 18, 9),
(18, 'Amazing Ps3 Game I do Really Like It', 1, '2022-05-19', 14, 14),
(19, 'Beautiful T Shirt', 1, '2022-05-19', 18, 18),
(20, 'I Love It\r\n', 0, '2022-05-20', 18, 18),
(21, 'Amazing Ps4 Game\r\n\r\n', 0, '2022-05-20', 14, 14),
(22, 'Amazing Item', 1, '2022-05-22', 18, 18),
(23, 'Cool\r\n', 1, '2022-05-22', 18, 18),
(24, 'waw', 1, '2022-05-30', 18, 18),
(25, 'waw', 0, '2022-05-30', 18, 18);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `Tags`) VALUES
(11, 'T-Shirt', 'A Good T-Shirt For Both Gender', '$50', '2022-05-14', 'Egypt', '', '3', 0, 1, 11, 18, ''),
(12, 'ASUS Lab-Top', 'Version From ASUS Company', '$400', '2022-05-14', 'USA', '', '1', 0, 1, 9, 11, ''),
(13, 'Speaker', 'Very Good Speaker', '$60', '2022-05-14', 'Japan', '', '2', 0, 1, 9, 11, ''),
(14, 'Microphone', 'This Is A Very Good Microphone', '$80', '2022-05-14', 'Japan', '', '2', 0, 1, 9, 11, ''),
(15, 'Yeti Blue Mic', 'A Nice Yeti Blue Mic', '$40', '2022-05-14', 'Europe', '', '1', 0, 1, 9, 11, ''),
(16, 'iphone 6s', 'Apple iphone 6s', '$600', '2022-05-14', 'USA', '', '1', 0, 0, 10, 9, ''),
(17, 'Network Cable', 'Cat 9 Network Cable', '$100', '2022-05-15', 'USA', '', '1', 0, 1, 9, 11, ''),
(18, 'Trousers', 'A Very Comfortable Trousers', '$30', '2022-05-15', 'Egypt', '', '2', 0, 1, 11, 18, ''),
(19, 'Cap', 'A Nice Cap', '$30', '2022-05-17', 'Europe', '', '2', 0, 1, 11, 18, ''),
(20, 'Shoose', 'A Very Nice Shoose', '30', '2022-05-18', 'USA', '', '1', 0, 0, 11, 19, ''),
(21, 'Heavy Rain', 'A Good Heavy Rain', '50', '2022-05-18', 'USA', '', '1', 0, 0, 11, 19, ''),
(22, 'Dantes Inferno', 'A Good Ps Game', '$150', '2022-05-19', 'America', '', '1', 0, 1, 13, 18, ''),
(23, 'Heavy Rain', 'Amazing Ps3 Game', '120', '2022-05-19', 'Egypt', '', '2', 0, 0, 13, 14, ''),
(24, 'Derss', 'A Beautiful Dress', '$30', '2022-05-19', 'Japan', '', '2', 0, 0, 11, 18, ''),
(26, 'Dantes Inferno 3', 'Good Ps4 Game', '200', '2022-05-20', 'USA', '', '1', 0, 1, 13, 18, 'RPG'),
(27, 'Dantes Inferno 4', 'Amazing Ps4 Game', '400', '2022-05-20', 'America', '', '1', 0, 1, 13, 14, 'Osama,'),
(28, 'Dantes Inferno 5', 'Amazing Ps3 Game', '$300', '2022-05-23', 'Japan', '', '1', 0, 0, 13, 14, 'Osman, Guarantee, Fast-To-Download'),
(29, 'Diablo |||', 'Diablo ||| Good Game', '50', '2022-05-23', 'Egypt', '', '2', 0, 1, 13, 18, 'RPG, Online, Game'),
(30, 'samsong', 'A Good Company', '600', '2022-05-30', 'USA', '', '1', 0, 1, 10, 18, 'Discount');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `Username` varchar(255) NOT NULL COMMENT 'User Name To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'Identify User Group',
  `Truststatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User Approval ',
  `Date` date NOT NULL,
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `Truststatus`, `RegStatus`, `Date`, `Avatar`) VALUES
(1, 'monther', '601f1889667efaebb33b8c12572835da3f027f78', 'm@gmail.com', 'Monther Safe', 1, 0, 1, '0000-00-00', ''),
(9, 'Mohammed Husham', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Mohammed @gmail.com', 'Mohammed Husham', 0, 0, 1, '0000-00-00', ''),
(11, 'Mohammed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mohammed123@gmail.com', 'Mohammed Mudather', 0, 0, 1, '0000-00-00', ''),
(14, 'Gmal', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Gmal@gmail.com', 'Gmal Mohammed', 0, 0, 1, '2022-05-02', ''),
(18, 'Ekrima', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Ekrima@gmail.com', 'Ekrima Hashem', 0, 0, 1, '2022-05-05', ''),
(19, 'Application', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Application@gmail.com', 'Application Application', 0, 0, 0, '2022-05-16', ''),
(20, 'Abdo', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'abdo123@gmail.com', '', 0, 0, 0, '2022-05-17', ''),
(21, 'brir', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'brir@gmail.com', 'brir Altegane', 0, 0, 0, '2022-05-17', ''),
(22, 'btrxbbb', 'deccc3be7550bb94bc1acc2614e8ebf4dfabe8a8', 'wdWDqwdqwd@arvecawe', 'wEEWAcwde', 0, 0, 1, '2022-05-27', '98916_vlcsnap-2021-08-30-01h48m16s374.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `items_comment` (`Item_ID`),
  ADD KEY `user_comment` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
