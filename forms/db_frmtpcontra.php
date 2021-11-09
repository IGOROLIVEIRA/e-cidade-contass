<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

//MODULO: recursos humanos
$cltpcontra->rotulo->label();
?>
<form name="form1" method="post" action="">
<fieldset>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Th13_codigo?>">
       <?=@$Lh13_codigo?>
    </td>
    <td>
<?
db_input('h13_codigo',4,'',true,'text',$db_opcao,"","","","",6)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Th13_regime?>">
       <?=@$Lh13_regime?>
    </td>
    <td>
<?
$result_regime = $clrhcadregime->sql_record($clrhcadregime->sql_query_file());
db_selectrecord("h13_regime", $result_regime, true, $db_opcao);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Th13_tpcont?>">
       <?=@$Lh13_tpcont?>
    </td>
    <td>
<?
db_input('h13_tpcont',2,$Ih13_tpcont,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Th13_categoria?>">
       <?=@$Lh13_categoria?>
    </td>
    <td>
<?
db_input('h13_categoria',3,$Ih13_categoria,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Th13_descr?>">
       <?=@$Lh13_descr?>
    </td>
    <td>
<?
db_input('h13_descr',40,$Ih13_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
    <tr>
        <td nowrap title="Tipo">
            <strong>Tipo de Cargo: </strong>
        </td>
        <td>
            <?
            $x = array('1' => 'CEF - Efetivo','2' => 'CRA - Comissionado de recrutamento amplo',
                '3' => 'CRR - Comissionado de recrutamento restrito','4' => 'FPU - Função pública',
                '5' => 'EPU - Emprego público', '6' => 'APO - Agente político', '7' => 'STP - Servidor temporário',
                '8' => 'OTC - Outros tipos de cargo');
            db_select("h13_tipocargo",$x,true,$db_opcao,"onchange='js_showAPO()'");
            ?>
        </td>
    </tr>
    </table>

    <table>
    <tr id="dscapo" <? if($h13_tipocargo != 6){ ?> style="display: none;" <? }else{ ?> style="display: inline;" <? } ?>>
       <td nowrap title="Descrição do tipo de cargo"><b>Descrição do tipo de cargo: </b></td>
       <td>
           <?
           $adescCargo = array("GOV"=>"Governador",
               "VGO"=>"Vice Governador",
               "PRE"=>"Prefeito Municipal",
               "VPR"=>"Vice Prefeito",
               "SCE"=>"Secretário de Estado",
               "SEA"=>"Secretário de Estado Adjunto",
               "SCM"=>"Secretário Municipal",
               "SMA"=>"Secretário Municipal Adjunto",
               "PAS"=>"Presidente da Assembléia",
               "VPA"=>"Vice Presidente da Assembléia",
               "DEE"=>"Deputado Estadual",
               "PCA"=>"Presidente da Câmara Municipal",
               "VPC"=>"Vice Presidente da Câmara Municipal",
               "VER"=>"Vereador"
           );
           db_select('h13_dscapo', $adescCargo, true, $db_opcao);
           ?>
       </td>
    </tr>
    </table>
    <table>
    <tr>

        <td nowrap="" title="Tipo Cargo Descrição" id="tipocargodescricao1" style="display: none;">
            <strong>Tipo Cargo Descrição:</strong>
        </td>
        <td id="tipocargodescricao2" style="display: none;">
            <?
            db_input('h13_tipocargodescr',45,$Ih13_tipocargodescr,true,'text',$db_opcao,'');
            ?>
        </td>
    </tr>
  </table>
</fieldset>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

function js_showAPO() {

    if (document.form1.h13_tipocargo.value == 6) {
        document.getElementById('dscapo').style.display = "inline";
        console.log(document.getElementById('dscapo'));
    } else {
        document.getElementById('dscapo').style.display = "none";
        console.log(document.getElementById('dscapo'));
    }
}


/*if(top.corpo.document.getElementById('h13_tipocargo').options.selectedIndex == 7){
        top.corpo.document.getElementById('tipocargodescricao1').style.display = 'inline';
        top.corpo.document.getElementById('tipocargodescricao2').style.display = 'inline';
}*/

function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_tpcontra','func_tpcontra.php?funcao_js=parent.js_preenchepesquisa|h13_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_tpcontra.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
/*top.corpo.document.getElementById('h13_tipocargo').onchange=function () {
    if(top.corpo.document.getElementById('h13_tipocargo').options.selectedIndex == 7){
        top.corpo.document.getElementById('tipocargodescricao1').style.display = 'inline';
        top.corpo.document.getElementById('tipocargodescricao2').style.display = 'inline';
    }else{
        top.corpo.document.getElementById('tipocargodescricao1').style.display = 'none';
        top.corpo.document.getElementById('tipocargodescricao2').style.display = 'none';
        top.corpo.document.getElementById('h13_tipocargodescr').removeAttribute('value');
    }
};*/
</script>
