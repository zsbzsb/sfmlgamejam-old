CREATE TABLE users (
  ID int(11) NOT NULL AUTO_INCREMENT,
  Username text NOT NULL,
  Password text NOT NULL,
  Salt text NOT NULL,
  LastIP text NOT NULL,
  IsBanned tinyint(1) NOT NULL DEFAULT 0,
  IsAdmin tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (ID)
)