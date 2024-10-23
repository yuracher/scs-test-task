<?php

namespace App\Core;

use Exception;
use ReflectionClass;

class Container
{

    public function __construct(
        protected array $config)
    {
    }

    public function get(string $class)
    {
        try {

            $reflector = new ReflectionClass($class);

            if (!$reflector->isInstantiable()) {
                foreach ($this->config as $component) {
                    if (in_array($class, class_implements($component['class']))) {
                        $reflector = new ReflectionClass($component['class']);
                        if (!empty($component['params'])) {
                            return $reflector->newInstanceArgs($component['params']);
                        }
                        return new $component['class'];
                    }
                }
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
