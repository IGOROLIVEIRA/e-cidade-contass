<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_afast102018_classe.php");
require_once ("classes/db_afast202018_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2018/flpg/GerarAFAST.model.php");


/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class SicomArquivoAfast extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 147;

    /**
     *
     * NOme do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'AFAST';

    /**
     *
     * Contrutor da classe
     */
    public function __construct() {

    }

    /**
     * Retorna o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout(){
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos(){

        $aElementos  = array(

        );
        return $aElementos;
    }

    /**
     * selecionar os dados de indentificacao da remessa pra gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $clafast = new cl_afast102018();
        $clafast20 = new cl_afast202018();

        /**
         * inserir informacoes no banco de dados
         */
        db_inicio_transacao();
        $result = $clafast->sql_record($clafast->sql_query(NULL, "*", NULL, "si199_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si199_inst = " . db_getsession("DB_instit")));

        if (pg_num_rows($result) > 0) {
            $clafast->excluir(NULL, "si199_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si199_inst = " . db_getsession("DB_instit"));
            if ($clafast->erro_status == 0) {
                throw new Exception($clafast->erro_msg);
            }
        }

        $result = $clafast20->sql_record($clafast20->sql_query(NULL, "*", NULL, "si200_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si200_inst = " . db_getsession("DB_instit")));

        if (pg_num_rows($result) > 0) {
            $clafast20->excluir(NULL, "si200_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si200_inst = " . db_getsession("DB_instit"));
            if ($clafast20->erro_status == 0) {
                throw new Exception($clafast20->erro_msg);
            }
        }


        $sSql = "select r45_regist
                     from afasta 
WHERE DATE_PART('DAY',r45_dtreto) >= 2
    AND DATE_PART('MONTH',r45_dtreto) >= 1
    AND DATE_PART('YEAR',r45_dtreto) = 2018
    AND r45_situac <> 5    
    group by 1";

        $rsResult = db_query($sSql);//db_criatabela($rsResult);exit;

        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oDados = db_utils::fieldsMemory($rsResult, $iCont);

            $sSql = "SELECT distinct r45_regist as si199_codvinculopessoa,
                  10||r45_regist as si199_codafastamento,
                  
                  case when r45_dtreto >
				             (SELECT si199_dtretornoafastamento
				              FROM afast102018
				              WHERE si199_codvinculopessoa = $oDados->r45_regist
				                  AND si199_mes < 02 limit 1) then (SELECT si199_dtretornoafastamento+1
															              FROM afast102018
															              WHERE si199_codvinculopessoa = $oDados->r45_regist
															                  AND si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " limit 1)
				     else r45_dtafas
				     end as si199_dtinicioafastamento,        
                  
                  
                  r45_dtreto as si199_dtretornoafastamento,
                  case when r45_situac = 4 and r45_codafa <> 'W' then 2 
                  when r45_situac in (2,7) and r45_codafa <> 'W' then 3
                  when r45_codafa = 'W' then 4
                  else 99
                  end as si199_tipoafastamento,
                  
                  case when r45_situac = 4 and r45_codafa <> 'W' then '' 
                  when r45_situac in (2,7) and r45_codafa <> 'W' then ''
                  when r45_codafa = 'W' then ''
                  else r45_obs
                  end as si199_dscoutrosafastamentos
                     FROM afasta
                     join rhpessoal on r45_regist = rh01_regist 
                        WHERE r45_regist = $oDados->r45_regist
                            AND 
                            (  r45_regist NOT IN
                                               (SELECT si199_codvinculopessoa
                                                FROM afast102018
                                                WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                    AND si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " ) or r45_regist IN
                                                (SELECT si199_codvinculopessoa
                                                 FROM afast102018
                                                 WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                     and si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )

                                                    and

                                                 r45_dtreto > (SELECT si199_dtretornoafastamento
                                                 FROM afast102018
                                                 WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                     and si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )  
                            )  
                            AND DATE_PART('DAY',r45_dtreto) >= 2
                            AND DATE_PART('MONTH',r45_dtreto) >= 1
                            AND DATE_PART('YEAR',r45_dtreto) = 2018
                            AND r45_anousu = 2018
                            AND r45_situac <> 5 
                            AND rh01_instit =  " . db_getsession("DB_instit") . "
                            
                            ";

            $rsResult2 = db_query($sSql);
            $oDadosAfast = db_utils::fieldsMemory($rsResult2, 0);//echo $sSql;db_criatabela($rsResult2);

            if (pg_num_rows($rsResult2) > 0) {

                $clafast = new cl_afast102018();

                $clafast->si199_tiporegistro = 10;
                $clafast->si199_codvinculopessoa = $oDadosAfast->si199_codvinculopessoa;
                $clafast->si199_codafastamento = $oDadosAfast->si199_codafastamento;
                $clafast->si199_dtinicioafastamento = $oDadosAfast->si199_dtinicioafastamento;
                $clafast->si199_dtretornoafastamento = $oDadosAfast->si199_dtretornoafastamento;
                $clafast->si199_tipoafastamento = $oDadosAfast->si199_tipoafastamento;

                $oDadosAfast->si199_dscoutrosafastamentos = str_replace(";", " ", $oDadosAfast->si199_dscoutrosafastamentos); //usei essas 3 formas que achei
                $oDadosAfast->si199_dscoutrosafastamentos = str_replace("\n", " ", $oDadosAfast->si199_dscoutrosafastamentos); //usei essas 3 formas que achei
                $oDadosAfast->si199_dscoutrosafastamentos = str_replace("\r", " ", $oDadosAfast->si199_dscoutrosafastamentos); //na net pra tentar eliminar a quebra
                $oDadosAfast->si199_dscoutrosafastamentos = preg_replace('/\s/', ' ', $oDadosAfast->si199_dscoutrosafastamentos);//de linha, mas até o momento sem sucesso :/

                $clafast->si199_dscoutrosafastamentos = $oDadosAfast->si199_dscoutrosafastamentos;
                $clafast->si199_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $clafast->si199_inst = db_getsession("DB_instit");


                $clafast->incluir(null);
                if ($clafast->erro_status == 0) {
                    throw new Exception($clafast->erro_msg);
                }


            }

        }

        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oDados = db_utils::fieldsMemory($rsResult, $iCont);

            $sSql = "SELECT distinct r45_regist as codvinculopessoa,
                  10||r45_regist as codafastamento,
                  r45_dtafas as dtinicioafastamento,
                  r45_dtreto as dtretornoafastamento,
                  case when r45_situac = 4 and r45_codafa <> 'W' then 2 
                  when r45_situac in (2,7) and r45_codafa <> 'W' then 3
                  when r45_codafa = 'W' then 4
                  else 99
                  end as tipoafastamento,
                  
                  case when r45_situac = 4 and r45_codafa <> 'W' then '' 
                  when r45_situac in (2,7) and r45_codafa <> 'W' then ''
                  when r45_codafa = 'W' then ''
                  else r45_obs
                  end as dscoutrosafastamentos
                     FROM afasta 
                        WHERE r45_regist = $oDados->r45_regist
                            AND 
                            (
                                          r45_regist IN
                                                (SELECT si199_codvinculopessoa
                                                 FROM afast102018
                                                 WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                     and si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . ")

                                                    and

                                                 r45_dtreto < (SELECT si199_dtretornoafastamento
                                                 FROM afast102018
                                                 WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                     and si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )  
                            )  
                            AND DATE_PART('DAY',r45_dtreto) >= 2
                            AND DATE_PART('MONTH',r45_dtreto) >= 1
                            AND DATE_PART('YEAR',r45_dtreto) = 2018
                            AND r45_situac <> 5";

            $rsResult3 = db_query($sSql);//echo $sSql;db_criatabela($rsResult3);

            for ($iCont2 = 0; $iCont2 < pg_num_rows($rsResult3); $iCont2++) {

                $oDadosAfast2 = db_utils::fieldsMemory($rsResult3, $iCont2);

                if ( pg_num_rows($rsResult3) > 0 ) {

                    $clafast = new cl_afast202018();

                    $clafast->si200_tiporegistro = 20;
                    $clafast->si200_codvinculopessoa = $oDadosAfast2->codvinculopessoa;
                    $clafast->si200_codafastamento = $oDadosAfast2->codafastamento;
                    $clafast->si200_dtterminoafastamento = $oDadosAfast2->dtretornoafastamento;
                    $clafast->si200_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clafast->si200_inst = db_getsession("DB_instit");

                    $clafast->incluir(null);
                    if ($clafast->erro_status == 0) {
                        throw new Exception($clafast->erro_msg);
                    }

                }
            }


            db_fim_transacao();



        }

        $oGerarAfast = new GerarAFAST();
        $oGerarAfast->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarAfast->gerarDados();

    }

}
