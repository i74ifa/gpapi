<?php

namespace I74ifa\Gpapi;

use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Str;
trait RelatedModel
{

    protected $modelContainer = '\\App\\Models\\';

    protected $resourceContainer =  '\\App\\Http\\Resources\\';

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
        if (class_exists($class = $this->resourceContainer . $class . 'Resource')) {
            return $class;
        }
        throw new Exception("[$class] not exist please make it first");

    }

    public function getModel($table)
    {
        $modelName = $this->modelContainer . $this->singularTitle($table);
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
