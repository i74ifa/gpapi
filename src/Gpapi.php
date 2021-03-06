<?php

namespace I74ifa\Gpapi;

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
            if ($this->$relation) {
                if ($this->relationHasOne($this->$relation)) {
                    $returnRelations[$relation] = $this->getResource($relation)::make($this->$relation);
                }else {
                    $returnRelations[$relation] = $this->getResource($relation)::collection($this->$relation);
                }
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
                'relation' => $relation
            ];
        }
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
