<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: empenho
require_once("classes/db_empparametro_classe.php");
require_once("dbforms/db_classesgenericas.php");

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clempparametro = new cl_empparametro;

$result_elementos = $clorcparametro->sql_record($clorcparametro->sql_query_file(null, "o50_subelem"));
if($clorcparametro->numrows > 0){
  db_fieldsmemory($result_elementos,0);
}

$clempautitem->rotulo->label();
$clrotulo = new rotulocampo;
//solicitemunid
$clrotulo->label("pc17_unid");

$clrotulo->label("e54_anousu");
$clrotulo->label("o56_elemento");
$clrotulo->label("pc01_descrmater");


if (!isset($e30_numdec)){
  $e30_numdec=4;
}

if(isset($db_opcaoal)){
    $db_opcao=3;
    $db_botao=false;
}else{
  $db_botao=true;
}
if(isset($opcao) && $opcao=="alterar"){
    $db_opcao = 2;
}elseif(isset($opcao) && $opcao=="excluir" || isset($db_opcao) && $db_opcao==3){
    $db_opcao = 3;
    if(isset($db_opcaoal)){
  $db_opcao=33;
    }
}else{
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
      $e55_item   ="";
      $e55_sequen ="";
      $e55_quant  ="";
      $e55_vltot  ="";
      $e55_descr  ="";
      $e55_vluni  ="";
      $e55_marca  = "";
      $pc01_descrmater  ="";
    }
}

?>

<script type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/prototype.js"></script>

<script>

function js_calcula(origem) {
  obj   = document.form1;
  quant = new Number(obj.e55_quant.value);
  uni   = new Number(obj.e55_vluni.value);
  tot   = new Number(obj.e55_vltot.value).toFixed(2);

  conQt = 'false';

  if (document.querySelector('#lControlaQuantidade')){
    conQt = obj.lControlaQuantidade.value;
  } 

  if (conQt == 'true') {
    t = new Number(uni * quant);
    obj.e55_vltot.value = t.toFixed(2);
  }

  if (origem == 'quant' && quant != '' && conQt == 'false' ) {
    if (isNaN(quant)) {
      obj.e55_quant.focus();
      return false;
    }
    if (tot != 0) {
     t = new Number(tot / quant);
     obj.e55_vltot.value = tot;
     obj.e55_vluni.value = t.toFixed('<?=$e30_numdec?>');
    } else {
        t = new Number(uni * quant);
        obj.e55_vltot.value = t.toFixed(2);
    }
  }

  if (origem == "uni") {
    if (isNaN(uni)) {
      //alert("Valor unico inváido!");
      obj.e55_vluni.focus();
      return false;
    }
    t = new Number(uni * quant);
    obj.e55_vltot.value = t.toFixed(2);
  }

  if (origem == "tot" && conQt == 'false' ) {
    if (isNaN(tot)) {
      //alert("Valor total inváido!");
      obj.e55_vltot.focus();
      return false;
    }
    if (quant != 0) {
      t = new Number(tot/quant);
      obj.e55_vltot.value = tot;
      obj.e55_vluni.value = t.toFixed('<?=$e30_numdec?>');
    }
  }

}

function js_verificaControlaQuantidade(lControla) {
  <?php
    if ($db_opcao == 3) {
      echo "return;";
    }
  ?>
  if (lControla == "true") {
    $("e55_quant").style.backgroundColor = "#FFFFFF";
    $("e55_quant").removeAttribute("readonly");
    $("e55_vluni").style.backgroundColor = "#DEB887";
    $("e55_vluni").setAttribute("readonly", true);
  } else {
    $("e55_quant").style.backgroundColor = "#DEB887";
    $("e55_quant").setAttribute("readonly", true);
    //$("e55_quant").value = 1;
    $("e55_vluni").style.backgroundColor = "#FFFFFF";
    $("e55_vluni").removeAttribute("readonly");
    js_calcula('uni');
  }
}

function js_troca(codele) {

  descr = eval("document.form1.ele_"+codele+".value");
  arr =  descr.split("#");

  elemento  = arr[0];
  descricao = arr[1];
  document.form1.elemento01.value = elemento;
  document.form1.o56_descr.value  = descricao;
}
</script>
<form name="form1" method="post" action="">
<input type="hidden" id="pc80_criterioadjudicacao" name="pc80_criterioadjudicacao">
<input type="hidden" id="e55_quant_ant" name="e55_quant_ant" value="<?= $e55_quant ?>">
<center>
<fieldset style="margin-top:5px; width:45%;">
  <legend><b>Ítens</b></legend>
  <table border="0" cellpadding='0' cellspacing='0' >
    <tr style="height: 20px;">
      <td nowrap title="<?=@$Te55_autori?>">
        <?=$Le55_autori?>
      </td>
      <td>
        <?php db_input('e55_autori',8,$Ie55_autori,true,'text',3); ?>
      </td>
  </tr>
  <tr style="height: 20px;">
    <td nowrap title="<?=@$Te55_sequen?>">
       <?=@$Le55_sequen?>
    </td>
      <td>
         <?  db_input('e55_sequen',8,$Ie55_sequen,true,'text',3)  ?>
      </td>
    </tr>
    <tr style="height: 20px;">
      <td nowrap title="<?=@$Te55_item?>">
   <? db_ancora(@$Le55_item,"js_pesquisae55_item(true);",$db_opcao); ?>
      </td>
      <td>
         <?  db_input('e55_item',8,$Ie55_item,true,'text',$db_opcao," onchange='js_pesquisae55_item(false);'")  ?>
         <?  db_input('pc01_descrmater',52,$Ipc01_descrmater,true,'text',3,'')   ?>
      </td>
    </tr>

    <tr>
      <td><b>Unidade:</b></td>
      <td>
      <?
	       $result_unidade = array ();
	       $result_sql_unid = $clmatunid->sql_record($clmatunid->sql_query_file(null, "m61_codmatunid,substr(m61_descr,1,20) as m61_descr,m61_usaquant,m61_usadec", "m61_descr"));
           $numrows_unid = $clmatunid->numrows;
           for ($i = 0; $i < $numrows_unid; $i++){
              db_fieldsmemory($result_sql_unid, $i);
              $result_unidade[$m61_codmatunid] = $m61_descr;
           }

         db_select("e55_unid", $result_unidade, true, $db_opcao) ;

      ?>
      <label style="margin-left: 20px"><b>Marca:</b></label>
      <? db_input('e55_marca',20,$Ie55_marca,true,'text',$db_opcao,'','','','',100)	 ?>
      </td>
    </tr>

    <? if( isset($e55_item) && $e55_item!='' && (empty($liberado) || (isset($liberado) && $liberado==true) ) ){?>
        <tr style="height: 20px;">
          <td nowrap title="">
          <b>Ele. item: </b>
          </td>
          <td>
           <?  db_selectrecord("pc07_codele",$result_elemento,true,$db_opcao,'','','','',"js_troca(this.value);");  ?>
          </td>
        </tr>
    <?
       } else{
          db_input('pc07_codele',50,0,true,'hidden',1);
       }

    ?>

    <tr style="height: 20px;">
      <td><?=$Lo56_elemento?></td>
      <td>
  <?
    $ero=$clempautitem->erro_msg;


    $result88 = $clempautitem->sql_record($clempautitem->sql_query_pcmaterele($e55_autori,null,"o56_codele as codele,o56_elemento as elemento01,o56_descr"));
    if($clempautitem->numrows>0){
         $numrows88= $clpcmater->numrows;
         db_fieldsmemory($result88,0);//$codele é o primeiro elemento incluido
         echo "
       <script>
      parent.document.formaba.empautidot.disabled=false;\n
     </script>
         ";
    }else{
      echo "
    <script>
      parent.document.formaba.empautidot.disabled=false;\n
    </script>

      ";
      if(isset($e55_item) && $e55_item!=""){
   $result99  = $clpcmater->sql_record($clpcmater->sql_query_elemento($e55_item,"o56_codele as  codele,o56_elemento as elemento01,o56_descr"));
   $numrows99 = $clpcmater->numrows;
   db_fieldsmemory($result99,0);//$codele é o primeiro elemento incluido
      }else{
   $elemento01='';
   $o56_descr='';
      }
    }
    $clempautitem->erro_msg=$ero;
    db_input('elemento01',20,0,true,'text',3);
    db_input('o56_descr',40,0,true,'text',3);
    if(isset($numrows99) && $numrows99>0){
  for($i=0; $i<$numrows99; $i++){
    db_fieldsmemory($result99,$i);
    $r="ele_$codele";
    $$r = "$elemento01#$o56_descr";
    db_input("ele_$codele",20,0,true,'hidden',3);
  }
    }
  ?>
      </td>
    </tr>
    <tr style="height: 20px;">
      <td nowrap title="<?=@$Te55_quant?>">
   <?=@$Le55_quant?>
      </td>
      <td>
      <?php
          /*if(isset($pc01_servico) and $pc01_servico=='t') {

            if (!isset($e55_servicoquantidade) || $e55_servicoquantidade == "f") {
              $e55_quant = 1;
            }
            $db_opcao_e55_quant = 3;
          } else {
            $db_opcao_e55_quant = $db_opcao;
          }*/
          db_input('e55_quant',11,$e55_quant,true,'text','',"onchange=\"js_calcula('quant');\"");
          ?>

          <script>
            //Controla a validação de vírgulas e pontos.
            var oQuantidade = $("e55_quant");
            oQuantidade.setAttribute("onkeydown" ,"return js_controla_tecla_enter(this,event);");
            oQuantidade.setAttribute("onkeyup" ,"js_ValidaCampos(this,4,'Quantidade','f','f',event);");
            oQuantidade.setAttribute("onblur", "js_ValidaMaiusculo(this,'f',event);");
          </script>
        <label><b>Valor unitário:</b></label>
        <?
          if(isset($opcao)){
            if(!isset($e55_vlrun)){
              $e55_vlrun = number_format($e55_vltot / $e55_quant,2,".","");
            }
          }
          db_input('e55_vluni',10,$Ie55_vluni,true,'text',1,"onchange=\"js_calcula('uni');\"");
        ?>
        <?=@$Le55_vltot?>
        <?
          if(isset($pc01_servico) and $pc01_servico == 't') {
            $db_opcao_e55_vltot = 3;
          } else {
            $db_opcao_e55_vltot = $db_opcao;
          }
          db_input('e55_vltot',10,$Ie55_vltot,true,'text',3,"onblur=\"js_calcula('tot');\"");
        ?>
      </td>
    </tr>
    <tr style="height: 20px;">
      <td>
        <strong>Utilizado: </strong>
      </td>
      <td>
        <? db_input('utilizado',11,"",true,'text',3,""); ?>
        <strong style="margin-right:15px">Disponível: </strong>
        <? db_input('disponivel',10,"",true,'text',3,""); ?>
        <? db_input('totalad',9,"",true,'hidden',3,""); ?>
      </td>
    </tr>
   <tr style="height: 20px;">
      <td>&nbsp;</td>
      <td>
        <?php if (isset($pc01_servico) && $pc01_servico=='t') :

            if (!isset($e55_servicoquantidade)) {
              $e55_servicoquantidade = "f";
            }
          ?>

          <b>Controlar por quantidade:</b>
          <select name="lControlaQuantidade" id="lControlaQuantidade" onchange="js_verificaControlaQuantidade(this.value);" <?php echo $db_opcao == 3 ? " disabled='true'" : "" ?>>
          <option value="false">NÃO</option>
          <option value="true">SIM</option>
          </select>
          <script>
          lControlaQuantidade = "<?php echo $e55_servicoquantidade == 't' ? 'true' : 'false';?>";
          $("lControlaQuantidade").value = lControlaQuantidade;
          js_verificaControlaQuantidade($F("lControlaQuantidade"));
          </script>
        <?php endif; ?>
      </td>
    </tr>
   <tr style="height: 20px;">
      <td nowrap title="<?=@$Te55_descr?>">
   <?=@$Le55_descr?>
      </td>
      <td>
         <?
           $lDisabled = false;
           if (empty($opcao)) {

             if (isset($e55_item) && $e55_item != '') {

               $sWhere      = "pc01_codmater = {$e55_item}";
               $sSqlPcMater = $clpcmater->sql_query_file($e55_item, "pc01_complmater,pc01_liberaresumo", null, $sWhere);
               $result      = $clpcmater->sql_record($sSqlPcMater);
               if ($clpcmater->numrows > 0) {

                 db_fieldsmemory($result,0);
                 if ($pc01_liberaresumo == 'f') {

                   $lDisabled = true;
                   $e55_descr = $pc01_complmater;
                 } else {

                   // PARA SAPIRANGA A VARIÁVEL TEM QUE ESTAR EM BRANCO
                   $e55_descr = '';
                 }
               } else {
                 $e55_descr='';
               }
             } else {
               $e55_descr='';
             }
           }

           if ($lDisabled) {
             $iOpcao = 3;
           } else {
             $iOpcao = $db_opcao;
           }

           db_textarea('e55_descr',3,70,$Ie55_descr,true,'text',$iOpcao,"");
          ?>
      </td>
    </tr>
  </table>

</fieldset>
  <table>
    <tr>
    <td colspan='2' align='center'>
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> <?=($db_opcao == 2 ||$db_opcao == 1) ? "onclick='return js_verificar();'" : ''?>  >
    <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
      </td>
    </tr>
  </table>
  <table width="90%" border="0" height="50%">
    <tr>
      <td valign="top"  align='center' width="90%"  height="100%">
       <?php
        $sql_item = $clempautitem->sql_query_pcmaterele($e55_autori,null,"e55_autori,e55_item,pc07_codele,e55_sequen,e55_descr,m61_descr,e55_marca,e55_quant,e55_vlrun, round(e55_vltot,2) as e55_vltot ,pc01_descrmater","e55_sequen");

        $chavepri= array("e55_autori"=>$e55_autori,"e55_sequen"=>@$e55_sequen);
        $cliframe_alterar_excluir->chavepri=$chavepri;
        $cliframe_alterar_excluir->sql     = $sql_item;
        $cliframe_alterar_excluir->campos  ="e55_sequen,e55_item,pc07_codele,pc01_descrmater,e55_descr,m61_descr,e55_quant,e55_marca,e55_vlrun,e55_vltot";
        $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
        $cliframe_alterar_excluir->strFormatar   ="";
        $cliframe_alterar_excluir->iframe_height ="160";
        $cliframe_alterar_excluir->iframe_width ="100%";
        $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
       ?>
      </td>
    </tr>
    <tr>
      <td><b>Total de itens:</b>
  <?
  $result02 = $clempautitem->sql_record($clempautitem->sql_query_file($e55_autori,null,"count(e55_sequen) as tot_item"));
   db_fieldsmemory($result02,0);

  if($tot_item>0){
     $result = $clempautitem->sql_record($clempautitem->sql_query_file($e55_autori,null,"sum(round(e55_vltot,2)) as tot_valor"));
     db_fieldsmemory($result,0);
     if(empty($tot_valor) ||  $tot_valor==""){
       $tot_valor='0';
       $tot_item='0';
     }else{
       $tot_valor= number_format($tot_valor,2,".","");
     }
  }else{

    $tot_valor='0';
    $tot_item='0';
  }
  db_input('tot_item',8,0,true,'text',3);
  ?>
      <b>Total dos valores:</b>
  <?
  db_input('tot_valor',13,0,true,'text',3,"onchange=\"js_calcula('quant');\"")
  ?>

      </td>
    </tr>
    </table>
    </center>
  </form>
    <script>

  function js_verificar() {

    let qt    =  new Number(document.form1.e55_quant.value);
    let qtant =  new Number(document.form1.e55_quant_ant.value);
    let vluni =  new Number(document.form1.e55_vluni.value);
    let vltot =  new Number(document.form1.e55_vltot.value);
    let total =  new Number(document.form1.totalad.value);
    let utili =  new Number(document.form1.utilizado.value);
    let dispo =  new Number(document.form1.disponivel.value);

    if (isNaN(qt) || qt <= 0) {
      alert('Quantidade do item é inválida!');
      return false;
    }

    if (isNaN(vluni) || vluni <= 0) {
      alert('Valor unitário é inválido!');
      return false;
    }

    if (isNaN(vltot) || vltot==0 || vltot ==' '  ) {

      alert('Valor total inválido!');
      return false;
    }

    if ((vltot+utili) > total) {
      alert('O valor total do item não pode ser maior que o valor total do item Adjudicado!');
      return false;
    }

    return true;
  }

  function js_consulta(){
    var opcao = document.createElement("input");
    opcao.setAttribute("type","hidden");
    opcao.setAttribute("name","consultando");
    opcao.setAttribute("value","true");
    document.form1.appendChild(opcao);
    <?
       if(isset($opcao) && $opcao=="alterar"){
    ?>
        var opcao = document.createElement("input");
        opcao.setAttribute("type","hidden");
        opcao.setAttribute("name","opcao");
        opcao.setAttribute("value","alterar");
        document.form1.appendChild(opcao);
    <?
      }
    ?>
      document.form1.submit();
 }
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}

function js_pesquisae55_item(mostra){

  if(mostra==true){
    js_OpenJanelaIframe('top.corpo.iframe_empautitem','db_iframe_pcmaterele',"func_pcmaterelelibaut.php?<?php echo "criterioadjudicacao=true&z01_numcgm=$z01_numcgm&" ?>iCodigoAutorizacao="+$F('e55_autori')+"&funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater|pc07_codele|pc23_quant|pc23_vlrun|pc23_valor|pc80_criterioadjudicacao|pc01_servico|tipoitem|pc94_sequencial",'Pesquisa',true,"0","1");
  }else{
     if(document.form1.e55_item.value != ''){
        js_OpenJanelaIframe('top.corpo.iframe_empautitem','db_iframe_pcmaterele',"func_pcmaterelelibaut.php?pesquisa=true&z01_numcgm=<?=$z01_numcgm?>&iCodigoAutorizacao="+$F('e55_autori')+"&pesquisa_chave="+document.form1.e55_item.value+"&funcao_js=parent.js_mostrapcmater",'Pesquisa',false);
     }else{
       document.form1.pc01_descrmater.value = '';
       document.form1.submit();
     }
  }
}
function js_mostrapcmater(chave,erro,codele,quant,vluni,tipoitem,total,sequencial){
  document.form1.pc01_descrmater.value = chave;
  let opcao = "<?= $opcao ?>";

  if(erro==true){
    document.form1.e55_item.focus();
    document.form1.e55_item.value = '';
    document.form1.pc01_descrmater.value = '';
    document.form1.e55_quant.value = '';
    document.form1.submit();
  } else {
      document.form1.pc07_codele.value = codele;
      document.form1.pc01_descrmater.value = chave;
      document.form1.e55_quant.value = quant;
      document.form1.totalad.value = total;
      document.form1.e55_quant.focus();

      var params = {
          exec: 'verificaSaldoCriterio',
          e55_item: document.form1.e55_item.value,
          e55_autori: document.form1.e55_autori.value,
          tipoitem: tipoitem,
          pc94_sequencial: sequencial,
          total: total
      };

      js_consultaValores(params);
  }
}

function js_mostrapcmater1(chave1,chave2,codele,chave3,chave4,chave5,chave6,chave7,chave8,chave9) {
  document.form1.e55_item.value        = chave1;
  document.form1.pc01_descrmater.value = chave2;
  document.form1.pc07_codele.value     = codele;
  document.form1.e55_quant.value = chave3;
  document.form1.e55_vluni.value = '';
  chave7 == 't' ? document.form1.e55_vltot.value = chave5 : "";
  document.form1.pc80_criterioadjudicacao.value  = chave6;
  document.form1.totalad.value = chave5;
  db_iframe_pcmaterele.hide();
  var params = {
    exec: 'verificaSaldoCriterio',
    e55_item: chave1,
    e55_autori: document.form1.e55_autori.value,
    tipoitem: chave8,
    pc94_sequencial: chave9,
    total: chave5
  };

    js_consultaValores(params);
}
    function js_consultaValores(params){
        novoAjax(params, (e) => {
            let totitens = JSON.parse(e.responseText).itens;
            document.form1.utilizado.value  = totitens[0].totalitens > 0 ? totitens[0].totalitens : "0" ;
            document.form1.disponivel.value = new Number(params.total - totitens[0].totalitens) > 0 ? new Number(params.total - totitens[0].totalitens) : "0";

            js_consulta();

            document.form1.e55_quant.focus();
        });
    }

function novoAjax(params, onComplete) {

  var request = new Ajax.Request('lic4_geraAutorizacoes.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}

function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_empautitem','func_empautitem.php?funcao_js=parent.js_preenchepesquisa|e55_autori|e55_sequen','Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1){
  db_iframe_empautitem.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&chavepesquisa1='+chave1";
  }
  ?>
}

<?
  if(isset($incluir) || isset($alterar) || isset($excluir) ) {

    echo "\n\ntop.corpo.iframe_empautidot.location.href =  'emp1_empautidottaxatabela001.php?anulacao=true&e56_autori=$e55_autori';\n";
  }
?>

<?if(isset($numrows99) && $numrows99>0){?>
  codele = document.form1.pc07_codele.value;
  if(codele!=''){
     js_troca(codele);
  }
<?}?>
</script>