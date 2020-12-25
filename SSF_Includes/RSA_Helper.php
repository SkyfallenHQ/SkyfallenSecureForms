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

    // Files doesn't exist, so create a new keypair.
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    $res = openssl_pkey_new($config);

    // Extract the private key from $res to $privKey
    openssl_pkey_export($res, $privKey);

    // Extract the public key from $res to $pubKey
    $pubKey = openssl_pkey_get_details($res);
    $pubKey = $pubKey["key"];



    // Open the key file
    $keyFile = fopen(SSF_ABSPATH."/DataSecurity/RSA_KEYS/".USERNAME."-key.php","w+");

    // Create a valid PHP Syntax
    $phpKeyFileText = "<?php define('".USERNAME."-PRIVATEKEY','".$privKey."'); \n define('".USERNAME."-PUBLICKEY','".$pubKey."');";

    // Write the key to the file
    fwrite($keyFile,$phpKeyFileText);
}