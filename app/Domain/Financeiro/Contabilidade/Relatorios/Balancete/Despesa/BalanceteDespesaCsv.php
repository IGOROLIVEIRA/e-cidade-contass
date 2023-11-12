<?php


namespace App\Domain\Financeiro\Contabilidade\Relatorios\Balancete\Despesa;

use ECidade\File\Csv\Dumper\Dumper;

/**
 * Class BalanceteDespesaCsv
 * @package App\Domain\Financeiro\Contabilidade\Relatorios\Balancete\Despesa
 */
class BalanceteDespesaCsv extends Dumper
{
    private $dados = [];

    public function setDados(array $dados)
    {
        $this->dados = $dados;
    }

    public function emitir()
    {
        $filename = sprintf('tmp/balancete-despesa-%s.csv', time());
        $this->dumpToFile($this->organizarDados(), $filename);
        return [
            'csv' => $filename,
            'csvLinkExterno' => ECIDADE_REQUEST_PATH . $filename
        ];
    }

    private function organizarDados()
    {
        $dadosImprimir = [$this->cabecalho()];

        foreach ($this->dados as $dado) {
            foreach ($dado->recursos as $codigoRecurso => $recurso) {
                if ($dado->recurso === $codigoRecurso) {
                    $dadosImprimir[] = $this->criaLinhaPrincipal($dado, $recurso);
                } else {
                    $dadosImprimir[] = $this->criaLinhaSecundaria($dado, $recurso);
                }
            }
        }

        return $dadosImprimir;
    }

    private function cabecalho()
    {
        return [
            'Dota��o',
            '�rg�o',
            'Descri��o �rg�o',
            'Unidade',
            'Descri��o Unidade',
            'Fun��o',
            'Descri��o Fun��o',
            'Subfun��o',
            'Descri��o Subfun��o',
            'Programa',
            'Descri��o Programa',
            'Projeto/Atividade',
            'Descri��o Projeto/Atividade',
            'Elemento',
            'Descri��o Elemento',
            'Recurso',
            'Descri��o Recurso',
            'Complemento',
            'Descri��o Complemento',
            'Institui��o',

            'Empenhado M�s',
            'Anulado M�s',
            'Empenho L�quido M�s',
            'Liquidado M�s',
            'Pago M�s',

            'Empenhado Ano',
            'Anulado Ano',
            'Empenho L�quido Ano',
            'Liquidado Ano',
            'Pago Ano',

            'Saldo Inicial',
            'Suplementa��o',
            'Cr�dito Especiais',
            'Redu��es',
            'Total Cr�ditos',
            'Saldo Dispon�vel',
            '� Liquidar',
            '� Pagar Liquidado',
        ];
    }

    private function criaLinhaPrincipal($dado, $recurso)
    {
        $totalCreditos = $dado->saldo_inicial + $dado->suplementado + $dado->suplementado_especial - $dado->reducoes;
        return [
            $dado->reduzido,
            $dado->orgao,
            $dado->descricao_orgao,
            $dado->unidade,
            $dado->descricao_unidade,
            $dado->funcao,
            $dado->descricao_funcao,
            $dado->subfuncao,
            $dado->descricao_subfuncao,
            $dado->programa,
            $dado->descricao_programa,
            $dado->projeto,
            $dado->descricao_projeto,
            $dado->elemento,
            $dado->descricao_elemento,
            $recurso->recurso,
            $recurso->descricao_recurso,
            $recurso->complemento,
            $recurso->descricao_complemento,
            $dado->nome_instituicao,

            db_formatar($recurso->valores->empenhado, 'f'),
            db_formatar($recurso->valores->anulado, 'f'),
            db_formatar($recurso->valores->empenhado_liquido, 'f'),
            db_formatar($recurso->valores->liquidado, 'f'),
            db_formatar($recurso->valores->pago, 'f'),

            db_formatar($recurso->valores->empenhado_acumulado, 'f'),
            db_formatar($recurso->valores->anulado_acumulado, 'f'),
            db_formatar($recurso->valores->empenhado_liquido_acumulado, 'f'),
            db_formatar($recurso->valores->liquidado_acumulado, 'f'),
            db_formatar($recurso->valores->pago_acumulado, 'f'),

            db_formatar($dado->saldo_inicial, 'f'),
            db_formatar($dado->suplementado, 'f'),
            db_formatar($dado->suplementado_especial, 'f'),
            db_formatar($dado->reducoes, 'f'),
            db_formatar($dado->saldo_disponivel, 'f'),
            db_formatar($totalCreditos, 'f'),
            db_formatar($dado->a_liquidar, 'f'),
            db_formatar($dado->a_pagar, 'f'),
            db_formatar($dado->a_pagar_liquidado, 'f'),
        ];
    }

    private function criaLinhaSecundaria($dado, $recurso)
    {
        return [
            $dado->reduzido,
            $dado->orgao,
            $dado->descricao_orgao,
            $dado->unidade,
            $dado->descricao_unidade,
            $dado->funcao,
            $dado->descricao_funcao,
            $dado->subfuncao,
            $dado->descricao_subfuncao,
            $dado->programa,
            $dado->descricao_programa,
            $dado->projeto,
            $dado->descricao_projeto,
            $dado->elemento,
            $dado->descricao_elemento,
            $recurso->recurso,
            $recurso->descricao_recurso,
            $recurso->complemento,
            $recurso->descricao_complemento,
            $dado->nome_instituicao,

            db_formatar($recurso->valores->empenhado, 'f'),
            db_formatar($recurso->valores->anulado, 'f'),
            db_formatar($recurso->valores->empenhado_liquido, 'f'),
            db_formatar($recurso->valores->liquidado, 'f'),
            db_formatar($recurso->valores->pago, 'f'),

            db_formatar($recurso->valores->empenhado_acumulado, 'f'),
            db_formatar($recurso->valores->anulado_acumulado, 'f'),
            db_formatar($recurso->valores->empenhado_liquido_acumulado, 'f'),
            db_formatar($recurso->valores->liquidado_acumulado, 'f'),
            db_formatar($recurso->valores->pago_acumulado, 'f'),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];
    }
}
