<?php
/* State of the Jam - only 1 may be active at once */
$NextJamQued = true; // Generally Used with theme selection
$ThemeVisible = false; // Used when voting is finished before the jam is running
$JamRunning = false; // Used with submitting and editing game entries
$JamCompleted = false; // Used with editing game entries before the next jam

/* Any of the following may be active at any time - note above and make smart choices */
$ThemeSuggestionsOpen = true;

$ThemeVotingOpen = false;

$AddGamesActive = false;

$EditGamesActive = false;

$JamGalleryActive = false;

/* $ActiveJam must be set to a valid jam ID in the database */
$ActiveJamID = 1;
$MaxSuggestions = 2;
$MaxVotes = 1;
?>