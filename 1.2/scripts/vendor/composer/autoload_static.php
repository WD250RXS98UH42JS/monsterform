<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit32d01bbed295e5aa8bee984c2c068274
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit32d01bbed295e5aa8bee984c2c068274::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit32d01bbed295e5aa8bee984c2c068274::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
