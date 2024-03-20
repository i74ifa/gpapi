<?php

namespace I74ifa\Gpapi;

use Exception;
use Illuminate\Support\Collection;

trait Gpapi
{

    use RelatedModel;

    private $relations;

    private $relationParams;

    public function spiltRelations($data)
    {
        //        return preg_split($data, "/\[[^[]+\](*SKIP)(*FAIL)|,\s*/");
        return preg_split("/\[[^[]+\](*SKIP)(*FAIL)|,\s*/", $data);
    }

    public function getRelations()
    {
        return $this->relations;
    }

    public function withRelations($relations)
    {
        $returnRelations = [];
        foreach ($this->spiltRelations($relations) as $relation) {
            $this->resolveRelationParams($relation);
        }

        foreach ($this->getRelations() as ['relation' => $relation, 'params' => $params]) {
            $relationData = $this->$relation();

            if ($params) {
                $relationData = $relationData->select($params)->getResults();
            }

            $resourceClass = $this->getResource($relation);
            if ($relationData instanceof Collection) {
                $returnRelations[$relation] = $resourceClass::collection($relationData);
            }else {
                $returnRelations[$relation] = $resourceClass::make($relationData);
            }
        }

        return $returnRelations;
    }


    private function relationHasOne($relation): bool
    {
        if (isset($relation->id)) {
            return true;
        }

        return false;
    }

    public function paramShow($params)
    {
        dd($this->resolveRelationParams($params));
    }

    protected function resolveRelationParams($relation)
    {
        if (preg_match('/(.*)\[([^[]+)\]/', $relation, $match)) {
            $this->relations[] = [
                'relation' => $match[1],
                'params' => preg_split('/\,\s?/', $match[2])
            ];
        } else {
            $this->relations[] = [
                'relation' => $relation,
                'params' => [],
            ];
        }
    }

    public function getParams($params)
    {
        $data = [];
        if (preg_match('/(.*)\[([^[]+)\]/', $params, $match)) {
            foreach (preg_split('/\,\s?/', $match[2]) as $column) {
                $data[$column] = $this->$column;
            }
            return $data;
        }

        return [];
    }

    public function simpleRelations($param)
    {
        $relations = [];
        $params = explode(',', $param);
        foreach ($params as $relate) {
            if ($this->$relate) {
                $relations[$relate] = $this->getResource($relate)::make($this->$relate);
            } else {
            }
        }
        return $relations;
    }
}
