<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); /* For debugging */
//error_reporting(0); /* For publishing */
include('poloniexApi.php');

$user = "coinnect_user";
$pass = "coinnect1907";
$dbh = new PDO('mysql:host=localhost;dbname=coinnect_db', $user, $pass);
$dbh->exec("set names utf8");

// site ayarları

$stmt = $dbh->prepare("select * from api_settings order by id asc limit 1");
$stmt->execute();
$apiSettings = $stmt->fetch();

$settings = array(
    'site_url' => 'http://coinnect.xyz', // no slash at the end.
    'site_name' => 'Poloniex Auto Trader',
    'api_key' => $apiSettings['api_key'],
    'api_secret' => $apiSettings['api_secret'],
    'btc_amount_per_buy' => $apiSettings['btc_amount_per_buy'],
    'buy_limit_per_coin' => $apiSettings['buy_limit_per_coin']
);

$polo = new poloniex($settings['api_key'], $settings['api_secret']);

define('path', realpath('.'));
define('client_path', path);
define('site_url', $settings['site_url']);
define('client_url', $settings['site_url'].'/client');

// ++
function toplamaBtc($x, $y){
    $sonuc = bcadd($x, $y, 8);  // 6.2340
    return $sonuc;
}


function cikarmaBtc($x, $y){
    $sonuc = bcsub($x, $y, 8);
    return $sonuc;
}


function bolmeBtc($x, $y){
    $sonuc = bcdiv($x, $y, 8);
    return $sonuc;
}

function carpmaBtc($x, $y){
    $sonuc = bcmul($x, $y, 8);
    return $sonuc;
}

?>