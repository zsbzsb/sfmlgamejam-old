CREATE TABLE jams (
  ID int(11) NOT NULL AUTO_INCREMENT,
  Title text NOT NULL,
  BeginTime text NOT NULL,
  EndTime text NOT NULL,
  ChosenTheme text NOT NULL,
  GalleryOpen tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (ID)
)