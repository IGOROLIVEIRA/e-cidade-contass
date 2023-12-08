<?php

namespace App\Repositories\Patrimonial\Fornecedores;

use App\Models\PcForne;
use App\Repositories\Contracts\Patrimonial\Fornecedores\PcForneRepositoryInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;

class PcForneRepository implements PcForneRepositoryInterface
{
    private int $idInstituicao;

    /**
     *
     * @var PcForne
     */
    private PcForne $model;

    public function __construct()
    {
        $this->idInstituicao = db_getsession("DB_instit");
        $this->model = new PcForne();
    }

    /**
     *
     * @param string $ativo
     * @return Collection
     */
    public function getForneByStatusBlockWithCgm(string $ativo): Collection
    {
        $idInstituicao = $this->idInstituicao;

        return $this->model
                ->with(['cgm' => function (BelongsTo $query) {
                    $query->select([
                        'cgm.z01_nome',
                        'cgm.z01_cgccpf',
                        'cgm.z01_uf',
                        'cgm.z01_munic',
                        'cgm.z01_cepcon',
                        'cgm.z01_bairro',
                        'cgm.z01_ender',
                        'cgm.z01_telcel',
                    ]);
                }])
                ->where( function ($query) use ($ativo,$idInstituicao) {
                    if ($ativo == 't' || $ativo == 'f') {
                        $query->where('pc60_bloqueado', $ativo);
                    }
                    $query->where('pc60_instit', $idInstituicao)
                    ->orWhere('pc60_instit',0);
                })
                ->select([
                    'pc60_objsocial',
                    'pc60_motivobloqueio'
                     ])
                ->get();
    }
}
