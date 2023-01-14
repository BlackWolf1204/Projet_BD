
<?php

    session_start();
    $_SESSION=array(); //array c'est une fonction qui vide le tableau
    session_destroy();
    header('Location: Page_accueil.php');

?>

