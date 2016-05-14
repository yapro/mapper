<?php

namespace Tarantool\Mapper\Contracts;

use Tarantool\Client;

interface Manager
{
    /**
     * @return Repository|Entity
     */
    public function get($type, $id = null);

    /**
     * @return Entity
     */
    public function save(Entity $entity);

    /**
     * @return Entity
     */
    public function remove(Entity $entity);

    /**
     * @return Entity
     */
    public function create($type, $data = null);

    public function findRepository(Entity $entity);

    public function forgetRepository($type);

    /**
     * @return Client
     */
    public function getClient();

    /**
     * @return Schema
     */
    public function getSchema();

    /**
     * @return Meta
     */
    public function getMeta();
}
