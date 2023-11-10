<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Request;

Route::get('atendimento-ajustar-json', function (Request $request) {
    return view("patrimonial.protocolo.atendimento-ajustar-json");
});
