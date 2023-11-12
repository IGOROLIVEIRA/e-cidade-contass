<?php
namespace App\Domain\Patrimonial\Ouvidoria\Repository\Atendimento\Contracts;

use ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Filter\ListagemProcessos as FiltroListagemProcessos;

/**
* Interface da classe AtendimentoRepository
*
* @var string
*/
interface AtendimentoRepository
{
    /**
     * Fun��o que busca os processos da ouvidoria que n�o tem um atendimento vinculado
     *
     * @param FiltroListagemProcessos $filtroProcesso
     * @return EloquentCollection|Paginator
     */
    public function buscarProcessosOuvidoria(FiltroListagemProcessos $filtroProcesso);

    /**
     * Fun��o que busca os dados de uma solicita��o da ouvidoria
     *
     * @param FiltroListagemProcessos $filtroProcesso
     * @return EloquentCollection|Paginator
     */
    public function buscarSolicitacaoOuvidoria(FiltroListagemProcessos $filtroProcesso);
}
