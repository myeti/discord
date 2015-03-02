<?php

namespace Discord\Orm;

class Manager extends Mapper implements Manageable
{

    /**
     * Read all entities
     *
     * @param string $name
     * @param array $where
     * @param string $sort
     * @param int|array $limit
     *
     * @return object[]
     */
    public function all($name, array $where = [], $sort = null, $limit = null)
    {
        $read = $this->read($name);

        foreach($where as $cond => $value) {
            $read->where($cond, $value);
        }

        if($sort and is_array($sort)) {
            foreach($sort as $field => $sorting) {
                $read->sort($field, $sorting);
            }
        }
        elseif($sort) {
            $read->sort($sort);
        }

        if($limit and is_array($limit)) {
            $read->limit($limit[0], $limit[1]);
        }
        elseif($limit) {
            $read->limit($limit);
        }

        return $read->all();
    }


    /**
     * Read one entity
     *
     * @param string $name
     * @param array $where
     *
     * @return object
     */
    public function one($name, $where = [])
    {
        $read = $this->read($name);

        // id
        if(is_int($where) or is_string($where)) {
            $id = $this->entity($name)->id;
            $where = [$id => $where];
        }

        foreach($where as $cond => $value) {
            $read->where($cond, $value);
        }

        return $read->one();
    }


    /**
     * Create or edit entity
     *
     * @param string $name
     * @param object|array $data
     *
     * @return int|mixed
     */
    public function save($name, $data)
    {
        // force array
        if(is_object($data)) {
            $data = (array)$data;
        }
        elseif(!is_array($data)) {
            throw new \InvalidArgumentException('$data must be an array or object');
        }

        // retrieve id field
        $id = $this->entity($name)->id;

        // edit
        if(!empty($data[$id])) {
            $edit = $this->edit($name);
            $edit->where($id, $data[$id]);
            $edit->with($data);
            return $edit->apply();
        }

        // create
        return static::create($name)->with($data)->apply();
    }


    /**
     * Delete entity
     *
     * @param string $name
     * @param int|array $where
     *
     * @return bool
     */
    public function wipe($name, $where)
    {
        // id
        if(!is_array($where)) {
            $where = ['id' => $where];
        }

        $drop = $this->drop($name);
        foreach($where as $cond => $value) {
            $drop->where($cond, $value);
        }

        return $drop->apply();
    }

} 