<?php

namespace App\Models;

use App\Support\String\StringHelper;
use App\Traits\LegacyAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

class Socio extends LegacyModel
{
    use LegacyAccount;

    public const TYPE_SOCIO = 1;

    public const TYPE_RESPONSAVEL_MEI = 2;

    public const TYPE_RESPONSAVEL = 3;

    public const TYPE_SOCIO_ADMINISTRADOR = 4;

    public const TYPE_SOCIO_COTISTA = 5;

    public const TYPE_ADMINISTRADOR = 6;

    public const ASSOCIABLES_WITH_LABEL = [
        self::TYPE_SOCIO => 'Socio',
        self::TYPE_RESPONSAVEL_MEI => 'Responsavel MEI',
        self::TYPE_RESPONSAVEL => 'Responsavel',
        self::TYPE_SOCIO_ADMINISTRADOR => 'Socio Administrador',
        self::TYPE_SOCIO_COTISTA => 'Socio Cotista',
        self::TYPE_ADMINISTRADOR => 'Administrador',
    ];

    public $timestamps = false;

    protected $table = 'issqn.socios';

    protected $primaryKey = 'q95_numcgm, q95_cgmpri';

    protected $fillable = [
        'q95_cgmpri',
        'q95_numcgm',
        'q95_perc',
        'q95_tipo',
    ];

    public static function getAssociateLabelByType(int $type): string
    {
        return self::ASSOCIABLES_WITH_LABEL[$type] ?? 'Não informado';
    }

    public static function getCaseAssociateLabel(string $alias = 'tipo'): string
    {
        return "CASE socios.q95_tipo
              WHEN ".self::TYPE_SOCIO." then '".self::ASSOCIABLES_WITH_LABEL[self::TYPE_SOCIO]."'
              WHEN ".self::TYPE_RESPONSAVEL_MEI." then '".self::ASSOCIABLES_WITH_LABEL[self::TYPE_RESPONSAVEL_MEI]."'
              WHEN ".self::TYPE_RESPONSAVEL." then '".self::ASSOCIABLES_WITH_LABEL[self::TYPE_RESPONSAVEL]."'
              WHEN ".self::TYPE_SOCIO_ADMINISTRADOR." then '".self::ASSOCIABLES_WITH_LABEL[self::TYPE_SOCIO_ADMINISTRADOR]."'
              WHEN ".self::TYPE_SOCIO_COTISTA." then '".self::ASSOCIABLES_WITH_LABEL[self::TYPE_SOCIO_COTISTA]."'
              WHEN ".self::TYPE_ADMINISTRADOR." then '".self::ASSOCIABLES_WITH_LABEL[self::TYPE_ADMINISTRADOR]."'
              else 'Não informado' end as {$alias}";
    }

    public function getSociosBCI(): Builder
    {
        return $this->newQuery()
            ->select(
                [
                    'z01_numcgm',
                    'z01_nome',
                    'z01_cgccpf',
                    new Expression(self::getCaseAssociateLabel('q95_tipo')),
                    'q95_perc'
                ]
            )
            ->join('issbase', 'q95_cgmpri', '=', 'q02_numcgm')
            ->join('cgm', 'z01_numcgm', '=', 'q95_numcgm');
    }

    public static function getAssociateLabelOptions(): string
    {
        return collect(self::ASSOCIABLES_WITH_LABEL)->map(function (string $label) {
            return StringHelper::removeAccent($label);
        })->toJson();
    }
}
