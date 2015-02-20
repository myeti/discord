<?php

namespace Discord\Orm\Mapper\Entity;

class Field
{

    /** @var string */
    public $name;

    /** @var string */
    public $type = 'string';

    /** @var bool */
    public $primary = false;

    /** @var bool */
    public $null = true;

    /** @var mixed */
    public $default;

    /** @var string */
    public $many;

    /** @var string */
    public $one;


    /**
     * New entity field
     *
     * @param string $name
     * @param string $type
     * @param bool $primary
     * @param bool $null
     * @param mixed $default
     */
    public function __construct($name, $type = 'string', $primary = false, $null = true, $default = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->primary = $primary;
        $this->$null = $null;
        $this->default = $default;
    }


    /**
     * Parse field from raw array
     *
     * @param array $config
     *
     * @return static
     */
    public static function from(array $config)
    {
        // get default array
        $default = get_class_vars(static::class);

        // keep only useful values
        $config = array_intersect_key($config, $default);
        $config = array_merge($default, $config);

        // build field
        $entity = new static($config['name'], $config['type'], $config['primary'], $config['null'], $config['default']);
        $entity->one = $config['one'];
        $entity->many = $config['many'];

        return $entity;
    }

} 