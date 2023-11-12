<?php

namespace App\Domain\Financeiro\Contabilidade\Builder;

use App\Domain\Financeiro\Contabilidade\Contracts\PlanoContasOrcamentarioInterface;
use App\Domain\Financeiro\Contabilidade\Mappers\PlanoContas\PlanoContas;
use Carbon\Carbon;
use Exception;

abstract class PlanoOrcamentarioBuilder
{
    /**
     * @var PlanoContasOrcamentarioInterface
     */
    protected $layout;
    /**
     * Cont�m os dados de uma linha do CSV
     * @var array
     */
    protected $linha = [];

    /**
     * @var integer
     */
    protected $exercicio;
    /**
     * Tipo do plano: uniao | UF
     * @var string
     */
    protected $plano;

    /**
     * Mapa dos poss�veis valores para definir se a conta � sint�tica
     * - Informar como consta na planilha, mas sempre em CAPSLOCK
     * @var array
     */
    protected $deParaSintetica = [
        'N�O' => true,
        'N' => true,
        'S' => false,
        'SIM' => false,
    ];

    /**
     * @param PlanoContasOrcamentarioInterface $layout
     * @return PcaspBuilder
     */
    public function addLayout(PlanoContasOrcamentarioInterface $layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Adiciona uma linha do CSV com os dados das colunas
     * @param array $linha
     * @return PcaspBuilder
     */
    public function addLinha(array $linha)
    {
        $this->linha = $linha;
        return $this;
    }

    public function addExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    public function addTipoPlano($plano)
    {
        $this->plano = $plano;
        return $this;
    }

    /**
     * Recebe o "N�vel de detalhamento" (se a conta � sint�tica ou anal�tica) conforme apresentado no arquivo
     * e retorna um booleam
     *
     * @param string $string
     * @return boolean
     * @throws Exception
     */
    protected function sintetica($strings)
    {
        $string = $this->normalize($strings);
        if (!array_key_exists($string, $this->deParaSintetica)) {
            throw new Exception(sprintf(
                'N�o foi mapeado a string "%s" (%s) para realizar o "de para" para identificar se a conta � %s.',
                $string,
                'sint�tica ou analitica',
                $strings
            ));
        }
        return $this->deParaSintetica[$string];
    }

    /**
     * @param $string
     * @return string
     */
    protected function normalize($string)
    {
        return mb_strtoupper(str_replace(' ', '', trim($string)), 'ISO-8859-1');
    }
}
