alter table problem add modUserId int not null after userId;
update problem set modUserId = userId;
update problem set statement="Se dau douã numere; sã se calculeze suma acestora." WHERE `id`='1';


DROP TABLE IF EXISTS `history_problem`;
CREATE TABLE `history_problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `problemId` int(11) NOT NULL,
  `statement` blob NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `history_problem` VALUES (1,4,1,'Se dau douã numere; sã se calculeze suma lor.',1397927202),
(2,4,2,'Aceastã problemã n-ar trebui sã fie vizibilã în mod normal.',1397927202),
(3,4,3,'Se dau douã numere; sã se calculeze diferenþa lor.',1397927202),
(4,4,8,'Aceastaa **problema** este de *test*. ***Incercati*** sa nu o ~~distrugeti~~ stricati, si vedeti ca exista un [link](magico.co.vu) pe undeva pe aici. Poate ar fi si o imagine, daca n-ar fi &[30]prea mare textul&. Ah, uitati, am gasit-o: .(http://i.imgur.com/CRg25yC.png). Vreti si o tabela? Uitati acilea: .[.|.-uitati-..-ca se poate-.|..|.-sa avem-..-si tabele-.|.]. Si aveti si un blockquote: ./Alea iacta est/.',1398506726),
(5,4,1,'Se dau douã numere; sã se calculeze suma acestora.',1397927202);

TRIGGER problemModified
	 AFTER UPDATE
     ON `problem`
     FOR EACH ROW begin
          insert into history_problem set userId=NEW.modUserId, statement=NEW.statement, problemId=NEW.id, created=NEW.modified;
END
