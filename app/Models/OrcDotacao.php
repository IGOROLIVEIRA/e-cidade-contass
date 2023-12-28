<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Query\Expression;

class OrcDotacao extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'orcamento.orcdotacao';

    protected $primaryKey = 'o58_anousu, o58_coddot';

    protected $fillable = [
        'o58_anousu',
        'o58_coddot',
        'o58_orgao',
        'o58_unidade',
        'o58_subfuncao',
        'o58_projativ',
        'o58_codigo',
        'o58_funcao',
        'o58_programa',
        'o58_codele',
        'o58_valor',
        'o58_instit',
        'o58_localizadorgastos',
        'o58_datacriacao',
        'o58_concarpeculiar',
    ];

    public function getOrcamentosDotacoesAnoDestino (int $anoOrigem, int $anoDestino) {
        return $this->newQuery()
            ->whereIn('o58_coddot', function ($query) {
                global $anoOrigem;
                $query->select('ac22_coddot')
                    ->from('acordo')
                    ->join('acordoposicao', 'acordoposicao.ac26_acordo', '=', 'acordo.ac16_sequencial')
                    ->join('acordoitem', 'acordoitem.ac20_acordoposicao', '=', 'acordoposicao.ac26_sequencial')
                    ->join('acordoitemdotacao', 'acordoitemdotacao.ac22_acordoitem', '=', 'acordoitem.ac20_sequencial')
                    ->join('orcdotacao', function ($join) {
                        $join->on('orcdotacao.o58_coddot', '=', 'acordoitemdotacao.ac22_coddot')
                            ->whereColumn('orcdotacao.o58_anousu', '=', 'acordoitemdotacao.ac22_anousu');
                    })
                    ->where('acordo.ac16_anousu', $anoOrigem)
                    ->whereIn('ac26_sequencial', function ($subquery) {
                        $subquery->selectRaw('max(ac26_sequencial)')
                            ->from('acordoposicao')
                            ->whereColumn('ac26_acordo', 'acordo.ac16_sequencial');
                    });
            })
            ->join('orcelemento', function ($join) {
                $join->on('orcdotacao.o58_codele', '=', 'orcelemento.o56_codele')
                    ->whereColumn('orcdotacao.o58_anousu', '=', 'orcelemento.o56_anousu');
            })
            ->where('o58_anousu', $anoDestino)
            ->select(
                'o58_coddot AS dotacao',
                new Expression("CONCAT(
                CASE
                    WHEN o58_orgao < 10 THEN '0'
                    ELSE ''
                END,
                o58_orgao, '.',
                CASE
                    WHEN o58_unidade < 10 THEN '0'
                    ELSE ''
                END,
                o58_unidade, '.',
                o58_funcao, '.', o58_subfuncao, '.', o58_programa, '.', o58_projativ, '.', orcelemento.o56_elemento, '.', o58_codigo) AS estrutural"),
                'o58_anousu'
            );
    }
}
