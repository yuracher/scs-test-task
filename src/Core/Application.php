<?php

namespace App\Core;

use App\Controllers\ApiController;
use Exception;

class Application
{
    protected array $config;
    protected Container $container;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->container = new Container($config);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $controller = $this->container->get(ApiController::class);
        $controller->handleRequest();
    }
}
