<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                    Skyfallen Secure Forms Developed by                          */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         File Since: SFR-301110                                  */
/*      This file creates a RSA Key for the current user if there is none.         */
/***********************************************************************************/

// Check if called from main process
defined("SSF_ABSPATH") or die("Hmmmm...");

// Check if key file exists for the current user
if(ISLOGGEDIN && !file_exists(SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php")){

    // Create a new keypair
    $keyPair = \ParagonIE\EasyRSA\KeyPair::generateKeyPair(4096);

    $privKey = $keyPair->getPrivateKey()->getKey();
    $pubKey = $keyPair->getPublicKey()->getKey();

    // Open the key file
    $keyFile = fopen(SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php","w+");

    // Create a valid PHP Syntax
    $phpKeyFileText = "<?php define('".USERNAME."-PRIVATEKEY','".$privKey."'); \n define('".USERNAME."-PUBLICKEY','".$pubKey."');";

    // Write the key to the file
    fwrite($keyFile,$phpKeyFileText);
}