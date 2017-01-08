<?php
    require_once('php/function.php');

    $page = new WebApp;
    if(isset($_POST['search'])) //wyszykiwarka, przekazanie zmiennej do obiektu
    {
        $page->search = strtolower($_POST['search']);
    }

    $page->database = 'database.csv'; //wskazujemy jaki plik ma być bazą daynych
    $page->Show(); //wyświetlenie strony
?>
