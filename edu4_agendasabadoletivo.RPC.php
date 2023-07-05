<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("std/DBDate.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlibwebseller.php");
require_once("model/webservices/ControleAcessoAluno.model.php");
require_once("model/educacao/avaliacao/iFormaObtencao.interface.php");
require_once("model/educacao/avaliacao/iElementoAvaliacao.interface.php");
require_once("classes/db_calendario_classe.php");
require_once("classes/db_feriado_classe.php");
require_once("classes/db_turma_classe.php");
require_once("classes/db_turmaturnoreferente_classe.php");
require_once("classes/db_rechumanoescola_classe.php");
db_app::import("educacao.*");
db_app::import("educacao.censo.DisciplinaCenso");
db_app::import("exceptions.*");
db_app::import("educacao.avaliacao.*");

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";


$iEscola        = db_getsession("DB_coddepto");
$oJson          = new services_json();
$oParam         = $oJson->decode(str_replace("\\", "", $_POST["json"]));
switch ($oParam->exec) {

  case 'getCalendarios':

    $clcalendario = new cl_calendario;
    $sql = $clcalendario->sql_query_calescola(null,"*", null, "ed38_i_escola = ".db_getsession("DB_coddepto"));
    $rsCalendario = $clcalendario->sql_record($sql);

    $oRetorno->calendarios = array();
    $oRetorno->calendarios      = db_utils::getCollectionByRecord($rsCalendario, false, false, true);

    break;

  case 'getDiasLetivos':

    $clFeriado = new cl_feriado;
    $sql = $clFeriado->sql_query_file(" feriado.* ","*", null, " ed54_i_calendario = ".$oParam->iCalendario. " and ed54_c_dialetivo='S' ");
    $rsFeriados = $clFeriado->sql_record($sql);
    $oRetorno->aDiasLetivos = array();
    $oRetorno->aDiasLetivos = db_utils::getCollectionByRecord($rsFeriados, false, false, true);

    $aTurmas = array();
    $clTurma = new cl_turma;
    $sSqlTurmas = $clTurma->sql_query(null,"*", "ed57_c_descr", " ed57_i_escola = ".db_getsession("DB_coddepto"). " and ed57_i_calendario = ".$oParam->iCalendario);
    $rsTurmas = $clTurma->sql_record($sSqlTurmas);
    $oRetorno->aTurmas = db_utils::getCollectionByRecord($rsTurmas, false, false, true);

    break;


  case 'getTurmaDisciplinas' :

    $oTurma      = TurmaRepository::getTurmaByCodigo($oParam->iTurma);
    $oRetorno->aRegencias = $oTurma->getTumaDisciplinas();
    $sWhere = " ed336_turma = {$oParam->iTurma} ";
    $oDaoTurnoReferente = new cl_turmaturnoreferente();
    $sSqlTurnoReferente = $oDaoTurnoReferente->sql_query_file(null, "*", "ed336_turnoreferente", $sWhere);
    $rsTurnos = $oDaoTurnoReferente->sql_record($sSqlTurnoReferente);
    $oRetorno->aTurnos   = db_utils::getCollectionByRecord($rsTurnos, false, false, true);


    break;

  case 'getProfessorDisciplina' :

    $clRecursoHumanoEscola  = new cl_rechumanoescola;
    $sqlRecursoHumanoEscola = $clRecursoHumanoEscola->sql_query_professor(null, "*", "z01_nome", " ed75_i_escola = ".db_getsession("DB_coddepto"));
    $rsRecursoHumanoEscola  = $clRecursoHumanoEscola->sql_record($sqlRecursoHumanoEscola);
    $oRetorno->aProfessores = db_utils::getCollectionByRecord($rsRecursoHumanoEscola, false, false, true);
    break;

  case 'salvarSabadoLetivo' :

    /**
     * Pesquisamos quais os registros devemos excluir e lançar novamente.
     */
    try {


      db_inicio_transacao();

      foreach($oParam->aPeriodos as $oPerido){

        $clregenciahorario = new cl_regenciahorario;
        $clregenciahorario->ed58_i_regencia  = $oParam->iRegencia;
        $clregenciahorario->ed58_i_diasemana = 7; //sempre sabado
        $clregenciahorario->ed58_i_periodo   = $oPerido;
        $clregenciahorario->ed58_i_rechumano = $oParam->iRecHumano;
        $clregenciahorario->ed58_ativo       = "true";
        $clregenciahorario->ed58_tipovinculo = 2;
        $clregenciahorario->ed58_d_data      = $oParam->dData;
        $clregenciahorario->incluir(null);
        $clregenciahorario->erro_msg;

        if ($clregenciahorario->erro_status == 0) {

            $sMsg  = "Erro ao salvar dados do Agenda de Sábado.\n";
            $sMsg .= "Erro Sistema: {$clregenciahorario->erro_msg}";
            throw new Exception($sMsg);
        }
      }

      db_fim_transacao(false);
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status = 2;
      $oRetorno->message = $eErro->getMessage();
    }
    break;

    case 'excluirSabadoLetivo' :

        /**
         * Pesquisamos quais os registros devemos excluir e lançar novamente.
         */
        try {

          db_inicio_transacao();

            $cldiarioclasseregenciahorario = new cl_diarioclasseregenciahorario;
            $cldiarioclasseregenciahorario->excluir(null,"ed302_regenciahorario = $oParam->iRegenciaHorario");
            $cldiarioclasseregenciahorario->erro_msg;

            if ($cldiarioclasseregenciahorario->erro_status == 0) {

              $sMsg  = "Erro ao excluir dados do Agenda de Sábado.\n";
              $sMsg .= "Erro Sistema: {$cldiarioclasseregenciahorario->erro_msg}";
              throw new Exception($sMsg);
            }
            
            $clregenciahorario = new cl_regenciahorario;
            $clregenciahorario->excluir($oParam->iRegenciaHorario);
            $clregenciahorario->erro_msg;

            if ($clregenciahorario->erro_status == 0) {

                $sMsg  = "Erro ao excluir dados do Agenda de Sábado.\n";
                $sMsg .= "Erro Sistema: {$clregenciahorario->erro_msg}";
                throw new Exception($sMsg);
            }

          db_fim_transacao(false);
        } catch (Exception $eErro) {

          db_fim_transacao(true);
          $oRetorno->status = 2;
          $oRetorno->message = $eErro->getMessage();
        }
        break;

    case 'getSabadosLetivos' :
        $clRegenciaHorario = new cl_regenciahorario;
        $where  = " ed58_i_regencia = ". $oParam->iRegencia;
        $where .= " and ed58_i_diasemana = ". 7;
        $where .= " and ed58_i_rechumano = ". $oParam->iRecHumano;
        $where .= " and ed58_ativo = 't' ";
        $sqlRegenciaHorario = $clRegenciaHorario->sql_query_regencia_dia_semana(null, "*", "ed58_i_periodo", $where);
        $rsRegenciaHorario = $clRegenciaHorario->sql_record($sqlRegenciaHorario);
        $oRetorno->aSabodosLetivos = db_utils::getCollectionByRecord($rsRegenciaHorario, false, false, true);
        break;
}
echo $oJson->encode($oRetorno);
