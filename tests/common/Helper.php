<?php

use Tarantool\Mapper\Client;
use Tarantool\Mapper\Manager;
use Tarantool\Mapper\Migrations\Migrator;
use Tarantool\Connection\SocketConnection;
use Tarantool\Packer\PurePacker;
use Tarantool\Schema\Space;
use Tarantool\Schema\Index;

abstract class Helper
{
    public static function createManager($flush = true)
    {
        // create client
        $port = getenv('TNT_CONN_PORT') ?: 3301;
        $connection = new SocketConnection(getenv('TNT_CONN_HOST'), $port);
        $client = new Client($connection, new PurePacker());

        // flush everything
        if ($flush) {
            $schema = new Space($client, Space::VSPACE);
            $response = $schema->select([], Index::SPACE_NAME);
            $data = $response->getData();
            foreach ($data as $row) {
                if ($row[1] == 0) {
                    // user space
                    $client->evaluate('box.schema.space.drop('.$row[0].')');
                }
            }
        }

        // create fresh manager instance
        $manager = new Manager($client);

        // boostrap
        $migrator = new Migrator();
        $migrator->migrate($manager);

        return $manager;
    }
}
