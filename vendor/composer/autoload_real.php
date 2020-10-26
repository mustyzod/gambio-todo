<?php

// autoload_real.php @generated by Composer

<<<<<<< HEAD
class ComposerAutoloaderInit6a881f86c994d6634f23d648ccb4c9a0
=======
class ComposerAutoloaderInita4594c86ff453b93fb18314eadcac5d1
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

<<<<<<< HEAD
        spl_autoload_register(array('ComposerAutoloaderInit6a881f86c994d6634f23d648ccb4c9a0', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit6a881f86c994d6634f23d648ccb4c9a0', 'loadClassLoader'));
=======
        spl_autoload_register(array('ComposerAutoloaderInita4594c86ff453b93fb18314eadcac5d1', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInita4594c86ff453b93fb18314eadcac5d1', 'loadClassLoader'));
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c

        $useStaticLoader = PHP_VERSION_ID >= 50600 && !defined('HHVM_VERSION') && (!function_exists('zend_loader_file_encoded') || !zend_loader_file_encoded());
        if ($useStaticLoader) {
            require_once __DIR__ . '/autoload_static.php';

<<<<<<< HEAD
            call_user_func(\Composer\Autoload\ComposerStaticInit6a881f86c994d6634f23d648ccb4c9a0::getInitializer($loader));
=======
            call_user_func(\Composer\Autoload\ComposerStaticInita4594c86ff453b93fb18314eadcac5d1::getInitializer($loader));
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c
        } else {
            $map = require __DIR__ . '/autoload_namespaces.php';
            foreach ($map as $namespace => $path) {
                $loader->set($namespace, $path);
            }

            $map = require __DIR__ . '/autoload_psr4.php';
            foreach ($map as $namespace => $path) {
                $loader->setPsr4($namespace, $path);
            }

            $classMap = require __DIR__ . '/autoload_classmap.php';
            if ($classMap) {
                $loader->addClassMap($classMap);
            }
        }

        $loader->register(true);

        if ($useStaticLoader) {
<<<<<<< HEAD
            $includeFiles = Composer\Autoload\ComposerStaticInit6a881f86c994d6634f23d648ccb4c9a0::$files;
=======
            $includeFiles = Composer\Autoload\ComposerStaticInita4594c86ff453b93fb18314eadcac5d1::$files;
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c
        } else {
            $includeFiles = require __DIR__ . '/autoload_files.php';
        }
        foreach ($includeFiles as $fileIdentifier => $file) {
<<<<<<< HEAD
            composerRequire6a881f86c994d6634f23d648ccb4c9a0($fileIdentifier, $file);
=======
            composerRequirea4594c86ff453b93fb18314eadcac5d1($fileIdentifier, $file);
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c
        }

        return $loader;
    }
}

<<<<<<< HEAD
function composerRequire6a881f86c994d6634f23d648ccb4c9a0($fileIdentifier, $file)
=======
function composerRequirea4594c86ff453b93fb18314eadcac5d1($fileIdentifier, $file)
>>>>>>> b3e501ed918f878fff17dddd4c1f383ed1d1d73c
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        require $file;

        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
    }
}
