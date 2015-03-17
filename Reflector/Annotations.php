<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Reflector;

abstract class Annotations
{

    /** @var Annotations\Parser */
    protected static $parser;


    /**
     * Get inner parser
     *
     * @param Annotations\Parser $parser
     *
     * @return Annotations\Parser
     */
    public static function parser(Annotations\Parser $parser = null)
    {
        if($parser) {
            static::$parser = $parser;
        }
        if(!static::$parser) {
            static::$parser = new Annotations\KeyValueParser;
        }

        return static::$parser;
    }


    /**
     * Get annotations of class
     *
     * @param string|object $class
     * @param string $key
     *
     * @return mixed
     */
    public static function ofClass($class, $key = null)
    {
        $reflector = is_object($class)
            ? new \ReflectionObject($class)
            : new \ReflectionClass($class);

        $annotations = static::parser()->parse($reflector->getDocComment());

        if($key) {
            return isset($annotations[$key]) ? $annotations[$key] : null;
        }

        return $annotations;
    }


    /**
     * Get annotations of class property
     *
     * @param string|object $class
     * @param string $property
     * @param string $key
     *
     * @return mixed
     */
    public static function ofProperty($class, $property, $key = null)
    {
        $reflector = new \ReflectionProperty($class, $property);

        $annotations = static::parser()->parse($reflector->getDocComment());

        if($key) {
            return isset($annotations[$key]) ? $annotations[$key] : null;
        }

        return $annotations;
    }


    /**
     * Get annotations of class method
     *
     * @param string|object $class
     * @param string $method
     * @param string $key
     *
     * @return mixed
     */
    public static function ofMethod($class, $method, $key = null)
    {
        $reflector = new \ReflectionMethod($class, $method);

        $annotations = static::parser()->parse($reflector->getDocComment());

        if($key) {
            return isset($annotations[$key]) ? $annotations[$key] : null;
        }

        return $annotations;
    }


    /**
     * Get annotations of function
     *
     * @param string|callable $function
     * @param string $key
     *
     * @return mixed
     */
    public static function ofFunction($function, $key = null)
    {
        $reflector = new \ReflectionFunction($function);

        $annotations = static::parser()->parse($reflector->getDocComment());

        if($key) {
            return isset($annotations[$key]) ? $annotations[$key] : null;
        }

        return $annotations;
    }

} 