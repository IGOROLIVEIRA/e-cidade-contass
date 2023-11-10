<?php
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Request;

Route::get('relatorios/alunos/historico-escolar', function (Request $request) {
    return view("educacao.escola.relatorios.alunos.historico-escolar");
});
