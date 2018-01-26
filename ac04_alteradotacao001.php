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

  $delete = db_query($sDelete);

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
  db_redireciona("ac04_alteradotacao001.php?material=$material&codigo_acordo=".$acordo);
}
if(isset($adicionar)){
  $material = key($adicionar);
//    $material = explode('-',$material);
//    $material = $material[0];
    /**
     * Pega quantidade da ultima posição
     */
  $sSqlVlr = " SELECT ac20_sequencial,
                      ac20_valorunitario,
                      ac20_valortotal
               FROM acordoposicao
               JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
               WHERE ac20_acordoposicao =
                    (SELECT max(ac26_sequencial)
                     FROM acordoposicao
                     WHERE ac26_acordo = $codigo_acordo1[$material])";
    $oResultVlr = db_query($sSqlVlr);
    $oResultVlr = db_utils::getColectionByRecord($oResultVlr);

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
  WHERE ac16_sequencial = '".$codigo_acordo1[$material]."' AND ac20_pcmater = '".$codigo_material[$material]."' AND ac22_coddot = '".$codigo_dotacao[$material]."' AND ac20_acordoposicao = '".$codigo_posicao[$material]."' AND o58_anousu = '".db_getsession("DB_anousu")."' AND ac22_anousu = '".db_getsession("DB_anousu")."' AND ac22_acordoitem = '".$codigo_acordo_item[$material]."' ORDER BY ac20_acordoposicao DESC, ac20_pcmater ASC";

  if(pg_numrows(db_query($sSqlDotacao)) == 0 || pg_numrows(db_query($sSqlDotacaoAcordo)) > 0){
    //significa que há a relação ou a dotação nao existe
    echo "<script>";
    echo "alert('Operação inválida. Verifique se existe a dotação ou se ela já está vinculada a este ítem.');";
    echo "</script>";
  }else if(pg_numrows(db_query($sSqlDotacao)) > 0 && pg_numrows(db_query($sSqlDotacaoAcordo)) == 0){
    $sInsert = "INSERT INTO acordoitemdotacao
    VALUES (
    (select nextval('acordoitemdotacao_ac22_sequencial_seq')), ".$codigo_dotacao[$material].",
    ".db_getsession("DB_anousu").",
    ".$codigo_acordo_item[$material].",
    ".$oResultVlr[0]->ac20_valorunitario.",
    ".$oResultVlr[0]->ac20_valortotal.")";
    $insert = db_query($sInsert);
    if($insert){
     echo "<script>";
    // echo "alert('Dotação cadastrada.');";
     echo " document.getElementById('ancora$material').scrollIntoView(); ";
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
  ac16_numero ||'/'|| ac16_anousu AS contrato,
  ac26_acordo,
  ac22_sequencial ,
  ac22_anousu ,
  ac16_sequencial,
  ac22_acordoitem ,
  z01_nome,
  ac22_valor ,
  ac22_quantidade ,
  ac20_sequencial ,
  ac20_acordoposicao ,
  ac20_pcmater,
  ac20_ordem,
  pc01_descrmater,
  ac20_quantidade,
  ac20_valortotal,
  ac27_descricao,
  ac26_data,
  o58_valor,
  o58_anousu,
  o56_elemento,
  ac16_dataassinatura
  FROM orcdotacao
  JOIN acordoitemdotacao ON ac22_coddot=o58_coddot
  JOIN acordoitem ON ac22_acordoitem = ac20_sequencial
  JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
  JOIN acordoposicaotipo ON ac26_acordoposicaotipo = ac27_sequencial
  JOIN orcelemento ON o56_codele = ac20_elemento AND o56_anousu = o58_anousu
  JOIN acordo ON ac26_acordo = ac16_sequencial
  JOIN cgm ON ac16_contratado = z01_numcgm
  JOIN pcmater ON ac20_pcmater = pc01_codmater
  WHERE  ac20_acordoposicao = (SELECT max(ac26_sequencial) FROM acordoposicao where ac26_acordo = '".$codigo_acordo."') AND ac16_sequencial = '".$codigo_acordo."' ORDER BY ac20_acordoposicao DESC, ac20_ordem asc, ac22_coddot ASC ";
  $oResult = db_query($sSql);
  $oResult = db_utils::getColectionByRecord($oResult);
//  echo $sSql;

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
          <table style='width: 100%; background: #ffffff;' border='0' align="center">
            <tr>
              <td width="100%">
                <table width="100%" id="dotacoes">
                  <!-- primeiro exige posicao, data, material, quantidade valor total, qtd autorizar -->
                <!--tr style="border:1px solid black; background:#bac6d8;">
                  <th colspan="4">Posições de acordo</th>
                </tr-->
                <tr style="background: #ffffff;
                height: 20px;">
                <th style="height: 25px; font-size:14px; background: #ffffff;">Cód. Acordo</th>
                <th style="height: 25px; font-size:14px; background: #ffffff;">Contratado</th>
                <th style="height: 25px; font-size:14px; background: #ffffff;">Nº. Contrato</th>
                <th style="height: 25px; font-size:14px; background: #ffffff;">Data Ass.</th> </tr>
                <tr style="background: #ffffff; height:20px; ">

                  <td style=""><?php echo $oResult[0]->ac16_sequencial; ?></td>
                  <td style=""><?php echo $oResult[0]->z01_nome; ?></td>
                  <td style=""><?php echo $oResult[0]->contrato; ?></td>
                  <td style=""><?php echo date("d/m/Y", strtotime($oResult[0]->ac16_dataassinatura)); ?></td>

                </tr>



                <?php $iMaterial = ""; ?>
                <?php $i = 0; ?>
                <?php foreach ($oResult as $aResult): ?>
                  <?php if($aResult->ac20_acordoposicao == $oResult[0]->ac20_acordoposicao){
                    if($iMaterial != $aResult->ac20_pcmater){ ?>
                    <?php if($i!=0): ?>

                     <tr>
                      <td colspan="4" style=" background:#ededed; height:25px" >
                        <a href="#" id="ancora<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>" onclick="js_pesquisao47_coddot(true, '<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>', <?php echo $oResult[$i-1]->o56_elemento; ?>);"><b>Dotações:</b></a>
                        <input type="text" onchange="js_pesquisao47_coddot(false, <?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>)" maxlengh="4" style="width:60px;" id="<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>" name="codigo_dotacao[<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>]">
                        <input type="hidden" name="codigo_material[<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>]" value="<?php echo $oResult[$i-1]->ac20_pcmater; ?>">
                        <input type="hidden" name="codigo_posicao[<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>]" value="<?php echo $oResult[0]->ac20_acordoposicao; ?>">
                        <input type="hidden" name="codigo_acordo1[<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>]" value="<?php echo $oResult[0]->ac26_acordo; ?>">
                        <input type="hidden" name="codigo_acordo_item[<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>]" value="<?php echo $oResult[$i-1]->ac22_acordoitem; ?>">
                        <input type="submit" name="adicionar[<?php echo $oResult[$i-1]->ac20_pcmater.'-'.$oResult[$i-1]->ac20_ordem; ?>]" value="Incluir"></td>
                      </tr>
                    <?php endif; ?>
                    <tr>
                      <td colspan="4" style="height: 20px; width:100%;"> <hr> </td>
                    </tr>
                    <tr style="margin-top:10px;border: 1px solid black; background: #e1dede; height: 25px; ">
                      <th>Cód. Item: <?php echo $aResult->ac20_pcmater; ?> </th>
                      <th><?php echo $aResult->pc01_descrmater; ?> </th>
                      <th >Qtd: <?php echo $aResult->ac20_quantidade; ?> </th>
                      <th >Valor total: <?php echo $aResult->ac20_valortotal; ?> </th>
                    </tr>



                    <?php $iMaterial = $aResult->ac20_pcmater; ?>

                    <tr style="border:1px solid black; background:#dedede; height:20px">
                     <th colspan="2">Dotações do item</th>


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
             <td  style="border:1px solid #e8e8e8;" ><a href="ac04_alteradotacao001.php?excluir=true&material=<?php echo $aResult->ac20_pcmater;?>&acordo=<?php echo $codigo_acordo; ?>&ano=<?php echo $aResult->o58_anousu; ?>&acordo_item_sequencial=<?php echo $aResult->ac22_sequencial; ?>">Excluir</a></td>
           <?php else: ?>
             <td colspan="2" style="border:1px solid #e8e8e8;" ><?php echo $aResult->ac22_coddot; ?></td>
             <td  colspan="2" style="border:1px solid #e8e8e8;" ><?php echo $aResult->o58_anousu; ?></td>
           <?php endif; ?>
         <?php endif; ?>

       </tr>



       <?php } ?>
       <?php $i++; ?>
     <?php endforeach;?>

     <tr>
      <td colspan="4" style=" background:#ededed; height:25px" >
        <a href="#" id="ancora<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>" onclick="js_pesquisao47_coddot(true, '<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>', <?php echo $oResult[count($oResult)-1]->o56_elemento; ?>);"><b>Dotações:</b></a>
        <input type="text" onchange="js_pesquisao47_coddot(false, <?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>)" maxlengh="4" style="width:60px;" id="<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>" name="codigo_dotacao[<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>]">
        <input type="hidden" name="codigo_material[<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>]" value="<?php echo $oResult[count($oResult)-1]->ac20_pcmater; ?>">
        <input type="hidden" name="codigo_posicao[<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>]" value="<?php echo $oResult[0]->ac20_acordoposicao; ?>">
        <input type="hidden" name="codigo_acordo1[<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>]" value="<?php echo $oResult[0]->ac26_acordo; ?>">
        <input type="hidden" name="codigo_acordo_item[<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>]" value="<?php echo $oResult[count($oResult)-1]->ac22_acordoitem; ?>">
        <input type="submit"  name="adicionar[<?php echo $oResult[count($oResult)-1]->ac20_pcmater.'-'.$oResult[count($oResult)-1]->ac20_ordem; ?>]" value="Incluir"></td>
      </tr>


    </table>
  </td>
</tr>

</table>
</fieldset>
<center>
  <br>
  <input type="button" name="Pesquisar" value="Pesquisar" onclick="js_pesquisaac16_sequencial(true);" >
</center>
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
  Element.prototype.documentOffsetTop = function () {
    return this.offsetTop + ( this.offsetParent ? this.offsetParent.documentOffsetTop() : 0 );
  };
  var top = document.getElementById("ancora"+input).documentOffsetTop() - ( window.innerHeight / 2 );
  window.scrollTo( 0, top );
  /*var elmnt = document.getElementById("ancora"+input);
  elmnt.scrollIntoView();*/
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
<?php
if($material){
     echo "<script>";
     echo " document.getElementById('ancora$material').scrollIntoView(); ";
     echo "</script>";
   }
 ?>
</html>
