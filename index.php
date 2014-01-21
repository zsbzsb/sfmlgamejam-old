<?php $selected = "home"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h3>Hello and welcome to the SFML Game Jam website!</h3>

<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
    $session = new LoginSession();
    if (!$session->GetIsLoggedIn()) echo '<h3>To continue please login and register</h3>';
?>

<!--<a class="twitter-timeline"  href="https://twitter.com/sfmlgamejam"  data-widget-id="422492659622481920">Tweets by @sfmlgamejam</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>-->
    
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
