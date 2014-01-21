CREATE TABLE `suggestions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `JamID` int(11) NOT NULL,
  `ThemeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `JamID_idx` (`JamID`),
  KEY `FKThemeID_idx` (`ThemeID`),
  KEY `FKUserID_idx` (`UserID`),
  CONSTRAINT `FKThemeID` FOREIGN KEY (`ThemeID`) REFERENCES `themes` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKUserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKJamID` FOREIGN KEY (`JamID`) REFERENCES `jams` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
)