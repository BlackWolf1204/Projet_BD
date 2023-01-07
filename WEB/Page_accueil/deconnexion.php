<!--        //SITE D'UNE MAISON ECONOME // -->
<!--    (page deconnexion) 
    Cette page permettra la deconnexion ( après connexion ) quand on se trouve sur la page d'accueil:

-->

<!-- Notes 24/12/2022 : a tester avec la page d'accueil-->


<?php

    session_start();
    $_SESSION=array(); //array c'est une fonction qui vide le tableau
    setcookie('Id', '', 0); // expire immédiatement
    session_destroy();
    header('Location: Page_accueil.php');

?>

