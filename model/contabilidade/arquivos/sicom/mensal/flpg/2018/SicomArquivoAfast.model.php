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

            $sSql = "   SELECT r45_regist
                        FROM afasta
                        WHERE (
                                        (DATE_PART('YEAR',r45_dtafas) = 2018 and DATE_PART('MONTH',r45_dtafas) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . ")
                                        
                                    )
                          AND r45_situac <> 5
                          AND r45_mesusu = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                        GROUP BY 1  
                        ORDER BY r45_regist ASC";

            $rsResult = db_query($sSql);//echo $sSql;db_criatabela($rsResult);

            for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                $oDados = db_utils::fieldsMemory($rsResult, $iCont);

                if($this->sDataFinal['5'] . $this->sDataFinal['6'] == 01) {

                    $sSql = "SELECT distinct r45_regist as si199_codvinculopessoa,
                      10||r45_codigo as si199_codafastamento,
                      r45_dtafas AS si199_dtinicioafastamento,     
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
                      end as si199_dscoutrosafastamentos,
                      r45_situac
                         FROM afasta
                         join rhpessoal on r45_regist = rh01_regist 
                            WHERE r45_regist = $oDados->r45_regist
                                AND 
                                (  
                                                r45_dtafas NOT IN           
                                                     (SELECT si199_dtinicioafastamento
                                                      FROM afast102018
                                                      WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                          AND si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )  
                 
                                                    and
                                        
                                                r45_dtreto NOT IN
                                                     (SELECT si199_dtretornoafastamento
                                                      FROM afast102018
                                                      WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                          AND si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )   
                                )  
                                
                                
                                AND (
                                        (DATE_PART('YEAR',r45_dtafas) = 2018 and DATE_PART('MONTH',r45_dtafas) = 01)
                                        or
                                        (DATE_PART('YEAR',r45_dtafas) = 2017 and DATE_PART('MONTH',r45_dtafas) <= 12)
                                        or
                                        (DATE_PART('YEAR',r45_dtafas) = 2016 and DATE_PART('MONTH',r45_dtafas) <= 12)
                                        or
                                        (DATE_PART('YEAR',r45_dtafas) = 2015 and DATE_PART('MONTH',r45_dtafas) <= 12)
                                        or
                                        (DATE_PART('YEAR',r45_dtafas) = 2014 and DATE_PART('MONTH',r45_dtafas) <= 12)
                                        or
                                        (DATE_PART('YEAR',r45_dtafas) = 2013 and DATE_PART('MONTH',r45_dtafas) <= 12)
                                    ) 
                                
                                AND DATE_PART('DAY',r45_dtreto) >= 1
                                AND DATE_PART('MONTH',r45_dtreto) >= 1
                                AND DATE_PART('YEAR',r45_dtreto) >= 2018
                                AND r45_situac <> 5 
                                AND rh01_instit =  " . db_getsession("DB_instit") . "
                                AND   rh01_sicom = 1
                                ";
                }else{

                    $sSql = "SELECT distinct r45_regist as si199_codvinculopessoa,
                      r45_codigo as si199_codafastamento,
                      r45_dtafas AS si199_dtinicioafastamento,     
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
                      end as si199_dscoutrosafastamentos,
                      
                      r45_situac
                      
                         FROM afasta
                         join rhpessoal on r45_regist = rh01_regist 
                            WHERE r45_regist = $oDados->r45_regist
                                AND 
                                
                                (  
                                                r45_dtafas NOT IN           
                                                     (SELECT si199_dtinicioafastamento
                                                      FROM afast102018
                                                      WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                          AND si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )  
                 
                                                    and
                                        
                                                r45_dtreto NOT IN
                                                     (SELECT si199_dtretornoafastamento
                                                      FROM afast102018
                                                      WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                          AND si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " )    
                                )  
                                
                                
                                AND (
                                        (DATE_PART('YEAR',r45_dtafas) = 2018 and DATE_PART('MONTH',r45_dtafas) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . ")
                                        
                                    ) 
                                
                                AND DATE_PART('DAY',r45_dtreto) >= 1
                                AND DATE_PART('MONTH',r45_dtreto) >= 1
                                AND DATE_PART('YEAR',r45_dtreto) >= 2018
                                AND r45_situac <> 5 
                                AND rh01_instit =  " . db_getsession("DB_instit") . "
                                AND   rh01_sicom = 1
                                ";

                }

                $rsResult2 = db_query($sSql);//echo $sSql;db_criatabela($rsResult2);exit;

                if(pg_num_rows($rsResult2) > 0) {
                    //echo db_criatabela($rsResult2);
                    if(pg_num_rows($rsResult2) == 1)
                        $oDadosAfast = db_utils::fieldsMemory($rsResult2, 0);

                    if(pg_num_rows($rsResult2) > 1) {
                        unset($oAfast);
                        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsResult2); $iCont2++) {

                            $oAfast[] = db_utils::fieldsMemory($rsResult2, $iCont2);

                            if (
                                    $oAfast[0]->si199_codvinculopessoa     == $oAfast[1]->si199_codvinculopessoa
                                and $oAfast[0]->r45_situac                 == $oAfast[1]->r45_situac
                                and $oAfast[0]->si199_dtinicioafastamento  == $oAfast[1]->si199_dtinicioafastamento
                                and $oAfast[0]->si199_dtretornoafastamento <  $oAfast[1]->si199_dtretornoafastamento
                            ){
                                $oDadosAfast = $oAfast[1];
                            }elseif (
                                $oAfast[0]->si199_codvinculopessoa         == $oAfast[1]->si199_codvinculopessoa
                                and $oAfast[0]->r45_situac                 == $oAfast[1]->r45_situac
                                and $oAfast[0]->si199_dtinicioafastamento  == $oAfast[1]->si199_dtinicioafastamento
                                and $oAfast[0]->si199_dtretornoafastamento >  $oAfast[1]->si199_dtretornoafastamento
                            ){
                                $oDadosAfast = $oAfast[0];

                            }else{
                                $oDadosAfast = db_utils::fieldsMemory($rsResult2, $iCont2);
                            }
                        }
                    }

//                    echo '<pre>';
//                    print_r($oDadosAfast);

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

                    if($oDadosAfast->si199_tipoafastamento == 99) {

                        if($oDadosAfast->r45_situac == 2)
                            $clafast->si199_dscoutrosafastamentos = 'Afastado sem remuneração';
                        if($oDadosAfast->r45_situac == 3)
                            $clafast->si199_dscoutrosafastamentos = 'Afastado acidente de trabalho +15 dias';
                        if($oDadosAfast->r45_situac == 4)
                            $clafast->si199_dscoutrosafastamentos = 'Afastado serviço militar';
                        if($oDadosAfast->r45_situac == 5)
                            $clafast->si199_dscoutrosafastamentos = 'Afastado licença gestante';
                        if($oDadosAfast->r45_situac == 6)
                            $clafast->si199_dscoutrosafastamentos = 'Afastado doença +15 dias';
                        if($oDadosAfast->r45_situac == 7)
                            $clafast->si199_dscoutrosafastamentos = 'Licença sem vencimento, cessão sem ônus';
                        if($oDadosAfast->r45_situac == 8)
                            $clafast->si199_dscoutrosafastamentos = 'Afastado doença +30 dias';

                    }else{
                        $clafast->si199_dscoutrosafastamentos = $oDadosAfast->si199_dscoutrosafastamentos;
                    }

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
                      (SELECT DISTINCT si199_codafastamento
                  FROM afast102018
                  WHERE si199_codvinculopessoa = $oDados->r45_regist) as codafastamento,
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
                                                         and si199_codafastamento = (SELECT DISTINCT si199_codafastamento
                                                                                      FROM afast102018
                                                                                      WHERE si199_codvinculopessoa = $oDados->r45_regist)
                                                         and si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                                                         order by si199_codafastamento desc limit 1)
                                
                                                     AND
                                                     
                                                     r45_dtreto < (SELECT si199_dtretornoafastamento
                                                     FROM afast102018
                                                     WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                         and si199_codafastamento = (SELECT DISTINCT si199_codafastamento
                                                                                      FROM afast102018
                                                                                      WHERE si199_codvinculopessoa = $oDados->r45_regist
                                                                                      order by si199_codafastamento desc limit 1)
                                                         and si199_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " limit 1 )  
                                )
                                
                                AND r45_regist::varchar||r45_dtreto not in (select si200_codvinculopessoa::varchar||si200_dtterminoafastamento from afast202018 )
                                
                                AND DATE_PART('DAY',r45_dtreto) >= 2
                                AND DATE_PART('MONTH',r45_dtreto) >= 1
                                AND DATE_PART('YEAR',r45_dtreto) = 2018
                                AND r45_situac <> 5";

                $rsResult3 = db_query($sSql);//echo $sSql;db_criatabela($rsResult3);exit;
                //echo $sSql;db_criatabela($rsResult3);

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsResult3); $iCont3++) {

                    $oDadosAfast2 = db_utils::fieldsMemory($rsResult3, $iCont3);

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
