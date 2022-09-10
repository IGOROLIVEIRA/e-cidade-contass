<?
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


//MODULO: compras
$sArquivoRedireciona = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
$result_tipo = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_seltipo,pc30_tipoemiss"));
if ($clpcparam->numrows > 0) {
  db_fieldsmemory($result_tipo, 0);
}

$iOpcaoTipoSolicitacao = $db_opcao;
?>
<div>
  <form name="form1" method="post" action="">
    <fieldset>
      <legend><strong>Adicionar Item</strong></legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Tpc16_codmater ?>">
            <?
            db_ancora("Código do material", "js_pesquisapc16_codmater(true);", $tranca);
            ?>
          </td>

          <td>
            <?
            db_input('pc16_codmater', 8, $Ipc16_codmater, true, 'text', $tranca, " onchange='js_pesquisapc16_codmater(false);'");
            db_input("iCodigoRegistro", 8, "iCodigoRegistro", true, 'hidden', $db_opcao);
            db_input("pc01_veiculo", 8, "", true, 'hidden', $db_opcao);
            db_input("codigoitemregistropreco", 8, "", true, 'hidden', $db_opcao);
            db_input("pcmateranterior", 8, $pcmateranterior, true, 'hidden', $db_opcao);
            ?>
          </td>

          <td nowrap style="   display: block;">
            <?
            db_input('pc01_descrmater', 50, $Ipc01_descrmater, true, 'text', $db_opcao);
            ?>
          </td>

          <td nowrap>
            <b> Quantidade: </b>
          </td>
          <td nowrap>

            <?
            db_input('pc01_quantidade', 8, $Ipc01_descrmater, true, 'text', $db_opcao, '');
            ?>
          </td>

          <td nowrap>
            <b> Unidade: </b>
          </td>

          <td nowrap>

            <select name="unidade[]" id="unidade">

              <?

              echo "<option value=\"0\">  </option>";


              $result = db_query("select * from matunid");
              if (pg_numrows($result) != 0) {
                $numrows = pg_numrows($result);
                for ($i = 0; $i < $numrows; $i++) {

                  $matunid = db_utils::fieldsMemory($result, $i);
                  echo "<option value=\"$matunid->m61_codmatunid \">$matunid->m61_descr</option>";
                }
              }

              ?>

            </select>
          </td>
        </tr>


        <tr>
          <td>
            <b> Desdobramento: </b>
          </td>
          <td>
            <?

            ?>
          </td>
          <td nowrap>
            <select name="unidade[]" id="unidade2" style="width: 440;margin-left: -81;">

              <?

              echo "<option value=\"0\">  </option>";


              $result = db_query("select * from matunid");
              if (pg_numrows($result) != 0) {
                $numrows = pg_numrows($result);
                for ($i = 0; $i < $numrows; $i++) {

                  $matunid = db_utils::fieldsMemory($result, $i);
                  echo "<option value=\"$matunid->m61_codmatunid \">$matunid->m61_descr</option>";
                }
              }

              ?>

            </select>
          </td>


          <td>
            <b> Ordem: </b>
          </td>
          <td>
            <?
            db_input('pc01_ordem', 8, $Ipc01_descrmater, true, 'text', $db_opcao, '');
            ?>
          </td>

        </tr>

      </table>
      <input style="float:center; margin-top:10px;" name="<?= ($db_opcao == 1 ? "Adicionar Item" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Adicionar Item" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> onclick="return js_validaAlteracao(<?= $db_opcao ?>)">

    </fieldset>

    <table>
      <tr>
        <td>
          <fieldset>
            <legend>Itens</legend>
            <div id='ctnGridItens' style="width: 1000px"></div>
          </fieldset>
        </td>
      </tr>
    </table>
    <input style="float:center; margin-top:10px;" name="salvar" type="submit" value="Salvar Itens">


    <br>

  </form>
</div>
<script>
  oGridItens = new DBGrid('oGridItens');
  oGridItens.nameInstance = 'oGridItens';
  oGridItens.setCellAlign(['center', 'left', "right", "right", "right"]);
  oGridItens.setCellWidth(["10%", "10%", "50%", "20%", "10%"]);
  oGridItens.setHeader(["Ordem", "Código", "Descrição", "Unidade", "Ação"]);

  oGridItens.setHeight(200);
  oGridItens.show($('ctnGridItens'));
</script>