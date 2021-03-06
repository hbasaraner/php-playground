<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb5c0eed75c18a1eaef824ebfea07b2ba
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitb5c0eed75c18a1eaef824ebfea07b2ba::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitb5c0eed75c18a1eaef824ebfea07b2ba::$classMap;

        }, null, ClassLoader::class);
    }
}
