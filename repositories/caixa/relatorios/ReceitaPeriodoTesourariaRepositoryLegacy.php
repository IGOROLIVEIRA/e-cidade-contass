<?php

namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\SQLBuilder\ReceitaPeriodoTesourariaSQLBuilder;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;
use Exception;
use InstituicaoRepository;
use ReceitaContabilRepository;
use ContaPlanoPCASPRepository;
use Recurso;

require_once 'repositories/caixa/relatorios/SQLBuilder/ReceitaPeriodoTesourariaSQLBuilder.php';
require_once 'interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php';

class ReceitaPeriodoTesourariaRepositoryLegacy
implements IReceitaPeriodoTesourariaRepository
{
    /**
     * @var ReceitaPeriodoTesourariaSQLBuilder
     */
    private $oReceitaPeriodoTesourariaSQLBuilder;

    public function __construct(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $sOrdem,
        $dDataInicial,
        $dDataFinal,
        $sDesdobramento,
        $iEmendaParlamentar,
        $iRegularizacaoRepasse,
        $iInstituicao,
        $sReceitas = NULL,
        $sEstrutura = NULL,
        $sContas = NULL,
        $sContribuintes = NULL
    ) {
        $this->sTipo = $sTipo;
        $this->iAno = date("Y", strtotime($dDataInicial));
        $this->iInstituicao = $iInstituicao;
        $this->oReceitaPeriodoTesourariaSQLBuilder = new ReceitaPeriodoTesourariaSQLBuilder(
            $sTipo,
            $sTipoReceita,
            $iFormaArrecadacao,
            $sOrdem,
            $dDataInicial,
            $dDataFinal,
            $sDesdobramento,
            $iEmendaParlamentar,
            $iRegularizacaoRepasse,
            $iInstituicao,
            $sReceitas,
            $sEstrutura,
            $sContas,
            $sContribuintes
        );
    }

    /**
     * @return array
     */
    public function pegarDados()
    {
        $aDados = array();
        
        echo "<pre>";
        echo $this->oReceitaPeriodoTesourariaSQLBuilder->pegarSQL();
        die();
        
        if (!$result = pg_query($this->oReceitaPeriodoTesourariaSQLBuilder->pegarSQL()))
            throw new Exception("Erro realizando consulta");
        while ($data = pg_fetch_object($result)) {
            if ($this->sTipo == ReceitaTipoRepositoryLegacy::DIARIO) {
                $aDados[$data->data][] = $this->tratarDadosReceitaDiario($data);
                continue;
            } 
            $aDados[$data->tipo][] = $data;
        }
        ksort($aDados);
        return $aDados;
    }

    public function tratarDadosReceitaDiario($data)
    {
        if ($data->tipo == "O")
            $iConta = $data->reduzido;
        if ($data->tipo == "E")
            $iConta = $data->conta;
        $data->fonte = $this->pegarFonteRecurso($iConta, $data->tipo);
        return $data;
    }

    /**
     * Estrutura padrão que estava no e-cidade
     *
     * @param int $iConta
     * @param string $sTipo
     * @return int
     */
    public function pegarFonteRecurso($iConta, $sTipo)
    {
        if ($sTipo == "O") {
            $oReceita = ReceitaContabilRepository::getReceitaByCodigo($iConta, $this->iAno);
            $oFonteRecurso = new Recurso($oReceita->getTipoRecurso());
            return $oFonteRecurso->getEstrutural();
        }

        if ($sTipo == "E") {
            $oInstituicao = InstituicaoRepository::getInstituicaoByCodigo($this->iInstituicao);
            $oFonteRecurso = new Recurso(ContaPlanoPCASPRepository::getContaPorReduzido($iConta, $this->iAno, $oInstituicao)->getRecurso());
            return $oFonteRecurso->getEstrutural();
        }
    }

    /**
     * @return string
     */
    public function pegarFormatoPagina()
    {
        if (in_array($this->sTipo, array(ReceitaTipoRepositoryLegacy::RECEITA, ReceitaTipoRepositoryLegacy::ESTRUTURAL)))
            return "Portrait";
        return "Landscape";
    }
}
