<?php

namespace Booothy\Core\Infrastructure\Repository\Memory;

class Handler
{
    protected $collections;

    public function __construct()
    {
        $this->collections = [];
    }

    public function clean()
    {
        $this->collections = [];
    }

    public function addResource($type, $id, $resource)
    {
        $this->collections[$type][$id] = $resource;
    }

    public function getFirst($type)
    {
        if (empty($this->collections[$type])) {
            return null;
        }

        return $this->collections[$type][key($this->collections[$type])];
    }

    public function getResource($type, $id, $non_existing_callback)
    {
        if (!array_key_exists($id, $this->collections[$type])) {
            $non_existing_callback();
        }

        return $this->collections[$type][$id];
    }

    public function getCollection($type)
    {
        return array_values($this->collections[$type]);
    }
}