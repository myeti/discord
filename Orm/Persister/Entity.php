<?php

namespace Discord\Orm\Persister;

use Discord\Reflector\Annotations;

class Entity
{

    /** @var string */
    public $name;

    /** @var Entity\Field[] */
    public $fields = [];

    /** @var string */
    public $class;

    /** @var string */
    public $id = 'id';


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
        foreach($fields as $field => $config) {

            // direct type
            if(!is_array($config)) {
                $config = ['type' => $config];
            }

            // add field
            $this->fields[$field] = Entity\Field::from($config);
            if($this->fields[$field]->primary) {
                $this->id = $field;
            }
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
        $name = Annotations::ofClass($class, 'entity');
        if(!$name) {
            $namespace = explode('\\', $class);
            $name = strtolower(end($namespace));
        }

        // scan properties
        $fields = [];
        foreach(get_class_vars($class) as $property => $default) {
            $meta = Annotations::ofProperty($class, $property);
            if(array_key_exists('id', $meta)) {
                $meta['primary'] = true;
                unset($meta['id']);
            }
            if(array_key_exists('var', $meta)) {
                $meta['type'] = $meta['var'];
                unset($meta['var']);
            }
            if($default != null and is_scalar($default)) {
                $meta['default'] = $default;
            }
            $meta['name'] = $property;
            $fields[$property] = $meta;
        }

        return new static($name, $fields, $class);
    }

} 