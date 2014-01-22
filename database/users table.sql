CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `Salt` text NOT NULL,
  `IsAdmin` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID`)
)