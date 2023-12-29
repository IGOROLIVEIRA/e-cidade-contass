<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Query\Expression;

class Acordo extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'acordos.acordo';

    protected $primaryKey = 'ac16_sequencial';

    protected $fillable = [
        'ac16_sequencial',
        'ac16_acordosituacao',
        'ac16_coddepto',
        'ac16_numero',
        'ac16_anousu',
        'ac16_dataassinatura',
        'ac16_contratado',
        'ac16_datainicio',
        'ac16_datafim',
        'ac16_resumoobjeto',
        'ac16_objeto',
        'ac16_instit',
        'ac16_acordocomissao',
        'ac16_lei',
        'ac16_acordogrupo',
        'ac16_origem',
        'ac16_qtdrenovacao',
        'ac16_tipounidtempo',
        'ac16_deptoresponsavel',
        'ac16_numeroprocesso',
        'ac16_periodocomercial',
        'ac16_qtdperiodo',
        'ac16_tipounidtempoperiodo',
        'ac16_acordocategoria',
        'ac16_tipomodalidade',
        'ac16_numodalidade',
        'ac16_acordoclassificacao',
        'ac16_numeroacordo',
        'ac16_valor',
        'ac16_formafornecimento',
        'ac16_formapagamento',
        'ac16_cpfsignatariocontratante',
        'ac16_datapublicacao',
        'ac16_datainclusao',
        'ac16_veiculodivulgacao',
        'ac16_tipoorigem',
        'ac16_licitacao',
        'ac16_valorrescisao',
        'ac16_datarescisao',
        'ac16_semvigencia',
        'ac16_licoutroorgao',
        'ac16_adesaoregpreco',
        'ac16_tipocadastro',
        'ac16_providencia',
        'ac16_datareferencia',
        'ac16_datareferenciarescisao',
        'ac16_reajuste',
        'ac16_criterioreajuste',
        'ac16_datareajuste',
        'ac16_indicereajuste',
        'ac16_periodoreajuste',
        'ac16_descricaoreajuste',
        'ac16_descricaoindice',
        'ac16_vigenciaindeterminada',
    ];

    public function getAcordosDotacoesComPosicoes() {
        return $this->newQuery()
            ->select([
                'acordoitemdotacao.ac22_coddot AS dotacao',
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
                o58_unidade, '.', o58_funcao, '.', o58_subfuncao, '.', o58_programa, '.', o58_projativ, '.', o56_elemento, '.', o58_codigo) AS estrutural"),
                'orcdotacao.o58_anousu',
                'acordoitem.ac20_sequencial AS acordoitem',
                'acordoitem.ac20_valortotal AS valor',
                'acordoitem.ac20_quantidade AS quantidade',
                'acordoitem.ac20_pcmater AS codigomaterial',
                new Expression("CONCAT(ac16_numero, '/', ac16_anousu) AS numerocontrato"),
                'ac16_objeto AS objeto',
                'acordovigencia.ac18_datainicio AS vigenciainicio',
                'acordovigencia.ac18_datafim AS vigenciafim',
                'pcmater.pc01_descrmater AS descmaterial',
                'ac16_sequencial AS codacordo',

            ])
            ->join('acordoposicao', 'acordoposicao.ac26_acordo', '=', 'acordo.ac16_sequencial')
            ->join('acordovigencia', 'acordovigencia.ac18_acordoposicao', '=', 'acordoposicao.ac26_sequencial')
            ->join('acordoitem', 'acordoitem.ac20_acordoposicao', '=', 'acordoposicao.ac26_sequencial')
            ->join('pcmater', 'pcmater.pc01_codmater', '=', 'acordoitem.ac20_pcmater')
            ->join('acordoitemdotacao', 'acordoitemdotacao.ac22_acordoitem', '=', 'acordoitem.ac20_sequencial')
            ->join('orcdotacao', function ($join) {
                $join->on('orcdotacao.o58_coddot', '=', 'acordoitemdotacao.ac22_coddot')
                    ->whereColumn('orcdotacao.o58_anousu', '=', 'acordoitemdotacao.ac22_anousu');
            })
            ->join('orcelemento', function ($join) {
                $join->on('orcdotacao.o58_codele', '=', 'orcelemento.o56_codele')
                    ->whereColumn('orcdotacao.o58_anousu', '=', 'orcelemento.o56_anousu');
            })
            ->whereIn('acordoposicao.ac26_sequencial', function ($query) {
                $query->select(new Expression('MAX(ac26_sequencial)'))
                    ->from('acordoposicao')
                    ->whereColumn('ac26_acordo', 'acordo.ac16_sequencial');
            })
            ->where('ac16_acordosituacao', 4);
    }

    public function getItensAcordosDotacoesSemPosicoes() {
        return $this->newQuery()
            ->select([
                'acordoitem.ac20_sequencial AS acordoitem',
            ])
            ->join('acordoposicao', 'acordoposicao.ac26_acordo', '=', 'acordo.ac16_sequencial')
            ->join('acordovigencia', 'acordovigencia.ac18_acordoposicao', '=', 'acordoposicao.ac26_sequencial')
            ->join('acordoitem', 'acordoitem.ac20_acordoposicao', '=', 'acordoposicao.ac26_sequencial')
            ->join('pcmater', 'pcmater.pc01_codmater', '=', 'acordoitem.ac20_pcmater')
            ->join('acordoitemdotacao', 'acordoitemdotacao.ac22_acordoitem', '=', 'acordoitem.ac20_sequencial')
            ->join('orcdotacao', function ($join) {
                $join->on('orcdotacao.o58_coddot', '=', 'acordoitemdotacao.ac22_coddot')
                    ->whereColumn('orcdotacao.o58_anousu', '=', 'acordoitemdotacao.ac22_anousu');
            });
    }
}
