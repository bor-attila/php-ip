<?php
/**
 * Created by PhpStorm.
 * User: attila
 * Date: 11/28/14
 * Time: 9:07 PM
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include "Ip.php";

$myip = new Ip("localhost");
echo $myip . PHP_EOL;
echo $myip->getIp() . PHP_EOL;
var_dump($myip->isPrivate());

$myip = new Ip();
echo $myip . PHP_EOL;
echo $myip->getIp() . PHP_EOL;
var_dump($myip->isPrivate());

var_dump((new Ip("192.168.1.1"))->isInNetwork("192.168.1.1/24")); //true
var_dump((new Ip("192.168.1.1"))->isInNetwork("192.168.1.1/25")); //true
var_dump((new Ip("192.168.1.1"))->isInNetwork("192.168.1.1/32"));//true
var_dump((new Ip("198.155.1.5"))->isInNetwork("192.168.1.1/32"));//false
var_dump((new Ip("10.4.12.15"))->isInNetwork("10.4.12.0/22"));//true
var_dump((new Ip("10.4.14.15"))->isInNetwork("10.4.12.0/22"));//true
var_dump((new Ip("10.4.12.254"))->isInNetwork("10.4.12.0/22"));//true
var_dump((new Ip("10.4.12.255"))->isInNetwork("10.4.12.0/22"));//true
var_dump((new Ip("10.4.15.255"))->isInNetwork("10.4.12.0/22"));//true
var_dump((new Ip("10.4.16.1"))->isInNetwork("10.4.12.0/22"));//false
var_dump((new Ip("localhost"))->isInNetwork("10.4.12.0/22"));//false
var_dump((new Ip("localhost"))->isInNetwork("10.4.12.0/22"));//false

var_dump((new Ip("localhost"))->isPrivate());//true
var_dump((new Ip("192.168.1.111"))->isPrivate());//true
var_dump((new Ip("192.169.2.111"))->isPrivate());//false

var_dump((new Ip("::1"))->isPrivate());//false

var_dump((new Ip("2001:738:3100:241::1"))->isInNetwork("2001:738:3100:241::/64"));//true
var_dump((new Ip("2001:938:3100:241::1"))->isInNetwork("2001:738:3100:241::/64"));//true

try{
    $badIp = new Ip("198.1111.11.11");
}catch (NoValidIp $e){
    echo $e->getMessage(); //'Invalid IP'
}

var_dump((new Ip("2001:738:3100:241::1"))->getClass()); //null
var_dump((new Ip("10.0.1.1"))->getClass()); // A
var_dump((new Ip("172.16.1.1"))->getClass()); // B
var_dump((new Ip("192.168.1.1"))->getClass()); // C
