<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class Controller
{
    public function __construct(protected ContainerInterface $container)
    {
    }
}
