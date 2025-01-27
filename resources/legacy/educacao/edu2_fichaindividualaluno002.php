<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once("libs/db_stdlibwebseller.php");
require_once("fpdf151/pdfwebseller.php");
include("edu_cabecalhoatolegal.php");
require_once("libs/db_utils.php");
require_once("libs/db_libdocumento.php");
require_once("libs/db_libparagrafo.php");
require_once("dbforms/db_funcoes.php");

$resultedu           = eduparametros(db_getsession("DB_coddepto"));
$permitenotaembranco = VerParametroNota(db_getsession("DB_coddepto"));
$escola              = db_getsession("DB_coddepto");
$oGet                = db_utils::postMemory($_GET);

$clmatricula       = new cl_matricula;
$claluno           = new cl_aluno;
$clturma           = new cl_turma;
$clEscola          = new cl_escola();
$cldiarioavaliacao = new cl_diarioavaliacao;
$clregenteconselho = new cl_regenteconselho;
$clrotulo          = new rotulocampo;
$oDaoEscolaDiretor = new cl_escoladiretor();
$oDaoTipoSanguineo = new cl_tiposanguineo();

$claluno->rotulo->label();
$clrotulo->label("ed76_i_escola");
$clrotulo->label("ed76_d_data");

$sSqlDadosEscola = $clEscola->sql_query("", "ed261_c_nome as mun_escola", "", "ed18_i_codigo = {$escola}");
$rsDadosEscola   = db_query($sSqlDadosEscola);
$oDadosEscola    = db_utils::fieldsMemory($rsDadosEscola, 0);
$mun_escola      = $oDadosEscola->mun_escola;

$camp  = " ed60_d_datasaida as datasaida, ";
$camp .= "  case ";
$camp .= "   when ed60_c_situacao = 'TRANSFERIDO REDE' then ";
$camp .= "    (select escoladestino.ed18_c_nome from transfescolarede ";
$camp .= "      inner join atestvaga  on  atestvaga.ed102_i_codigo = transfescolarede.ed103_i_atestvaga ";
$camp .= "      inner join escola  as escoladestino on  escoladestino.ed18_i_codigo = atestvaga.ed102_i_escola ";
$camp .= "     where ed103_i_matricula = ed60_i_codigo order by ed103_d_data desc limit 1) ";
$camp .= "   when ed60_c_situacao = 'TRANSFERIDO FORA' then ";
$camp .= "    (select escolaproc1.ed82_c_nome from transfescolafora ";
$camp .= "     inner join escolaproc as escolaproc1 on  escolaproc1.ed82_i_codigo = transfescolafora.ed104_i_escoladestino ";
$camp .= "     where ed104_i_matricula = ed60_i_codigo order by ed104_d_data desc limit 1) ";
$camp .= "   else null ";
$camp .= "  end as destinosaida, ";
$camp .= "  matricula.*, ";
$camp .= "  turma.ed57_c_descr, ";
$camp .= "  turma.ed57_i_codigo, ";
$camp .= "  turmaserieregimemat.ed220_i_procedimento, ";
$camp .= "  turma.ed57_c_medfreq, ";
$camp .= "  calendario.ed52_c_descr, ";
$camp .= "  calendario.ed52_i_ano, ";
$camp .= "  case when turma.ed57_i_tipoturma = 2 then ";
$camp .= "   fc_nomeetapaturma(ed60_i_turma) else ";
$camp .= "   serie.ed11_c_descr ";
$camp .= "  end as ed11_c_descr, ";
$camp .= "  serie.ed11_i_codigo, ";
$camp .= "  escola.ed18_c_nome, ";
$camp .= "  turno.ed15_c_nome, ";
$camp .= "  aluno.ed47_v_nome, ";
$camp .= "  alunoprimat.ed76_i_codigo, ";
$camp .= "  alunoprimat.ed76_i_escola, ";
$camp .= "  alunoprimat.ed76_d_data, ";
$camp .= "  alunoprimat.ed76_c_tipo, ";
$camp .= "  case when ed76_c_tipo = 'M' ";
$camp .= "   then escolaprimat.ed18_c_nome else escolaproc.ed82_c_nome end as nomeescola, ";
$camp .= "   aluno.*     ";

$sSqlMatricula = $clmatricula->sql_query("", $camp, "ed60_d_datamatricula desc", " ed60_i_codigo in ({$alunos})");
$result1       = $clmatricula->sql_record($sSqlMatricula);

if ($clmatricula->numrows == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado.");
}

$sCampos  = " aluno.ed47_i_codigo,   ";
$sCampos .= " censoufident.ed260_c_nome as ufident, ";
$sCampos .= " censoufnat.ed260_c_nome as ufnat, ";
$sCampos .= " censoufcert.ed260_c_nome as ufcert, ";
$sCampos .= " censoufend.ed260_c_nome as ufend, ";
$sCampos .= " censomunicnat.ed261_c_nome as municnat, ";
$sCampos .= " censomuniccert.ed261_c_nome as municcert, ";
$sCampos .= " censomunicend.ed261_c_nome as municend, ";
$sCampos .= " censoorgemissrg.ed132_c_descr as orgemissrg, ";
$sCampos .= " pais.ed228_c_descr ";
$sSql     = $claluno->sql_query_matricula_uf("",  $sCampos, "ed47_v_nome", " ed60_i_codigo IN ($alunos) ");
$rsResult = $claluno->sql_record($sSql);

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(223);

for ($ww = 0; $ww < $clmatricula->numrows; $ww++) {

  db_fieldsmemory($result1, $ww);
  db_fieldsmemory($rsResult,$ww);

  $data         = date("Y-m-d", DB_getsession("DB_datausu"));
  $dia          = date("d");
  $mes          = date("m");
  $ano          = date("Y");

  $mes_extenso  = array(
    "01" => "janeiro",
    "02" => "fevereiro",
    "03" => "mar�o",
    "04" => "abril",
    "05" => "maio",
    "06" => "junho",
    "07" => "julho",
    "08" => "agosto",
    "09" => "setembro",
    "10" => "outubro",
    "11" => "novembro",
    "12" => "dezembro"
  );

  $data_extenso = $mun_escola . ", " . $dia . " de " . $mes_extenso[$mes] . " de " . $ano . ".";
  $head1        = "FICHA INDIVIDUAL DO ALUNO";
  $head2        = "{$ed47_i_codigo} - {$ed47_v_nome}";
  $pdf->addpage('P');

  /////////////////////////////////////////////DADOS PESSOAIS

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(191, 4, "DADOS PESSOAIS", "LBT", 1, "L", 1);
  $pdf->cell(3,   4, "",               "L",   0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_v_nome), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(120, 4, $ed47_v_nome, 0,   1, "L", 0);
  $pdf->cell(3,   4, "",           "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_i_codigo), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(20, 4, $ed47_i_codigo, 0, 0, "L", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(30, 4, strip_tags($Led47_c_codigoinep), 0, 0, "R", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(20, 4, $ed47_c_codigoinep, 0, 0, "L", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(25, 4, strip_tags($Led47_c_nis), 0, 0, "R", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(25, 4, $ed47_c_nis, 0,   1, "L", 0);
  $pdf->cell(3,  4, "",          "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_d_nasc), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(20, 4, db_formatar($ed47_d_nasc, 'd'), 0, 0, "L", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(30, 4, strip_tags($Led47_v_sexo), 0, 0, "R", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(20, 4, $ed47_v_sexo == "M" ? "MASCULINO" : "FEMININO", 0, 0, "L", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(25, 4, strip_tags($Led47_i_estciv), 0, 0, "R", 0);

  if ($ed47_i_estciv == 1) {
    $ed47_i_estciv = "SOLTEIRO";
  } else if ($ed47_i_estciv == 2) {
    $ed47_i_estciv = "CASADO";
  } else if ($ed47_i_estciv == 3) {
    $estciv = "VI�VO";
  } else if ($ed47_i_estciv == 4) {
    $ed47_i_estciv = "DIVORCIADO";
  }

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(25, 4, $ed47_i_estciv, 0,   1, "L", 0);
  $pdf->cell(3,  4, "",             "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_c_raca), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(25, 4, $ed47_c_raca, 0,   1, "L", 0);
  $pdf->cell(3,  4, "",           "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_i_filiacao), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(120, 4, $ed47_i_filiacao == "0" ? "N�O DECLARADO / IGNORADO" : "PAI E/OU M�E", 0, 1, "L", 0);
  $pdf->cell(3,  4, "", "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_v_pai), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(120, 4, $ed47_v_pai, 0, 1, "L", 0);
  $pdf->cell(3, 4, "", "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_v_mae), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(120, 4, $ed47_v_mae, 0, 1, "L", 0);
  $pdf->cell(3, 4, "", "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35,  4,  strip_tags($Led47_i_nacion),  0,  0,  "L",  0);

  if ($ed47_i_nacion == 1) {
    $ed47_i_nacion = "BRASILEIRA";
  } else if ($ed47_i_nacion == 2) {
    $ed47_i_nacion = "BRASILEIRA NO EXTERIOR OU NATURALIZADO";
  } else if ($ed47_i_nacion == 3) {
    $ed47_i_nacion = "ESTRANGEIRA";
  }

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(42, 4, $ed47_i_nacion, 0, 0, "L", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(18,  4,  strip_tags($Led47_i_censomunicnat),  0,  0,  "L",  0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(20, 4, $municnat .", " . $ufnat, 0, 1, "L", 0);
  $pdf->cell(3, 4, "", "L", 0, "C", 0);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(35, 4, strip_tags($Led47_v_ender), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 7);
  $pdf->cell(121, 4, substr($ed47_v_ender,  0,  35). ", ". $ed47_c_numero . ". " . $ed47_v_bairro, 0, 0, "L", 0);
  
  $pdf->line(201, 35, 201, 75);
  $pdf->line(10,  75, 201, 75);

  $cont_geral = 0;
  $altini     = $pdf->getY() + 10;

  $pdf->setY($altini);

  if ($clmatricula->numrows > 0) {

    $contador = 0;
    db_fieldsmemory($result1, $ww);

    $oTurma     = TurmaRepository::getTurmaByCodigo($ed57_i_codigo);
    $oMatricula = MatriculaRepository::getMatriculaByCodigo($ed60_i_codigo);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(35, 4, "Matr�cula N�:", "LT", 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(40, 4, $ed60_i_codigo, "T", 0, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, 4, "Escola:", "T", 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(86, 4, $ed18_c_nome, "RT", 1, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(35, 4, "Data da Matr�cula:", "L", 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(40, 4, db_formatar($ed60_d_datamatricula, 'd'), 0, 0, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, 4, "Situa��o:", 0, 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);

    if (trim($ed60_c_situacao) == "AVAN�ADO" || trim($ed60_c_situacao) == "CLASSIFICADO") {
      $sitt = trim($ed60_c_situacao);
    } else {

      if ($ed60_c_concluida == "S") {
        $sitt = Situacao($ed60_c_situacao, $ed60_i_codigo) . "(CONCLU�DA)";
      } else {
        $sitt = Situacao($ed60_c_situacao, $ed60_i_codigo);
      }
    }

    $pdf->cell(86, 4, $sitt, "R", 1, "L", 1);

    if (
      trim(Situacao($ed60_c_situacao, $ed60_i_codigo)) != "MATRICULADO"
      && trim(Situacao($ed60_c_situacao, $ed60_i_codigo)) != "REMATRICULADO"
    ) {

      $pdf->setfont('arial', '', 7);
      $pdf->cell(35, 4, "Data Sa�da:", "L", 0, "L", 1);

      $pdf->setfont('arial', 'b', 7);
      $sDataSaida = !empty($datasaida) ? db_formatar($datasaida, 'd') : "";
      $pdf->cell(40, 4, $sDataSaida, 0, 0, "L", 1);

      $pdf->setfont('arial', '', 7);
      $pdf->cell(30, 4, "Destino Sa�da:", 0, 0, "L", 1);

      $pdf->setfont('arial', 'b', 7);
      $pdf->cell(86, 4, $destinosaida, "R", 1, "L", 1);
    }

    $pdf->setfont('arial', '', 7);
    $pdf->cell(35, 4, "Nome da Turma:", "L", 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(40, 4, $ed57_c_descr, 0, 0, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, 4, "Etapa:", 0, 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(86, 4, $ed11_c_descr, "R", 1, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(35, 4, "Turno:", "L", 0, "L", 1);

    /**
     * Verifica se a turma � do tipo Integral e Infantil, alterando a forma como � apresentada a descri��o do
     * turno.
     * Por padr�o, mostra somente a descri��o do Turno (Ex.: MANH�)
     * No caso de turno Integral e Infantil, mostra tamb�m o turno referente o qual a matr�cula est� vinculada
     * Ex.: INTEGRAL - MANH� / TARDE
     */
    $oMatricula = MatriculaRepository::getMatriculaByCodigo($ed60_i_codigo);
    if (
      $oMatricula->getTurma()->getTurno()->isIntegral()
      && $oMatricula->getTurma()->getBaseCurricular()->getCurso()->getEnsino()->isInfantil()
    ) {

      $aDescricaoTurno = array();
      $aTurnoReferente = array(1 => 'MANH�', 2 => 'TARDE', 3 => 'NOITE');

      foreach ($oMatricula->getTurnosVinculados() as $oTurnoReferente) {
        $aDescricaoTurno[] = $aTurnoReferente[$oTurnoReferente->ed336_turnoreferente];
      }

      $ed15_c_nome = "INTEGRAL - " . implode(" / ", $aDescricaoTurno);
    }

    $oEtapa        = EtapaRepository::getEtapaByCodigo($ed11_i_codigo);
    $sCargaHoraria = "";
    $sCargaHoraria = $oTurma->getCargaHoraria($oEtapa);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(40, 4, $ed15_c_nome, 0, 0, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, 4, "Calend�rio:", 0, 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(86, 4, $ed52_c_descr . " / " . $ed52_i_ano, "R", 1, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(35, 4, "Carga Hor�ria Total:", "L", 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(40, 4, $sCargaHoraria, 0, 0, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, 4, "Dias Letivos:", 0, 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(86, 4, $oTurma->getCalendario()->getDiasLetivos(), "R", 1, "L", 1);

    $pdf->setfont('arial', '', 7);
    $pdf->cell(35, 4, "Classifica��o:", "L", 0, "L", 1);

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(156, 4, $oMatricula->getNumeroOrdemAluno(), "R", 1, "L", 1);

    GradeAproveitamentoBOLETIM($ed60_i_codigo, 190, $pdf, "", "P", 0, "S");

    $pdf->cell(190, 3, "", "T", 1, "C", 0);
  }

  $campos  = " ed95_i_regencia,ed232_c_descr,ed72_t_obs,ed72_i_codigo as codaval,ed72_t_parecer as parecer,ed09_c_descr, ";
  $campos .= " ed72_c_amparo as amparoum,ed81_c_todoperiodo as amparo,ed06_c_descr as justificativa,ed72_i_numfaltas,ed09_i_codigo, ";
  $campos .= " ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed72_i_numfaltas,ed78_i_aulasdadas";
  $sql     = " SELECT {$campos} ";
  $sql    .= "   FROM diarioavaliacao ";
  $sql    .= "        inner join diario           on ed95_i_codigo                        = ed72_i_diario ";
  $sql    .= "        inner join regencia         on ed59_i_codigo                        = ed95_i_regencia ";
  $sql    .= "        inner join disciplina       on ed12_i_codigo                        = ed59_i_disciplina ";
  $sql    .= "        inner join caddisciplina    on ed232_i_codigo                       = ed12_i_caddisciplina ";
  $sql    .= "        left  join amparo           on ed81_i_diario                        = ed95_i_codigo ";
  $sql    .= "        left  join justificativa    on ed06_i_codigo                        = ed81_i_justificativa ";
  $sql    .= "        left  join convencaoamp     on ed250_i_codigo                       = ed81_i_convencaoamp ";
  $sql    .= "        inner join procavaliacao    on procavaliacao.ed41_i_codigo          = diarioavaliacao.ed72_i_procavaliacao";
  $sql    .= "        inner join periodoavaliacao on periodoavaliacao.ed09_i_codigo       = procavaliacao.ed41_i_periodoavaliacao";
  $sql    .= "        inner join regenciaperiodo  on regenciaperiodo.ed78_i_procavaliacao = procavaliacao.ed41_i_codigo ";
  $sql    .= "                                   and regenciaperiodo.ed78_i_regencia      = regencia.ed59_i_codigo";
  $sql    .= "        inner join diariofinal      on diariofinal.ed74_i_diario            = diario.ed95_i_codigo";
  $sql    .= "  WHERE ed95_i_aluno      = {$ed60_i_aluno} ";
  $sql    .= "    AND ed95_i_calendario = " . $calendario;
  $sql    .= "    AND ed59_c_condicao   = 'OB' and (trim(ed72_t_obs) !='' or  trim(ed72_t_parecer) !='')";
  $sql    .= "  ORDER BY ed41_i_sequencia,ed59_i_ordenacao ";
  $result  = db_query($sql);
  $linhas0 = pg_num_rows($result);
  $u       = 0;

  for ($r = 0; $r < $linhas0; $r++) {

    db_fieldsmemory($result, $r);
    $pdf->setfont('arial', 'b', 7);

    if ($u != $ed09_i_codigo) {

      $pdf->cell(190, 4, "Per�odo de Avalia��o: " . $ed09_c_descr, 1, 1, "C", 1);
      $u = $ed09_i_codigo;
    }

    if ($ed72_t_obs != "" || $parecer != "") {

      $pdf->cell(190, 4, "Disciplina: {$ed232_c_descr}", 1, 1, "L", 0);

      if ($ed72_t_obs != "") {

        $pdf->setfont('arial', 'b', 7);
        $pdf->cell(190, 4, "Observa��es:", 1, 1, "L", 1);

        $pdf->setfont('arial', '', 7);
        $pdf->multicell(190, 4, ($ed72_t_obs != "" ? $ed72_t_obs . "\n" : ""), 1, "L", 0, 0);
      }

      if ($parecer != "") {

        $pdf->setfont('arial', 'b', 7);
        $pdf->cell(190, 4, "Parecer:", 1, 1, "L", 1);

        $pdf->setfont('arial', '', 7);
        $pdf->multicell(190, 4, ($parecer != "" ? $parecer . "\n" : ""), 1, "L", 0, 0);
        $pdf->cell(190, 3, "", 0, 1, "L", 0);
      }
    }
  }

  $campos  = " ed95_i_regencia, ed232_c_descr, ed74_t_obs, ed125_codigo,";
  $campos .= " (SELECT 1 from progressaoparcialalunodiariofinalorigem ";
  $campos .= " where progressaoparcialalunodiariofinalorigem.ed107_diariofinal = diariofinal.ed74_i_codigo ";
  $campos .= "   and calendario.ed52_i_codigo = {$oGet->calendario}) as progressao";
  $sql     = " SELECT {$campos} ";
  $sql    .= "   FROM diariofinal ";
  $sql    .= "        inner join diario             on ed95_i_codigo                   = diariofinal.ed74_i_diario ";
  $sql    .= "        inner join calendario         on calendario.ed52_i_codigo        = diario.ed95_i_calendario";
  $sql    .= "        inner join regencia           on ed59_i_codigo                   = ed95_i_regencia ";
  $sql    .= "        inner join disciplina         on ed12_i_codigo                   = ed59_i_disciplina ";
  $sql    .= "        inner join caddisciplina      on ed232_i_codigo                  = ed12_i_caddisciplina ";
  $sql    .= "        left  join diarioregracalculo on diarioregracalculo.ed125_diario = diario.ed95_i_codigo ";
  $sql    .= "  WHERE ed95_i_aluno    = {$ed60_i_aluno} ";
  $sql    .= "    AND ed59_c_condicao = 'OB'";
  $sql    .= "  ORDER BY ed59_i_ordenacao ";
  $result  = db_query($sql);
  $linhas1 = pg_num_rows($result);
  $s       = 0;

  $lUtilizaProporcionalidade = false;

  for ($r = 0; $r < $linhas1; $r++) {

    db_fieldsmemory($result, $r);

    if (!empty($ed125_codigo)) {
      $lUtilizaProporcionalidade = true;
    }

    if ($s != $ed95_i_regencia) {

      $s = $ed95_i_regencia;

      if (!empty($progressao)) {

        $sTextoProgressao = "Aluno aprovado nesta disciplina atrav�s de progress�o parcial.";
        $ed74_t_obs      .= !empty($ed74_t_obs) ? "\n{$sTextoProgressao}" : $sTextoProgressao;
      }

      if ($ed74_t_obs != "") {

        $pdf->setfont('arial', 'b', 7);
        $pdf->cell(191, 4, "Disciplina: " . $ed232_c_descr,  1, 1, "C", 1);
        $pdf->cell(191, 4, "Observa��es Resultado Final:", 1, 1, "L", 1);

        $pdf->setfont('arial', '', 7);
        $pdf->multicell(191, 4, ($ed74_t_obs != "" ? $ed74_t_obs . "\n" : ""), 1, "L", 0, 0);
        $pdf->cell(191, 3, "", 0, 1, "L", 0);
      }
    }
  }

  $oDaoAprovConselho = new cl_aprovconselho();
  $sCamposAprovCons  = " distinct ed11_c_descr as serie_conselho, ed52_i_ano, ed253_aprovconselhotipo, ed253_t_obs";
  $sCamposAprovCons .= ", ed232_c_descr, ed253_alterarnotafinal, ed253_avaliacaoconselho";
  $sWhereAprovCons   = "     ed95_i_aluno = {$ed60_i_aluno} ";
  $sWhereAprovCons  .= " and ed52_i_codigo = {$oGet->calendario} ";
  $sSqlAprovCons     = $oDaoAprovConselho->sql_query("", $sCamposAprovCons, "ed11_c_descr, ed52_i_ano", $sWhereAprovCons);
  $rsAprovConselho   = $oDaoAprovConselho->sql_record($sSqlAprovCons);
  $iLinhasAprovCons  = $oDaoAprovConselho->numrows;

  $aAprovadoBaixaFrequencia   = array();
  $aAprovadoConselhoRegimento = array();

  if ($iLinhasAprovCons > 0) {

    for ($iContObs = 0; $iContObs < $iLinhasAprovCons; $iContObs++) {

      $oDadosAprovConselho = db_utils::fieldsmemory($rsAprovConselho, $iContObs);

      switch ($oDadosAprovConselho->ed253_aprovconselhotipo) {
          /**
         * Valida se a aprova��o foi por conselho
         */
        case 1:

          $oDocumento                = new libdocumento(5013);
          $oDocumento->disciplina    = $oDadosAprovConselho->ed232_c_descr;
          $oDocumento->etapa         = $oDadosAprovConselho->serie_conselho;
          $oDocumento->justificativa = $oDadosAprovConselho->ed253_t_obs;
          $oDocumento->nota          = $oDadosAprovConselho->ed253_avaliacaoconselho;
          $oDocumento->anomatricula  = $oDadosAprovConselho->ed52_i_ano;

          $oDadosObservacao              = new stdClass();
          $oDadosObservacao->aParagrafos = $oDocumento->getDocParagrafos();

          if (trim($oDadosObservacao->aParagrafos[1]->oParag->db02_texto) != '') {
            $aAprovadoConselhoRegimento[]  = "- " . $oDadosObservacao->aParagrafos[1]->oParag->db02_texto;
          }
          break;
          /**
           * Valida se a aprova��o n�o foi por baixa frequencia
           */
        case 2:

          $sHashSerieAno = $oDadosAprovConselho->serie_conselho . $oDadosAprovConselho->ed52_i_ano;
          if (!isset($aAprovadoBaixaFrequencia[$sHashSerieAno])) {
            $aAprovadoBaixaFrequencia[$sHashSerieAno] = $oDadosAprovConselho;
          }
          continue;
          break;
          /**
           * Valida se a aprova��o foi por regimento escolar
           */
        case 3:

          $sTipoAprovacao = "foi aprovado pelo regimento escolar.";
          $sObservacao    = "- Disciplina {$oDadosAprovConselho->ed232_c_descr} na etapa";
          $sObservacao   .= " {$oDadosAprovConselho->serie_conselho} {$sTipoAprovacao}";
          $sObservacao   .= "Justificativa: {$oDadosAprovConselho->ed253_t_obs}";

          $aAprovadoConselhoRegimento[]  = $sObservacao;
          break;
      }
    }
  }

  $sObservacaoConselho = '';
  if (count($aAprovadoBaixaFrequencia) > 0) {

    $oDocumento = new libdocumento(5006);

    foreach ($aAprovadoBaixaFrequencia as $oBaixaFrequencia) {

      $oDocumento->nome_aluno = $ed47_v_nome;
      $oDocumento->ano        = $oBaixaFrequencia->ed52_i_ano;
      $oDocumento->nome_etapa = $oBaixaFrequencia->serie_conselho;
      $aParagrafos            = $oDocumento->getDocParagrafos();

      if (isset($aParagrafos[1])) {
        $sObservacaoConselho .= "- {$aParagrafos[1]->oParag->db02_texto}\n";
      }
    }
  }

  $sObservacaoConselho .= implode("\n", $aAprovadoConselhoRegimento);

  /**
   * Valido se � utilizado a proporcionalidade para c�lculo do resultado final e adiciono h� observa��o o par�grafo de
   * acordo com o Tipo de Ensino
   */
  $oEnsino = $oTurma->getBaseCurricular()->getCurso()->getEnsino();
  $sObservacaoProporcionalidade = "";

  if ($lUtilizaProporcionalidade) {

    if ($oEnsino->getCodigoTipoEnsino() == $oEnsino::ENSINO_REGULAR) {

      $oDocumento  = new libdocumento(5017);
      $aParagrafos = $oDocumento->getDocParagrafos();

      if (isset($aParagrafos[1])) {
        $sObservacaoProporcionalidade .= "- {$aParagrafos[1]->oParag->db02_texto}\n";
      }
    } else if ($oEnsino->getCodigoTipoEnsino() == $oEnsino::ENSINO_EJA) {

      $oDocumento  = new libdocumento(5018);
      $aParagrafos = $oDocumento->getDocParagrafos();

      if (isset($aParagrafos[1])) {
        $sObservacaoProporcionalidade .= "- {$aParagrafos[1]->oParag->db02_texto}\n";
      }
    }
  }

  if ($sObs != "" || $sObservacaoConselho || $sObservacaoProporcionalidade != "") {

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(191, 4, "",                    0, 1, "L", 0);
    $pdf->cell(191, 4, "Observa��es Gerais:", 1, 1, "L", 1);

    $pdf->setfont('arial', '', 7);
    $sObservacaoImprimir  = $sObservacaoProporcionalidade;
    $sObservacaoImprimir .= "{$sObservacaoConselho}" . mb_strtoupper($sObs);

    $pdf->multicell(191, 4, $sObservacaoImprimir, 1, "L", 0, 0);
  }

  $final = $pdf->getY();
  $pdf->setY($final + 10);

  $pdf->setfont('arial', '', 7);
  $pdf->cell(191, 4, $data_extenso, 0, 1, "C", 0);

  $fim = $pdf->getY();
  $pdf->setY($fim + 1);

  $sCampos = "case when ed20_i_tiposervidor = 1 then cgmrh.z01_nome else cgmcgm.z01_nome end as regente";

  $sSqlRegenteConselho = $clregenteconselho->sql_query("", $sCampos, "", " ed235_i_turma = {$ed57_i_codigo}");
  $result5             = $clregenteconselho->sql_record($sSqlRegenteConselho);

  if ($clregenteconselho->numrows > 0) {
    db_fieldsmemory($result5, 0);
  } else {
    $regente = "";
  }

  $pdf->Ln(4);

  /**
   * Vari�veis para controle da posi��o X das op��es poss�veis de serem impressas
   */
  $iPosicaoXProfessor  = 10;
  $iPosicaoXAdicional  = 10;
  $iPosicaoXDiretor    = 10;
  $iPosicaoXSecretario = 10;

  /**
   * Vari�veis para controle da posi��o Y das op��es poss�veis de serem impressas
   */
  $iPosicaoYDiretor    = $pdf->GetY();
  $iPosicaoYProfessor  = $pdf->GetY();
  $iPosicaoYAdicional  = $pdf->GetY();
  $iPosicaoYSecretario = $pdf->GetY();

  /**
   * Vari�veis para controle de exibi��o da assinatura adicional e do professor
   */
  $lExibirAdicional = false;
  $lExibirProfessor = false;

  if (isset($oGet->iAssinaturaAdicional) && !empty($oGet->iAssinaturaAdicional)) {
    $lExibirAdicional = true;
  }

  if (isset($oGet->lExibeAssinaturaProfessor) && $oGet->lExibeAssinaturaProfessor == "S") {
    $lExibirProfessor = true;
  }

  /**
   * Imprime a assinatura adicional caso informada
   */
  if ($lExibirAdicional) {

    $oDocente         = DocenteRepository::getDocenteByCodigoRecursosHumano($oGet->iAssinaturaAdicional);
    $sNomeDocente     = $oDocente->getNome();
    $sFuncaoDocente   = '';

    foreach ($oDocente->getAtividades($oTurma->getEscola()) as $oAtividades) {

      if (isset($oGet->iAtividade) && $oAtividades->getAtividade()->getCodigo() == $oGet->iAtividade) {
        $sFuncaoDocente = $oAtividades->getAtividade()->getDescricao();
      }
    }

    $pdf->setY($iPosicaoYAdicional+15);
    $pdf->setX(30);
    $pdf->cell(60, 5, "______________________________________________", 0, 1, "C", 0);

    $pdf->setX(30);
    $pdf->multicell(60, 4, ucwords($sNomeDocente), 0, "C", 0, 0);
    $pdf->setX(30);
    $pdf->cell(60, 3, $sFuncaoDocente, 0, 1, "C", 0);

    /**
     * Caso tenha sido selecionado para exibir a assinatura do professor, setamos a posi��o Y do mesmo
     */
    if ($lExibirProfessor) {
      
      $pdf->setY($iPosicaoYProfessor+15);
      $pdf->setX(110);
      $pdf->cell(60, 5, "______________________________________________", 0, 1, "C", 0);
  
      $pdf->setX(110);
      $pdf->cell(60, 3, "Professor",   0, 1, "C", 0);
    }
  }

  /**
   * Imprime a assinatura do professor caso checado
   */
  if ($lExibirProfessor && !$lExibirAdicional) {

    $pdf->setY($iPosicaoYProfessor+15);
    $pdf->setX(70);
    $pdf->cell(60, 5, "______________________________________________", 0, 1, "C", 0);

    $pdf->setX(70);
    $pdf->cell(60, 3, "Professor",   0, 1, "C", 0);
  }

  /**
   * Imprime assinaturas
   */
  $pdf->setY($iPosicaoYDiretor);
  $pdf->setX(30);
  $pdf->cell(60, 5, "______________________________________________", 0, 1, "C", 0);

  $pdf->setX(30);
  $pdf->cell(60, 3, "Diretor(a) Escolar n� Reg ou Aut.",   0, 1, "C", 0);

  $pdf->setY($iPosicaoYSecretario);
  $pdf->setX(110);
  $pdf->cell(60, 5, "______________________________________________", 0, 1, "C", 0);

  $pdf->setX(110);
  $pdf->cell(60, 3, "Secret�rio(a) Escolar n� Reg ou Aut.",   0, 1, "C", 0);
}

$pdf->Output();
