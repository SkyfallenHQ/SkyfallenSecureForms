<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3e4ab4b0c7f008522a1bcc4cbd242116
{
    public static $files = array (
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        '3a163f06e55e497e0acc65ba132a7a76' => __DIR__ . '/..' . '/sarciszewski/php-future/autoload.php',
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
        'P' => 
        array (
            'ParagonIE\\EasyRSA\\' => 18,
            'ParagonIE\\ConstantTime\\' => 23,
        ),
        'D' => 
        array (
            'Defuse\\Crypto\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'ParagonIE\\EasyRSA\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/easyrsa/src',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
        'Defuse\\Crypto\\' => 
        array (
            0 => __DIR__ . '/..' . '/defuse/php-encryption/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3e4ab4b0c7f008522a1bcc4cbd242116::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3e4ab4b0c7f008522a1bcc4cbd242116::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3e4ab4b0c7f008522a1bcc4cbd242116::$classMap;

        }, null, ClassLoader::class);
    }
}
