<?php
Route::prefix('integracao')->group(function () {
    Route::post('habilitar', 'IntegracaoController@habilitar');
    Route::post('verificaIntegracao', 'IntegracaoController@verificaIntegracao');
});

Route::prefix('unidades')->group(function () {
    Route::post('incluir', 'UnidadesController@incluir');
    Route::post('buscarEntidade', 'UnidadesController@buscarEntidade');
    Route::post('buscarUnidades', 'UnidadesController@buscarUnidades');
    Route::post('buscarUnidadesAtivas', 'UnidadesController@buscarUnidadesAtivas');
});

Route::prefix('compraEditalAviso')->group(function () {
    Route::post('buscarAmparosLegais', 'CompraEditalAvisoController@buscarAmparosLegais');
    Route::post('buscarInstrumentoConvocatorio', 'CompraEditalAvisoController@buscarInstrumentoConvocatorio');
    Route::post('buscarModoDisputa', 'CompraEditalAvisoController@buscarModoDisputa');
    Route::post('buscarLicitacao', 'CompraEditalAvisoController@buscarLicitacao');
    Route::post('incluirCompraEditalAviso', 'CompraEditalAvisoController@incluirCompraEditalAviso');
    Route::post('buscarEditais', 'CompraEditalAvisoController@buscarEditais');
    Route::post('incluirRespostaItem', 'CompraEditalAvisoController@incluirRespostaItem');
    Route::post('buscarCompras', 'CompraEditalAvisoController@buscarCompras');
    Route::post('buscarCompra', 'CompraEditalAvisoController@buscarCompra');
    Route::post('excluirCompra', 'CompraEditalAvisoController@excluirCompra');
});

Route::prefix('ataRegistroPreco')->group(function () {
    Route::post('incluir', 'AtaRegistroPrecoController@incluir');
    Route::post('buscar', 'AtaRegistroPrecoController@buscar');
    Route::post('excluir', 'AtaRegistroPrecoController@excluir');
    Route::post('retificar', 'AtaRegistroPrecoController@retificar');
});

Route::prefix('contratos')->group(function () {
    Route::post('incluirContrato', 'ContratosController@incluirContrato');
    Route::post('incluirDocumento', 'ContratosController@incluirDocumento');
    Route::post('buscarContratos', 'ContratosController@buscarContratos');
    Route::post('excluirContrato', 'ContratosController@excluirContrato');
});
