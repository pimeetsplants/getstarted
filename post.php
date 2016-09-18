<?php

// get sensor data - example for temperature sensor [RASPBERRY PI]
$SensorPath = "/sys/bus/w1/devices/10-000802dea372/w1_slave"; // your sensor id might be different [10-000802dea372] - change to your sensor id
$GetDataFromFile = implode('', file($SensorPath));
$SensorDataUnformated = substr($GetDataFromFile, strpos($GetDataFromFile, "t=") + 2);
$sensordata = sprintf("%2.2f", $SensorDataUnformated / 1000);

// code below copyright by David Walsh: https://davidwalsh.name/curl-post

// insert your values
$appid = '123456789012345678901234'; // your app id
$appkey = '123456789012345678901234567890123456'; // your app key
$appsecret = '12345678901234567890123456789012345678901234567890'; // your app secret

$data = $sensordata;

//extract data from the post
extract($_POST);

//set POST variables
$url = 'https://pimeetsplants.com/api/post/';
$fields_string = "";
$fields = array(
        'data'=>urlencode($data),
        'appid'=>urlencode($appid),
        'appkey'=>urlencode($appkey),
        'appsecret'=>urlencode($appsecret)
    );

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string = rtrim($fields_string,'&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
?>
