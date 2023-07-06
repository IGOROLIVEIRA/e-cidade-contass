<?php

namespace App\Http\Controllers;

use ECidade\Api\V1\Controllers\GenericController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends GenericController
{
    public function responseApi($data)
    {
        return new JsonResponse($data);
    }
}