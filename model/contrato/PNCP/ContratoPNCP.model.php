<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel por montar as informaes do Envio de Contratos - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class ContratoPNCP extends ModeloBasePNCP
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados)
    {
        parent::__construct($dados);
    }

    public function montarDados()
    {
        //ini_set('display_errors', 'on');
        // $aDadosAPI = array();

       

        // $oDadosAPI                                  = new \stdClass;
        // // $oDadosAPI->cnpjCompra                               = '01001'; //$oDado->codigounidadecompradora;
        // // $oDadosAPI->anoCompra                                = $oDado->tipoinstrumentoconvocatorioid;
        // // $oDadosAPI->sequencialCompra                         = $oDado->modalidadeid;
        // $oDadosAPI->tipoContratoId                           = $oDado->tipocontratoid;
        // // $oDadosAPI->numeroContratoEmpenho                    = $oDado->numerocompra;
        // $oDadosAPI->anoContrato                              = $oDado->anocontrato;
        // $oDadosAPI->processo                                 = $oDado->processo;
        // $oDadosAPI->categoriaProcessoId                      = $oDado->categoriaprocessoid;
        // $oDadosAPI->niFornecedor                             = $oDado->nifornecedor;
        // $oDadosAPI->tipoPessoaFornecedor                     = $oDado->tipopessoafornecedor;
        // $oDadosAPI->nomeRazaoSocialFornecedor                = $oDado->nomerazaosocialfornecedor;
        // $oDadosAPI->receita                                  = $oDado->receita;
        // $oDadosAPI->codigoUnidade                            = $oDado->codigounidade;
        // $oDadosAPI->objetoContrato                           = $oDado->objetocontrato;
        // $oDadosAPI->valorInicial                             = $oDado->valorinicial;
        // $oDadosAPI->numeroParcelas                           = $oDado->numeroparcelas;
        // $oDadosAPI->valorParcela                             = $oDado->valorparcela;
        // $oDadosAPI->valorGlobal                              = $oDado->valorglobal;
        // $oDadosAPI->dataAssinatura                           = $oDado->dataassinatura;
        // $oDadosAPI->dataVigenciaInicio                       = $oDado->datavigenciainicio;
        // $oDadosAPI->dataVigenciaFim                          = $oDado->datavigenciafim;
        // $oDadosAPI->valorAcumulado                           = $oDado->valorAcumulado;
        // $oDadosAPI->niFornecedorSubContratado                = $oDado->nifornecedorsubcontratado;
        // $oDadosAPI->tipoPessoaFornecedorSubContratado        = $oDado->tipopessoafornecedorsubcontratado;
        // $oDadosAPI->nomeRazaoSocialFornecedorSubContratado   = $oDado->nomerazaosocialfornecedorsubcontratado;
        // $oDadosAPI->informacaoComplementar                   = $oDado->informacaocomplementar;
        // $oDadosAPI->urlCipi                                  = $oDado->urlcipi;
        // $oDadosAPI->identificadorCipi                        = $oDado->identificadorcipi;

        $oDado = $this->dados;

        $aDadosAPI = array 
        ( 
        'cnpjCompra'                               => '17316563000196',//$oDado->cnpjcompra,
        'anoCompra'                                => $oDado->anocompra,
        'sequencialCompra'                         => '000044',
        'tipoContratoId'                           => $oDado->tipocontratoid,
        'numeroContratoEmpenho'                    => $oDado->numerocontratoempenho,
        'anoContrato'                              => $oDado->anocontrato,
        'processo'                                 => $oDado->processo,
        'categoriaProcessoId'                      => $oDado->categoriaprocessoid,
        'niFornecedor'                             => $oDado->nifornecedor,
        'tipoPessoaFornecedor'                     => 'PJ',//$oDado->tipopessoafornecedor,
        'nomeRazaoSocialFornecedor'                => $oDado->nomerazaosocialfornecedor,
        'receita'                                  => true,//$oDado->receita,
        'codigoUnidade'                            => '01001',//$oDado->codigounidade,
        'objetoContrato'                           => $oDado->objetocontrato,
        'valorInicial'                             => $oDado->valorinicial,
        'numeroParcelas'                           => $oDado->numeroparcelas,
        'valorParcela'                             => 0,//$oDado->valorparcela,
        'valorGlobal'                              => $oDado->valorglobal,
        'dataAssinatura'                           => $oDado->dataassinatura,
        'dataVigenciaInicio'                       => $oDado->datavigenciainicio,
        'dataVigenciaFim'                          => $oDado->datavigenciafim,
        'valorAcumulado'                           => $oDado->valorAcumulado,
        'niFornecedorSubContratado'                => '09336849000105',//$oDado->nifornecedorsubcontratado,
        'tipoPessoaFornecedorSubContratado'        => 'PJ',//$oDado->tipopessoafornecedorsubcontratado,
        'nomeRazaoSocialFornecedorSubContratado'   => 'Teste Fornecedor',//$oDado->nomerazaosocialfornecedorsubcontratado,
        'informacaoComplementar'                   => $oDado->informacaocomplementar,
        // 'urlCipi'                                  => $oDado->urlcipi,
        // 'identificadorCipi'                        => '',//$oDado->identificadorcipi,
        );   
        // '2522.31-81',
        $oDadosAPI = $aDadosAPI;
        // print_r($oDadosAPI);exit;
        return $oDadosAPI;
               
    }

    public function montarRetificacao()
    {
        //ini_set('display_errors', 'on');
        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->codigoUnidadeCompradora         = '01001'; //$oDado->codigounidadecompradora;
        $oDadosAPI->tipoInstrumentoConvocatorioId   = $oDado->tipoinstrumentoconvocatorioid;
        $oDadosAPI->modalidadeId                    = $oDado->modalidadeid;
        $oDadosAPI->modoDisputaId                   = $oDado->mododisputaid;
        $oDadosAPI->numeroCompra                    = $oDado->numerocompra;
        $oDadosAPI->anoCompra                       = $oDado->anocompra;
        $oDadosAPI->numeroProcesso                  = $oDado->numeroprocesso;
        $oDadosAPI->objetoCompra                    = $this->formatText($oDado->objetocompra);
        $oDadosAPI->informacaoComplementar          = $oDado->informacaocomplementar;
        $oDadosAPI->srp                             = $oDado->srp == 'f' ? 'false' : 'true';
        $oDadosAPI->orcamentoSigiloso               = $oDado->orcamentosigiloso == 'f' ? 'false' : 'true';
        $oDadosAPI->dataAberturaProposta            = $this->formatDate($oDado->dataaberturaproposta);
        $oDadosAPI->dataEncerramentoProposta        = $this->formatDate($oDado->dataencerramentoproposta);
        $oDadosAPI->amparoLegalId                   = $oDado->amparolegalid;
        $oDadosAPI->linkSistemaOrigem               = $oDado->linksistemaorigem;

        $aDadosAPI = json_encode($oDadosAPI);
        echo "<pre>";
        print_r($aDadosAPI);
        exit;
    }
}
