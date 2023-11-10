<?php
Route::prefix('consulta')->group(function () {
    Route::post('acordos', 'AcordosController@buscarAcordos');
});
