<?php
        $ENV = 'TEST'; // ou TEST

        if ($ENV == 'PROD') {
                define('URL', 'https://api1.binance.com');
                define('secret', 'XXX');
                define('header', [
                        'Accepts: */*',
                        'Content-Type: application/json',
                        'X-MBX-APIKEY: XXX'
                        ]
                );
                
                $api = new Binance\API('XXX','XXX');
        }                               

        if ($ENV == 'TEST') {
                define('URL', 'https://testnet.binance.vision');
                define('secret', 'XXX');
                define('header', [
                        'Accepts: */*',
                        'Content-Type: application/json',
                        'X-MBX-APIKEY: XXX'
                        ]
                );

                $api = new Binance\API('XXX','XXX', true);                  
        }
?>