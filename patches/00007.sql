DROP TABLE IF EXISTS `round_problem`;
CREATE TABLE `round_problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `roundId` int(11) NOT NULL,
  `problemId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
LOCK TABLES `round_problem` WRITE;
INSERT INTO `round_problem` VALUES (1,1398079800,1398079800,1,1),(2,1398079800,1398079800,1,3);
UNLOCK TABLES;

DROP TABLE IF EXISTS `round`;
CREATE TABLE `round` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `startDate` int NOT NULL,
  `duration` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
LOCK TABLES `round` WRITE;
INSERT INTO `round` VALUES (1,1398079800,1398079800,'TestRound',4,'1333699439',60);
UNLOCK TABLES;
