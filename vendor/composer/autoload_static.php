<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0a663cecfdd54df23aa311999812d701
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MintyMedia\\Cancellation\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MintyMedia\\Cancellation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0a663cecfdd54df23aa311999812d701::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0a663cecfdd54df23aa311999812d701::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0a663cecfdd54df23aa311999812d701::$classMap;

        }, null, ClassLoader::class);
    }
}
