<?php

namespace I74ifa\Gpapi\Interfaces;

use Illuminate\Http\Request;

interface interfaceGpapi
{
    /**
     * All relationships, with the exception, Here
     * @param Request $request
     * @return mixed
     */
    public function resolveRelations($request): array;
}
