# Crypto
An easy to use encryption class for >PHP5 using OpenSSL

# Requirements
Not tested on windows OS

* Apache 2
* PHP 5 or greater
* Open SSL 

## Quick Usage Example

```php
$string = "The quick brown fox jumps over the lazy dog.";
$method = "aes-256-cbc";

//get object
$crypto = new \Crypto\OpenSSL(); 

//encrypt $string
$encrypted =  $crypto->encrypt($string, false, false);

//decrypt $encrypted into $decrypted
$decrypted =  $crypto->decrypt($encrypted, $crypto->iv, false, false); 

//release
unset($crypto);

print $encrypted . "<br>";
print $decrypted . "<br>";
```

## Installation 

* Copy the class file to your web root & reference it in your code with require_once or require etc.
* Follow the quick example above.
* If you get errors about mcrypt() or any fatal errors you probably need to install it. If you are using shared hosting, mcrypt is probably installed, use phpinfo() or CPANEL to determine and contact your host as needed.

```bash
#> sudo apt-get install php5-mcrypt 
#> sudo php5enmod mcrypt
#> sudo service apache2 restart
```

### Features

* Easy encryption and decryption of text using OpenSSL and one of many supported encryption algorythms. This is not a home-rolled encryption system, mearly a wrapper class for well accepted and documented methods.
* Supports optional persitable output and optional base64 encoding support for storing output in databases

### Methods

You always start with the object:

```php 
$crypto = new \Crypto\OpenSSL();
```

You can specify one of the supported encryption mechanisms in the contructor and also optionally specify a different encryption key.  The class has these values hard coded, which you can change. You should change the encryption key for sure. The encryption mechanism is up to you and you can look up all the options here:

http://php.net/manual/en/function.openssl-get-cipher-methods.php

####Basic Encryption example: 

```php
$crypto->encrypt($string, $withoutPersistance, $withOutBase64);
```
This will encrypt ```$string``` using the ```$method``` you selected with the ```$cryptoKey``` you provided.

The initialization vector will be stored in ```$crypto->iv``` which is required to decrypt your text.

This basic method is used if you want to keep the initialization vector separate from the output and handle all persistance matters yourself.

A more common use case is to allow Cryto to do it for you like this:

####Common Encryption Example

```php
$crypto->encrypt($string, $withPersistance, $withOutBase64);
```

The output of this method call will include the initialization vector concatenated onto the cyphertext. This is suitable for storing the encrypted result (persitance) somewhere else, like a database.

It's sometimes preferable to store encrypted text as base64 encoded text in databases.  For this you can just do:

####Encrypting text for storage in a database

```php
$crypto->encrypt($string, $withPersistance, $withBase64);
```

You'll get back a base64 encoded string representation of your encrypted text (with or without the initialization vector included in your cypher text, as you choose).

Please note you do not have to use ```$withBase64``` for storage in databases. This is often prefered and it's up to you do decide.

####Decryption 

Decryption works very easily when you use the ```$withPersitance``` option.

Notice that when you use persistance, you do not need to pass the initialization vector. 

When you *do not* use persistance, you *must* pass the iv value produced when you encrypted your text. *It must be the same value produced by the encrypt call*. Each encrypt call generates a different iv value which is accessible by calling ```$crypto->iv```. Your cyphertext is effectively unrecoverable without the matching iv value.

```php
$crypto->decrypt(decrypt($encrypted, "", $withPeristance, $withoutBase64);
```

If you had previously encoded the output with base64, then just ensure you asked for that when you decrypt your text

```php
$crypto->decrypt(decrypt($encrypted, "", $withPeristance, $fromBase64);
```

Finally, if you did not choose the persitance option, you'd have to pass in the initialization vector.

```php
$crypto->decrypt(decrypt($encrypted, $iv, $withOutPeristance, $withoutBase64);
```
