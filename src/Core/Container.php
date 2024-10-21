<?php

namespace App\Core;

use Exception;
use ReflectionClass;
use App\Models\DataStorage;

class Container
{

    public function __construct(
        protected array $config)
    {
    }

    public function get(string $class)
    {
        // TODO: refactor this
        if ($class === DataStorage::class) {
            $storageClass = $this->config['storage']['class'];
            $filePath = $this->config['storage']['filePath'];
            return new $storageClass($filePath);
        }

        try {
            $reflector = new ReflectionClass($class);
            if (!$reflector->isInstantiable()) {
                throw new Exception("Class $class cannot be instantiated");
            }

            $constructor = $reflector->getConstructor();
            if (is_null($constructor)) {
                return new $class;
            }

            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                $dependencyClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
                    ? new ReflectionClass($parameter->getType()->getName())
                    : null;

                if ($dependencyClass) {
                    $dependencies[] = $this->get($dependencyClass->getName());
                } else {
                    $dependencies[] = $parameter->getDefaultValue();
                }
            }

            return $reflector->newInstanceArgs($dependencies);
        } catch (Exception $e) {
            throw new Exception("Error while resolving class $class: " . $e->getMessage());
        }
    }
}
