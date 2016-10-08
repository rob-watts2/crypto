# crypto
An easy to use encryption class for >PHP5 using OpenSSL

# requirements
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

## Documentation 

* Copy the class file to your web root & reference it in your code with require_once or require etc.
* Follow the quick example above.
* If you get errors about mcrypt() or any fatal errors you probably need to install it. If you are using shared hosting, mrypt is probably installed, use phpinfo() or CPANEL to determine and contact your host as needed.

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









