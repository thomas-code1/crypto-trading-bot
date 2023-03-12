<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

<?php
        require 'vendor/autoload.php';
        require 'environment.php';
        require 'functions.php';
        
        // TICKER & BALANCES UPDATE
        $ticker = $api->prices();
        $balances = $api->balances($ticker);

        display($balances);

?>
    </body>
</html>