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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("model/Dotacao.model.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_solicita_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_emptipo_classe.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_acordo_classe.php");
require_once("classes/db_acordoacordogarantia_classe.php");
require_once("classes/db_acordoacordopenalidade_classe.php");
require_once("classes/db_acordoitem_classe.php");

$clacordo = new cl_acordo;
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");


db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
if(isset($excluir)){

      $sDelete = "DELETE FROM acordoitemdotacao WHERE
      ac22_sequencial = '".$acordo_item_sequencial."' AND ac22_anousu = '".db_getsession('DB_anousu')."' ";
     // echo $sDelete;
      $delete = db_query($sDelete);
//var_dump($delete);die;

    if($delete){
      echo "<script>";
      echo "alert('Dotação apagada.');";
      echo "location.href = 'ac04_alteradotacao001.php?codigo_acordo=".$acordo.";";
      echo "</script>";
      $delete = "true";
    }else{
      echo "<script>";
      echo "alert('Dotação não apagada.');";
      echo "location.href = 'ac04_alteradotacao001.php?codigo_acordo=".$acordo.";";
      echo "</script>";
      $delete = "false";
    }
    db_redireciona("ac04_alteradotacao001.php?codigo_acordo=".$acordo);
}
if(isset($adicionar)){
  $material = key($adicionar);
  //verifica se existe a dotação cadastrada
  $sSqlDotacao = "SELECT * FROM orcdotacao WHERE o58_coddot = '".$codigo_dotacao[$material]."' AND o58_anousu = '".db_getsession("DB_anousu")."'";
  //verifica se existe a relacao
  $sSqlDotacaoAcordo = "SELECT DISTINCT
  ac22_coddot ,
  ac26_acordo,
  ac22_sequencial ,
  ac22_anousu ,
  ac22_acordoitem ,
  ac22_valor ,
  ac22_quantidade ,
  ac20_sequencial ,
  ac20_acordoposicao ,
  ac20_pcmater,
  pc01_descrmater,
  ac20_quantidade,
  ac20_valortotal,
  ac27_descricao,
  ac26_data,
  o58_valor,
  o58_anousu
  FROM orcdotacao
  JOIN acordoitemdotacao ON ac22_coddot=o58_coddot
  JOIN acordoitem ON ac22_acordoitem = ac20_sequencial
  JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
  JOIN acordoposicaotipo ON ac26_acordoposicaotipo = ac27_sequencial
  JOIN acordo ON ac26_acordo = ac16_sequencial
  JOIN pcmater ON ac20_pcmater = pc01_codmater
  WHERE ac16_sequencial = '".$codigo_acordo1[$material]."' AND ac20_pcmater = '".$codigo_material[$material]."' AND ac22_coddot = '".$codigo_dotacao[$material]."' AND ac20_acordoposicao = '".$codigo_posicao[$material]."' AND o58_anousu = '".db_getsession("DB_anousu")."' AND ac22_acordoitem = '".$codigo_acordo_item[$material]."' ORDER BY ac20_acordoposicao DESC, ac20_pcmater ASC";

  if(pg_numrows(db_query($sSqlDotacao)) == 0 || pg_numrows(db_query($sSqlDotacaoAcordo)) > 0){
    //significa que há a relação ou a dotação nao existe
    echo "<script>";
    echo "alert('Operação inválida. Verifique se existe a dotação ou se ela já está vinculada a este ítem.');";
    echo "</script>";
  }else if(pg_numrows(db_query($sSqlDotacao)) > 0 && pg_numrows(db_query($sSqlDotacaoAcordo)) == 0){
    $sInsert = "INSERT INTO acordoitemdotacao (ac22_sequencial, ac22_coddot,ac22_anousu,ac22_acordoitem)
    VALUES (
    (select nextval('acordoitemdotacao_ac22_sequencial_seq')), '".$codigo_dotacao[$material]."',
    '".db_getsession("DB_anousu")."',
    '".$codigo_acordo_item[$material]."')";

    $insert = db_query($sInsert);
    if($insert){
     echo "<script>";
     echo "alert('Dotação cadastrada.');";
     echo "</script>";
   }else{
     echo "<script>";
     echo "alert('Não foi possível cadastrar a dotação.');";
     echo "</script>";
   }
 }


}
if(isset($codigo_acordo)){
  $sSql = "SELECT DISTINCT
  ac22_coddot ,
  ac26_acordo,
  ac22_sequencial ,
  ac22_anousu ,
  ac22_acordoitem ,
  ac22_valor ,
  ac22_quantidade ,
  ac20_sequencial ,
  ac20_acordoposicao ,
  ac20_pcmater,
  pc01_descrmater,
  ac20_quantidade,
  ac20_valortotal,
  ac27_descricao,
  ac26_data,
  o58_valor,
  o58_anousu,
  o56_elemento
  FROM orcdotacao
  JOIN acordoitemdotacao ON ac22_coddot=o58_coddot
  JOIN acordoitem ON ac22_acordoitem = ac20_sequencial
  JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
  JOIN acordoposicaotipo ON ac26_acordoposicaotipo = ac27_sequencial
  JOIN orcelemento ON o56_codele = ac20_elemento
  JOIN acordo ON ac26_acordo = ac16_sequencial
  JOIN pcmater ON ac20_pcmater = pc01_codmater
  WHERE ac16_sequencial = '".$codigo_acordo."' ORDER BY ac20_acordoposicao DESC, ac20_pcmater ASC, ac22_coddot ASC";
  $oResult = db_query($sSql);
  $oResult = db_utils::getColectionByRecord($oResult);
  //echo $sSql;

}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?
  db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js");
  db_app::load("dbmessageBoard.widget.js, prototype.js, contratos.classe.js");
  db_app::load("estilos.css, grid.style.css");
  ?>
  <style type="text/css">
    #dotacoes td{
      text-align: center;
    }
  </style>

</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">

<?php db_menu(); ?>
  <br>
  <br>
  <center>
  <?php if (isset($codigo_acordo)): ?>


    <form action="" method="post" id="form1">


      <fieldset style="width: 75%;">
        <legend><b>Alteração de dotação</b></legend>
        <table style='width: 100%' border='0' align="center">
          <tr>
            <td width="100%">
              <table width="100%" id="dotacoes">
                <!-- primeiro exige posicao, data, material, quantidade valor total, qtd autorizar -->
                <tr style="border:1px solid black; background:#bac6d8;">
                  <th colspan="4">Posições de acordo</th>
                </tr>
                <tr style="border:1px solid black; background:#bac6d8;">
                  <th>Cdg. Posição</th>
                  <th>Tipo</th>
                  <th>Data</th>
                  <th>Emergencial</th>
                </tr>
                <tr style="background: #bac6d8;">

                  <td><?php echo $oResult[0]->ac20_acordoposicao; ?></td>
                  <td><?php echo $oResult[0]->ac27_descricao; ?></td>
                  <td><?php echo DateTime::createFromFormat('Y-m-d', $oResult[0]->ac26_data )->format('d/m/Y'); ?></td>
                  <td><?php if($oResult[0]->ac26_emergencial == "f") echo "Não";else echo "Sim"; ?></td>
                </tr>



             <?php $iMaterial = ""; ?>
             <?php foreach ($oResult as $aResult): ?>
              <?php if($aResult->ac20_acordoposicao == $oResult[0]->ac20_acordoposicao){
                if($iMaterial != $aResult->ac20_pcmater){ ?>
                <tr style="border:1px solid black; background:#bce5c4;">
                 <th>Cdg. Material: <?php echo $aResult->ac20_pcmater; ?> </th>
                 <th>Material: <?php echo $aResult->pc01_descrmater; ?> </th>
                 <th >Qtd: <?php echo $aResult->ac20_quantidade; ?> </th>
                 <th >Valor total: <?php echo $aResult->ac20_valortotal; ?> </th>
               </tr>
               <tr style="border:1px solid black; background:#b5cdfc;">
                <th colspan="4">Dotações</th>
              </tr>

             <tr>
              <td colspan="4">
                <a href="#" onclick="js_pesquisao47_coddot(true, <?php echo $aResult->ac20_pcmater; ?>, <?php echo $aResult->o56_elemento; ?>);"><b>Código da Dotações:</b></a>
               <input type="text" onchange="js_pesquisao47_coddot(false, <?php echo $aResult->ac20_pcmater; ?>)" placeholder="Código da dotação" id="<?php echo $aResult->ac20_pcmater; ?>" name="codigo_dotacao[<?php echo $aResult->ac20_pcmater; ?>]">
              <input type="hidden" name="codigo_material[<?php echo $aResult->ac20_pcmater; ?>]" value="<?php echo $aResult->ac20_pcmater; ?>">
              <input type="hidden" name="codigo_posicao[<?php echo $aResult->ac20_pcmater; ?>]" value="<?php echo $oResult[0]->ac20_acordoposicao; ?>">
              <input type="hidden" name="codigo_acordo1[<?php echo $aResult->ac20_pcmater; ?>]" value="<?php echo $oResult[0]->ac26_acordo; ?>">
              <input type="hidden" name="codigo_acordo_item[<?php echo $aResult->ac20_pcmater; ?>]" value="<?php echo $aResult->ac22_acordoitem; ?>">
<input type="submit"  name="adicionar[<?php echo $aResult->ac20_pcmater; ?>]" value="Adicionar dotação"></td>
            </tr>
              <?php $iMaterial = $aResult->ac20_pcmater; ?>
              <tr style="border:1px solid black; background:#b5cdfc;">
               <th colspan="2">Codigo dotacao</th>


               <th colspan="2">Exercício</th>
             </tr>
             <?php } ?>



             <tr >
             <?php if(DB_getsession("DB_anousu") == $aResult->o58_anousu && $aResult->o58_anousu == $aResult->ac22_anousu): ?>
             <?php
             /*
             SE O ANO FOR MAIOR QUE O ATUAL (NAO O DA SESSAO) + 1 E A MESMO
             TEMPO MAIOR QUE 2017 (JA FOI ENVIADO PRO SICOM),
             SERÁ POSSIVEL REALIZAR A EXCLUSÃO
             */
             if($aResult->o58_anousu > 2017):
             ?>
              <td colspan="2" style="border:1px solid #e8e8e8;" ><?php echo $aResult->ac22_coddot; ?></td>
              <td  style="border:1px solid #e8e8e8;" ><?php echo $aResult->o58_anousu; ?></td>
              <td  style="border:1px solid #e8e8e8;" ><a href="ac04_alteradotacao001.php?excluir=true&acordo=<?php echo $codigo_acordo; ?>&ano=<?php echo $aResult->o58_anousu; ?>&acordo_item_sequencial=<?php echo $aResult->ac22_sequencial; ?>">Excluir</a></td>
            <?php else: ?>
               <td colspan="2" style="border:1px solid #e8e8e8;" ><?php echo $aResult->ac22_coddot; ?></td>
              <td  colspan="2" style="border:1px solid #e8e8e8;" ><?php echo $aResult->o58_anousu; ?></td>
            <?php endif; ?>
            <?php endif; ?>

            </tr>



          <?php } ?>

        <?php endforeach;
        ?>

      </table>
    </td>
  </tr>

</table>
</fieldset>
</form>
<?php endif; ?>
</body>
<script type="text/javascript">
<?php if(isset($excluido) && $excluido == true){
  echo "alert('Dotação removida');";
}else if(isset($excluido) && $excluido != true){

  echo "alert('Dotação não removida');";
} ?>
<?php if(!isset($codigo_acordo) && $codigo_acordo == null): ?>
  js_pesquisaac16_sequencial(true);
  <?php endif; ?>
var input = "";
function js_pesquisao47_coddot(mostra, campo, estrutural){
    input = campo;
    query='elemento='+estrutural;

  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_orcdotacao','func_permorcdotacao.php?'+query+'&funcao_js=parent.js_mostraorcdotacao1|o58_coddot','Pesquisa',true,20,0);
  }/*else{
    js_OpenJanelaIframe('top.corpo','db_iframe_orcdotacao','func_permorcdotacao.php?'+query+'pesquisa_chave='+document.getElementById(input).value+'&funcao_js=parent.js_mostraorcdotacao','Pesquisa',false);
  }*/
}
/*function js_mostraorcdotacao(chave,erro){
  /*if(erro==true){
    document.form1.o47_coddot.focus();
    document.form1.o47_coddot.value = '';
  }*/
  /*document.getElementById(input).setAttribute('value', chave);

}*/

function js_mostraorcdotacao1(chave1){

  document.getElementById(input).setAttribute('value', chave1);
  /*document.form1.o47_coddot.value = chave1;
  js_dot();*/


  db_iframe_orcdotacao.hide();
}

function js_pesquisaac16_sequencial(lMostrar) {

  if (lMostrar == true) {

    var sUrl = 'func_acordo.php?lDepartamento=1&funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto&iTipoFiltro=4&lGeraAutorizacao=true';
    js_OpenJanelaIframe('top.corpo',
      'db_iframe_acordo',
      sUrl,
      'Pesquisar Acordo',
      true);
  } else {

    if (oTxtCodigoAcordo.getValue() != '') {

      var sUrl = 'func_acordo.php?lDepartamento=1&descricao=true&pesquisa_chave='+oTxtCodigoAcordo.getValue()+
      '&funcao_js=parent.js_mostraacordo&iTipoFiltro=4&lGeraAutorizacao=true';

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_acordo',
        sUrl,
        'Pesquisar Acordo',
        false);
    } else {
     oTxtCodigoAcordo.setValue('');
   }
 }
}

/**
 * Retorno da pesquisa acordos
 */
 function js_mostraacordo(chave1,chave2,erro) {

  if (erro == true) {

    oTxtCodigoAcordo.setValue('');
    oTxtDescricaoAcordo.setValue('');
    $('oTxtDescricaoAcordo').focus();
  } else {

    oTxtCodigoAcordo.setValue(chave1);
    oTxtDescricaoAcordo.setValue(chave2);
  }
}

/**
 * Retorno da pesquisa acordos
 */
 function js_mostraacordo1(chave1,chave2) {
  db_iframe_acordo.hide();
  location.href = "ac04_alteradotacao001.php?codigo_acordo="+chave1;
  /*oTxtCodigoAcordo.setValue(chave1);
  oTxtDescricaoAcordo.setValue(chave2);*/
}

</script>
</html>
