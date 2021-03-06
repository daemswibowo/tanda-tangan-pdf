<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitadee7e8a6542bd185aa1804fc239f603
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'setasign\\Fpdi\\' => 14,
        ),
        'F' => 
        array (
            'Fpdf\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'setasign\\Fpdi\\' => 
        array (
            0 => __DIR__ . '/..' . '/setasign/fpdi/src',
        ),
        'Fpdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf',
        ),
    );

    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitadee7e8a6542bd185aa1804fc239f603::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitadee7e8a6542bd185aa1804fc239f603::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitadee7e8a6542bd185aa1804fc239f603::$classMap;

        }, null, ClassLoader::class);
    }
}
