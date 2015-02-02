<?php

namespace Discord\Reflector;

abstract class ClassLoader
{

    /** @var array */
    protected static $vendors = [];

    /** @var array */
    protected static $aliases = [];


    /**
     * Register many vendors
     *
     * @param array $vendors
     */
    public static function vendors(array $vendors = [])
    {
        foreach($vendors as $vendor => $path) {
            static::vendor($vendor, $path);
        }
    }


    /**
     * Register vendor
     *
     * @param string $vendor
     * @param string $path
     */
    public static function vendor($vendor, $path)
    {
        // clean
        $prefix = trim($vendor, '\\');
        $path = str_replace('\\', DIRECTORY_SEPARATOR , $path);
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // register
        static::$vendors[$prefix] = $path;
    }


    /**
     * Get vendor path
     * @param string $vendor
     * @throws \RuntimeException
     * @return string
     */
    public static function path($vendor)
    {
        // clean
        $vendor = trim($vendor, '\\');

        // error
        if(!isset(static::$vendors[$vendor])) {
            throw new \RuntimeException('Vendor "' . $vendor . '" does not exists.');
        }

        return static::$vendors[$vendor];
    }


    /**
     * Register many alias
     *
     * @param array $aliases
     */
    public static function aliases(array $aliases)
    {
        foreach($aliases as $class => $alias) {
            static::alias($class, $alias);
        }
    }


    /**
     * Register alias
     *
     * @param string $class
     * @param string $alias
     */
    public static function alias($class, $alias)
    {
        static::$aliases[$alias] = $class;
    }


    /**
     * Load a class
     * @param string $class
     * @return bool
     */
    public static function load($class)
    {
        // has alias ?
        if(isset(static::$aliases[$class])) {
            $class = static::$aliases[$class];
        }

        // clean
        $class = str_replace('\\', DIRECTORY_SEPARATOR , $class);
        $class .= '.php';

        // in global namespace ?
        if(file_exists($class)) {
            require $class;
            return true;
        }

        // has vendor ?
        foreach(static::$vendors as $vendor => $path) {

            // prefix matching
            $length = strlen($vendor);
            if(substr($class, 0, $length) === $vendor) {

                // make real path
                $filename = $path . substr($class, $length);

                // class exists
                if(file_exists($filename)) {
                    require $filename;
                    return true;
                }
            }

        }

        return false;
    }


    /**
     * Register as runtime loader
     */
    public function register()
    {
        spl_autoload_register('static::load');
    }

}