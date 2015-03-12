<?php

namespace Discord\Reflector\Annotations;

class KeyValueParser implements Parser
{

    /**
     * Extract array of values :
     * - @key
     * - @key value
     * - @key [value, value, value]
     * - @key {prop: value, prop: value}
     *
     * @param string $string
     *
     * @return array
     */
    public function parse($string)
    {
        // parse @key value
        preg_match_all('#@([a-zA-Z]+)(.*)(\*/|\n)#', $string, $out, PREG_SET_ORDER);

        // compile data
        $annotations = [];
        foreach($out as $row) {
            $key = trim($row[1]);
            $annotations[$key] = $this->resolveValue($row[2]);
        }

        return $annotations;
    }


    /**
     * Resolve value type
     *
     * @param string$value
     *
     * @return array|string
     */
    protected function resolveValue($value)
    {
        // clear
        $value = trim($value);

        // @key
        if(is_null($value) or $value == '') {
            return null;
        }
        // @key 10
        if(is_numeric($value)) {
            return $value + 0; // keeps type (int, float...)
        }
        // @key true
        elseif($value == 'true') {
            return true;
        }
        // @key false
        elseif($value == 'false') {
            return false;
        }
        // @key [value, value, value]
        elseif(preg_match('#^\[(.+)\]$#', $value, $out)) {
            $values = explode(',', $out[1]);
            $array = [];
            foreach($values as $item) {
                $array[] = $this->resolveValue($item);
            }
            return $array;
        }
        // @key {key: value, key: value}
        elseif(preg_match('#^\{(.+)\}$#', $value, $out)) {
            $props = explode(',', $out[1]);
            $object = [];
            foreach($props as $prop) {
                list($name, $item) = explode(':', $prop);
                $object[trim($name)] = $this->resolveValue($item);
            }
            return (object)$object;
        }

        // @key 'value'
        return trim($value, '\'""');
    }

}