CREATE TABLE `varena`.`source` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `created` INT NOT NULL,
  `modified` INT NOT NULL,
  `problemId` INT NOT NULL,
  `extension` VARCHAR(45) NULL,
  `evalStatus` INT NULL,
  `score` INT NULL,
  `evalTime` INT NULL,
  PRIMARY KEY (`idSource`));

