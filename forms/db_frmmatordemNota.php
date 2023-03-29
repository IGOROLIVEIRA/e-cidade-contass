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


/**
 * Cadastro de ordem de compras por empenho
 *
 * @package compras
 * @author dbluizmarcelo Revisão $Author: dbiuri $Author: dbiuri $
 * @version $Revision: 1.28 $
 */

//MODULO: empenho
include("classes/db_db_almox_classe.php");
include("classes/db_db_almoxdepto_classe.php");
$cldb_almox = new cl_db_almox;
$cldb_almoxdepto = new cl_db_almoxdepto;
$clempempenho->rotulo->label();
$clcgm->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("coddepto");
$clrotulo->label("descrdepto");
$clrotulo->label("m51_obs");
$clrotulo->label("m51_prazoent");

$where   = " 1=1 ";
$where1  = "";
$where2  = "";
$pesqemp = false;

$coddepto = db_getsession("DB_coddepto");
$instit   = db_getsession("DB_instit");

$resultdepto = db_query("select descrdepto from db_depart where coddepto = $coddepto");
db_fieldsmemory($resultdepto, 0);

$m51_prazoent = 3;

if (isset($e60_numcgm) && $e60_numcgm != '') {
  $where   = "e60_numcgm = $e60_numcgm ";
}
if (isset($e60_numemp) && $e60_numemp != '') {
  $where1  = " and e60_numemp = $e60_numemp ";
  $pesqemp = true;
}

if (isset($e60codemp) && $e60_codemp) {
  $where2  = " and e60_codemp = '$e60_codemp' ";
  $pesqemp = true;
}

if ((isset($e60_numcgm) && $e60_numcgm != '') || (isset($e60_numemp) && $e60_numemp != '') || (isset($e60_codemp) && $e60_codemp)) {

  //rotina que traz os dados do empenho
  $result = $clempempenho->sql_record($clempempenho->sql_query_empnome(null, "*", "", "$where $where1 $where2"));
  db_fieldsmemory($result, 0, true);
  //fim

}

if ($lBloquear) {
  $pesqemp = false;
}
?>
<style>
  <? $cor = "#999999" ?>.bordas02 {
    border: 2px solid #cccccc;
    border-top-color: <?= $cor ?>;
    border-right-color: <?= $cor ?>;
    border-left-color: <?= $cor ?>;
    border-bottom-color: <?= $cor ?>;
    background-color: #999999;
  }

  .bordas {
    border: 1px solid #cccccc;
    border-top-color: <?= $cor ?>;
    border-right-color: <?= $cor ?>;
    border-left-color: <?= $cor ?>;
    border-bottom-color: <?= $cor ?>;
    background-color: #cccccc;
  }
</style>
<form name="form1" method="post" action="">
  <center>
    <table border='0'>
      <tr>
        <td>
          <fieldset>
            <legend><b>Dados da Ordem</b></legend>
            <table border="0">
              <tr>
                <td nowrap align="right" title="<?= @$Te60_numcgm ?>"><?= @$Le60_numcgm ?></td>
                <td><? db_input('e60_numcgm', 20, $Ie60_numcgm, true, 'text', 3) ?></td>
                <td nowrap align="right" title="<?= @$z01_nome ?>"><?= @$Lz01_nome ?></td>
                <td><? db_input('z01_nome', 45, $Iz01_nome, true, 'text', 3) ?></td>
              </tr>
              <tr>
                <td nowrap align="right" title="<?= @$Tz01_cgccpf ?>"><?= @$Lz01_cgccpf ?></td>
                <td><? db_input('z01_cgccpf', 20, $Iz01_cgccpf, true, 'text', 3) ?></td>
                <td nowrap align="right" title="<?= @$z01_email ?>"><?= @$Lz01_email ?></td>
                <td nowrap><? db_input('z01_email', 45, $Iz01_email, true, 'text', 3) ?>
                  <input name="Alterar CGM" type="button" id="alterarcgm" value="Alterar CGM" onclick="js_AlteraCGM(document.form1.e60_numcgm.value);" <?= $sDisable ?>>
                </td>
              </tr>
              <?
              $result_pcparam = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit")));
              if ($clpcparam->numrows > 0) {
                db_fieldsmemory($result_pcparam, 0);

                if (($pc30_importaresumoemp == 't') and ($clempempenho->numrows == 1)) {
                  $m51_obs = $e60_resumo;
                }

                if ($pc30_emiteemail == 't') {
                  $sSql = "select usuext
      from db_usuarios u
      inner join db_usuacgm c on u.id_usuario = c.id_usuario
      where cgmlogin = $z01_numcgm";
                  $rs = db_query($sSql);
                  if (pg_num_rows($rs) > 0) {
                    db_fieldsmemory($rs, 0);
                    if ($usuext == 1) {

              ?>

                      <tr>
                        <td nowrap></td>
                        <td nowrap></td>
                        <td align="right"><input id='manda_email' name="manda_mail" type="checkbox" value="X"></td>
                        <td nowrap><label for='manda_email'><b>Mandar e-mail para o fornecedor.</b></label></td>
                      </tr>
              <? //end if parametro
                    }
                  }
                }
              }
              ?>
              <tr>
                <td nowrap align="right" title="<?= @$z01_ender ?>"><?= @$Lz01_ender ?></td>
                <td><? db_input('z01_ender', 30, "$Iz01_ender", true, 'text', 3);
                    if (@$z01_numero != 0) {
                      db_input('z01_numero', 4, @$Iz01_numero, true, 'text', 3);
                    } ?></td>
                <td nowrap align="right" title="<?= @$Tz01_compl ?>"><?= @$Lz01_compl ?></td>
                <td><? db_input('z01_compl', 20, $Iz01_compl, true, 'text', 3) ?></td>
              </tr>
              <tr>
                <td nowrap align="right" title="<?= @$Tz01_munic ?>"><?= @$Lz01_munic ?></td>
                <td><? db_input('z01_munic', 30, $Iz01_munic, true, 'text', 3) ?></td>
                <td nowrap align="right" title="<?= @$Tz01_cep ?>"><?= @$Lz01_cep ?></td>
                <td><? db_input('z01_cep', 20, $Iz01_cep, true, 'text', 3) ?></td>
              </tr>
              <tr>
                <td nowrap align="right" title="<?= @$Tz01_telef ?>"><?= @$Lz01_telef ?></td>
                <td><? db_input('z01_telef', 20, $Iz01_telef, true, 'text', 3) ?></td>
                <td nowrap align="right" title="<?= @$Tm51_prazoent ?>"><?= @$Lm51_prazoent ?></td>
                <td><? db_input('m51_prazoent', 6, $Im51_prazoent, true, 'text', $dbopcao) ?></td>
              </tr>
              <tr>
                <td nowrap align="right" title="<?= @$Tm51_data ?>"><b>Data:</b></td>
                <td><? if (empty($m51_data_dia)) {
                      $m51_data_dia =  date("d", db_getsession("DB_datausu"));
                      $m51_data_mes =  date("m", db_getsession("DB_datausu"));
                      $m51_data_ano =  date("Y", db_getsession("DB_datausu"));
                    }
                    db_inputdata('m51_data', @$m51_data_dia, @$m51_data_mes, @$m51_data_ano, true, 'text', 3); ?>
                </td>
                <?
                $result_matparam = $clmatparam->sql_record($clmatparam->sql_query_file());
                if ($clmatparam->numrows > 0) {
                  db_fieldsmemory($result_matparam, 0);
                  if ($m90_tipocontrol == 'F') {

                    echo "<td nowrap align='right' title='Almox'><b>Almoxarifado :</b></td>";

                    if ($m90_almoxordemcompra == "2") {

                      $sSqlOrigemEmpenho = "select * from fc_origem_empenho($e60_numemp)";
                      $rsOrigemEmpenho   = db_query($sSqlOrigemEmpenho) or die($sSqlOrigemEmpenho);

                      for ($i = 0; $i < pg_num_rows($rsOrigemEmpenho); $i++) {
                        $oOrigemEmpenho = db_utils::fieldsMemory($rsOrigemEmpenho, $i);
                        $aDeptoEmp[]    = $oOrigemEmpenho->ridepto;
                      }

                      $rsAlmox = $cldb_almoxdepto->sql_record($cldb_almoxdepto->sql_query(null, null, "distinct m91_depto,a.descrdepto", null, " m92_depto in (" . implode(",", array_unique($aDeptoEmp)) . ") and a.instit = $instit"));

                      if ($cldb_almoxdepto->numrows > 1) {
                        $rsAlmox    = $cldb_almoxdepto->sql_record($cldb_almoxdepto->sql_query(null, null, "'0' as m91_depto, 'Nenhum' as descrdepto union all select distinct m91_depto,a.descrdepto", null, " m92_depto in (" . implode(",", array_unique($aDeptoEmp)) . ") and a.instit = $instit"));
                      }

                      $iLinhasAlmox = $cldb_almoxdepto->numrows;
                    } else {

                      $rsAlmox      = $cldb_almox->sql_record($cldb_almox->sql_query(null, "m91_depto,descrdepto", null, "db_depart.instit = $instit"));
                      $iLinhasAlmox = $cldb_almox->numrows;
                    }

                    if ($iLinhasAlmox == 0) {
                      db_msgbox("Sem Almoxarifados cadastrados!!");
                      echo "<script>location.href='emp4_ordemCompra001.php';</script>";
                    }

                    echo "<td>";
                    db_selectrecord("coddepto", $rsAlmox, true, $dbopcao);
                    echo "</td>";
                  } else {
                ?>
                    <td nowrap align="right" title="<?= @$descrdepto ?>"><? db_ancora(@$Lcoddepto, "js_coddepto(true);", 1); ?></td>
                    <td><? db_input('coddepto', 6, $Icoddepto, true, 'text', $dbopcao, " onchange='js_coddepto(false);'");
                        db_input('descrdepto', 35, $Idescrdepto, true, 'text', 3, ''); ?>
                    </td>
                  <?
                  }
                } else {
                  ?>
                  <td nowrap align="right" title="<?= @$descrdepto ?>"><? db_ancora(@$Lcoddepto, "js_coddepto(true);", $dbopcao); ?></td>
                  <td><? db_input('coddepto', 6, $Icoddepto, true, 'text', $dbopcao, " onchange='js_coddepto(false);'");
                      db_input('descrdepto', 35, $Idescrdepto, true, 'text', 3, ''); ?>
                  </td>
                <? } ?>
              </tr>
              <tr>
                <td align="right"><b>Origem do recurso:</b></td>
                <td>
                  <?
                  $sSql = db_query("select o58_programa||' - '||o54_descr as programa from orcdotacao inner join orcprograma on o54_programa = o58_programa and o54_anousu = o58_anousu inner join empempenho on e60_coddot = o58_coddot and e60_anousu = o58_anousu where e60_numemp = $e60_numemp");
                  db_fieldsmemory($sSql, 0, true);
                  db_input("programa", 45, @$Iprograma, true, 'text', 3, '');
                  ?>
                </td>
                <td nowrap align="right" title="<?= @$Te60_codemp ?>">
                <?
                db_ancora("Empenho:", "js_pesquisaEmpenho({$e60_numemp});", "1");
                ?>
                </td>
                <td>
                  <? 
                  $sSql = db_query("select e60_codemp||'/'||e60_anousu as numempano from empempenho where e60_numemp = $e60_numemp");
                  db_fieldsmemory($sSql, 0, true);
                  db_input('numempano', 20, $Ie60_codemp, true, 'text', 3) 
                  ?>
                </td>
              </tr>
              <tr>
                <td align='right'><b>Obs:</b></td>
                <td colspan='3' align='left'>
                  <?
                  $sSql = db_query("select e60_resumo as m51_obs from empempenho where e60_numemp = $e60_numemp");
                  db_fieldsmemory($sSql, 0, true);
                  db_textarea("m51_obs", "", "110", $Im51_obs, true, 'text', $dbopcao, "onkeyup = 'return js_validaCaracteres(this.value, m51_obs.id)';");

                  ?>
                </td>

              </tr>
              <tr>
                <td colspan='4' align='center'></td>
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td colspan='4' align='center'>
          <? if ($e60_numcgm != "") {
            $result = db_query("select * from empempenho inner join empempitem on e62_numemp = e60_numemp inner join pcmater on pc01_codmater = e62_item where e60_numcgm=$e60_numcgm");
            if (pg_numrows($result) > 0) { ?>
              <input name="incluir" type="submit" value="Incluir" onclick=" return js_valida()" <?= $sDisable ?>>
              <input name="voltar" type="button" value="Voltar" onclick="location.href='emp4_ordemCompra001.php';" <?= $sDisable ?>>
            <? } else { ?>
              <input name="incluir" type="submit" disabled value="Incluir" onclick=" return js_valida()" <?= $sDisable ?>>
              <input name="voltar" type="button" value="Voltar" onclick="location.href='emp4_ordemCompra001.php';" <?= $sDisable ?>>
            <? }
          } else { ?>
            <input name="incluir" type="submit" disabled value="Incluir" onclick=" return js_valida()" <?= $sDisable ?>>
            <input name="voltar" type="button" value="Voltar" onclick="location.href='emp4_ordemCompra001.php';" <?= $sDisable ?>><? } ?>
        </td>

      </tr>
      <tr>
        <td align='center' valign='top' colspan='2'>
          <fieldset>
            <legend><b>Dados da Ordem</b></legend>
            <?
            if ($pesqemp == true) {
            ?>
              <table border='0' cellspacing="0" cellpadding="0" style='border:2px inset white; padding-bottom:15px;' width='100%' bgcolor="white" id="dadosDaOrdem">
                <tr class=''>
                  <td class='table_header' title='Marca/desmarca todos' align='center'>
                    <input type='checkbox' style='display:none' id='mtodos' onclick='js_marca(false)'>
                    <a onclick='js_marca(true)' style='cursor:pointer'><b>M</b></a>
                  </td>
                  <td class='table_header' align='center'><b>Seq.</b></td>
                  <td class='table_header' align='center'><b>Cod. Item</b></td>
                  <td class='table_header' align='center' style='width:26%'><b>Item</b></td>
                  <td class='table_header' align='center'><b>Unid.</b></td>

                  <!--<td class='table_header' align='center'><b>Descrição</b></td>-->
                  <td class='table_header' align='center'><b>Quantidade</b></td>
                  <td class='table_header' align='center'><b>Vlr. Uni.</b></td>
                  <td class='table_header' align='center'><b>Valor Total</b></td>
                  <td class='table_header' align='center'><b>Quantidade</b></td>
                  <td class='table_header' align='center'><b>Valor</b></td>
                </tr>
                <tbody id='dados' style='height:150px;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>
                  <?
                  if ((isset($e60_numcgm) && $e60_numcgm != "")) {

                    $where = "";
                    $where1 = "";
                    if (isset($e60_numemp)) {
                      $where = "and e60_numemp = $e60_numemp";
                    }

                    if (isset($e60_codemp)) {
                      $where1 = "and e60_codemp = '$e60_codemp'";
                    }
                    $sSQLemp  = "select e60_numemp, ";
                    $sSQLemp .= "       e60_codemp, ";
                    $sSQLemp .= "       e62_item, ";
                    $sSQLemp .= "       pc01_descrmater, ";
                    $sSQLemp .= "       e62_sequen, ";
                    $sSQLemp .= "	      e62_descr, ";
                    $sSQLemp .= "	      e62_vlrun, ";
                    $sSQLemp .= "	      case when matunid.m61_abrev is null or matunid.m61_abrev = '' then coalesce(matunidaut.m61_abrev,coalesce(matunidsol.m61_abrev,'UN')) else coalesce(matunid.m61_abrev,coalesce(matunidsol.m61_abrev,'UN')) end as m61_abrev, ";
                    $sSQLemp .= "       e62_sequencial,";
                    $sSQLemp .= "	      pc01_servico,";
                    $sSQLemp .= "	      pc01_fraciona,";
                    $sSQLemp .= "	     (select rnsaldoitem  from  fc_saldoitensempenho(e60_numemp, e62_sequencial)) as e62_quant,";
                    $sSQLemp .= "	     (select round(rnsaldovalor,2) from fc_saldoitensempenho(e60_numemp, e62_sequencial)) as e62_vltot,";
                    $sSQLemp .= "	      e62_servicoquantidade";
                    $sSQLemp .= "  from empempenho ";
                    $sSQLemp .= "       inner join empempitem on e62_numemp       = e60_numemp ";
                    $sSQLemp .= "       inner join pcmater    on pc01_codmater    = e62_item";
                    $sSQLemp .= "       inner join pcsubgrupo on pc04_codsubgrupo = pc01_codsubgrupo";
                    $sSQLemp .= "       inner join pctipo     on pc05_codtipo     = pc04_codtipo";
                    $sSQLemp .= "       left  join empempaut             on empempaut.e61_numemp            = empempenho.e60_numemp";
                    $sSQLemp .= "       left  join empautoriza           on empempaut.e61_autori            = empautoriza.e54_autori";
                    $sSQLemp .= "       left  join empautitem            on empempaut.e61_autori            = empautitem.e55_autori and empempitem.e62_sequen          = empautitem.e55_sequen";
                    $sSQLemp .= "       left join empautitempcprocitem  pcprocitemaut  on pcprocitemaut.e73_autori        = empautitem.e55_autori and pcprocitemaut.e73_sequen        = empautitem.e55_sequen";
                    $sSQLemp .= "       left join pcprocitem                           on pcprocitem.pc81_codprocitem     = pcprocitemaut.e73_pcprocitem";
                    $sSQLemp .= "       left join solicitem                            on solicitem.pc11_codigo           = pcprocitem.pc81_solicitem";
                    $sSQLemp .= "       left join solicitemunid                on solicitemunid.pc17_codigo                = solicitem.pc11_codigo";
                    $sSQLemp .= "       left join matunid                on solicitemunid.pc17_unid                = matunid.m61_codmatunid";
                    $sSQLemp .= "       left join matunid matunidaut               on empautitem.e55_unid                = matunidaut.m61_codmatunid";
                    $sSQLemp .= "       left join matunid matunidsol               on solicitemunid.pc17_unid                = matunidsol.m61_codmatunid";
                    $sSQLemp .= " where e60_numcgm = {$e60_numcgm} {$where} {$where1}";
                    $sSQLemp .= "  order by e60_numemp";
                    $result   = db_query($sSQLemp);

                    $numrows  = pg_num_rows($result);


                    $sSQLacordo = "select
                    distinct ac26_acordo
                  from
                    acordoposicao
                  inner join acordoitem on
                    ac20_acordoposicao = ac26_sequencial
                  inner join acordoitemexecutado on
                    ac20_sequencial = ac29_acordoitem
                  inner join acordoitemexecutadoempautitem on
                    ac29_sequencial = ac19_acordoitemexecutado
                  inner join empautitem on
                    e55_sequen = ac19_sequen
                    and ac19_autori = e55_autori
                  inner join empautoriza on
                    e54_autori = e55_autori
                  left join empempaut on
                    e61_autori = e54_autori
                  left join empempenho on
                    e61_numemp = e60_numemp
                  where
                    e60_numemp = {$e60_numemp}";
                    $resultAcordo   = db_query($sSQLacordo);

                    $numrowAcordo  = pg_num_rows($resultAcordo);

                    db_fieldsmemory($resultAcordo, 0);

                    $sClassName = 'normal';
                    $sChecked   = '';
                    //      if ($numrows == 1) {
                    //
                    //        $sChecked   = " checked ";
                    //        $sClassName = " marcado ";
                    //      }

                    for ($i = 0; $i < $numrows; $i++) {

                      $disabled    = null;
                      $iOpcao      = 1;
                      $sClassName  = "normal";
                      db_fieldsmemory($result, $i);
                      if($numrowAcordo == 1){
                        $sSQLtabela = "select case when pc01_tabela = false then 0 else 1 end as pc01_tabela from pcmater where pc01_codmater = {$e62_item}";
                        $resultTabela   = db_query($sSQLtabela);
                        db_fieldsmemory($resultTabela, 0);
                      }
                      
                      if ($e62_vltot <= 0 || $e62_quant <= 0) {

                        $disabled   = " disabled ";
                        $sChecked   =  '';
                        $iOpcao     = 3;
                        $sClassName  = "disabled";
                      }

                      echo "<tr id='trchk{$e62_sequencial}' class='{$sClassName}'>";

                      // Marcar
                      echo "  <td class='linhagrid' title='Inverte a marcação' align='center'>";
                      echo "  <input type='checkbox' {$sChecked} {$disabled} id='chk{$e62_sequencial}' class='itensEmpenho'";
                      echo "    name='itensOrdem[]' value='{$e62_sequencial}' onclick='js_marcaLinha(this, $e62_sequencial)'></td>";

                      // Sequencia
                      echo "  <td class='linhagrid' id='sequen{$e62_sequencial}' align='center'>$e62_sequen</td>";


                      // Código do item
                      echo "  <td class='linhagrid' id='e62_item{$e62_sequencial}' align='center'>$e62_item</td>";

                      // Item
                      echo "  <td class='linhagrid' id='e62_descr{$e62_sequencial}' nowrap align='left' title='$pc01_descrmater' ondblclick='js_verificatabela($e60_numemp,$e62_item,$ac26_acordo, $pc01_tabela)'><small>" . substr($pc01_descrmater, 0, 20) . "&nbsp;</small></td>";

                      // Unidade
                      echo "  <td class='linhagrid' id='m61_abrev{$e62_sequencial}' nowrap align='left' title='$m61_abrev'>{$m61_abrev}</td>";

                      // Descrição
                      // echo "  <td class='linhagrid' nowrap align='left' title='$e62_descr'><small>".substr($e62_descr,0,20)."&nbsp;</small></td>";

                      // Quantidade
                      echo "  <td class='linhagrid' id='e62_quant{$e62_sequencial}' align='center'>$e62_quant</td>";

                      // Valor unitário
                      echo "  <td class='linhagrid' id='e62_vluni{$e62_sequencial}'align='center'>";
                      echo "  <input type='text' style='border:0px' readonly id='vlrunitario{$e62_sequencial}' ";
                      echo "         size='6' name='vlrunitario{$e62_sequencial}' value='{$e62_vlrun}'</td>";

                      // Valor total
                      echo "  <td class='linhagrid' id='e62_vltot{$e62_sequencial}'align='center'>$e62_vltot</td>";


                      ${"quantidade{$e62_sequencial}"} =  $e62_quant;
                      ${"valor{$e62_sequencial}"}      =  $e62_vltot;
                      if ($pc01_servico == 'f') {

                        // Quantidade
                        $pc01_fraciona = $pc01_fraciona == 'f' ? "false" : "true";
                        echo "<td class='linhagrid' align='center'>";
                        db_input(
                          "quantidade{$e62_sequencial}",
                          6,
                          0,
                          true,
                          'text',
                          $iOpcao,
                          "onkeyPress='return js_validaQuantidade(event,{$pc01_fraciona},this)' 
              onchange='js_verifica($e62_quant,this.value,this.name,$e62_vlrun,$e60_numemp,$e62_sequencial)'",
                          '',
                          '',
                          'text-align:right'
                        );
                        echo "</td>";

                        // Valor
                        echo "<td class='linhagrid' align='center'>";
                        db_input(
                          "valor{$e62_sequencial}",
                          6,
                          0,
                          true,
                          'text',
                          3,
                          "onkeyPress='return js_teclas(event)'
              id='e62_vl{$e62_sequencial}'
              onchange='js_verifica($e62_vltot,this.value,this.name,$e62_vlrun,$e60_numemp,$e62_sequencial)'",
                          '',
                          '',
                          'text-align:right'
                        );
                        echo "</td>";
                        echo "</tr> ";
                      } else {

                        $sStyle = 'text-align:right';
                        /**
                         * Verifica se o serviço é controlado pela quantidade
                         */
                        if ($e62_servicoquantidade == 't') {
                          $iControlaQuantidade = 1;
                          $iControlaValor      = 3;
                        } else {
                          $iControlaQuantidade = 3;
                          $iControlaValor      = 1;

                          if ($e62_vltot <= 0  || $e62_quant <= 0) {
                            $iControlaValor = $iOpcao;
                          }
                        }

                        if ($e62_vltot <= 0  || $e62_quant <= 0) {
                          $iControlaQuantidade = 3;
                          $iControlaValor      = 3;
                        }

                        echo "<td class='linhagrid' align='center'><small>";
                        db_input(
                          "quantidade{$e62_sequencial}",
                          6,
                          0,
                          true,
                          'text',
                          $iControlaQuantidade,
                          "onchange='js_verifica($e62_quant,this.value,this.name,$e62_vlrun,$e60_numemp,$e62_sequencial);'",
                          '',
                          '',
                          $sStyle
                        );
                        echo "</small></td>
          <td class='linhagrid' align='center'><small>";
                        db_input(
                          "valor{$e62_sequencial}",
                          6,
                          0,
                          true,
                          'text',
                          $iControlaValor,
                          "onkeyPress='return js_teclas(event)'
                   onfocus='this.oldValue = this.value'
                   onchange='alteraValor($e62_vltot,this.value,this.name,$e62_vlrun,$e60_numemp,$e62_sequencial,this.oldValue)'
                   ",
                          '',
                          '',
                          'text-align:right'
                        );
                        echo "</small></td>";
                        echo "</tr> ";
                      }
                    }
                  }
                  ?>
                  <tr style='height: auto'>
                    <td>&nbsp;</td>
                  </tr>

                  <!--        <tr style='height: auto; background-color:#EEEFF2; border-top:1px solid #444444;'>-->
                  <!--            <td></td>-->
                  <!--            <td colspan="9"><b>Total de itens: </b><span id="total_de_itens">0</span></td>-->
                  <!--            <td colspan="2"><b>Valor total: </b><span id="valor_total">0.00</span></td>-->
                  <!--        </tr>-->
                </tbody>
              </table>
              <div id="itenstabela" style="display:none">
                <fieldset>
                  <legend><b>Adicionar Item</b></legend>
                  <table>
                    <tr>
                      <td>
                        <?
                        db_ancora("Código do material", "js_pesquisapc16_codmater(true);", 1);
                        ?>
                      </td>
                      <td nowrap>
                        <?
                        db_input('pc16_codmater', 8, $Ipc16_codmater, true, 'text', 1, " onchange='js_pesquisapc16_codmater(false);'");
                        db_input('pc01_descrmater', 50, $Ipc01_descrmater, true, 'text', 1, '');
                        echo "<b>Quantidade<b>";
                        db_input('l223_quant', 5, 0, true, 'text', 1, "onchange='js_calculatotal();'");
                        echo "<b>Unitário<b>";
                        db_input('l223_vlrn', 5, 0, true, 'text', 1, "onchange='js_calculatotal();'");
                        echo "<b>Total<b>";
                        db_input('l223_total', 5, 0, true, 'text', 3, '');
                        db_input('codempenho', 5, 0, true, 'text', 3, '');
                        db_input('coditemordem', 5, 0, true, 'text', 3, '');
                        db_input('coditemordemtabela', 5, 0, true, 'text', 3, '');
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: center;">
                        <input type="button" value='Adicionar Item' id='btnAddItem'>
                        <input type="button" value='Alterar Item' id='btnAlterarItem' style="display:none;">
                        <input type="button" value='Novo Item' id='btnNovoItem' style="display:none;">
                        <input type="button" value='Excluir Item' id='btnExcluirItem' style="display:none;">
                      </td>
                    </tr>                   
                  </table>
                  <table width='100%'>
                    <tr>
                      <td>
                        <fieldset>
                          <legend>
                            <b>Itens</b>
                          </legend>
                          <div id='gridItensSolicitacao'>

                          </div>
                        </fieldset>
                      </td>
                    </tr>
                  </table>
              </div>

              <div style="display: block;height: auto; background-color:#EEEFF2; border-top:1px solid #444444; padding: 6px 42px 19px 10px;">
                <div style="float: left; width: 50%; text-align: left">
                  <b>Total de Registros: </b><span id="total_de_itens">0</span>
                </div>
                <div style="float: left; width: 50%; text-align: right">
                  <b>Valor total: </b><span id="valor_total">0.00</span>
                </div>
              </div>

            <?
            }
            ?>
        </td>
      </tr>
    </table>
  </center>
  <?
  db_input("valores", 100, 0, true, "hidden", 3);
  db_input("val", 100, 0, true, "hidden", 3);
  ?>
</form>
</center>
<script>
  
  var sUrlRC = 'com4_ordemdecompra001.RPC.php';

  function js_init(empenho,item) {

  oGridItens = new DBGrid('gridItens');
  oGridItens.nameInstance = "gridItens";
  oGridItens.setCellAlign(new Array("center", "center","center", "center", "center", "center", "center"));
  oGridItens.setCellWidth(new Array("6%","6%", "40%", "10%", "10%", "10%", "10%"));
  oGridItens.setHeader(new Array("Ordem", "Cod Material", "Descrição", "Quantidade", "Valor Unitário", "Valor Total", "Ação"));
  oGridItens.aHeaders[1].lDisplayed = false;
  oGridItens.show($('gridItensSolicitacao'));
  $('btnAddItem').observe("click", js_adicionarItem);
  $('btnAlterarItem').observe("click", js_alterarItem);
  $('btnNovoItem').observe("click", js_novoItem);
  $('btnExcluirItem').observe("click", js_excluirItem);
  js_pesquisaitemtabela(empenho,item);

  }

  function js_validaQuantidade(evt, lFraciona, obj) {
    t = document.all ? event.keyCode : evt.which;
    if (obj.value.indexOf(".") != -1 && t == 46) {
      return false;
    }
    if (lFraciona) {
      sMask = "0-9|.";

    } else {
      sMask = "0-9";
      return js_pressKey(evt, sMask);

    }

    var sMask = '';

    var obj = event.srcElement ? event.srcElement : event.currentTarget;
    var t = document.all ? event.keyCode : event.which;
    if (t == 44) {
      if (obj.value.indexOf(".") == -1) {
        obj.value += ".";
      }
    }
    if (obj != null) {

      if (obj.value.indexOf(".") != -1 && t == 46) {
        return false;
      }
    }
    sMask = "0-9|.";
    return js_mask(event, sMask);
  }

  function js_pesquisaEmpenho(iNumEmp) {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_empempenho', 'func_empempenho001.php?e60_numemp=' + iNumEmp, 'Pesquisa', true);
  }

  function js_AlteraCGM(cgm) {
    js_OpenJanelaIframe('', 'db_iframe_altcgm', 'prot1_cadcgm002.php?chavepesquisa=' + cgm + '&testanome=true&autoc=true', 'Altera Cgm', true);
  }

  function js_coddepto(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?funcao_js=parent.js_mostracoddepto1|coddepto|descrdepto', 'Pesquisa', true);
    } else {
      coddepto = document.form1.coddepto.value;
      if (coddepto != "") {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_db_depart', 'func_db_depart.php?pesquisa_chave=' + coddepto + '&funcao_js=parent.js_mostracoddepto', 'Pesquisa', false);
      } else {
        document.form1.descrdepto.value = '';
      }
    }
  }

  function js_mostracoddepto1(chave1, chave2) {
    document.form1.coddepto.value = chave1;
    document.form1.descrdepto.value = chave2;
    db_iframe_db_depart.hide();
  }

  function js_mostracoddepto(chave, erro) {

    document.form1.descrdepto.value = chave;
    if (erro) {

      document.form1.coddepto.focus();
      document.form1.coddepto.value = '';

    }
  }

  function js_valida() {


    if (document.form1.coddepto.value == 0) {
      alert("Favor escolha algum almoxarifado!");
      return false;
    }

    //buscamos todos os itens marcados pelo usuário, e validos ele.
    var itensOrdem = js_getElementbyClass(form1, "itensEmpenho");

    itensMarcados = new Number(0);
    for (i = 0; i < itensOrdem.length; i++) {

      if (itensOrdem[i].checked) {

        //codigo do item
        iItem = itensOrdem[i].value;
        //valor do item (identificamos pela string "valor" seguido do sequencial do empenho.
        var nValor = new Number($('valor' + iItem).value);
        var nQuantidade = new Number($('quantidade' + iItem).value);
        var nValorEmpenho = new Number($('e62_vltot' + iItem).innerHTML);
        var nQteEmpenho = new Number($('e62_quant' + iItem).innerHTML);
        if (nValor > nValorEmpenho || nQuantidade > nQteEmpenho || (nValor == 0 || nQuantidade == 0)) {

          var iSequen = js_stripTags($('e62_descr' + iItem).innerHTML);
          var iEmpenho = $('empenho' + iItem).innerHTML
          alert("Item (" + iSequen + ") do Empenho " + iEmpenho + " possui valores/quantidade inválidas.\nVerifique");
          return false;
        } else {
          itensMarcados++;
        }
      }
    }
    if (itensMarcados == 0) {
      alert("Não há itens Selecionados.\nVerifique.");
      return false;
    } else {
      js_validaCaracteres($('m51_obs').value, m51_obs.id);
      return true;
    }
  }

  function js_marca(val) {

    obj = document.getElementById('mtodos');

    if (obj.checked) {
      obj.checked = false;
    } else {
      obj.checked = true;
    }
    itens = js_getElementbyClass(form1, 'itensEmpenho');

    for (i = 0; i < itens.length; i++) {
      if (itens[i].disabled == false) {
        if (obj.checked == true) {
          itens[i].checked = true;
          js_marcaLinha(itens[i], itens[i].value);
        } else {
          itens[i].checked = false;
          js_marcaLinha(itens[i], itens[i].value);
        }
      }
    }
  }



  function js_marcaLinha(obj, sequencia) {

    var vlr_anterior = $('valor' + sequencia).value;
    var qtd_anterior = 0;
    if ($('quantidade' + sequencia).value) {
      qtd_anterior = formataValor($('quantidade' + sequencia).value);
    }



    var vlr_unitario = $("vlrunitario" + sequencia).value;
    if (obj.checked) {

      if ($('tr' + obj.id).className === 'marcado') {

        $('quantidade' + sequencia).on('change', function(event, ui) {
          var temp = parseFloat($('valor_total').innerText) + parseFloat($('valor' + sequencia).value);
          $("valor_total").innerText = formataValor + --(temp);
        });
        return;
      }

      $("total_de_itens").innerText = parseInt($("total_de_itens").innerText, 10) + 1;
      $('tr' + obj.id).className = 'marcado';

      if (vlr_unitario == $('valor' + sequencia).value) {
        var temp = parseFloat($('valor_total').innerText) + parseFloat(vlr_unitario) * parseFloat(qtd_anterior);
      } else {
        var temp = parseFloat($('valor_total').innerText) + $('valor' + sequencia).value * parseFloat(qtd_anterior);

      }

      if (!document.getElementById('quantidade' + sequencia).hasAttribute('readonly')) {
        temp = parseFloat($('valor_total').innerText) + formataValor($('quantidade' + sequencia).value) * vlr_unitario;
      }



      let resultado = formataValor(temp.toFixed(2));


      $("valor_total").innerText = resultado;

    } else {

      if ($('tr' + obj.id).className === 'marcado') {

        $('tr' + obj.id).className = 'normal';

        $("total_de_itens").innerText = parseInt($("total_de_itens").innerText, 10) >= 1 ?
          parseInt($("total_de_itens").innerText, 10) - 1 : 0;

        var vlr_unitario = $("vlrunitario" + sequencia).value;
        if (vlr_unitario == $('valor' + sequencia).value) {
          var temp = parseFloat($("valor_total").innerText) - parseFloat(vlr_unitario) * parseFloat(qtd_anterior);

        } else {
          var temp = parseFloat($("valor_total").innerText) - $('valor' + sequencia).value * parseFloat(qtd_anterior);

        }

        if (!document.getElementById('quantidade' + sequencia).hasAttribute('readonly')) {
          temp = parseFloat($('valor_total').innerText) - formataValor($('quantidade' + sequencia).value) * vlr_unitario;
        }

        $("valor_total").innerText = formataValor(temp.toFixed(2));
      }
    }


  }

  function js_verificatabela(empenho,item,acordo,tabela){
   if( $('itenstabela').style.display == 'none'){
      if(tabela == 1 && acordo != "block"){
        $('itenstabela').style.display = '';
        $('pc16_codmater').value = "";
        $('pc01_descrmater').value = "";
        $('codempenho').value = empenho;
        $('coditemordem').value = item;
        $('codempenho').style.display = 'none';
        $('coditemordem').style.display = 'none';
        $('coditemordemtabela').style.display = 'none';
        js_init(empenho,item);
      }
   }else{
    if(tabela == 1 && acordo != ""){
        $('itenstabela').style.display = 'none';
  
      }
   }

  }

  function js_pesquisapc16_codmater(mostra) {

    if (mostra == true) {
      js_OpenJanelaIframe('',
        'db_iframe_pcmater',
        'func_pcmatersolicita.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater',
        'Pesquisar Materias/Serviços',
        true,
        '0'
      );
    } else {

      if ($F('pc16_codmater') != '') {

        js_OpenJanelaIframe('',
          'db_iframe_pcmater',
          'func_pcmatersolicita.php?pesquisa_chave=' +
          $F('pc16_codmater') +
          '&funcao_js=parent.js_mostrapcmater',
          'Pesquisar Materiais/Serviços',
          false, '0'
        );
      } else {
        $('pc16_codmater').value = '';
      }
    }
    }

    function js_mostrapcmater(sDescricaoMaterial, Erro) {
    $('pc01_descrmater').value = sDescricaoMaterial;
    if (Erro == true) {
      $('pc16_codmater').value = "";
    }
    }

    function js_mostrapcmater1(iCodigoMaterial, sDescricaoMaterial) {

    $('pc16_codmater').value = iCodigoMaterial;
    $('pc01_descrmater').value = sDescricaoMaterial;
    db_iframe_pcmater.hide();
  }

  function js_adicionarItem() {

    if ($F('pc01_descrmater') == "") {

      alert('Informe a descrição!');
      return false;

    }
    if ($F('l223_quant') == "") {

    alert('Informe a quantidade!');
    return false;

    }
    if ($F('l223_vlrn') == "") {

    alert('Informe o valor unitário!');
    return false;

    }
    if ($F('l223_total') == 0) {

    alert('Valor total zerado!');
    return false;

    }
    
    js_divCarregando('Aguarde, adicionando item', "msgBox");
    var oParam = new Object();
    oParam.pcmaterordem = $F('coditemordem');
    oParam.pcmatertabela = $F('pc16_codmater');
    oParam.quantidade = $F('l223_quant');
    oParam.valorunit = $F('l223_vlrn');
    oParam.codempenho = $F('codempenho') ;
    oParam.descricao = $F('pc01_descrmater') ;
    oParam.exec = "adicionarItemOrdemTabela";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });
  }

  function js_retornoadicionarItem(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.iStatus == 1) {

      js_preencheGrid(oRetorno.itens);
      js_limparForm();

    } else {
      alert(oRetorno.message.urlDecode());
    }
  }

  function js_pesquisaitemtabela(empenho,item){
    if (empenho == "") {

    alert('Numero de empenho vazio');
    return false;

    }
    if (item == "") {

    alert('Item vazio');
    return false;

    }

    js_divCarregando('Aguarde, adicionando item', "msgBox");
    var oParam = new Object();
    oParam.pcmaterordem = item;
    oParam.codempenho = empenho;
    oParam.exec = "buscaItemOrdemTabela";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });
  }

  function js_limparForm() {

    $('coditemordemtabela').value = "";
    $('pc16_codmater').value = "";
    $('pc01_descrmater').value = "";
    $('l223_quant').value = "";
    $('l223_vlrn').value = "";
    $('l223_total').value = "";
    $('btnAddItem').style.display = "";
    $('btnAlterarItem').style.display = "none";
    $('btnNovoItem').style.display = "none";
    $('btnExcluirItem').style.display = "none";
    $('pc16_codmater').disabled = false;
    $('pc01_descrmater').disabled = false;
    $('l223_quant').disabled = false;
    $('l223_vlrn').disabled = false;
    $('l223_total').disabled = false;
    $('btnFecharWindowAux').onclick = function() {
      windowAuxiliar.hide();
    }

  }

  function js_preencheGrid(aItens) {

    aItensAbertura = aItens;
    oGridItens.clearAll(true);
    for (var i = 0; i < aItens.length; i++) {

      with(aItens[i]) {

        var aLinha = new Array();
        aLinha[0] = i + 1;
        aLinha[1] = pc01_codmater;
        aLinha[2] = iDescricao.urlDecode();
        aLinha[3] = iQuantidade;
        aLinha[4] = iUnit;
        aLinha[5] = iValor;
        aLinha[6] = "<input type='button' value='A' onclick='js_alterarLinha(" + iSequencial + ", " + i + ")'>";
        aLinha[6] += "<input type='button' value='E' onclick='js_excluirLinha(" + iSequencial + ", " + i + ")'>";

        oGridItens.addRow(aLinha);
        oGridItens.aRows[i].aCells[0].sStyle += "background-color:#DED5CB;font-weight:bold;padding:1px";

      }
    }
    oGridItens.renderRows();
  }

  function js_alterarLinha(coditemtabela,linha){
    $('coditemordemtabela').value = coditemtabela; 
    $('pc16_codmater').value = oGridItens.aRows[linha].aCells[1].getValue();
    $('pc01_descrmater').value = oGridItens.aRows[linha].aCells[2].getValue();
    $('l223_quant').value = oGridItens.aRows[linha].aCells[3].getValue();
    $('l223_vlrn').value = oGridItens.aRows[linha].aCells[4].getValue();
    $('l223_total').value = oGridItens.aRows[linha].aCells[5].getValue();
    $('btnAddItem').style.display = "none";
    $('btnAlterarItem').style.display = "";
    $('btnNovoItem').style.display = "";
  }

  function js_excluirLinha(coditemtabela,linha){
    $('coditemordemtabela').value = coditemtabela; 
    $('pc16_codmater').value = oGridItens.aRows[linha].aCells[1].getValue();
    $('pc01_descrmater').value = oGridItens.aRows[linha].aCells[2].getValue();
    $('l223_quant').value = oGridItens.aRows[linha].aCells[3].getValue();
    $('l223_vlrn').value = oGridItens.aRows[linha].aCells[4].getValue();
    $('l223_total').value = oGridItens.aRows[linha].aCells[5].getValue();
    $('pc16_codmater').disabled = true;
    $('pc01_descrmater').disabled = true;
    $('l223_quant').disabled = true;
    $('l223_vlrn').disabled = true;
    $('l223_total').disabled = true;
    $('btnAddItem').style.display = "none";
    $('btnAlterarItem').style.display = "none";
    $('btnNovoItem').style.display = "none";
    $('btnExcluirItem').style.display = "";
  }

  function js_alterarItem(){

    if ($F('pc16_codmater') == "") {

      alert('Informe o material!');
      return false;

    }
    if ($F('l223_quant') == "") {

    alert('Informe a quantidade!');
    return false;

    }
    if ($F('l223_vlrn') == "") {

    alert('Informe o valor unitário!');
    return false;

    }
    if ($F('l223_total') == 0) {

    alert('Valor total zerado!');
    return false;

    }
    
    js_divCarregando('Aguarde, adicionando item', "msgBox");
    var oParam = new Object();
    oParam.pcmaterordem = $F('coditemordem');
    oParam.pcmatertabela = $F('pc16_codmater');
    oParam.quantidade = $F('l223_quant');
    oParam.valorunit = $F('l223_vlrn');
    oParam.codempenho = $F('codempenho') ;
    oParam.coditemtabela = $F('coditemordemtabela') ;
    oParam.exec = "alterarItemOrdemTabela";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });


    
  }

  function js_novoItem(){
    $('coditemordemtabela').value = "";
    $('pc16_codmater').value = "";
    $('pc01_descrmater').value = "";
    $('l223_quant').value = "";
    $('l223_vlrn').value = "";
    $('l223_total').value = "";
    $('btnAddItem').style.display = "";
    $('btnAlterarItem').style.display = "none";
    $('btnNovoItem').style.display = "none";
  }

  function js_excluirItem(){
    if ($F('pc16_codmater') == "") {

      alert('Informe o material!');
      return false;

    }

    
    js_divCarregando('Aguarde, adicionando item', "msgBox");
    var oParam = new Object();
    oParam.pcmaterordem = $F('coditemordem');
    oParam.pcmatertabela = $F('pc16_codmater');
    oParam.quantidade = $F('l223_quant');
    oParam.valorunit = $F('l223_vlrn');
    oParam.codempenho = $F('codempenho') ;
    oParam.coditemtabela = $F('coditemordemtabela') ;
    oParam.exec = "excluirItemOrdemTabela";
    var oAjax = new Ajax.Request(sUrlRC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_retornoadicionarItem
    });

  }

  function js_calculatotal(){
    quan = $('l223_quant').value;
    unit =  $('l223_vlrn').value;
    quan = quan.replace(/,/g, '.');
    unit = unit.replace(/,/g, '.');
    let contDot = 0;
    let novaQuantidade = '';
    for (cont = 0; cont < quan.length; cont++) {

      if (quan[cont] != '.') {
        novaQuantidade += quan[cont];
      } else {
        contDot += 1;
        if (contDot > 1) {
          novaQuantidade += '';
        } else {
          novaQuantidade += quan[cont];
        }
      }
    }
    if (contDot > 1) {
      alert('Valor Decimal já inserido');
    }
    contDot = 0;
    let novoValorunit = '';
    for (cont = 0; cont < unit.length; cont++) {

      if (unit[cont] != '.') {
        novoValorunit += unit[cont];
      } else {
        contDot += 1;
        if (contDot > 1) {
          novoValorunit += '';
        } else {
          novoValorunit += unit[cont];
        }
      }
    }

    if (contDot > 1) {
      alert('Valor Decimal já inserido');
    }

    
    quan = novaQuantidade;
    unit = novoValorunit;
    $('l223_quant').value = quan;
    $('l223_vlrn').value = unit;
    $('l223_total').value = round(quan * unit,2);
    
  }

  function js_verifica(max, quan, nome, valoruni, numemp, sequencia) {
    quan = quan.replace(/,/g, '.');

    let contDot = 0;
    let novaQuantidade = '';
    for (cont = 0; cont < quan.length; cont++) {

      if (quan[cont] != '.') {
        novaQuantidade += quan[cont];
      } else {
        contDot += 1;
        if (contDot > 1) {
          novaQuantidade += '';
        } else {
          novaQuantidade += quan[cont];
        }
      }
    }

    if (contDot > 1) {
      alert('Valor Decimal já inserido');
    }

    document.getElementById(`quantidade${sequencia}`).value = novaQuantidade;
    quan = novaQuantidade;

    if (max < quan) {

      alert("Informe uma quantidade valida!!");
      eval("document.form1." + nome + ".value='';");
      eval("document.form1." + nome + ".focus();");
      quan = 0;
      js_verifica(max, quan, nome, valoruni, numemp, sequencia);
      return

    }

    var valorAntigo = $("valor" + sequencia).value;
    //  Insere novo valor na coluna

    $("valor" + sequencia).value = formataValor(round(new Number(quan * valoruni), 2));

    let recebeTotal = 0;
    //  Atualiza valor total
    if ($("chk" + sequencia).checked) {
      recebeTotal = definePontoFlutuante(parseFloat($("valor_total").innerText) - parseFloat(valorAntigo) + parseFloat($("valor" + sequencia).value));

      if (!recebeTotal)
        return;

      if (recebeTotal > 0 && recebeTotal % 2 != 0) {
        let aValor = parseFloat(recebeTotal).toFixed(2).toString().split('.');

        if (aValor[1] && aValor[1].length == 1) {
          aValor[1] += '0';
        }

        if (aValor.length == 1) {
          recebeTotal = aValor.join('.') + ".00";
        } else {
          recebeTotal = aValor.join('.');
        }
      }

      $("valor_total").innerText = recebeTotal;
    }


  }

  function alteraValor(max, quan, nome, valoruni, numemp, sequencia, valorAntigo) {
    if ($("valor" + sequencia).value > max || $("valor" + sequencia).value < 0) {
      alert("Informe um valor válido!");
      $("valor" + sequencia).value = definePontoFlutuante(0);
    }

    //  Atualiza valor total
    if ($("chk" + sequencia).checked) {

      $("valor_total").innerText = definePontoFlutuante(parseFloat($("valor_total").innerText) -
        parseFloat(valorAntigo) +
        parseFloat($("valor" + sequencia).value));

    }
  }

  function definePontoFlutuante(temp) {
    if (Number.isInteger(parseFloat(temp))) {
      return (temp + ".00");
    }
    return (temp);
  }

  function formataValor(valor) {
    if (!valor) {
      return valor;
    }

    let numFormat = '';
    let caractere = '';
    if (valor.toString().includes(','))
      caractere = ',';
    if (valor.toString().includes('.'))
      caractere = '.';

    if (caractere)
      numFormat = valor.toString().split(caractere);


    let valorFinal = '';
    if (valor && numFormat) {
      if (numFormat.length > 1) {
        if (numFormat[1].length == 1)
          numFormat[1] += '0';
      } else {
        numFormat[0] += '.00';
      }


      if (numFormat.length > 1) {

        valorFinal = numFormat.join('.');
      }

    } else {
      valorFinal = definePontoFlutuante(valor);
    }

    return valorFinal;
  }

  function js_validaCaracteres(texto, campo) {
    let temporario = '';
    temporario = texto;

    /*Caracteres não permitidos na descrição e complemento material*/
    let charBuscados = [";", "'", "\"", "\\", "*", ":"];
    let novoTexto = temporario;
    let erro = '';

    charBuscados.map(caractere => {
      if (texto.includes(caractere)) {
        erro = true;
      }
    })


    if (window.event) {
      /* Lança o erro quando a tecla Enter é pressionada. */
      if (window.event.keyCode == 13) {
        erro = true;
        novoTexto = texto.replace(/(\r\n|\r)/g, '');
      }
    }

    /* Remove os caracteres contidos no array charBuscados */
    novoTexto = novoTexto.match(/[^;\*\\\:\"\']/gm);

    for (let cont = 0; cont < novoTexto.length; cont++) {

      /* Remove aspas duplas e simples pelo código, pelo fato de virem de fontes diferentes*/

      if (novoTexto[cont].charCodeAt(0) == 8221 || novoTexto[cont].charCodeAt(0) == 8220 || novoTexto[cont].charCodeAt(0) == 8216) {
        novoTexto[cont] = '';
        erro = true;
      }
    }

    // if(erro){
    //   alert('Caractere não permitido para inclusão!');
    // }

    novoTexto = novoTexto.join('');

      //alert(novoTexto);
      document.form1.m51_obs.value = novoTexto;
     
  }
</script>