<?php

namespace SpeackWithUs\Modules\Category\Controllers\Contracts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface IHandle
{
    public function handle(ServerRequestInterface $req, ResponseInterface $res, $args);
}
