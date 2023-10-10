<?php

use ECidade\Financeiro\Efdreinf\Efdreinf\Efdreinf;
use ECidade\Financeiro\Efdreinf\ModeloBaseEFDREINF;

use \ECidade\V3\Extension\Registry;

require_once("src/Financeiro/Efdreinf/Efdreinf.php");
/**
 * Classe responsvel por montar as informaes do EFD Reinf R4099
 *
 * @package  ECidade\model\EfdRreinf
 * @author   Dayvison Nunes
 */
class EFDReinfR4000 extends ModeloBaseEFDREINF
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados,$dadosCgm,$cgc)
    {
        parent::__construct($dados,$dadosCgm,$cgc); 
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
        
        // Use json_encode para transformar o array em JSON
        $aDadosAPI = json_encode($aDadosAPI, JSON_PRETTY_PRINT);
        $oDadosAPI = $aDadosAPI;

        return $oDadosAPI;
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
                "tpAmb" => $this->dadosCGM->sAmbiente, // Substitua por sua variável $tpAmb
                "procEmi" => "1", // Substitua por sua variável $procEmi
                "verProc" => "2.01.02" // Substitua por sua variável $verProc
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
                "tpAmb" => $this->dadosCGM->sAmbiente, // Substitua por sua variável $tpAmb
                "procEmi" => "1", // Substitua por sua variável $procEmi
                "verProc" => "2.01.02" // Substitua por sua variável $verProc
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
