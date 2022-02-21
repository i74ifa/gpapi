<?php

namespace I74ifa\Gpapi;

use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Str;
class RelatedModel
{
    /**
     * @throws \ReflectionException
     */
    private function reflectClass($type): \ReflectionClass
    {
        return new \ReflectionClass($type);
    }

        public function MorphClassSort($type)
    {
        return $this->reflectClass($type)->getShortName();
    }

    public function getResource($type): \Illuminate\Http\JsonResponse | string
    {
        return $this->resourceClass($type);
    }

    private function resourceClass($class)
    {
        $class = $this->singularTitle($class);
        if (class_exists($class = 'App\\Http\\Resources\\' . $class . 'Resource')) {
            return $class;
        }
        throw new Exception("[$class]he does not have Resource");

    }

    public function getModel($table)
    {
        $modelName = 'App\\Models\\' . $this->singularTitle($table);
        if (class_exists($modelName)) {
            return $modelName;
        }
        throw new Exception("[$modelName] not exist");

    }

    private function singularTitle($field)
    {
        return Str::singular(Str::title($field));
    }
}