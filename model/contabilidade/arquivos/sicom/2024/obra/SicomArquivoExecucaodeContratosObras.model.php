<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/contabilidade/arquivos/sicom/2024/obra/geradores/gerarEXEOBRAS.php");
require_once("classes/db_exeobras102024_classe.php");
require_once("classes/db_exeobras202024_classe.php");

/**
 * Execu��o dos Contratos de Obras e Servi�os de Engenharia
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
        $exeobras102024 = new cl_exeobras102024();
        $exeobras202024 = new cl_exeobras202024();

        /**
         * excluir informacoes do mes selecioado para evitar duplicacao de registros
         */

        /**
         * registro 10 exclus�o
         */
        $result = db_query($exeobras102024->sql_query(null, "*", null, "si197_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si197_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $exeobras102024->excluir(null, "si197_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si197_instit=" . db_getsession("DB_instit"));
            if ($exeobras102024->erro_status == 0) {
                throw new Exception($exeobras102024->erro_msg);
            }
        }

        /**
         * registro 20 exclus�o
         */
        $result = db_query($exeobras202024->sql_query(null, "*", null, "si204_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si204_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $exeobras202024->excluir(null, "si204_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si204_instit=" . db_getsession("DB_instit"));
            if ($exeobras202024->erro_status == 0) {
                throw new Exception($exeobras202024->erro_msg);
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
           WHERE db01_coddepto=l20_codepartamento
               AND db01_anousu=" . db_getsession("DB_anousu") . "
           LIMIT 1) AS si197_codunidadesubresp,
             ac16_numeroacordo AS si197_nrocontrato,
             l20_edital as si197_nroprocessolicitatorio,
             l20_anousu as si197_exerciciolicitacao,
             ac16_anousu AS si197_exerciciocontrato,
             obr01_numeroobra AS si197_codobra,
             ac16_objeto AS si197_objeto,
             obr01_linkobra AS si197_linkobra,
            CASE
                WHEN l20_tipojulg = 1 THEN '1'
                ELSE obr08_liclicitemlote
            END AS si197_nrolote,
            ac16_tipoorigem,
            CASE
                WHEN LENGTH(cgm.z01_cgccpf) = 11 THEN 2
                ELSE 3
             END AS si197_tipodocumento,
      FROM acordo
      INNER JOIN cgm on z01_numcgm = ac16_contratado
      INNER JOIN liclicita ON l20_codigo = ac16_licitacao
      INNER JOIN liclicitem on l21_codliclicita = l20_codigo
      INNER JOIN liclicitemlote on l04_liclicitem = l21_codigo
      INNER JOIN licobras ON obr01_licitacao = l20_codigo
      INNER JOIN cflicita ON l20_codtipocom = l03_codigo
      INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
      LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
      left join acordoobra on obr08_acordo = ac16_sequencial
      WHERE si09_tipoinstit in (1,2,3,4,5,6,8,9)
          AND ac16_instit = ".db_getsession("DB_instit")."
          AND l03_pctipocompratribunal NOT IN (100,101,102,103)
          AND DATE_PART('YEAR',acordo.ac16_dataassinatura)= " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',acordo.ac16_dataassinatura)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and
          case
            when l20_tipojulg = 3
              then obr08_liclicitemlote = obr01_licitacaolote
            else 1 = 1
        end";
        $rsResult10 = db_query($sql);//echo $sql;db_criatabela($rsResult10);exit;

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      $clexeobras102024 = new cl_exeobras102024();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clexeobras102024->si197_tiporegistro = 10;
      $clexeobras102024->si197_codorgao = $oDados10->si197_codorgao;
      $clexeobras102024->si197_codunidadesub = $oDados10->si197_codunidadesub;
      $clexeobras102024->si197_nrocontrato = $oDados10->si197_nrocontrato;
      $clexeobras102024->si197_tipodocumento = $oDados10->si197_tipodocumento;
      $clexeobras102024->si197_exerciciocontrato = $oDados10->si197_exerciciocontrato;
      if($oDados10->ac16_tipoorigem){
        $clexeobras102024->si197_contdeclicitacao = $oDados10->ac16_tipoorigem;
      }else{
        $clexeobras102024->si197_contdeclicitacao = null;
      }
      $clexeobras102024->si197_exerciciolicitacao = $oDados10->si197_exerciciolicitacao;
      $clexeobras102024->si197_nroprocessolicitatorio = $oDados10->si197_nroprocessolicitatorio;
      $clexeobras102024->si197_codunidadesubresp = $oDados10->si197_codunidadesubresp;
      $clexeobras102024->si197_nrolote = $oDados10->si197_nrolote;
      $clexeobras102024->si197_codobra = $oDados10->si197_codobra;
      $clexeobras102024->si197_objeto = $this->removeCaracteres($oDados10->si197_objeto);
      $clexeobras102024->si197_linkobra = $oDados10->si197_linkobra;
      $clexeobras102024->si197_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clexeobras102024->si197_instit = db_getsession("DB_instit");
      $clexeobras102024->incluir(null);

            if ($clexeobras102024->erro_status == 0) {
                throw new Exception($clexeobras102024->erro_msg);
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
           WHERE db01_coddepto=l20_codepartamento
               AND db01_anousu=" . db_getsession("DB_anousu") . "
           LIMIT 1) AS si204_codunidadesubresp,
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
             obr01_linkobra AS si204_linkobra,
             ac16_tipoorigem
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
            $clexeobras202024 = new cl_exeobras202024();
            $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

            $clexeobras202024->si204_tiporegistro = 20;
            $clexeobras202024->si204_codorgao = $oDados20->si204_codorgao;
            $clexeobras202024->si204_codunidadesub = $oDados20->si204_codunidadesub;
            $clexeobras202024->si204_nrocontrato = $oDados20->si204_nrocontrato;
            $clexeobras202024->si204_exerciciocontrato = $oDados20->si204_exerciciocontrato;
            if($oDados20->ac16_tipoorigem){
                $clexeobras202024->si204_contdeclicitacao = $oDados20->ac16_tipoorigem;
            }else{
                $clexeobras202024->si204_contdeclicitacao = null;
            }
            $clexeobras202024->si204_exercicioprocesso = $oDados20->si204_exercicioprocesso;
            $clexeobras202024->si204_nroprocesso = $oDados20->si204_nroprocesso;
            $clexeobras202024->si204_codunidadesubresp = $oDados20->si204_codunidadesubresp;
            $clexeobras202024->si204_tipoprocesso = $oDados20->si204_tipoprocesso;
            $clexeobras202024->si204_codobra = $oDados20->si204_codobra;
            $clexeobras202024->si204_objeto = $this->removeCaracteres($oDados20->si204_objeto);
            $clexeobras202024->si204_linkobra = $oDados20->si204_linkobra;
            $clexeobras202024->si204_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clexeobras202024->si204_instit = db_getsession("DB_instit");
            $clexeobras202024->incluir(null);

            if ($clexeobras202024->erro_status == 0) {
                throw new Exception($clexeobras202024->erro_msg);
            }
        }

        $oGerarEXEOBRAS = new gerarEXEOBRAS();
        $oGerarEXEOBRAS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarEXEOBRAS->gerarDados();
    }
}
