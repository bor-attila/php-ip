<?php
/**
 * Created by PhpStorm.
 * User: Bőr Attila
 * Date: 11/28/14
 * Time: 9:06 PM
 */

class NoValidIp extends Exception{
    function __contruct( $e ){
        echo $e;
    }
}


class Ip {

    private $isPrivate = false;
    private $ip = null;
    private $ipbinary = [];
    private $isIp4 = true;

    public function __construct( $ip ) {

        if( !is_string($ip) ){
            throw new NoValidIp("The ip must be string");
        }

        if($ip == "localhost"){
            $this->ip = "127.0.0.1";
            $this->setIpBinary();
            $this->isPrivate = true;
            return;
        }

        if( self::isValidIp4($ip) || self::isValidIp6($ip) ){
            $this->ip = $ip;
            $this->setIpBinary();
        } else {
            throw new NoValidIp("Invalid IP");
        }

    }

    private function setIpBinary(){
        if( self::isValidIp4($this->ip) ){
            foreach( explode(".",$this->ip) as $ip ){
                array_push($this->ipbinary,$this->addLeadingZeros($ip));
            }
            $this->setPrivate();
        }else{
            $this->isIp4 = false;
            $this->isPrivate = $this->ip == "::1";
            foreach( explode(":",$this->ip) as $ip ){
               if( $ip == "" ){
                   array_push($this->ipbinary,"0000000000000000");
                   array_push($this->ipbinary,"0000000000000000");
               }else{
                   array_push($this->ipbinary,$this->addLeadingZeros($ip));
               }
            }
            if( count($this->ipbinary) != 8 ){
                $last = $this->ipbinary[count($this->ipbinary)-1];
                for($i = count($this->ipbinary) - 2; $i < 8; $i++){
                    $this->ipbinary[$i] = "0000000000000000";
                }
                $this->ipbinary[7] = $last;
            }
        }
    }

    public function __toString(){
        return implode("",$this->ipbinary);
    }

    public function getString(){
        return implode("",$this->ipbinary);
    }

    public function isInNetwork( $cidr ){

        if(!(preg_match("/[0-9\.]+\/[0-9]{1,2}/",$cidr) || preg_match("/[0-9A-F\:]+\/[0-9]{1,2}/",$cidr))){
            throw new NoValidIp("Invalid CIDR.");
        }
        $address = explode("/",$cidr);
        if(
            count($address) != 2 ||
            !((self::isValidIp4($address[0]) && (int)$address[1] < 33) ||
            (self::isValidIp6($address[0]) && (int)$address[1] < 129))
        ){
            throw new NoValidIp("Invalid CIDR.");
        }
        $network = new Ip($address[0]);

        if( $this->isIp4 != $network->isIp4 ){
            throw new NoValidIp("Incompatible IP addresses.");
        }
        return substr($network->getString(),0,(int)$address[1]) == substr($this->getString(),0,(int)$address[1]);
    }

    private function setPrivate(){
        $this->isPrivate =
            substr($this->getString(),0,12) == "101011000001" ||
            substr($this->getString(),0,8)  == "00001010"     ||
            substr($this->getString(),0,16) == "1100000010101000";
    }

    public function getClass(){

        if( !$this->isIp4 )
            return null;
        $binary = $this->getString();

        if( $binary[0] == "0" )
            return "A";
        elseif( substr($binary,0,2) == "10" )
            return "B";
        elseif( substr($binary,0,3) == "110" )
            return "C";


    }

    public function isPrivate(){
        return $this->isPrivate;
    }

    private function addLeadingZeros( $binary ){
        return ($this->isIp4) ? sprintf('%1$08b',$binary) : sprintf('%1$016b',hexdec($binary));
    }

    public static function isValidIp4($ip){
       return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public static function isValidIp6($ip){
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    public function getIp(){
        return $this->ip;
    }

} 