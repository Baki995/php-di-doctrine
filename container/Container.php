<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Container;

use Closure;
use Exception;
use League\Container\Container as LeagueContainer;
use ReflectionClass;

class Container extends LeagueContainer
{
    public function get($id)
    {
        if ($this->definitions->has($id)) {
            return $this->definitions->resolve($id);
        }

        return $this->resolveClass($id);
    }

    public function has($id): bool
    {
        return true;
    }

    private function resolveClass($classId)
    {
        if ($classId instanceof Closure) {
            return $classId($this);
        }

        $reflector = new ReflectionClass($classId);
        // check if class is instantiable
        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$classId} is not instantiable");
        }

        // get class constructor
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            $this->definitions->add($classId, $reflector->newInstanceArgs());
            return $reflector->newInstance();
        }

        // get constructor params
        $parameters   = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        // get new instance with dependencies resolved
        $newInstance = $reflector->newInstanceArgs($dependencies);

        $this->definitions->add($classId, $newInstance)->addArguments($dependencies);
        return $newInstance;
    }

    private function getDependencies($parameters): array
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // get the type hinted class
            $dependency = $parameter->getType();
            if ($dependency === NULL) {
                // check if default value for a parameter is available
                if ($parameter->isDefaultValueAvailable()) {
                    // get default value of parameter
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                // get dependency resolved
                $dependencies[] = $this->get($parameter->getType()->getName());
            }
        }

        return $dependencies;
    }
}