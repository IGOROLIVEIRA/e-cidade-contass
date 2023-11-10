<?php
// php5.6 artisan route:list --path=web/financeiro/contabilidade
Route::prefix('conta-corrente')->group(function () {
    Route::prefix('implantacao')->group(function () {
        Route::get('ddr', function () {
            return view('financeiro.contabilidade.conta-corrente.implantacao-ddr');
        });
    });
});
