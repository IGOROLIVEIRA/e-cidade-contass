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
        $sContribuintes = NULL,
        $iRecurso
    ) {
        $this->sTipo = $sTipo;
        $this->iAno = date("Y", strtotime($dDataInicial));
        $this->iInstituicao = $iInstituicao;
        $this->sOrdem = $sOrdem;
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
            $sContribuintes,
            $iRecurso
        );
    }

    /**
     * @return array
     */
    public function pegarDados()
    {
        $aDados = array();
        
        if (!$result = pg_query($this->oReceitaPeriodoTesourariaSQLBuilder->pegarSQL()))
            throw new Exception("Erro realizando consulta");
            
        while ($data = pg_fetch_object($result)) {
            if ($this->sTipo == ReceitaTipoRepositoryLegacy::DIARIO) {
                $aDados[$data->data][] = $this->tratarDadosReceitaDiario($data);
                continue;
            } 
            
            if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::CONTRIBUINTE) {
                $data->cgm = $data->cgm ? $data->cgm : 0;
                $descricaoCpfCnpj = strlen($data->cpfcnpj) == 11 ? "CPF:" : "CNPJ:";
                $chave = $data->nome ? "CGM: $data->cgm {$descricaoCpfCnpj} $data->cpfcnpj NOME: $data->nome" : "Sem contribuinte informado";
                $aDados[$data->tipo]["CGM"][$chave][] = $data;
                continue;
            }

            if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
                $data->codreceita = $data->codigo ? $data->codigo : 0;
                $chave = $data->codigo != 0 ? "CÓDIGO DE RECEITA: {$data->codreceita} - {$data->estrutural} - {$data->descricao} " : "Sem código de receita informado";
                $aDados[$data->tipo]["RECEITA"][$chave][] = $data;
                continue;
            }

            if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::OPERACAO_CREDITO) {
                $data->codreceita = $data->operacao ? $data->operacao : 0;
                $dataAssinatura = date('d/m/Y', strtotime($data->dtassinatura));
                $chave = $data->operacao != 0 ? "OPERAÇÃO DE CRÉDITO: {$data->operacao} - CONTRATO: {$data->numcontrato} - DATA DA ASSINATURA: {$dataAssinatura}" : "Sem operação de crédito informada";
                $aDados[$data->tipo]["OPCREDITO"][$chave][] = $data;
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
