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

        // GMT / UTC Times
        $starttime = $_REQUEST["starttime"];
        $endtime = $_REQUEST["endtime"];
        $pair = $_REQUEST["pair"];
                
        $timestamp = round(microtime(true)*1000);
        $dif = strtotime($endtime)-strtotime($starttime);

        echo 'Time,Price,BTC Volume,'.$pair.' Volume<br>';
        for ($j=0; $j<$dif; $j++){

            $json = trade_history($pair, (strtotime($starttime)+$j)*1000, (strtotime($starttime)+1+$j)*1000);

            for ($i=0; $i<sizeof($json); $i++) {
                echo date('H:i:s.v', $json[$i]['T']/1000).",".$json[$i]['p'].','.$json[$i]['p']*$json[$i]['q'].','.$json[$i]['q'].'<br>';
            }
        }

?>
    </body>
</html>