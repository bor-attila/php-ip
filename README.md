IP utility for PHP
======

###### It's a simple utility for PHP for validating IP addresses, and check if it's an IP is on the specified network.


Example:

```php
$myip = new Ip("localhost");
echo $myip . PHP_EOL; // 01111111000000000000000000000001
echo $myip->getIp() . PHP_EOL; //127.0.0.1
var_dump($myip->isPrivate()); // true
```

###### If you want to check if an IP address is on network use CIDR. It's usefull when you want to detect intranet.


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
var_dump((new Ip("localhost"))->isInNetwork("10.4.12.0/22"));//true
```

###### IpV6

```php

var_dump((new Ip("2001:738:3100:241::1"))->isInNetwork("2001:738:3100:241::/64"));//true
var_dump((new Ip("2001:938:3100:241::1"))->isInNetwork("2001:738:3100:241::/64"));//true

var_dump((new Ip("localhost"))->isPrivate());//true
var_dump((new Ip("192.168.1.111"))->isPrivate());//true
var_dump((new Ip("192.169.2.111"))->isPrivate());//false
```

