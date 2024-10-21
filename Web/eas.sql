SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

CREATE TABLE `location` (
  `Location_ID` int(10) NOT NULL,
  `Location_Name` varchar(255) NOT NULL,
  `Location_where` varchar(255) NOT NULL,
  `Date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `location` (`Location_ID`, `Location_Name`, `Location_where`, `Date_added`) VALUES
(1, 'Chatuchak Weekend Market', 'https://maps.app.goo.gl/TWtH4r1uzeXSPG4K6', '2024-09-27 21:13:16'),
(2, 'MBK Center', 'https://maps.app.goo.gl/N9kBeGqJt2DtDrjL9', '2024-09-27 21:13:16'),
(3, 'Siam Paragon', 'https://maps.app.goo.gl/YEwFfvHY1o3Agchx8', '2024-09-27 21:13:16'),
(4, 'Asiatique The Riverfront', 'https://maps.app.goo.gl/AJaiT5fGvkBB3egc8', '2024-09-27 21:13:16'),
(5, 'Terminal 21', 'https://maps.app.goo.gl/qCHkR8HTbmiqhPgW6', '2024-09-27 21:13:16');


CREATE TABLE `place` (
  `Place_ID` int(10) NOT NULL,
  `Place_Name` int(10) NOT NULL,
  `Place_Location` int(10) NOT NULL,
  `Place_Stat` varchar(255) NOT NULL,
  `Date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `place` (`Place_ID`, `Place_Name`, `Place_Location`, `Place_Stat`, `Date_added`) VALUES
(1, 1, 1, 'Peaceful', '2024-09-27 21:13:16'),
(2, 2, 2, 'Danger', '2024-09-27 21:13:16'),
(3, 3, 3, 'Peaceful', '2024-09-27 21:13:16'),
(4, 4, 4, 'Peaceful', '2024-09-27 21:13:16'),
(5, 5, 5, 'Peaceful', '2024-09-27 21:13:16');

ALTER TABLE `location`
  ADD PRIMARY KEY (`Location_ID`);

ALTER TABLE `place`
  ADD PRIMARY KEY (`Place_ID`),
  ADD KEY `Place_Name` (`Place_Name`),
  ADD KEY `Place_Location` (`Place_Location`);

ALTER TABLE `location`
  MODIFY `Location_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `place`
  MODIFY `Place_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`Place_Name`) REFERENCES `location` (`Location_ID`),
  ADD CONSTRAINT `place_ibfk_2` FOREIGN KEY (`Place_Location`) REFERENCES `location` (`Location_ID`);
COMMIT;
