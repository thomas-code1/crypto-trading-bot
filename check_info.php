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

        $pair = 'STRAXBTC';
        display('Pair is: '.$pair);

        $bought_quantity = 4567.123456789;
        display($bought_quantity);


        // Récupération des informations de la pair
        echo 'Binance Info API call starts: '.time_now().'<br>';
        $result = binance_info($pair);
        echo 'Binance Info API call ends: '.time_now().'<br>';

        $lotstepsize = $result['symbols'][0]['filters'][2]['stepSize'];
        display('LotStepSize is: '.$lotstepsize);

        $tickSize = $result['symbols'][0]['filters'][0]['tickSize'];
        display('TickSize is: '.$tickSize);

        // Calcul de la quantité à vendre
        $sell_quantity = sprintf('%.8f',
                floor(         // arrondi vers le bas avec le bon nombre de décimales
                    $bought_quantity / $lotstepsize
                ) * $lotstepsize
            );

        display($sell_quantity);

?>
    </body>
</html>