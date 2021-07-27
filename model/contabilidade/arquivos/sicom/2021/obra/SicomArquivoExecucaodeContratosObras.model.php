<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/contabilidade/arquivos/sicom/2021/obra/geradores/gerarEXEOBRAS.php");
require_once("classes/db_exeobras102021_classe.php");
require_once("classes/db_exeobras202021_classe.php");

/**
 * Execução dos Contratos de Obras e Serviços de Engenharia
 * @author Mario Junior
 * @package Obras
 */

class SicomArquivoExecucaodeContratosObras extends SicomArquivoBase implements iPadArquivoBaseCSV
{
    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'EXEOBRAS';

    /**
     *
     * Construtor da classe
     */
    public function __construct()
    {

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
    public function getCampos()
    {
        $aElementos[10] = array(
            "tipoRegistro",
            "codOrgao",
            "codUnidadeSub",
            "nroContrato",
            "exercicioContrato",
            "codObra",
            "Objeto",
            "linkObra"
        );
        return $aElementos;
    }

    public function gerarDados()
    {
        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $exeobras102021 = new cl_exeobras102021();
        $exeobras202021 = new cl_exeobras202021();

        /**
         * excluir informacoes do mes selecioado para evitar duplicacao de registros
         */

        /**
         * registro 10 exclusão
         */
        $result = db_query($exeobras102021->sql_query(null, "*", null, "si197_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si197_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $exeobras102021->excluir(null, "si197_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si197_instit=" . db_getsession("DB_instit"));
            if ($exeobras102021->erro_status == 0) {
                throw new Exception($exeobras102021->erro_msg);
            }
        }

        /**
         * registro 20 exclusão
         */
        $result = db_query($exeobras202021->sql_query(null, "*", null, "si204_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si204_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $exeobras202021->excluir(null, "si204_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si204_instit=" . db_getsession("DB_instit"));
            if ($exeobras202021->erro_status == 0) {
                throw new Exception($exeobras202021->erro_msg);
            }
        }
        /**
         * registro 10
         */

        $sql = "SELECT DISTINCT 10 AS si197_tiporegistro,
             infocomplementaresinstit.si09_codorgaotce AS si197_codorgao,
          (SELECT CASE
                      WHEN o41_subunidade != 0
                           OR NOT NULL THEN lpad((CASE
                                                      WHEN o40_codtri = '0'
                                                           OR NULL THEN o40_orgao::varchar
                                                      ELSE o40_codtri
                                                  END),2,0)||lpad((CASE
                                                                       WHEN o41_codtri = '0'
                                                                            OR NULL THEN o41_unidade::varchar
                                                                       ELSE o41_codtri
                                                                   END),3,0)||lpad(o41_subunidade::integer,3,0)
                      ELSE lpad((CASE
                                     WHEN o40_codtri = '0'
                                          OR NULL THEN o40_orgao::varchar
                                     ELSE o40_codtri
                                 END),2,0)||lpad((CASE
                                                      WHEN o41_codtri = '0'
                                                           OR NULL THEN o41_unidade::varchar
                                                      ELSE o41_codtri
                                                  END),3,0)
                  END AS codunidadesub
           FROM db_departorg
           JOIN infocomplementares ON si08_anousu = db01_anousu
           AND si08_instit = " . db_getsession("DB_instit") . "
           JOIN orcunidade ON db01_orgao=o41_orgao
           AND db01_unidade=o41_unidade
           AND db01_anousu = o41_anousu
           JOIN orcorgao ON o40_orgao = o41_orgao
           AND o40_anousu = o41_anousu
           WHERE db01_coddepto=ac16_deptoresponsavel
               AND db01_anousu=" . db_getsession("DB_anousu") . "
           LIMIT 1) AS si197_codunidadesub,
             ac16_numeroacordo AS si197_nrocontrato,
             l20_edital as si197_nroprocessolicitatorio,
             l20_anousu as si197_exerciciolicitacao,
             ac16_anousu AS si197_exerciciocontrato,
             obr01_numeroobra AS si197_codobra,
             ac16_objeto AS si197_objeto,
             obr01_linkobra AS si197_linkobra,
            CASE
                WHEN l20_tipojulg = 1 THEN '1'
                    ELSE l04_codigo
                END AS si197_nrolote      
      FROM acordo
      INNER JOIN liclicita ON l20_codigo = ac16_licitacao
      inner join liclicitem on l21_codliclicita = l20_codigo
      inner join liclicitemlote on l04_liclicitem = l21_codigo
      INNER JOIN licobras ON obr01_licitacao = l20_codigo
      INNER JOIN cflicita ON l20_codtipocom = l03_codigo
      INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
      LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
      WHERE si09_tipoinstit in (1,2,3,4,5,6,8,9)
          AND ac16_instit = ".db_getsession("DB_instit")."
          AND l03_pctipocompratribunal NOT IN (100,101,102,103)
          AND DATE_PART('YEAR',acordo.ac16_dataassinatura)= " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',acordo.ac16_dataassinatura)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $rsResult10 = db_query($sql);//echo $sql;db_criatabela($rsResult10);exit;

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      $clexeobras102021 = new cl_exeobras102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clexeobras102021->si197_tiporegistro = 10;
      $clexeobras102021->si197_codorgao = $oDados10->si197_codorgao;
      $clexeobras102021->si197_codunidadesub = $oDados10->si197_codunidadesub;
      $clexeobras102021->si197_nrocontrato = $oDados10->si197_nrocontrato;
      $clexeobras102021->si197_exerciciocontrato = $oDados10->si197_exerciciocontrato;
      $clexeobras102021->si197_exerciciolicitacao = $oDados10->si197_exerciciolicitacao;
      $clexeobras102021->si197_nroprocessolicitatorio = $oDados10->si197_nroprocessolicitatorio;
      $clexeobras102021->si197_nrolote = $oDados10->si197_nrolote;
      $clexeobras102021->si197_codobra = $oDados10->si197_codobra;
      $clexeobras102021->si197_objeto = $oDados10->si197_objeto;
      $clexeobras102021->si197_linkobra = $oDados10->si197_linkobra;
      $clexeobras102021->si197_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clexeobras102021->si197_instit = db_getsession("DB_instit");
      $clexeobras102021->incluir(null);

            if ($clexeobras102021->erro_status == 0) {
                throw new Exception($clexeobras102021->erro_msg);
            }
        }

        /**
         * registro 20
         */

        $sql = "SELECT DISTINCT 20 AS si204_tiporegistro,
             infocomplementaresinstit.si09_codorgaotce AS si204_codorgao,
          (SELECT CASE
                      WHEN o41_subunidade != 0
                           OR NOT NULL THEN lpad((CASE
                                                      WHEN o40_codtri = '0'
                                                           OR NULL THEN o40_orgao::varchar
                                                      ELSE o40_codtri
                                                  END),2,0)||lpad((CASE
                                                                       WHEN o41_codtri = '0'
                                                                            OR NULL THEN o41_unidade::varchar
                                                                       ELSE o41_codtri
                                                                   END),3,0)||lpad(o41_subunidade::integer,3,0)
                      ELSE lpad((CASE
                                     WHEN o40_codtri = '0'
                                          OR NULL THEN o40_orgao::varchar
                                     ELSE o40_codtri
                                 END),2,0)||lpad((CASE
                                                      WHEN o41_codtri = '0'
                                                           OR NULL THEN o41_unidade::varchar
                                                      ELSE o41_codtri
                                                  END),3,0)
                  END AS codunidadesub
           FROM db_departorg
           JOIN infocomplementares ON si08_anousu = db01_anousu
           AND si08_instit = " . db_getsession("DB_instit") . "
           JOIN orcunidade ON db01_orgao=o41_orgao
           AND db01_unidade=o41_unidade
           AND db01_anousu = o41_anousu
           JOIN orcorgao ON o40_orgao = o41_orgao
           AND o40_anousu = o41_anousu
           WHERE db01_coddepto=ac16_deptoresponsavel
               AND db01_anousu=" . db_getsession("DB_anousu") . "
           LIMIT 1) AS si204_codunidadesub,
             ac16_numeroacordo AS si204_nrocontrato,
             ac16_anousu AS si204_exerciciocontrato,
             l20_anousu AS si204_exercicioprocesso,
             l20_edital as si204_nroprocesso,
             case when l03_pctipocompratribunal = 101 then 1
             when l03_pctipocompratribunal = 100 then 2
             when l03_pctipocompratribunal = 102 then 3
             when l03_pctipocompratribunal = 103 then 4 end AS si204_tipoprocesso,
             obr01_numeroobra AS si204_codobra,
             ac16_objeto AS si204_objeto,
             obr01_linkobra AS si204_linkobra
      FROM acordo
      INNER JOIN liclicita ON l20_codigo = ac16_licitacao
      INNER JOIN licobras ON obr01_licitacao = l20_codigo
      INNER JOIN cflicita ON l20_codtipocom = l03_codigo
      INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
      LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
      WHERE si09_tipoinstit in (1,2,3,4,5,6,8,9)
          and l03_pctipocompratribunal in (100,101,102,103)
          AND ac16_instit = ".db_getsession("DB_instit")."
          AND DATE_PART('YEAR',acordo.ac16_dataassinatura)= " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',acordo.ac16_dataassinatura)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $rsResult20 = db_query($sql);

        for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
            $clexeobras202021 = new cl_exeobras202021();
            $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

            $clexeobras202021->si204_tiporegistro = 20;
            $clexeobras202021->si204_codorgao = $oDados20->si204_codorgao;
            $clexeobras202021->si204_codunidadesub = $oDados20->si204_codunidadesub;
            $clexeobras202021->si204_nrocontrato = $oDados20->si204_nrocontrato;
            $clexeobras202021->si204_exerciciocontrato = $oDados20->si204_exerciciocontrato;
            $clexeobras202021->si204_exercicioprocesso = $oDados20->si204_exercicioprocesso;
            $clexeobras202021->si204_nroprocesso = $oDados20->si204_nroprocesso;
            $clexeobras202021->si204_tipoprocesso = $oDados20->si204_tipoprocesso;
            $clexeobras202021->si204_codobra = $oDados20->si204_codobra;
            $clexeobras202021->si204_objeto = $oDados20->si204_objeto;
            $clexeobras202021->si204_linkobra = $oDados20->si204_linkobra;
            $clexeobras202021->si204_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clexeobras202021->si204_instit = db_getsession("DB_instit");
            $clexeobras202021->incluir(null);

            if ($clexeobras202021->erro_status == 0) {
                throw new Exception($clexeobras202021->erro_msg);
            }
        }

        $oGerarEXEOBRAS = new gerarEXEOBRAS();
        $oGerarEXEOBRAS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarEXEOBRAS->gerarDados();
    }
}
