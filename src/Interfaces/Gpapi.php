<?php

namespace I74ifa\Gpapi\Interfaces;

use Illuminate\Http\Request;

interface Gpapi
{
    /**
     * All relationships, with the exception, Here
     * @param Request $request
     * @return mixed
     */
    public function resolveRelations(\Illuminate\Http\Request $request): array;
}