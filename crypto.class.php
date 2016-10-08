<?php

  /**
  * @author rob watts [rob.watts@live.ca] \Crypto\OpenSSL
  * @license none
  * @version 0.0.1
  * @example sudo apt-get install php5-mcrypt && php5enmod mcrypt && service apache2 restart
  * @example see below:
  *
  *  $string = "The quick brown fox jumps over the lazy dog.";
  *  $method = "aes-256-cbc";
  *
  *  $crypto = new \Crypto\OpenSSL(); //get object
  *
  *  $encrypted =  $crypto->encrypt($string, false, false); //encrypt $string
  *  $decrypted =  $crypto->decrypt($encrypted, $crypto->iv, false, false); //decrypt $encrypted into $decrypted
  *
  *  //release
  *  unset($ctypto);
  *
  *  print $encrypted . "<br>";
  *  print $decrypted . "<br>";
  */

  namespace Crypto;

  class OpenSSL {

    //the encryption algorythm to use
    //more options are here: http://php.net/manual/en/function.openssl-get-cipher-methods.php
    private $method = "AES-256-CBC";
    //key used to encrypt text (change this to something else for a default)
    private $cryptoKey = "5aba60a9-c590-48a7-842b-723d56e85f9c";
    //initialization vector
    public $iv;

    public function __construct($method = "", $cryptoKey = ""){
      if( strlen($method) > 0 ) { $this->method = $method; }
      if( strlen($cryptoKey) > 0 ) { $this->cryptoKey = $cryptoKey; }
    }

    public function encrypt($string, $withPersistence = false, $returnBase64 = false) {
      $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
      $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
      $this->iv = $iv;
      $encrypted = openssl_encrypt($string, $this->method, $this->cryptoKey, 0, $iv);
      if ($withPersistence) {
        if ($returnBase64) {
          return base64_encode($iv . $encrypted);
        } else {
          return $iv . $encrypted;
        }
      } else {
        return $encrypted;
      }
    }

    public function decrypt($string, $iv = "", $withPersistence = false, $fromBase64 = false) {
      if ($fromBase64) {
        $string = base64_decode($string);
      }
      switch ($withPersistence) {
        case true:
          $this->iv = substr($string,0,16);
          $cypherText = substr($string,16);
          $decrypted = openssl_decrypt($cypherText, $this->method, $this->cryptoKey, 0, $this->iv);
          return $decrypted;
          break;
        case false:
          $this->iv = $iv;
          $decrypted = openssl_decrypt($string, $this->method, $this->cryptoKey, 0, $iv);
          return $decrypted;
          break;
      }
    }

  }
?>
