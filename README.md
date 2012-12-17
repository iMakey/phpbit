phpbit
======

 **phpbit will be a light PHP Bitcoin wallet using the Stratum protocol**
 
Structure
---------
 
 phpbit will be build using a number of classes, that can be used seperately or
 combined to a Bitcoin wallet.

 * **phpbit**
   * **phpbit\Bitcoin** :
     Basic Bitcoin functions like creating private keys, addresses and encoding.
   * **phpbit\Wallet** :
     Allows storing of private keys, and retrieving balance.
     * **phpbit\Wallet\Transaction**
       Allows crating and sending transactions.
   * **phpbit\Stratum**
     * **phpbit\Stratum\Client**
       A Stratum client.
   
Features
--------
* Installable using Composer.
* Follow PSR standards that applies.
* Encrypted SQLite database backend.

Requirements/links
------------------
* https://github.com/scintill/danter-php-ecc
* https://gist.github.com/3549107
* http://bitfreak.info/?page=tools&t=bitsci (validate key generation method)
* https://github.com/mikegogulski/bitcoin-php

License
-------
phpbit will hopefully be released under the MIT license.

