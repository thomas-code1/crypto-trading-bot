<?php
    function display ($a){
        echo '<pre>';
        print_r($a);
        echo '</pre>';
    }

    function display_order ($tab, $pair){

        date_default_timezone_set("Europe/Paris");

        echo "<table>
            <thead>
            <tr>
                <th>Transaction Time</th>
                <th>Pair</th>
                <th>Side</th>
                <th>Order Status</th>
                <th>Order ID</th>
                <th>Quantity Requested</th>
                <th>Price Executed</th>
                <th>Quantity Bought</th>
                <th>BTC Transacted</th>
            </tr></thead>";

            echo "<tr><td>";
            echo date('d-m-Y H:i:s.u', round($tab[$pair]['time']/1000));           // Transaction time

            echo "</td><td>";
            echo $pair;           // Pair
        
            echo "</td><td>";
            echo $tab[$pair]['side'];           // Side
    
            echo "</td><td>";
            echo $tab[$pair]['status'];           // Order status

            echo "</td><td>";
            echo $tab[$pair]['orderid'];           // Order ID

            echo "</td><td>";
            echo $tab[$pair]['quantity'];           // Quantity requested

            echo "</td><td>";
            echo $tab[$pair]['price_exec'];           // Price executed
    
            echo "</td><td>";
            echo $tab[$pair]['quantity_exec'];           // Quantity executed

            echo "</td><td>";
            echo $tab[$pair]['btc_exec'];           // BTC Transacted
    
            echo "</td></tr></table>";
    }

    function export_order ($tab, $pair) {
        $myfile = fopen("order_logs.txt", "a+");

        fwrite($myfile,
            date('d-m-Y H:i:s.u', round($tab[$pair]['time']/1000)).','.          // Transaction time
            $pair.', '.
            $tab[$pair]['side'].','.
            $tab[$pair]['status'].','.
            $tab[$pair]['orderid'].','.
            $tab[$pair]['quantity'].','.
            $tab[$pair]['price_exec'].','.         // Price executed
            $tab[$pair]['quantity_exec'].','.
            $tab[$pair]['btc_exec'].','."\n"
        );
    }

    function market_buy ($pair, $quantity) {

        $endpoint = '/api/v3/order';
        $timestamp = round(microtime(true)*1000);
        $parameters = [
                'symbol' => $pair,
                'side' => 'BUY',
                'type' => 'MARKET',
                'quoteOrderQty' => $quantity,
                'timestamp' => $timestamp
        ];

        $qs = http_build_query($parameters); // query string encode the parameters

        $sig = hash_hmac('sha256',$qs,secret); // sign the parameters
        $request = URL.$endpoint."?".$qs."&signature=".$sig; // create the API request

        $curl = curl_init(); // Get cURL resource
        curl_setopt_array($curl, array(             // Set cURL options
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_POST => true,               // POST request
                CURLOPT_HTTPHEADER => header,     // set the headers 
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $result = json_decode($response, true);
        curl_close($curl); // Close request

        return $result;
    }

    function market_sell ($pair, $quantity) {

        $endpoint = '/api/v3/order';
        $timestamp = round(microtime(true)*1000);
        $parameters = [
                'symbol' => $pair,
                'side' => 'SELL',
                'type' => 'MARKET',
                'quantity' => $quantity,
                'timestamp' => $timestamp
        ];

        $qs = http_build_query($parameters); // query string encode the parameters

        $sig = hash_hmac('sha256',$qs,secret); // sign the parameters
        $request = URL.$endpoint."?".$qs."&signature=".$sig; // create the API request

        $curl = curl_init(); // Get cURL resource
        curl_setopt_array($curl, array(             // Set cURL options
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_POST => true,               // POST request
                CURLOPT_HTTPHEADER => header,     // set the headers 
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $result = json_decode($response, true);
        curl_close($curl); // Close request

        return $result;
    }

    function trade_history ($pair, $starttime, $endtime) {

        $endpoint = '/api/v3/aggTrades';
        $timestamp = round(microtime(true)*1000);
        $parameters = [
                'symbol' => $pair,
                'startTime' => $starttime,
                'endTime' => $endtime,
                'limit' => 1000
        ];

        $qs = http_build_query($parameters); // query string encode the parameters

        $request = URL.$endpoint."?".$qs; // create the API request

        $curl = curl_init(); // Get cURL resource
        curl_setopt_array($curl, array(             // Set cURL options
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_HTTPHEADER => header,     // set the headers 
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response

        $result = json_decode($response, true);
        curl_close($curl); // Close request

        return $result;
    }

    function time_now () {
        $timenow = DateTime::createFromFormat('U.u', microtime(true));
        return ($timenow->format("d-m-Y H:i:s.u"));
    }

    function binance_info ($pair) {
        $endpoint = '/api/v3/exchangeInfo';
        $parameters = [
            'symbol' => $pair
        ];

        $qs = http_build_query($parameters); // query string encode the parameters
        $request = URL.$endpoint."?".$qs; // create the API request

        $curl = curl_init(); // Get cURL resource
        curl_setopt_array($curl, array(             // Set cURL options
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_HTTPHEADER => header,     // set the headers 
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response

        $result = json_decode($response, true);
        return $result;
    }
?>