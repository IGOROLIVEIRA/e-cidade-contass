<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Tributario\Arrecadacao\PixReturnService;
use Symfony\Component\HttpFoundation\Response;

class PixController extends Controller
{
    public function index(): Response
    {
        $data = current($this->request->get('pix'));
        $service = new PixReturnService(
            (int) $this->session->get('DB_id_usuario'),
            (int) $this->session->get('DB_instit')
        );
        try {
            $service->execute($data);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return new Response('No Content', 204);
    }
}