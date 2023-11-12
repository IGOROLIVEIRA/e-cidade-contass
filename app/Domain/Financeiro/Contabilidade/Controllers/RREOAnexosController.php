<?php


namespace App\Domain\Financeiro\Contabilidade\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Contabilidade\Factories\AnexoQuatroFactory;
use App\Domain\Financeiro\Contabilidade\Factories\AnexoSeisFactory;
use App\Domain\Financeiro\Contabilidade\Factories\AnexoTresFactory;
use App\Domain\Financeiro\Contabilidade\Factories\AnexoUmFactory;
use App\Domain\Financeiro\Contabilidade\Requests\LRF\RREO\AnexosRREORequest;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoOitoService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresInRsService;
use App\Http\Controllers\Controller;

class RREOAnexosController extends Controller
{
    public function anexoUm(AnexosRREORequest $request)
    {
        $relatorio = AnexoUmFactory::getService($request->get('DB_anousu'), $request->all());
        $files = $relatorio->emitir();
        return new DBJsonResponse($files, 'Anexo I - Balan�o Or�ament�rio');
    }

    public function anexoTresInRs(AnexosRREORequest $request)
    {
        $relatorio = new AnexoTresInRsService($request->all());
        $files = $relatorio->emitir();
        return new DBJsonResponse($files, 'Anexo III - Receita Corrente L�quida IN RS');
    }

    public function anexoTresMdf(AnexosRREORequest $request)
    {
        $relatorio = AnexoTresFactory::getServiceMdf($request->get('DB_anousu'), $request->all());
        $files = $relatorio->emitir();
        return new DBJsonResponse($files, 'Anexo III - Receita Corrente L�quida MDF');
    }

    public function anexoQuatro(AnexosRREORequest $request)
    {
        $relatorio = AnexoQuatroFactory::getService($request->get('DB_anousu'), $request->all());
        $files = $relatorio->emitir();
        return new DBJsonResponse($files, 'Anexo IV - Demonstrativo das Receitas e Despesas do RPPS');
    }

    public function anexoSeis(AnexosRREORequest $request)
    {
        $relatorio = AnexoSeisFactory::getService($request->get('DB_anousu'), $request->all());
        $files = $relatorio->emitir();
        return new DBJsonResponse($files, 'Anexo VI - Demonstrativo dos Resultados Prim�rio e Nominal');
    }

    public function anexoOito(AnexosRREORequest $request)
    {
        $service = new AnexoOitoService($request->all());
        $files = $service->emitir();

        $msg = 'Anexo VIII - Demonstrativo das Receitas e Despesas com Manuten��o e Desenvolvimento do Ensino - MDE';
        return new DBJsonResponse($files, $msg);
    }
}
