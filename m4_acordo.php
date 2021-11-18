<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
require_once 'classes/db_acordo_classe.php';
require_once 'classes/db_acordoacordogarantia_classe.php';
require_once 'classes/db_acordoacordopenalidade_classe.php';
require_once 'classes/db_acordoitem_classe.php';
require_once 'classes/db_acordoaux_classe.php';
require_once 'classes/db_parametroscontratos_classe.php';
require_once 'classes/db_manutencaoacordo_classe.php';
require_once 'classes/db_acordoposicao_classe.php';

$clacordo = new cl_acordo;
$clmanutencaoacordo = new cl_manutencaoacordo;
$clacordoposicao = new cl_acordoposicao;

$clacordo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('ac17_sequencial');
$clrotulo->label('descrdepto');
$clrotulo->label('ac02_sequencial');
$clrotulo->label('ac08_descricao');
$clrotulo->label('ac50_descricao');
$clrotulo->label('z01_nome');
$clrotulo->label('ac16_licitacao');
$clrotulo->label('l20_objeto');
$clrotulo->label('ac16_dataassinatura');
$clrotulo->label('ac35_dataassinaturatermoaditivo');
$clrotulo->label('ac26_numeroaditamento');

if (isset($alterar)) {
  if (empty($_POST['ac16_adesaoregpreco'])) {
    unset($_POST['ac16_adesaoregpreco']);
    unset($GLOBALS["HTTP_POST_VARS"]["ac16_adesaoregpreco"]);
  }
  if (empty($_POST['ac16_licoutroorgao'])) {
    unset($_POST['ac16_licoutroorgao']);
    unset($GLOBALS["HTTP_POST_VARS"]["ac16_licoutroorgao"]);
  }
  if (empty($_POST['ac16_licitacao'])) {
    unset($_POST['ac16_licitacao']);
    unset($GLOBALS["HTTP_POST_VARS"]["ac16_licitacao"]);
  }
}

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

$anousu = db_getsession('DB_anousu');
$instit = db_getsession('DB_instit');
if (isset($alterar)) {
  $sqlerro = false;
  $aditivo = false;
  db_inicio_transacao();

  $ac16_datainicio = implode('-', array_reverse(explode('/', $ac16_datainicio)));
  $ac16_datafim = implode('-', array_reverse(explode('/', $ac16_datafim)));

  if ($ac16_numeroacordo != $ac16_numeroacordo_old) {
    $sWhere = "ac16_numeroacordo = '$ac16_numeroacordo' and ac16_anousu = $anousu and ac16_instit = $instit ";

    $numero_geral = $clacordo->sql_record($clacordo->sql_query_file(null, '*', null, $sWhere));

    if ($clacordo->numrows > 0) {
      db_msgbox("Já existe acordo com o número $ac16_numeroacordo");
      $erro = true;
    }
  }

  if($ac26_numeroaditamento != $ac26_numeroaditamento_old){
    $sWhere = "ac26_numeroaditamento = '$ac26_numeroaditamento' and ac26_acordo = $ac16_sequencial";

    $numadt = $clacordoposicao->sql_record($clacordoposicao->sql_query(null,'ac26_sequencial',null,$sWhere));

    if ($clacordoposicao->numrows > 0) {
      db_msgbox("Já existe aditamento com o número $ac26_numeroaditamento");
      $erro = true;
    }
  }

  $rsPosicoes = db_query(
    "select distinct
                ac26_sequencial as POSICAO,
                            ac18_sequencial,
                            ac18_datainicio,
                            ac18_datafim,
                            ac35_dataassinaturatermoaditivo
              from
                acordoposicao
              inner join acordo on
                acordo.ac16_sequencial = acordoposicao.ac26_acordo
                inner join acordoposicaotipo on
                acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
                inner join cgm on
                cgm.z01_numcgm = acordo.ac16_contratado
                inner join db_depart on
                db_depart.coddepto = acordo.ac16_coddepto
                inner join acordogrupo on
                acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
                inner join acordosituacao on
                acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
                left join acordocomissao on
                acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao
                inner join acordovigencia on
                ac26_sequencial = ac18_acordoposicao
                left join acordoposicaoaditamento on
                ac26_sequencial = ac35_acordoposicao
                inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
                where ac16_sequencial = '$ac16_sequencial'"
  );

  if (pg_num_rows($rsPosicoes) > 1) {
    $aditivo = true;
  }
  if (!isset($erro)) {
    for ($iCont = 0; $iCont < pg_num_rows($rsPosicoes); $iCont++) {
      $oPosicao = db_utils::fieldsMemory($rsPosicoes, $iCont);

      if ($aditivo) {
        $inicio = 'ac18_datainicio_' . $oPosicao->ac18_sequencial;
        $fim = 'ac18_datafim_' . $oPosicao->ac18_sequencial;
        $dataaditivo = 'ac35_dataassinaturatermoaditivo_' . $oPosicao->ac18_sequencial;

        $dTinicio = '';
        $dTfim = '';
        $dTassaditivo = '';

        $dTinicio = implode('-', array_reverse(explode('/', $$inicio)));
        $dTfim = implode('-', array_reverse(explode('/', $$fim)));
        $dTassaditivo = implode('-', array_reverse(explode('/', $$dataaditivo)));

        if (!empty($dTinicio) && !empty($dTfim)) {
          db_query("update acordovigencia  set ac18_datainicio = '$dTinicio', ac18_datafim  = '$dTfim' where ac18_acordoposicao  = '$oPosicao->posicao'");
          db_query("update acordoitemperiodo set ac41_datainicial = '$dTinicio', ac41_datafinal = '$dTfim' where ac41_acordoposicao = '$oPosicao->posicao'");
        }
        if (!empty($dTassaditivo)) {
          db_query("update acordoposicaoaditamento set ac35_dataassinaturatermoaditivo = '$dTassaditivo' where ac35_acordoposicao = '$oPosicao->posicao'");
        }
      } else {
        $dTinicio = implode('-', array_reverse(explode('/', $ac16_datainicio)));
        $dTfim = implode('-', array_reverse(explode('/', $ac16_datafim)));
        db_query("update acordovigencia  set ac18_datainicio = '$dTinicio', ac18_datafim  = '$dTfim' where ac18_acordoposicao  = '$oPosicao->posicao'");
        db_query("update acordoitemperiodo set ac41_datainicial = '$dTinicio', ac41_datafinal = '$dTfim' where ac41_acordoposicao = '$oPosicao->posicao'");
      }

      $resmanut = db_query("select nextval('db_manut_log_manut_sequencial_seq') as seq");
      $seq = pg_result($resmanut, 0, 0);

      $result = db_query("insert into db_manut_log values($seq,'Vigencia anterior: " . $oPosicao->ac16_datainicio . ' - ' . $oPosicao->ac16_datafim . ' atual: ' . $ac16_datainicio . ' - ' . $ac16_datafim . "  '," . db_getsession('DB_datausu') . ',' . db_getsession('DB_id_usuario') . ')');
    
      $numeroaditamento = "ac26_numeroaditamento_{$oPosicao->ac18_sequencial}";
      $clacordoposicao->ac26_numeroaditamento = $$numeroaditamento;
      $clacordoposicao->alterar_numaditamento($oPosicao->posicao);
    }
    
    $clacordo->ac16_numero = $ac16_numeroacordo;
    $clacordo->alterar($ac16_sequencial);

    if ($clacordo->erro_status == '0') {
      db_msgbox($clacordo->erro_msg);
      $sqlerro = true;
    }

    if (!empty($manutac_codunidsubanterior)) {

      $sSqlMaxmanutac = $clmanutencaoacordo->sql_query_file(null, "max(manutac_sequencial)", null, "manutac_acordo = $ac16_sequencial");
      $clmanutencaoacordo->sql_record($sSqlMaxmanutac);

      if ($clmanutencaoacordo->numrows > 0) {
        $clmanutencaoacordo->excluir('', "manutac_acordo = $ac16_sequencial");
      }

      $clmanutencaoacordo->manutac_acordo = $ac16_sequencial;
      $clmanutencaoacordo->manutac_codunidsubanterior = $manutac_codunidsubanterior;

      $clmanutencaoacordo->incluir();
    }
    

    if ($sqlerro == false) {
      db_msgbox('Alteração efetuada');

      if ($aditivo) {

        $rsAditivo = db_query(
          "select distinct
                ac26_sequencial as POSICAO,
                            ac18_sequencial,
                            ac16_datainicio,
                            ac16_datafim,
                            ac18_datainicio,
                            ac18_datafim,
                            ac35_dataassinaturatermoaditivo,
                            ac26_numeroaditamento
              from
                acordoposicao
              inner join acordo on
                acordo.ac16_sequencial = acordoposicao.ac26_acordo
                inner join acordoposicaotipo on
                acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
                inner join cgm on
                cgm.z01_numcgm = acordo.ac16_contratado
                inner join db_depart on
                db_depart.coddepto = acordo.ac16_coddepto
                inner join acordogrupo on
                acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
                inner join acordosituacao on
                acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
                inner join acordocomissao on
                acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao
                inner join acordovigencia on
                ac26_sequencial = ac18_acordoposicao
                inner join acordoposicaoaditamento on
                ac26_sequencial = ac35_acordoposicao
                inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
                where ac16_sequencial = '$ac16_sequencial' order by posicao"
        );
      }
    }
  }

  db_fim_transacao($sqlerro);

  $db_opcao = 2;
  $db_botao = true;
} elseif (isset($chavepesquisa)) {
  $db_opcao = 2;
  $db_botao = true;
  $result = $clacordo->sql_record($clacordo->sql_query($chavepesquisa));

  db_fieldsmemory($result, 0);

  $rsPosicoes = db_query(
    "SELECT distinct ac26_sequencial as POSICAO
        FROM acordo
        inner join acordoposicao on  ac16_sequencial = ac26_acordo
        inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
        inner join acordovigencia on ac18_acordoposicao = ac26_sequencial
        inner join acordoposicaotipo on ac27_sequencial = ac26_acordoposicaotipo
        inner join acordoitem on ac20_acordoposicao = ac26_sequencial
        inner join acordoitemperiodo on ac20_sequencial = ac41_acordoitem
        WHERE ac16_sequencial = '$ac16_sequencial'"
  );

  if (pg_num_rows($rsPosicoes) > 1) {
    $aditivo = true;

    $rsAditivo = db_query(
      "select distinct
            ac26_sequencial as POSICAO,
                        ac18_sequencial,
                        ac16_datainicio,
                        ac16_datafim,
                        ac18_datainicio,
                        ac18_datafim,
                        ac35_dataassinaturatermoaditivo,
                        ac26_numeroaditamento
          from
            acordoposicao
          inner join acordo on
            acordo.ac16_sequencial = acordoposicao.ac26_acordo
            inner join acordoposicaotipo on
            acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
            inner join cgm on
            cgm.z01_numcgm = acordo.ac16_contratado
            inner join db_depart on
            db_depart.coddepto = acordo.ac16_coddepto
            inner join acordogrupo on
            acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
            inner join acordosituacao on
            acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
            inner join acordocomissao on
            acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao
            inner join acordovigencia on
            ac26_sequencial = ac18_acordoposicao
            inner join acordoposicaoaditamento on
            ac26_sequencial = ac35_acordoposicao
            inner join acordoposicaoperiodo on ac36_acordoposicao = ac26_sequencial
            where ac16_sequencial = '$ac16_sequencial' order by posicao"
    );
  }

  db_fieldsmemory($rsAditivo, 0);

  $result = $clmanutencaoacordo->sql_record($clmanutencaoacordo->sql_query('', '*', '', "manutac_acordo = $chavepesquisa"));

  db_fieldsmemory($result, 0);

  $ac16_numeroacordo_old = $ac16_numeroacordo;

  $ac26_numeroaditamento_old = $ac26_numeroaditamento;
}

?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <?php
  db_app::load('scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js');
  db_app::load('widgets/windowAux.widget.js, widgets/DBToogle.widget.js');
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>
    .fora {
      background-color: #d1f07c;
    }

    #fieldset_depart_inclusao,
    #fieldset_depart_responsavel {
      width: 500px;
    }

    #fieldset_depart_inclusao table,
    #fieldset_depart_responsavel table {
      margin: 0 auto;
    }
  </style>
</head>

<body bgcolor="#CCCCCC">
  <?php
  $sContass = explode('.', db_getsession('DB_login'));

  if ($sContass[1] != 'contass') {
    echo '<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>';
  } else {
  ?>

    <form name='form1' method="post" action="" onsubmit="return confirm('Deseja realmente alterar?');">
      <div class="container">
        <fieldset>
          <legend><b></b></legend>
          <table>
            <tr>
              <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                <?php db_ancora($Lac16_sequencial, 'js_acordo(true);', 1); ?>
              </td>
              <td colspan="2">
                <?php
                db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3); ?>
              </td>
            </tr>

            <tr>
              <td nowrap title="<?= @$Tac16_origem ?>">
                <?= @$Lac16_origem ?>
              </td>
              <td>
                <?
                if (db_getsession('DB_anousu') <= 2017) {
                  $aValores = array(
                    0 => 'Selecione',
                    1 => 'Processo de Compras',
                    2 => 'Licitação',
                    3 => 'Manual',
                    6 => 'Empenho'
                  );
                } else {
                  $aValores = array(
                    0 => 'Selecione',
                    1 => 'Processo de Compras',
                    2 => 'Licitação',
                    3 => 'Manual'
                  );
                }

                db_select(
                  'ac16_origem',
                  $aValores,
                  true,
                  $db_opcao,
                  "onchange='js_verificaorigem();'"
                );

                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tac16_tipoorigem ?>">
                <?= @$Lac16_tipoorigem ?>
              </td>
              <td>
                <?
                $aValores = array(
                  0 => 'Selecione',
                  1 => '1 - Não ou dispensa por valor',
                  2 => '2 - Licitação',
                  3 => '3 - Dispensa ou Inexigibilidade',
                  4 => '4 - Adesão à ata de registro de preços',
                  5 => '5 - Licitação realizada por outro órgão ou entidade',
                  6 => '6 - Dispensa ou Inexigibilidade realizada por outro órgão ou entidade',
                  7 => '7 - Licitação - Regime Diferenciado de Contratações Públicas - RDC',
                  8 => '8 - Licitação realizada por consorcio público',
                  9 => '9 - Licitação realizada por outro ente da federação',
                );
                db_select('ac16_tipoorigem', $aValores, true, $db_opcao, "onchange='js_verificatipoorigem()'", "");

                ?>
              </td>
            </tr>
            <? if ($db_opcao == 1) : ?>
              <tr id="credenciamento" style="display: none">
                <td>
                  <strong>Credenciamento/Chamada Pública:</strong>
                </td>
                <td>
                  <?
                  $aValores = array(
                    0 => 'Selecione',
                    1 => '1 - Sim',
                    2 => '2 - Não'
                  );
                  db_select('tipodispenca', $aValores, true, $db_opcao, "", "");
                  ?>
                </td>
              </tr>
            <? endif; ?>
            <tr id="trlicoutroorgao" style="display: none ">
              <td nowrap title="<? @$Tac16_licoutroorgao ?>">
                <?=
                db_ancora("Licitação Outro Órgão:", "js_pesquisaac16_licoutroorgao(true)", $db_opcao);
                ?>
              </td>
              <td>
                <?
                db_input('ac16_licoutroorgao', 10, $Iac16_licoutroorgao, true, 'text', $db_opcao, "onchange='js_pesquisaac16_licoutroorgao(false)';");
                db_input('z01_nome', 43, $Iac02_sequencial, true, 'text', 3);
                ?>
              </td>
            </tr>
            <tr id="tradesaoregpreco" style="display: none">
              <td nowrap title="<? @$Tac16_adesaoregpreco ?>">
                <?=
                db_ancora("Adesão de Registro Preço:", "js_pesquisaaadesaoregpreco(true)", $db_opcao);
                ?>
              </td>
              <td>
                <?
                db_input('ac16_adesaoregpreco', 10, $Iac16_adesaoregpreco, true, 'text', $db_opcao, "onchange='js_pesquisaaadesaoregpreco(false)';");
                db_input('si06_objetoadesao', 43, $Iac02_sequencial, true, 'text', 3);
                ?>
              </td>
            </tr>

            <tr id="trLicitacao" style="display: none ">
              <td nowrap>
                <?
                db_ancora('<b>Licitação:</b>', "js_pesquisa_liclicita(true)", 1);
                ?>
              </td>
              <td>
                <?
                db_input(
                  "ac16_licitacao",
                  10,
                  $Iac16_licitacao,
                  true,
                  "text",
                  1,
                  "onchange='js_pesquisa_liclicita(false)'"
                );
                db_input("l20_objeto", 40, $Il20_objeto, true, "text", 3, '');
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tac16_acordogrupo ?>">
                <?
                db_ancora("Natureza do Contrato:", "js_pesquisaac16_acordogrupo(true);", $db_opcao);
                ?>
              </td>
              <td>
                <?
                db_input(
                  'ac16_acordogrupo',
                  10,
                  $Iac16_acordogrupo,
                  true,
                  'text',
                  $db_opcao,
                  "onchange='js_pesquisaac16_acordogrupo(false);'"
                );
                db_input('ac02_descricao', 30, $Iac02_sequencial, true, 'text', 3);
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="Codunidsubanterior">
                <strong>Codunidsubanterior:</strong>
              </td>
              <td>
                <?
                db_input('manutac_codunidsubanterior', 10, $Imanutac_codunidsubanterior, true, 'text', 2, "");
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="<?= @$Tac16_numeroacordo ?>">
                <?= @$Lac16_numeroacordo ?>
              </td>
              <td>
                <?php db_input('ac16_numeroacordo', 10, $Iac16_numeroacordo, true, 'text', $db_opcao);
                db_input('ac16_numeroacordo_old', 10, $Iac16_numeroacordo, true, 'hidden', 2, ''); ?>
              </td>
            </tr>
            <tr>
              <td nowrap><?= $Lac16_dataassinatura ?>
              </td>
              <td>
                <?=
                db_inputdata(
                  'ac16_dataassinatura',
                  @$ac16_dataassinatura_dia,
                  @$ac16_dataassinatura_mes,
                  @$ac16_dataassinatura_ano,
                  true,
                  'text',
                  $iOpcao
                ); ?>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <fieldset class='fieldsetinterno'>
                  <legend>
                    <b>Vigência</b>
                  </legend>
                  <table cellpadding="0" border="0" width="100%" class="table-vigencia">
                    <tr>
                      <td width="1%">
                        <b>Inicio:</b>
                      </td>
                      <td>
                        <?php $iCampo = 2; ?>
                        <?=
                        db_inputdata(
                          'ac16_datainicio',
                          @$ac16_datainicio_dia,
                          @$ac16_datainicio_mes,
                          @$ac16_datainicio_ano,
                          true,
                          'text',
                          $iCampo
                        ); ?>
                      </td>
                      <td>
                        <b>Fim:</b>
                      </td>
                      <td>
                        <?=

                        db_inputdata(
                          'ac16_datafim',
                          @$ac16_datafim_dia,
                          @$ac16_datafim_mes,
                          @$ac16_datafim_ano,
                          true,
                          'text',
                          $iCampo,
                          "",
                          '',
                          '',
                          ''
                        ); ?>
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
            <?php

            if ($aditivo) :

              for ($i = 0; $i < pg_numrows($rsAditivo); $i++) {
                db_fieldsmemory($rsAditivo, $i); ?>
                <tr>
                  <td colspan="2">
                    <fieldset class='fieldsetinterno'>
                      <legend>
                        <b>Aditivo <?php echo $posicao ?></b>
                      </legend>
                      <table cellpadding="0" border="0" width="100%" class="table-vigencia">
                        <tr width="1%">
                          <td nowrap title="numero aditamento">
                            <strong>Nº Aditamento: </strong>
                            <td>
                              <?php
                                $numadtm = "ac26_numeroaditamento_{$ac18_sequencial}";
                                $numadtmOld = "ac26_numeroaditamento_old_{$ac18_sequencial}";
                                $$numadtm = $ac26_numeroaditamento;
                                $$numadtmOld = $ac26_numeroaditamento;
                                db_input("ac26_numeroaditamento_{$ac18_sequencial}", 10, $Iac26_sequencial, true, "text", 2, "");
                                db_input("ac26_numeroaditamento_old_{$ac18_sequencial}", 10, $Iac26_sequencial, true, 'hidden', 2, "");
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td width="1%">
                            <b>Inicio:</b>
                          </td>
                          <td>
                            <?php
                            $iCampo = 2;
                            db_inputdata(
                              "ac18_datainicio_$ac18_sequencial",
                              @$ac18_datainicio_dia,
                              @$ac18_datainicio_mes,
                              @$ac18_datainicio_ano,
                              true,
                              'text',
                              $iCampo
                            ); ?>
                          </td>
                          <td>
                            <b>Fim:</b>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "ac18_datafim_$ac18_sequencial",
                              @$ac18_datafim_dia,
                              @$ac18_datafim_mes,
                              @$ac18_datafim_ano,
                              true,
                              'text',
                              $iCampo
                            ); ?>
                          </td>
                          <td nowrap><?= $Lac16_dataassinatura ?>
                          </td>
                          <td>
                            <?php
                            db_inputdata(
                              "ac35_dataassinaturatermoaditivo_$ac18_sequencial",
                              @$ac35_dataassinaturatermoaditivo_dia,
                              @$ac35_dataassinaturatermoaditivo_mes,
                              @$ac35_dataassinaturatermoaditivo_ano,
                              true,
                              'text',
                              $iOpcao
                            ); ?>
                          </td>
                        </tr>
                      </table>
                    </fieldset>
                  </td>
                </tr>
            <?php
              }
            endif; ?>
          </table>
        </fieldset>
        <input name="alterar" type="submit" id="alterar" value="Alterar" <?= ($db_botao == false ? 'disabled' : '') ?>>
      </div>
    </form>
    </div>

</body>

</html>
<div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:400px;
            text-align: left;
            padding:3px;
            z-index:10000;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>

</div>
<script>
  function js_acordo(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_acordo',
        'func_acordoinstit.php?funcao_js=parent.js_mostraAcordo1|ac16_sequencial|z01_nome',
        'Pesquisa', true);
    } else {
      if ($F('ac16_sequencial').trim() != '') {
        js_OpenJanelaIframe('', 'db_iframe_depart',
          'func_acordoinstit.php?pesquisa_chave=' + $F('ac16_sequencial') + '&funcao_js=parent.js_mostraAcordo' +
          '&descricao=true',
          'Pesquisa', false);
      } else {
        $('ac16_resumoobjeto').value = '';
      }
    }
  }

  function js_preenchepesquisa(chave) {

    db_iframe_acordo.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>

  }

  function js_mostraAcordo(chave, descricao, erro) {

    $('ac16_resumoobjeto').value = descricao;
    if (erro == true) {
      $('ac16_sequencial').focus();
      $('ac16_sequencial').value = '';
    }

    <?php
    echo " location.href = '" . basename($GLOBALS['HTTP_SERVER_VARS']['PHP_SELF']) .
      "?chavepesquisa='+chave;";
    ?>
  }

  function js_mostraAcordo1(chave1, chave2) {
    $('ac16_sequencial').value = chave1;
    $('ac16_resumoobjeto').value = chave2;
    db_iframe_acordo.hide();

    <?php
    echo " location.href = '" . basename($GLOBALS['HTTP_SERVER_VARS']['PHP_SELF']) .
      "?chavepesquisa='+chave1;";
    ?>
  }

  function js_pesquisa_liclicita(mostra) {
    if (mostra == true) {

      js_OpenJanelaIframe('top.corpo.iframe_acordo',
        'db_iframe_liclicita',
        'func_liclicita.php?&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_objeto',
        'Pesquisa Licitações', true);
    } else {

      if (document.form1.ac16_licitacao.value != '') {

        js_OpenJanelaIframe('top.corpo.iframe_acordo',
          'db_iframe_liclicita',
          'func_liclicita.php?&pesquisa_chave=' +
          document.form1.ac16_licitacao.value + '&funcao_js=parent.js_preencheLicitacao1',
          'Pesquisa', false);
      } else {
        document.form1.ac16_licitacao.value = '';
      }
    }
  }
  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheLicitacao(codigo, objeto) {
    document.form1.ac16_licitacao.value = codigo;
    document.form1.l20_objeto.value = objeto;
    db_iframe_liclicita.hide();
  }

  function js_pesquisaac16_acordogrupo(mostra) {

    if (mostra == true) {

      var sUrl = 'func_acordogrupo.php?funcao_js=parent.js_mostraacordogrupo1|ac02_sequencial|ac02_descricao';
      js_OpenJanelaIframe('top.corpo.iframe_acordo',
        'db_iframe_acordogrupo',
        sUrl,
        'Pesquisar Grupos de Acordo',
        true,
        '0');
    } else {

      if ($('ac16_acordogrupo').value != '') {

        js_OpenJanelaIframe('top.corpo.iframe_acordo',
          'db_iframe_acordogrupo',
          'func_acordogrupo.php?pesquisa_chave=' + $('ac16_acordogrupo').value +
          '&funcao_js=parent.js_mostraacordogrupo',
          'Pesquisar Grupos de Acordo',
          false,
          '0');
      } else {
        $('ac02_sequencial').value = '';
      }
    }
  }

  function js_mostraacordogrupo(chave, erro) {
    let chave1 = $('ac16_acordogrupo').value;

    $('ac02_descricao').value = chave;
    if (erro == true) {

      $('ac16_acordogrupo').focus();
      $('ac16_acordogrupo').value = '';
    } else {

      var oGet = js_urlToObject();

      /*
      * Verifica se está sendo setada a variavel chavepesquisa na url. Caso sim, quer dizer que é um procedimento de alteração ou exclusão,
      * sendo assim o programa não pode chamar a nova numeração
      *

      if (!oGet.chavepesquisa) {
      oContrato.getNumeroAcordo();
      }*/

    }

  }

  function js_mostraacordogrupo1(chave1, chave2) {
    $('ac16_acordogrupo').value = chave1;
    $('ac02_descricao').value = chave2;
    $('ac16_acordogrupo').focus();

    db_iframe_acordogrupo.hide();
  }

  /**
   *funçao para verificar tipo origem do acordo para listar ancorar relacionada
   */
  function js_verificatipoorigem() {
    iTipoOrigem = document.form1.ac16_tipoorigem.value;
    iOrigem = document.form1.ac16_origem.value;
    if ((iOrigem == 3 && iTipoOrigem == 5) || (iOrigem == 3 && iTipoOrigem == 6) || (iOrigem == 3 && iTipoOrigem == 7) || (iOrigem == 3 && iTipoOrigem == 8) || (iOrigem == 3 && iTipoOrigem == 9)) {
      document.getElementById('trlicoutroorgao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
    }

    if (iTipoOrigem == 4 && iOrigem == 3) {
      document.getElementById('tradesaoregpreco').style.display = "";
      document.getElementById('trlicoutroorgao').style.display = "none";
      document.getElementById('trLicitacao').style.display = "none";
    }

    if (iTipoOrigem == 2 && iOrigem == 3) {
      document.getElementById('trLicitacao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }

    if ((iTipoOrigem == 2 && iOrigem == 2) || (iTipoOrigem == 3 && iOrigem == 2)) {
      console.log(document.getElementById('trLicitacao'));
      console.log(document.getElementById('tradesaoregpreco'));
      console.log(document.getElementById('trlicoutroorgao'));
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }

    if (iTipoOrigem == 3 && iOrigem == 3) {
      document.getElementById('trLicitacao').style.display = "";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }

    if (iOrigem == 3 && iTipoOrigem == 1) {
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }

    if (iOrigem == 1) {
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trLicitacao').style.display = "";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }

    if (iTipoOrigem == 4 && iOrigem == 1) {
      document.getElementById('tradesaoregpreco').style.display = "";
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }


  }

  function js_verificaorigem() {

    iOrigem = document.form1.ac16_origem.value;

    if (iOrigem == 1 || iOrigem == 2) {
      document.getElementById('trLicitacao').style.display = "none";
      document.getElementById('tradesaoregpreco').style.display = "none";
      document.getElementById('trlicoutroorgao').style.display = "none";
    }
  }

  function js_pesquisaac16_licoutroorgao(mostra) {
    if (mostra == true) {
      var sUrl = 'func_liclicitaoutrosorgaos.php?funcao_js=parent.js_buscalicoutrosorgaos|lic211_sequencial|z01_nome';
      js_OpenJanelaIframe('', 'db_iframe_liclicitaoutrosorgaos', sUrl, 'Pesquisar', true, '0');
    } else {
      if (document.form1.ac16_licoutroorgao.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_liclicitaoutrosorgaos', 'func_liclicitaoutrosorgaos.php?poo=true&pesquisa_chave=' + document.form1.ac16_licoutroorgao.value + '&funcao_js=parent.js_mostrarlicoutroorgao',
          'Pesquisar licitação Outro Órgão',
          false,
          '0');
      } else {
        $('z01_nome').value = '';
      }
    }
  }

  function js_pesquisaaadesaoregpreco(mostra) {
    if (mostra == true) {
      var sUrl = 'func_adesaoregprecos.php?funcao_js=parent.js_buscaadesaoregpreco|si06_sequencial|si06_objetoadesao';
      js_OpenJanelaIframe('', 'db_iframe_adesaoregprecos', sUrl, 'Pesquisar', true, '0');
    } else {
      if (document.form1.ac16_adesaoregpreco.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_adesaoregprecos', 'func_adesaoregprecos.php?par=true&pesquisa_chave=' + document.form1.ac16_adesaoregpreco.value + '&funcao_js=parent.js_mostraradesao',
          'Pesquisar', false, '0');
      } else {
        $('si06_objetoadesao').value = '';
      }
    }
  }

  function js_validaCampoLicitacao() {

    var iOrigem = $('ac16_origem').value;
    if (iOrigem == 3) {

      $('tdLicitacao').style.display = 'block';
    }

  }

  /**
   * função para carregar os dados da licitação selecionada no campo
   */
  function js_buscalicoutrosorgaos(chave1, chave2) {

    $('ac16_licoutroorgao').value = chave1;
    $('z01_nome').value = chave2;
    db_iframe_liclicitaoutrosorgaos.hide();
  }

  function js_mostrarlicoutroorgao(chave, erro) {
    document.form1.z01_nome.value = chave;

    if (erro == true) {
      document.form1.z01_nome.focus();
    }
  }

  /**
   * funcao para carregar adesao de registro de preco escolhida no campo
   * */
  function js_buscaadesaoregpreco(chave1, chave2) {

    $('ac16_adesaoregpreco').value = chave1;
    $('si06_objetoadesao').value = chave2;
    db_iframe_adesaoregprecos.hide();
  }

  function js_mostraradesao(chave, erro) {
    document.form1.si06_objetoadesao.value = chave;

    if (erro == true) {
      document.form1.si06_objetoadesao.focus();
    }
  }
  js_verificaorigem();
  js_verificatipoorigem();
</script>
<?php
  }
