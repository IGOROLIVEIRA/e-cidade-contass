<?php
  //ini_set("display_errors", true);
  require_once('classes/db_empempenho_classe.php');
  require_once("classes/db_empenhosexcluidos_classe.php");
  require_once("libs/db_stdlib.php");
  require_once("libs/db_utils.php");
  require_once('libs/db_app.utils.php');
  require_once("libs/db_conecta.php");
  require_once("libs/db_sessoes.php");
  require_once("libs/JSON.php");
  require_once("std/db_stdClass.php");

  $oEmpenho = new cl_empempenho;

  $oJson             = new services_json();
  $oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));

  $oErro             = new stdClass();

  $oRetorno          = new stdClass();
  $oRetorno->status  = 1;
  $oRetorno->message = 1;
  $oDados            = array();

  switch($oParam->exec) {

      case "insereEmpenhoExcluido" :

        $oDados = getEmpenhosAnulados($oParam->iEmpenho, $oParam->iInstit);

        foreach ($oDados as $oDado) {
          try {

            $oEmpenhoExcluido = new cl_empenhosexcluidos;
            $oEmpenhoExcluido->e290_e60_numemp  = $oDado->e60_numemp;
            $oEmpenhoExcluido->e290_e60_codemp  = $oDado->e60_codemp;
            $oEmpenhoExcluido->e290_e60_anousu  = $oDado->e60_anousu;
            $oEmpenhoExcluido->e290_e60_vlremp  = $oDado->e60_vlremp;
            $oEmpenhoExcluido->e290_e60_emiss   = $oDado->e60_emiss;
            $oEmpenhoExcluido->e290_z01_numcgm  = $oDado->z01_numcgm;
            $oEmpenhoExcluido->e290_z01_nome    = $oDado->z01_nome;
            $oEmpenhoExcluido->e290_id_usuario  = db_getsession('DB_id_usuario');
            $oEmpenhoExcluido->e290_nomeusuario = $oParam->iNome;
            $oEmpenhoExcluido->e290_dtexclusao  = date("Y-m-d", db_getsession("DB_datausu"));
            $oEmpenhoExcluido->incluir(null);

            if ($oEmpenhoExcluido->erro_status != 1) {
              throw new Exception($oEmpenhoExcluido->erro_msg);
            }

             $resultado = db_query("

                BEGIN;

                CREATE TEMP TABLE data_final ON COMMIT DROP AS
                SELECT * FROM condataconf
                WHERE c99_anousu = ".date("Y-m-d", db_getsession("DB_datausu"))."
                AND c99_instit = ".db_getsession('DB_instit').";

                UPDATE condataconf
                SET c99_data = '".date("Y-m-d", db_getsession("DB_datausu"))."'
                WHERE c99_anousu = ".db_getsession("DB_datausu")."
                AND c99_instit = ".db_getsession('DB_instit').";

                CREATE TEMPORARY TABLE w_lancamentos ON COMMIT DROP AS
                SELECT c70_codlan AS lancam,
                       c75_numemp AS empenho
                FROM conlancam
                JOIN conlancamemp ON c70_codlan = c75_codlan
                WHERE c75_numemp = ".$oDado->e60_numemp.";

                 CREATE TEMP TABLE empenhos ON COMMIT DROP AS
                SELECT * FROM empempenho
                WHERE e60_anousu = ".db_getsession("DB_datausu")." 
                  AND e60_numemp = ".$oDado->e60_numemp.";

                CREATE TEMP TABLE autoriza ON COMMIT DROP AS
                     (SELECT * FROM empempaut
                      WHERE e61_numemp IN
                       (SELECT e60_numemp FROM empenhos));
    

                -- ## EXCLUSÃO DOS LANÇAMENTOS DOS EMPENHOS

                DELETE
                FROM conlancamcgm
                WHERE c76_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamemp
                WHERE c75_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamdot
                WHERE c73_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamcompl
                WHERE c72_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamdoc
                WHERE c71_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM contacorrentedetalheconlancamval
                WHERE c28_conlancamval IN
                    (SELECT c69_sequen FROM conlancamval
                     WHERE c69_codlan IN
                        (SELECT lancam
                         FROM w_lancamentos));

                DELETE
                FROM conlancamval
                WHERE c69_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamele
                WHERE c67_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamnota
                WHERE c66_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancampag
                WHERE c82_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamord
                WHERE c80_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamcorgrupocorrente
                WHERE c23_conlancam IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM pagordemdescontolanc
                WHERE e33_conlancam IN
                    (SELECT lancam
                     FROM w_lancamentos);


                DELETE
                FROM conlancamsup
                WHERE c79_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamconcarpeculiar
                WHERE c08_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancaminstit
                WHERE c02_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamordem
                WHERE c03_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancamacordo
                WHERE c87_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                DELETE
                FROM conlancam
                WHERE c70_codlan IN
                    (SELECT lancam
                     FROM w_lancamentos);

                -- ##EXCLUSÃO DOS EMPENHOS

                DELETE
                FROM empelemento
                WHERE e64_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empempaut
                WHERE e61_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empempenhonl
                WHERE e68_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empemphist
                WHERE e63_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empanuladoitem
                WHERE e37_empanulado IN
                    (SELECT e94_codanu
                     FROM empanulado
                     WHERE e94_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM empempitem
                WHERE e62_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empanuladoele
                WHERE e95_codanu IN
                    (SELECT e94_codanu
                     FROM empanulado
                     WHERE e94_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM empanulado
                WHERE e94_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empord
                WHERE e82_codord IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM pagordemnota
                WHERE e71_codord IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM pagordemele
                WHERE e53_codord IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM cairetordem
                WHERE k32_ordpag IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM issplanitop
                WHERE q96_pagordem IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM retencaoempagemov
                WHERE e27_retencaoreceitas IN
                    (SELECT e23_sequencial
                     FROM retencaoreceitas
                     WHERE e23_retencaopagordem IN
                         (SELECT e20_sequencial
                          FROM retencaopagordem
                          WHERE e20_pagordem IN
                              (SELECT e50_codord
                               FROM pagordem
                               WHERE e50_numemp IN
                                   (SELECT empenho
                     FROM w_lancamentos))));

                DELETE
                FROM retencaoreceitas
                WHERE e23_retencaopagordem IN
                    (SELECT e20_sequencial
                     FROM retencaopagordem
                     WHERE e20_pagordem IN
                         (SELECT e50_codord
                          FROM pagordem
                          WHERE e50_numemp IN
                              (SELECT empenho
                     FROM w_lancamentos)));

                DELETE
                FROM retencaopagordem
                WHERE e20_pagordem IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM pagordemdesconto
                WHERE e34_codord IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE
                FROM pagordem
                WHERE e50_codord IN
                    (SELECT e50_codord
                     FROM pagordem
                     WHERE e50_numemp IN
                         (SELECT empenho
                     FROM w_lancamentos));

                DELETE FROM contacorrentesaldo
                    WHERE c29_contacorrentedetalhe IN
                        (SELECT c19_sequencial
                          FROM contacorrentedetalhe
                          WHERE c19_numemp IN
                            (SELECT empenho
                     FROM w_lancamentos));

                DELETE FROM contacorrentedetalhe
                    WHERE c19_numemp IN
                          (SELECT empenho
                     FROM w_lancamentos);

                DELETE FROM rhempenhofolhaempenho
                    WHERE rh76_numemp IN
                          (SELECT empenho
                     FROM w_lancamentos);

                DELETE FROM empempenhocontrato
                    WHERE e100_numemp IN
                          (SELECT empenho
                     FROM w_lancamentos);

                DELETE
                FROM empempenho
                WHERE e60_numemp IN
                    (SELECT empenho
                     FROM w_lancamentos);

                -- ## EXCLUSÃO DAS AUTORIZAÇÕES DOS EMPENHOS

                DELETE
                FROM empautidot
                WHERE e56_autori IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM empautitempcprocitem
                WHERE e73_autori IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM acordoitemexecutadoempautitem
                WHERE ac19_autori IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM empautitem
                WHERE e55_autori IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM empempaut
                WHERE e61_autori IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM empauthist
                WHERE e57_autori IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM acordoempautoriza
                WHERE ac45_empautoriza IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM protempautoriza
                WHERE p102_autorizacao IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM empautorizaprocesso
                WHERE e150_empautoriza IN
                (SELECT e61_autori
                FROM autoriza);

                DELETE
                FROM empautoriza
                WHERE e54_autori IN
                (SELECT e61_autori
                FROM autoriza);

                -- # RETORNA A DATA AO FINAL DAS EXCLUSÕES

                UPDATE condataconf
                SET c99_data = (SELECT data_final.c99_data FROM data_final)
                WHERE c99_anousu = ".db_getsession("DB_datausu")."
                    AND c99_instit = ".db_getsession('DB_instit').";

                COMMIT;
              ");

              if ($resultado == false) {
                throw new Exception ("Erro ao realizar exclusão do empenho!");
              }


          } catch (Exception $eExeption) {
            //$oRetorno->message  = urlencode(str_replace("\\n","\n",$eExeption->getMessage()));
            $oRetorno->message = utf8_encode(pg_last_error());
            $oRetorno->status   = 2;
          }

        }
      break;

      case "getVerify" :
        try {
            $sql = "(SELECT distinct m52_numemp FROM matordemitem where m52_numemp = $oParam->iEmpenho
                UNION
            SELECT distinct e69_numemp FROM empnota where e69_numemp = $oParam->iEmpenho)";

            $resultado = db_query($sql);
            $empenhos = db_utils::getCollectionByRecord($resultado,0);
            if(isset($empenhos)){
                $oRetorno->message = utf8_encode("Não é possível excluir empenhos que tenham movimentações de ordem de compra por esta rotina. Contate o suporte");
                $oRetorno->status   = 2;
            }

        } catch (Exception $eExeption) {
            //$oRetorno->message  = urlencode(str_replace("\\n","\n",$eExeption->getMessage()));
            $oRetorno->message = utf8_encode(pg_last_error());
            $oRetorno->status   = 2;
        }

      break;

  }

  function getEmpenhosAnulados($empenhos, $instituicao) {
    $sql = "
      SELECT DISTINCT empempenho.e60_numemp,
                empempenho.e60_codemp,
                empempenho.e60_anousu,
                empempenho.e60_emiss,
                cgm.z01_nome,
                cgm.z01_numcgm,
                e60_vlremp
      FROM empempenho
      INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
      INNER JOIN empelemento ON empempenho.e60_numemp = empelemento.e64_numemp
      INNER JOIN db_config ON db_config.codigo = empempenho.e60_instit
      INNER JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu
      AND orcdotacao.o58_coddot = empempenho.e60_coddot
      INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = empempenho.e60_codcom
      INNER JOIN emptipo ON emptipo.e41_codtipo = empempenho.e60_codtipo
      INNER JOIN concarpeculiar ON concarpeculiar.c58_sequencial = empempenho.e60_concarpeculiar
      INNER JOIN db_config AS a ON a.codigo = orcdotacao.o58_instit
      INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
      INNER JOIN orcfuncao ON orcfuncao.o52_funcao = orcdotacao.o58_funcao
      INNER JOIN orcsubfuncao ON orcsubfuncao.o53_subfuncao = orcdotacao.o58_subfuncao
      INNER JOIN orcprograma ON orcprograma.o54_anousu = orcdotacao.o58_anousu
      AND orcprograma.o54_programa = orcdotacao.o58_programa
      INNER JOIN orcelemento ON orcelemento.o56_codele = orcdotacao.o58_codele
      AND orcelemento.o56_anousu = orcdotacao.o58_anousu
      INNER JOIN orcprojativ ON orcprojativ.o55_anousu = orcdotacao.o58_anousu
      AND orcprojativ.o55_projativ = orcdotacao.o58_projativ
      INNER JOIN orcorgao ON orcorgao.o40_anousu = orcdotacao.o58_anousu
      AND orcorgao.o40_orgao = orcdotacao.o58_orgao
      INNER JOIN orcunidade ON orcunidade.o41_anousu = orcdotacao.o58_anousu
      AND orcunidade.o41_orgao = orcdotacao.o58_orgao
      AND orcunidade.o41_unidade = orcdotacao.o58_unidade
      LEFT JOIN empcontratos ON si173_empenho::varchar = e60_codemp
      AND e60_anousu = si173_anoempenho
      LEFT JOIN contratos ON si173_codcontrato = si172_sequencial
      LEFT JOIN aditivoscontratos ON extract(YEAR
                                             FROM si174_dataassinaturacontoriginal) = si172_exerciciocontrato
      AND (si174_nrocontrato = si172_nrocontrato)
      LEFT JOIN empempaut ON empempenho.e60_numemp = empempaut.e61_numemp
      LEFT JOIN empautoriza ON empempaut.e61_autori = empautoriza.e54_autori
      LEFT JOIN db_depart ON empautoriza.e54_autori = db_depart.coddepto
      LEFT JOIN empempenhocontrato ON empempenho.e60_numemp = empempenhocontrato.e100_numemp
      LEFT JOIN acordo ON empempenhocontrato.e100_acordo = acordo.ac16_sequencial
      WHERE e60_instit = {$instituicao}
          AND e60_vlremp = e60_vlranu
          AND e60_vlrliq = 0
          AND e60_numemp NOT IN
              (SELECT m52_numemp
               FROM matordemitem
               UNION SELECT e69_numemp
               FROM empnota)
          AND e60_numemp in ({$empenhos})
      ORDER BY e60_numemp
    ";

    $resultado = db_query($sql);
    $empenhos = db_utils::getCollectionByRecord($resultado,0);
    return $empenhos;
  }

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}
echo json_encode($oRetorno);
?>
