<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Tributario\Arrecadacao\PixReturnService;
use Symfony\Component\HttpFoundation\Response;

class PixController extends Controller
{
    public function index(): Response
    {
        $data = json_decode($this->request->getContent());
        $service = new PixReturnService();
        $service->execute($data);
        return new Response('No Content', 204);
    }
}