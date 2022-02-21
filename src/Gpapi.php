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
        foreach ($this->spiltRelations($relations) as $relation) {
            $this->resolveRelationParams($relation);
        }

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
                'params' => $match[2]
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