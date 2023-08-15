<?php

namespace App\Http\Controllers;

use ECidade\Api\V1\Controllers\GenericController;
use ECidade\V3\Extension\Registry;
use ECidade\V3\Extension\Session;
use Symfony\Component\HttpFoundation\Request;

class Controller extends GenericController
{
    protected Session $session;

    public function __construct(Request $request)
    {
        $this->session = Registry::get('app.request')->session();
        parent::__construct($request);
    }
}