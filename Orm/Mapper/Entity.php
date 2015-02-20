<?php

namespace Discord\Orm\Mapper;

use Discord\Reflector\Annotations;

class Entity
{

    /** @var string */
    public $name;

    /** @var Entity\Field[] */
    public $fields = [];

    /** @var string */
    public $class;


    /**
     * New entity
     *
     * @param string $name
     * @param array $fields
     * @param string $class
     */
    public function __construct($name, array $fields, $class = null)
    {
        $this->name = $name;
        $this->class = $class;

        // parse fields
        foreach($this->fields as $field => $config) {

            // direct type
            if(!is_array($config)) {
                $config = ['type' => $config];
            }

            // add field
            $this->fields[$field] = Entity\Field::from($config);
        }
    }


    /**
     * Create entity from class
     *
     * @param string $class
     *
     * @return static
     */
    public static function of($class)
    {
        // resolve name
        $name = Annotations::ofClass($class, 'name');
        if(!$name) {
            $name = end(explode('\\', $class));
        }

        // scan properties
        $fields = [];
        foreach(get_class_vars($class) as $property => $default) {
            $meta = Annotations::ofProperty($class, $property);
            if(isset($meta['var'])) {
                $meta['type'] = $meta['var'];
                unset($meta['var']);
            }
            if($default != null and is_scalar($default)) {
                $meta['default'] = $default;
            }
            $fields[$property] = $meta;
        }

        return new static($name, $fields, $class);
    }

} 