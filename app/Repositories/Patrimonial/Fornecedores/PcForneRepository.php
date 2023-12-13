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

        $result = $this->model
            ->with(['cgm' => function (BelongsTo $query) {
                $query->select([
                    'z01_numcgm',
                    'z01_nome',
                    'z01_cgccpf',
                    'z01_uf',
                    'z01_munic',
                    'z01_cep',
                    'z01_bairro',
                    'z01_ender',
                    'z01_telef',
                    'z01_email',
                    'z01_numero'
                ]);
            }])
            ->where(function ($query) use ($ativo) {
                if ($ativo == 't' || $ativo == 'f') {
                    $query->where('pc60_bloqueado', $ativo);
                }
            })
            ->where(function ($query) use ($idInstituicao) {
                $query->where('pc60_instit', $idInstituicao)
                    ->orWhere('pc60_instit', 0);
            })
            ->select([
                'pc60_numcgm',
                'pc60_obs',
                'pc60_motivobloqueio',
                'pc60_databloqueio_ini',
                'pc60_databloqueio_fim',
                'pc60_bloqueado'
            ])
            ->get();

        return $result;
    }
}
