DROP TABLE IF EXISTS `problem`;
CREATE TABLE `problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `statement` blob NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `ModifiedUserId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `problem` VALUES (1,'adunare',0,1,'Se aduna doua numere sa se afiseze suma lor.',1397927202,1397927202,1),(2,'invizibilă',1,1,'Aceasta� problemă n-ar trebui să fie vizibilă în mod normal.',1397927202,1397927202,1),(3,'scădere',0,1,'Se dau două numere; să se calculeze diferența lor.',1397927202,1397927202,1),(4,'fractii',0,1,'Sa se afiseze rezultatul fractiei.',1397927202,1397927202,1),(8,'problematest',0,1,'Aceastaa **problema** este de *test*. ***Incercati*** sa nu o ~~distrugeti~~ stricati, si vedeti ca exista un [link](magico.co.vu) pe undeva pe aici. Poate ar fi si o imagine, daca n-ar fi &[30]prea mare textul&. Ah, uitati, am gasit-o: .(http://i.imgur.com/CRg25yC.png). Vreti si o tabela? Uitati acilea: .[.|.-uitati-..-ca se poate-.|..|.-sa avem-..-si tabele-.|.]. Si aveti si un blockquote: ./Alea iacta est/.',1398506726,1398506726,1);

DROP TABLE IF EXISTS `history_problem`;
CREATE TABLE `history_problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `problemId` int(11) NOT NULL,
  `statement` blob NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `history_problem` VALUES (1,4,1,'Se aduna doua numere sa se afiseze suma lor.',1397927202),(2,4,2,'Aceasta� problemă n-ar trebui să fie vizibilă în mod normal.',1397927202),(3,4,3,'Se dau două numere; să se calculeze diferența lor.',1397927202),(4,4,4,'Sa se afiseze rezultatul fractiei.',1397927202),(5,4,8,'Aceastaa **problema** este de *test*. ***Incercati*** sa nu o ~~distrugeti~~ stricati, si vedeti ca exista un [link](magico.co.vu) pe undeva pe aici. Poate ar fi si o imagine, daca n-ar fi &[30]prea mare textul&. Ah, uitati, am gasit-o: .(http://i.imgur.com/CRg25yC.png). Vreti si o tabela? Uitati acilea: .[.|.-uitati-..-ca se poate-.|..|.-sa avem-..-si tabele-.|.]. Si aveti si un blockquote: ./Alea iacta est/.',1398506726),(6,4,1,'Se aduna doua numere sa se afiseze suma acestora.',1397927202);

CREATE DEFINER=`root`@`localhost` TRIGGER modified
	 AFTER UPDATE
     ON `problem`
     FOR EACH ROW begin
          insert into history_problem set userId=NEW.ModifiedUserId, statement=NEW.statement, problemID=NEW.id, created=NEW.modified;
END
