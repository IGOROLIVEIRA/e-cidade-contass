<?php
Route::middleware(["auth:api"])->group(function () {
    Route::prefix('relatorio')->group(function () {
        Route::post('viagens-por-motorista', 'AgendaSaidaController@relatorioViagensPorMotorista');
    });
});
