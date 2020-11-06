<?php
require('vendor/autoload.php');

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use React\Http\Server;
use React\MySQL\Factory;

$loop = \React\EventLoop\Factory::create();

$posts = [];

$server = new \React\Http\Server(function (ServerRequestInterface $request) use (&$posts) {
    $path = $request->getUri()->getPath();
    if ($path == '/store') {
        $posts[] = json_decode((string)$request->getBody(), true);
        return new Response(201);
    }
    return new Response(200, ['Content-Type' => 'application/json'], json_encode($posts));
});
$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);

$server->listen($socket);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;
$loop->run();
?>