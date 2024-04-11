<?php

use ECidade\Financeiro\Efdreinf\Efdreinf\Efdreinf;
use ECidade\Financeiro\Efdreinf\ModeloBaseEFDREINF;
use \ECidade\V3\Extension\Registry;

require_once("src/Financeiro/Efdreinf/Efdreinf.php");
/**
 * Classe responsvel por montar as informaes do EFD Reinf
 *
 * @package  ECidade\model\EfdRreinf
 * @author   Dayvison Nunes
 */
class EFDReinfEventos extends ModeloBaseEFDREINF
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados,$dadosCgm,$cgc)
    {
        parent::__construct($dados,$dadosCgm,$cgc); 
    } 
    public function montarDadosReinfR2010()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataGeracao = date('YmdHis');
        $aDadosAPI = [
            "evtServTom"   => [
                "id"      => "ID1".$this->cgc.$dataGeracao."00000"
            ],
            "ideEvento" => [
                "indRetif" => 1 ,
                "perApur" => $this->dadosCGM->sAnocompetencia."-".$this->dadosCGM->sMescompetencia,
                "tpAmb" => $this->dadosCGM->sAmbiente,
                "procEmi" => "1",
                "verProc" => "2.01.02"
            ],
            "ideContri" => [
                "tpInsc"   => "1",
                "nrInsc"   => substr($this->cgc,0,8)
            ],
            "ideEstabObra" => [
                "tpInscEstab" => $this->dados->PossuiCNO == 1 ? 4 : 1,
                "nrInscEstab"  => $this->dados->PossuiCNO == 1 ? preg_replace("/[^0-9]/", "", $this->dados->NumeroCNO) : $this->cgc,
                "indObra"   => (integer) $this->dados->IndPrestServico,
            ],
            "idePrestServ" => [
                "cnpjPrestador" => $this->dados->CNPJPrestador,
                "vlrTotalBruto"  => (float) number_format(str_replace(['R$', '.', ','], ['','','.'], $this->dados->ValorBruto), 2, '.', ''), 
                "vlrTotalBaseRet"   => (float) number_format(str_replace(['R$', '.', ','], ['','','.'], $this->dados->ValorBase), 2, '.', ''),
                "vlrTotalRetPrinc"   => (float) number_format(str_replace(['R$', '.', ','], ['','','.'], $this->dados->ValorRetidoCP), 2, '.', ''),
                "vlrTotalRetAdic"   => '',
                "vlrTotalNRetPrinc"   => '',
                "vlrTotalNRetAdic"   => '',
                "indCPRB"   => (integer) $this->dados->OptanteCPRB,
            ],
        ];

        $aDadosAPI['nfs'] = [];
        $aDadosAPI['infoTpServ'] = [];

        $dados = str_replace(["\r", "\n", " ; ,"], ["", "", ";"],  $this->dados->DadosExtras);
        $itens = explode(";", $dados);
        $itens = array_filter(array_map('trim', $itens));
        
        $dadosArray = array_chunk($itens, 9);
    
        foreach ($dadosArray as $chave => $valor) {

            if ( $valor[1] == 'S/N' || !$valor[1]) {
                throw new Exception("Para transmitir o evento é obrigatório informar o número da nota fiscal !");
            }
            $aDadosAPI['nfs'][$chave] = array(
                "serie" => $valor[2],
                "numDocto" => preg_replace("/[^0-9]/", "", $valor[1]),
                "dtEmissaoNF" => $valor[3],
                "vlrBruto" => $valor[4],
                "obs" => $valor[7],
                'infoTpServ' => array(
                    "tpServico" => substr($valor[0], 0, 9),
                    "vlrBaseRet" => (float)number_format(str_replace(['R$', '.', ','], ['', '', '.'], $valor[5]), 2, '.', ''),
                    "vlrRetencao" => (float)number_format(str_replace(['R$', '.', ','], ['', '', '.'], $valor[6]), 2, '.', ''),
                    "vlrRetSub" => "",
                    "vlrNRetPrinc" => "",
                    "vlrServicos15" => "",
                    "vlrServicos20" => "",
                    "vlrServicos25" => "",
                    "vlrAdicional" => "",
                    "vlrNRetAdic" => "",
                ),
            );

            if (isset($aDadosAPI['nfs'][$chave]['dtEmissaoNF']) && DateTime::createFromFormat('d/m/Y', $aDadosAPI['nfs'][$chave]['dtEmissaoNF'])) {
                $dataObj = DateTime::createFromFormat('d/m/Y', $aDadosAPI['nfs'][$chave]['dtEmissaoNF']);
                $aDadosAPI['nfs'][$chave]['dtEmissaoNF'] = $dataObj->format('Y-m-d');
            }
            $camposMonetarios = ['vlrBruto', 'vlrLiquido', 'vlrDesc'];
            foreach ($camposMonetarios as $campo) {
                if (isset($aDadosAPI['nfs'][$chave][$campo])) {
                    $aDadosAPI['nfs'][$chave][$campo] = (float) number_format (str_replace(['R$', '.', ','], ['','','.'], $aDadosAPI['nfs'][$chave][$campo]), 2, '.', '');
                }
            }
          
        }
        $oDadosAPI = json_encode($aDadosAPI, JSON_PRETTY_PRINT);
        return $oDadosAPI;
    }
    public function emitirReinfR2010($dadosEnvio,$oCertificado)
    {
        
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2010", $this->dados->efd04_ambiente, "4");
        $exportar = new Efdreinf($url, "run.php");
        $exportar->setDados($dados);
        $retorno = $exportar->request();

        if (!$retorno) {
            throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retorno == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (substr($retorno,0,4) == 'JSON') {
            throw new Exception($retorno);
        }
        if (simplexml_load_string($retorno))
            return  simplexml_load_string($retorno);
        return $retorno; 
    }
    public function buscarReinfR2010($dadosEnvio,$oCertificado,$protocolo)
    {
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2010",$this->dados->efd04_ambiente, "4",$protocolo);
        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();

        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (substr($retornobuscar,0,4) == 'JSON') {
            throw new Exception($retornobuscar);
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function montarDadosReinfR2055()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataGeracao = date('YmdHis');
        $aDadosAPI = [
            "evtAqProd"   => [
                "id"      => "ID1".$this->cgc.$dataGeracao."00000"
            ],
            "ideEvento" => [
                "indRetif" => 1 ,
                "perApur" => $this->dadosCGM->sAnocompetencia."-".$this->dadosCGM->sMescompetencia,
                "tpAmb" => $this->dadosCGM->sAmbiente,
                "procEmi" => "1",
                "verProc" => "2.01.02"
            ],
            "ideContri" => [
                "tpInsc"   => "1",
                "nrInsc"   => substr($this->cgc,0,8)
            ],
            "ideEstabAdquir" => [
                "tpInscAdq" => 1,
                "nrInscAdq"  => $this->cgc,
                
            ],
            "ideProdutor" => [
                "tpInscProd" => $this->dados->Tipo == "CPF" ? '2' : '1',
                "nrInscProd" => $this->dados->CPFCNPJProdutor, 
                "indOpcCP"   => $this->dados->ProdOptaCp == 2 ? "S" : "",
            ],

        ];
        $dados = str_replace(["\r", "\n", " ; ,"], ["", "", ";"],  $this->dados->DadosExtras);
        $itens = explode(";", $dados);
        $itens = array_filter(array_map('trim', $itens));  
        $dadosArray = array_chunk($itens, 11);
        foreach ($dadosArray as $chave => $valor) {
            $aDadosAPI['detaquis'][$chave] = array(
                "indaquis" => (integer) substr($valor[8],0,1),
                "vlrbruto" => (float)number_format(str_replace(['R$', '.', ','], ['', '', '.'], $valor[3]), 2, '.', ''),
                "vlrcpdescpr" => (float)number_format(str_replace(['R$', '.', ','], ['', '', '.'], $valor[4]), 2, '.', ''),
                "vlrratdescpr" => (float)number_format(str_replace(['R$', '.', ','], ['', '', '.'], $valor[5]), 2, '.', ''),
                "vlrsenardesc" => (float)number_format(str_replace(['R$', '.', ','], ['', '', '.'], $valor[6]), 2, '.', ''),
                'infoprocjud' => array(
                    "nrprocjud" => "",
                    "codsusp" => "",
                    "vlrcpnret" => "",
                    "vlrratnre" => "",
                    "vlrsenarnret" => "",
                ),
            );
        }
        $aDadosAPI = json_encode($aDadosAPI, JSON_PRETTY_PRINT);
        return $aDadosAPI;
    }
    public function emitirReinfR2055($dadosEnvio,$oCertificado)
    {
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2055", $this->dados->efd04_ambiente, "4");
        $exportar = new Efdreinf($url, "run.php");
        $exportar->setDados($dados);
        $retorno = $exportar->request();
        
        if (!$retorno) {
            throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retorno == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (substr($retorno,0,4) == 'JSON') {
            throw new Exception($retorno);
        }
        if (simplexml_load_string($retorno))
            return  simplexml_load_string($retorno);
        return $retorno; 
    }
    public function buscarReinfR2055($dadosEnvio,$oCertificado,$protocolo)
    {
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2055",$this->dados->efd04_ambiente, "4",$protocolo);
        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();
       
        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (substr($retornobuscar,0,4) == 'JSON') {
            throw new Exception($retornobuscar);
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function montarDadosReinfR4099()
    {
        date_default_timezone_set('America/Sao_Paulo');
        
        $dataGeracao = date('YmdHis');
        $aDadosAPI = [
            "evtFech"   => [
                "id"      => "ID1".$this->cgc.$dataGeracao."00000"
            ],
            "ideEvento" => [
                "perApur" => $this->dados->efd01_anocompetencia."-".$this->dados->efd01_mescompetencia ,
                "tpAmb"   => $this->dados->efd01_ambiente,
                "procEmi" => "1",
                "verProc" => "2.01.02"
            ],
            "ideContri" => [
                "tpInsc"   => "1",
                "nrInsc"   => substr($this->cgc,0,8)
            ],
            "ideRespInf" => [
                "nmResp"   => str_pad($this->dadosCGM->z01_nome, 70, ' ', STR_PAD_RIGHT),
                "cpfResp"  => $this->dadosCGM->z01_cgccpf,
                "telefone" => !empty($this->dadosCGM->z01_telef) ? $this->dadosCGM->z01_telef : null,
                 "email"   => !empty($this->dadosCGM->z01_email) ? strtolower($this->dadosCGM->z01_email) : null
            ],
            "infoFech" => [
                "fechRet" => $this->dados->efd01_tipo,
            ]
        ];
        
        $aDadosAPI = json_encode($aDadosAPI, JSON_PRETTY_PRINT);
        return $aDadosAPI;
    }
    public function emitirReinfR4099($dadosEnvio,$oCertificado)
    {
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech4099", $this->dados->efd01_ambiente, "4");
        $exportar = new Efdreinf($url, "run.php");
        $exportar->setDados($dados);
        $retorno = $exportar->request();
     
        if (!$retorno) {
            throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retorno == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retorno))
            return  simplexml_load_string($retorno);
        return $retorno; 
    }
    public function buscarReinfR4099($dadosEnvio,$oCertificado,$protocolo)
    {
       
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech4099",$this->dados->efd01_ambiente, "4",$protocolo);
        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();
        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function montarDadosReinfR4020()
    {
        
        $data = [
            "ideEvento" => [
                "indRetif" => 1,
                "nrRecibo" => null,
                "perApur" => $this->dadosCGM->sAnocompetencia."-".$this->dadosCGM->sMescompetencia,
                "tpAmb" => $this->dadosCGM->sAmbiente, 
                "procEmi" => "1",
                "verProc" => "2.01.02" 
            ],
            "infoComplContri" => [
                "natJur" => null
            ],
            "ideEstab" => [
                "tpInscEstab" => 1,
                "nrInscEstab" => $this->cgc
            ],
            "ideBenef" => [
                "cnpjBenef" => $this->dados->CNPJBeneficiario,
                "nmBenef" => null,
                "isenImun" => null,
                "ideEvtAdic" => $this->dados->Identificador
            ],
            "idePgto" => [
                "natRend" => $this->dados->NatRendimento,
                "observ" =>  null,
                "infopgto" => [
                    "dtFG" => $this->dados->DataFG,
                    "vlrBruto" => $this->dados->ValorBruto,
                    "indFciScp" => null,
                    "nrInscFciScp" => null,
                    "percSCP" => null,
                    "indJud" =>  null,
                    "paisResidExt" => null,
                    "dtEscrCont" => null,
                    "observ" => null,
                    "retencoes" => [
                        "vlrBaseIR" => ($this->dados->ValorBase),
                        "vlrIR" => ($this->dados->ValorIRRF),
                        "vlrBaseAgreg" => (null),
                        "vlrAgreg" => (null),
                        "vlrBaseCSLL" => (null),
                        "vlrCSLL" => (null),
                        "vlrBaseCofins" => (null),
                        "vlrCofins" => (null),
                        "vlrBasePP" => (null),
                        "vlrPP" => (null)
                    ],
                    "infoprocret" => [
                        "tpProcRet" => null ,
                        "nrProcRet" => null,
                        "codSusp" => null,
                        "vlrBaseSuspIR" => null,
                        "vlrNIR" => null,
                        "vlrDepIR" => null,
                        "vlrBaseSuspCSLL" => null,
                        "vlrNCSLL" =>  null,
                        "vlrDepCSLL" =>  null,
                        "vlrBaseSuspCofins" => null,
                        "vlrNCofins" => null,
                        "vlrDepCofins" =>  null,
                        "vlrBaseSuspPP" =>  null,
                        "vlrNPP" => null,
                        "vlrDepPP" =>  null
                    ],
                    "infoprocjud" => null,
                    "infoprocjud" => null,
                    "infopgtoext" => null

                ]
            ],

        ];
        $aDadosAPI = json_encode($data, JSON_PRETTY_PRINT);
        return $aDadosAPI ;
    }
    public function emitirReinfR4020($dadosEnvio,$oCertificado)
    {
    
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech4020", $this->dados->efd01_ambiente, "4");
        $exportar = new Efdreinf($url, "run.php");
        $exportar->setDados($dados);
        $retorno = $exportar->request();
    
        if (!$retorno) {
            throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retorno == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retorno))
            return  simplexml_load_string($retorno);
        return $retorno; 
    }
    public function buscarReinfR4020($dadosEnvio,$oCertificado,$protocolo)
    {
       
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech4020",$this->dados->efd01_ambiente, "4",$protocolo);
   
        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();

        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function buscarReinfR1000($oCertificado)
    {
 
        $url            = $this->url;
        $dados = array($oCertificado, null, "evtFech1000",$this->dados->efd01_ambiente, "4",null);

        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();
       
        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function montarDadosReinfR4010()
    {
        
        $data = [
            "ideEvento" => [
                "indRetif" => 1,
                "nrRecibo" => null,
                "perApur" => $this->dadosCGM->sAnocompetencia."-".$this->dadosCGM->sMescompetencia,
                "tpAmb" => $this->dadosCGM->sAmbiente, 
                "procEmi" => "1", 
                "verProc" => "2.01.02" 
            ],
            "infoComplContri" => [
                "natJur" => null
            ],
            "ideEstab" => [
                "tpInscEstab" => 1,
                "nrInscEstab" => $this->cgc
            ],
            "ideBenef" => [
                "cpfBenef" => $this->dados->CPFBeneficiario,
                "nmBenef" => null,
                "isenImun" => null,
                "ideEvtAdic" => $this->dados->Identificador
            ],
            "idePgto" => [
                "natRend" => $this->dados->NatRendimento,
                "observ" =>  null,
                "infopgto" => [
                    "dtFG" => $this->dados->DataFG,
                    "vlrBruto" => $this->dados->ValorBruto,
                    "indFciScp" => null,
                    "nrInscFciScp" => null,
                    "percSCP" => null,
                    "indJud" =>  null,
                    "paisResidExt" => null,
                    "dtEscrCont" => null,
                    "observ" => null,
                    "retencoes" => [
                        "vlrBaseIR" => $this->dados->ValorBase,
                        "vlrIR" => $this->dados->ValorIRRF,
                        "vlrBaseAgreg" => (null),
                        "vlrAgreg" => (null),
                        "vlrBaseCSLL" => (null),
                        "vlrCSLL" => (null),
                        "vlrBaseCofins" => (null),
                        "vlrCofins" => (null),
                        "vlrBasePP" => (null),
                        "vlrPP" => (null)
                    ],
                    "infoprocret" => [
                        "tpProcRet" => null ,
                        "nrProcRet" => null,
                        "codSusp" => null,
                        "vlrBaseSuspIR" => null,
                        "vlrNIR" => null,
                        "vlrDepIR" => null,
                        "vlrBaseSuspCSLL" => null,
                        "vlrNCSLL" =>  null,
                        "vlrDepCSLL" =>  null,
                        "vlrBaseSuspCofins" => null,
                        "vlrNCofins" => null,
                        "vlrDepCofins" =>  null,
                        "vlrBaseSuspPP" =>  null,
                        "vlrNPP" => null,
                        "vlrDepPP" =>  null
                    ],
                    "infoprocjud" => null,
                    "infoprocjud" => null,
                    "infopgtoext" => null

                ]
            ],

        ];
        $aDadosAPI = json_encode($data, JSON_PRETTY_PRINT);
        return $aDadosAPI ;
    }
    public function emitirReinfR4010($dadosEnvio,$oCertificado)
    {
    
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech4010", $this->dados->efd01_ambiente, "4");
        $exportar = new Efdreinf($url, "run.php");
        $exportar->setDados($dados);
        $retorno = $exportar->request();

        if (!$retorno) {
            throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retorno == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retorno))
            return  simplexml_load_string($retorno);
        return $retorno; 
    }
    public function buscarReinfR4010($dadosEnvio,$oCertificado,$protocolo)
    {
       
        $url            = $this->url;
        $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech4010",$this->dados->efd01_ambiente, "4",$protocolo);

        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();
       
        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function montarDadosReinfR2099()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataGeracao = date('YmdHis');
        $aDadosAPI = [
            "evtFechaEvPer"   => [
                "id"      => "ID1".$this->cgc.$dataGeracao."00000"
            ],
            "ideEvento" => [
                "perApur" => $this->dados->efd04_anocompetencia."-".$this->dados->efd04_mescompetencia ,
                "tpAmb"   => $this->dados->efd04_ambiente,
                "procEmi" => "1",
                "verProc" => "2.01.02"
            ],
            "ideContri" => [
                "tpInsc"   => "1",
                "nrInsc"   => substr($this->cgc,0,8)
            ],
            "ideRespInf" => [
                "nmResp"   => str_pad($this->dadosCGM->z01_nome, 70, ' ', STR_PAD_RIGHT),
                "cpfResp"  => $this->dadosCGM->z01_cgccpf,
                "telefone" => !empty($this->dadosCGM->z01_telef) ? $this->dadosCGM->z01_telef : null,
                 "email"   => !empty($this->dadosCGM->z01_email) ? strtolower($this->dadosCGM->z01_email) : null
            ],
            "infoFech" => [
                "evtServTm" => $this->dados->efd04_servicoprev == 1 ? 'S' : 'N',
                "evtAquis"  => $this->dados->efd04_producaorural == 1 ? 'S' : 'N',
                "fechRet"   => $this->dados->efd04_tipo,
            ]
        ];
        
        $aDadosAPI = json_encode($aDadosAPI, JSON_PRETTY_PRINT);
        return $aDadosAPI;
    }
    public function emitirReinfR2099($dadosEnvio,$oCertificado)
    {
        $url            = $this->url;
        if ($this->dados->efd04_tipo == 0) {
            $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2099", $this->dados->efd04_ambiente, "4");
        }
        if ($this->dados->efd04_tipo == 1) {
            $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2098", $this->dados->efd04_ambiente, "4");
        }
        $exportar = new Efdreinf($url, "run.php");
        $exportar->setDados($dados);
        $retorno = $exportar->request();
   
        if (!$retorno) {
            throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retorno == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retorno))
            return  simplexml_load_string($retorno);
        return $retorno; 
    }
    public function buscarReinfR2099($dadosEnvio,$oCertificado,$protocolo)
    {
        $url            = $this->url;
        if ($this->dados->efd04_tipo == 0) {
            $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2099",$this->dados->efd04_ambiente, "4",$protocolo);
        }
        if ($this->dados->efd04_tipo == 1) {
            $dados = array($oCertificado, json_decode($dadosEnvio), "evtFech2098",$this->dados->efd04_ambiente, "4",$protocolo);
        }
        $exportar = new Efdreinf($url, "consulta.php");
        $exportar->setDados($dados);
        $retornobuscar = $exportar->request();
        
        if (!$retornobuscar) {
            throw new Exception("Erro na consulta das informações. \n {$exportar->getDescResposta()}");
        }
        if ($retornobuscar == 'The validity of the certificate has expired.') {
            throw new Exception("A validade do certificado expirou !");
        }
        if (simplexml_load_string($retornobuscar))
            return  simplexml_load_string($retornobuscar);
        return $retornobuscar; 
    }
    public function buscarCertificado($cgm)
    {
            
            $dao = new \cl_esocialenvio();
            $daoEsocialCertificado = new \cl_esocialcertificado();
            $sql = $daoEsocialCertificado->sql_query(null, "rh214_senha as senha,rh214_certificado as certificado, cgc as nrinsc, z01_nome as nmRazao", "rh214_sequencial", "rh214_cgm = $cgm");
            
            $rsReinfCertificado  = \db_query($sql);
            
            if (!$rsReinfCertificado && pg_num_rows($rsReinfCertificado) == 0) {
                throw new Exception("Certificado nao encontrado.");
            }
            $dadosCertificado = \db_utils::fieldsMemory($rsReinfCertificado, 0);
            $dadosCertificado->nmrazao = utf8_encode($dadosCertificado->nmrazao);
            $dados = $dadosCertificado;
     
            return $dados;
    }

}
