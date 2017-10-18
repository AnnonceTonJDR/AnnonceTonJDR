<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class App {

    public function run(ServerRequestInterface $request): ResponseInterface {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', substr($uri, 0, -1));
        }

        $response = new Response();
        $response->getBody()->write('Bonjour');
        return $response;
    }
}