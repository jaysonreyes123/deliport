<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc3bc6478f6db605cabcb633fd40e1519
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc3bc6478f6db605cabcb633fd40e1519::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc3bc6478f6db605cabcb633fd40e1519::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc3bc6478f6db605cabcb633fd40e1519::$classMap;

        }, null, ClassLoader::class);
    }
}
