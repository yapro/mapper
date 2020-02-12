<?php

use Tarantool\Mapper\Plugin\Annotation;

require dirname(__DIR__).'/vendor/autoload.php';

require 'Post.php';
require 'PostRepository.php';

$client = \Tarantool\Client\Client::fromDsn('tcp://tarantool');
$mapper = new \Tarantool\Mapper\Mapper($client);
$mapper->getPlugin(Tarantool\Mapper\Plugin\Sequence::class); // just not to fill id manually
function AutoMigration(\Tarantool\Mapper\Mapper $mapper)
{
    /** @var Annotation $plugin */
    $plugin = $mapper->getPlugin(Tarantool\Mapper\Plugin\Annotation::class);
    $plugin->setRepositoryPostfix('Repository')
        ->register(Post::class)
        ->register(PostRepository::class)
        ->migrate();
}
AutoMigration($mapper);
$nekufa = $mapper->create('post', ['title' => true]);