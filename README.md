IP utility for PHP
======

###### It's a simple PHP utility for validating IP addresses, and for checking wether an IP is on a specified network.


Example:

```php
$myip = new Ip("localhost");
echo $myip . PHP_EOL; // 01111111000000000000000000000001
echo $myip->getIp() . PHP_EOL; //127.0.0.1
var_dump($myip->isPrivate()); // true

$myip = new Ip();//REMOTE_ADDR
echo $myip . PHP_EOL;
echo $myip->getIp() . PHP_EOL;
var_dump($myip->isPrivate());

```

###### If you would like to check wether an IP address is on a network, you have to use CIDR format. It's usefull when you would like to detect wether it is intranet or not.


```php
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
```

###### IpV6

```php
var_dump((new Ip("2001:738:3100:241::1"))->isInNetwork("2001:738:3100:241::/64"));//true
var_dump((new Ip("2001:938:3100:241::1"))->isInNetwork("2001:738:3100:241::/64"));//true

var_dump((new Ip("localhost"))->isPrivate());//true
var_dump((new Ip("192.168.1.111"))->isPrivate());//true
var_dump((new Ip("192.169.2.111"))->isPrivate());//false
```

###### Invalid IP address

```php
try{
    $badIp = new Ip("198.1111.11.11");
}catch (NoValidIp $e){
    echo $e->getMessage(); //'Invalid IP'
}
```

###### Get IP class

```php
var_dump((new Ip("2001:738:3100:241::1"))->getClass()); //null
var_dump((new Ip("10.0.1.1"))->getClass()); // A
var_dump((new Ip("172.16.1.1"))->getClass()); // B
var_dump((new Ip("192.168.1.1"))->getClass()); // C
```
