<?

//MODULO: compras
$clpcmater->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc04_descrsubgrupo");
$clrotulo->label("o56_elemento");
$clrotulo->label("pc03_codgrupo");
$clrotulo->label("pc04_codsubgrupo");
$clrotulo->label("pc01_validademinima");
$clrotulo->label("pc01_obrigatorio");
$vaiIframe = "";

/**
 * Funcao que retorna se o item esta em uma solicitação, autorização ou empenho para permitir ou não a alteração do item como seriviço sim ou não.
 * @param $iItem
 * @return bool
 */
function verPermissaoAlteraServico($iItem)
{
    $clsolicitem = new cl_solicitem;
    $clempautitem = new cl_empautitem;
    $clempempitem = new cl_empempitem;
    $rSql2 = db_query($clempautitem->sql_query(null, null, "e54_autori,e54_emiss,e54_anulad,descrdepto,e55_quant,e55_vlrun,e55_vltot", null, "e55_item=$iItem"));
    $rSql3 = db_query($clempempitem->sql_query(null, null, "e60_numemp,e60_codemp,e60_emiss,nome,e62_quant,e62_vlrun,e62_vltot", null, "e62_item=$iItem"));
    $rSql1 = db_query($clsolicitem->sql_query_pcmater(null, "pc10_numero,pc10_data,descrdepto,nome,pc11_seq, pc11_quant,pc11_vlrun,pc11_vlrun*pc11_quant as dl_Valor", "pc10_numero desc", "pc16_codmater=$iItem"));

    if(pg_num_rows($rSql1) > 0 or pg_num_rows($rSql2) > 0 or pg_num_rows($rSql3) > 0){
        return true;
    }else{
        return false;
    }
}
?>
<script>
function js_troca(){
  document.form1.submit();
}
function js_executaIframe(val) {
  ele = document.form1.codeles.value;
  mat = document.form1.pc01_codmater.value;
  opc = <?=$db_opcao?>;
  pcmater0011.location.href = 'com1_pcmater0011.php?db_opcao='+opc+'&codigomater='+mat+'&codsubgrupo='+val+'&codele='+ele;
}
</script>
<form name="form1" method="post" action="" onsubmit="return js_check()">
<input type="hidden" name="codeles" value=<?=@$coluna?> >
<center>
<fieldset>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tpc01_codmater?>"> <?=@$Lpc01_codmater?> </td>
    <td> <? //db_input('pc01_codmater',6,$Ipc01_codmater,true,'text',$db_opcao,"readonly")
           // carlos
           db_input('pc01_codmater',6,$Ipc01_codmater,true,'text',3,"");
           $pc01_id_usuario = db_getsession("DB_id_usuario");
           db_input('pc01_id_usuario',6,$Ipc01_id_usuario,true,'hidden',3,"");
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc01_descrmater?>"> <?=@$Lpc01_descrmater?>    </td>
    <td> <? db_textarea('pc01_descrmater',0,75,$Ipc01_descrmater,true,'text',$db_opcao,"onkeyup = 'return js_validaCaracteres(this.value, pc01_descrmater.id)';",'','','80') ?>
  </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc01_complmater?>">       <?=@$Lpc01_complmater?>    </td>
    <td> <? db_textarea('pc01_complmater',0,75,$Ipc01_complmater,true,'text',$db_opcao, "onkeyup = 'return js_validaCaracteres(this.value, pc01_complmater.id)';") ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tpc01_libaut?>">       <?=@$Lpc01_libaut?>    </td>
    <td nowrap> <?
    $arrlibaut_truefalse = array('t'=>'Sim','f'=>'Não');
    db_select("pc01_libaut",$arrlibaut_truefalse,true,$db_opcao);
    ?>
    <?=$Lpc01_ativo?>
    <?
    $arr_truefalse = array('f'=>'Não','t'=>'Sim');
    db_select("pc01_ativo",$arr_truefalse,true,$db_opcao);
    ?>
    <b>Tipo:</b>
    <?
     $x = array("f"=>"Material","t"=>"Serviço/Material Permanente");
        if(isset($pc01_codmater)) {
            if (verPermissaoAlteraServico($pc01_codmater)) {
                db_select("pc01_servico", $x, true, 3);
            } else {
                db_select("pc01_servico", $x, true, $db_opcao);
            }
        }else{
            db_select("pc01_servico", $x, true, $db_opcao);
        }
    ?>
    <?=$Lpc01_veiculo?>
    <?
    $aVeic = array("f"=>"Não","t"=>"Sim");
    db_select("pc01_veiculo",$aVeic,true,$db_opcao);
    ?>

    </td>
    <tr>
      <td>
        <?
        echo $Lpc01_fraciona;
        ?>
      </td>
      <td>
        <?
        $aFrac = array("f"=>"Não","t"=>"Sim");
        db_select("pc01_fraciona",$aFrac,true,$db_opcao);
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap>
        <?
        echo $Lpc01_validademinima;
        ?>
      </td>
      <td nowrap>
       <?
        $aValMin = array("f"=>"Não","t"=>"Sim");
        db_select("pc01_validademinima",$aValMin,true,$db_opcao);
        ?>


        <?
        echo $Lpc01_obrigatorio;

        $aPObrigatorio = array("f"=>"Não","t"=>"Sim");
        db_select("pc01_obrigatorio", $aPObrigatorio ,true,$db_opcao);
        ?>

        <?
        echo $Lpc01_liberaresumo;

        $aLiberarResumo = array("t" => "Sim",
                                "f" => "Não");
        db_select("pc01_liberaresumo", $aLiberarResumo, true, $db_opcao);
        ?>
      </td>

  </tr>
  <tr>
    <td><?=$Lpc03_codgrupo?> </td>
    <td align='left'>
        <?
	  //com query_file na classe
	  /*
	  if (!isset($pc013_codgrupo)){
             if(isset($pc01_codsubgrupo) &&  ($db_opcao == 2 || $db_opcao == 3)){
                 global $pc03_codgrupo;
                 // echo "<script>alert('".$clpcsubgrupo->sql_query($pc01_codsubgrupo,"pc04_codgrupo as pc01_codgrupo")."'</script>";
                 $result = $clpcsubgrupo->sql_record($clpcsubgrupo->sql_query($pc01_codsubgrupo,"pc04_codgrupo as pc03_codgrupo"));
                 if ($clpcsubgrupo->numrows > 0 ){
	            db_fieldsmemory($result,0);
	         }
              }
	  }
          $result = $clpcgrupo->sql_record($clpcgrupo->sql_query(null,"pc03_codgrupo,pc03_descrgrupo","pc03_descrgrupo"));
          @db_selectrecord("pc03_codgrupo",$result,true,$db_opcao,"","","","0","js_troca(this.value);");
  */
     if (!isset($pc01_codgrupo)){
	    if (!isset($pc03_codgrupo)){
                if(isset($pc01_codsubgrupo) &&  ($db_opcao == 2 || $db_opcao == 3)){
                   global $pc01_codgrupo;
                   $result = $clpcsubgrupo->sql_record($clpcsubgrupo->sql_query($pc01_codsubgrupo,"pc04_codgrupo as pc01_codgrupo",null,"pc04_codsubgrupo=$pc01_codsubgrupo and pc04_ativo is true"));
                   if ($clpcsubgrupo->numrows > 0 ){
	             db_fieldsmemory($result,0);
	           }
                }
	    }
	  }
          $result = $clpcgrupo->sql_record($clpcgrupo->sql_query(null,"pc03_codgrupo,pc03_descrgrupo","pc03_descrgrupo","pc03_ativo is true"));
          @db_selectrecord("pc01_codgrupo",$result,true,$db_opcao,"","","","0","js_troca(this.value);");
        ?>

        <?
          /*$arr_truefalse = array('f'=>'Não','t'=>'Sim');
          db_select("pc01_ativo",$arr_truefalse,true,$db_opcao);*/
        ?>

    </td>
  </tr>
   <? if(isset($pc01_codgrupo) || $db_opcao != 1) : ?>
     <tr>
       <td> <?=$Lpc04_codsubgrupo?> </td>
       <td align='left'>
        <?
           $sWhere = "pc04_codgrupo = ".@$pc01_codgrupo." and pc04_ativo is true and (pc04_tipoutil=1 or pc04_tipoutil=3)";
           if (!isset($pc01_codgrupo)) {
             $sWhere = "pc04_ativo is true and (pc04_tipoutil=1 or pc04_tipoutil=3)";
           }
           $result = $clpcsubgrupo->sql_record(
	           $clpcsubgrupo->sql_query(null,"pc04_codsubgrupo as subgrupo,pc04_descrsubgrupo",
  	 		                              "pc04_descrsubgrupo",
 			                                $sWhere));
           if($clpcsubgrupo->numrows > 0 ){

             db_fieldsmemory($result,0);
             $pc04_codsubgrupo=$subgrupo;
             if(isset($impmater)){
               $result_coluna = $clpcmaterele->sql_record($clpcmaterele->sql_query_file($impmater,null,"pc07_codele"));
               $numrows_coluna = $clpcmaterele->numrows;
               $separa = "";
               $coluna = "";
               for($i=0;$i<$numrows_coluna;$i++){
               	 db_fieldsmemory($result_coluna,$i);
               	 $coluna .= $separa.$pc07_codele;
               	 $separa  = "XX";
               }
               //db_msgbox($subgrupo);
               $vaiIframe = "?db_opcao=$db_opcao&codigomater=".$impmater."&impmater=impmater&codsubgrupo=".$subgrupo."&codele=".$coluna;
             }else{
             	//db_msgbox($subgrupo);
       		    //db_msgbox($pc01_codmater);
       		     if (!isset($pc01_codmater)) {
       		       $pc01_codmater = '';
       		     }
               $vaiIframe = "?db_opcao=$db_opcao&codigomater=".$pc01_codmater."&codsubgrupo=".@$subgrupo."&codele=".@$coluna;
             }
           }
           @db_selectrecord("pc01_codsubgrupo",$result,true,$db_opcao,"","","","","js_executaIframe(this.value)");

        if(empty($pc01_data) || $pc01_data == "" ) {
            $pc01_data = date('Y-m-d', db_getsession("DB_datausu"));
        }
        db_input('pc01_data',6,$Ipc01_data,true,'hidden',3,"");
        ?>
      </td>
      </tr>
   <? endif;    ?>

  <!--OC3770-->
    <tr>
      <td>
        <strong>
           Tabela
        <strong>
      </td>
      <td>
        <?
        $aTabela = array("f"=>"Não","t"=>"Sim");
        db_select("pc01_tabela",$aTabela,true,$db_opcao);
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <strong>
           Taxa
        <strong>
      </td>
      <td>
        <?
        $aTaxa = array("f"=>"Não","t"=>"Sim");
        db_select("pc01_taxa",$aTaxa,true,$db_opcao);
        ?>
      </td>
    </tr>
  <tr>
    <td>
      <strong>Material Utilizado em Obras/serviços?</strong>
    </td>
    <td>
      <?php
      $aObra = array("0"=>"Selecione","f"=>"Não","t"=>"Sim");
      db_select("pc01_obras",$aObra,true,$db_opcao,"");
      ?>
    </td>
  </tr>
  <? if($db_opcao == 22 || $db_opcao == 2):?>
    <tr>
      <td><b>Justificativa da Alteração:</b></td>
      <td>
      <?= db_textarea('pc01_justificativa', 0, 75, '', true, 'text', $db_opcao, "onkeyup = 'return js_validaCaracteres(this.value, pc01_justificativa.id)';", '', '', '100'); ?>
      </td>
    </tr>
  <? endif; ?>
    <!--FIM OC3770 -->

   <tr>
		 <td>&nbsp;<td>
	 </tr>
   <tr>
    <td colspan="2" align="center">
    <div align="left"><b>Lista de desdobramentos<b></div>
      <iframe width="630" height="200" name="pcmater0011" src="com1_pcmater0011.php<?=$vaiIframe?>"></iframe>
    </td>
  </tr>
  <?
    if($db_opcao!=1){?>
  <tr>
    <td colspan=2 bgcolor="#CCFF99" align="center"><strong>***   Elementos que não podem ser <?=$db_opcao==2?" alterados ":" excluídos "?> por estar na autorização de empenho.</strong></td>
  </tr>
  <?}?>
  </table>
</fieldset>
  </center>

<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" disabled="disabled" <?=($db_opcao==2||$db_opcao==1?"onclick='return js_coloca();'":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
  <?

  if($db_opcao==1){
  	$result_pcmater = $clpcmater->sql_record($clpcmater->sql_query_file());
    	if($clpcmater->numrows>0){
  	  echo "<input name='importar' type='button' id='importar' value='Importar material' onclick='js_janelaimporta();' >";
  	}
  }
  ?>
</form>
<script>

  function js_check() {
    if(document.form1.pc01_obras.value == 0) {
      alert('Campo Material Utilizado em Obras/serviços? não informado.');
      document.form1.pc01_obras.focus();
      return false;
    }
    return true
  }

  /**
 * limitar caracteres de textarea
 */
function textCounter() {
  var field = document.form1.pc01_complmater;
  var maxlimit = 250;
  if (field.value.length > maxlimit){
    field.value = field.value.substring(0, maxlimit);
  }
  }


  function js_coloca(codele){
	obj = pcmater0011.document.form1;
	var coluna='';
	var sep='';

	for(i=0; i<obj.length; i++){
	  nome = obj[i].name.substr(0,10);
	  if(nome=="o56_codele" && obj[i].checked==true){
	    coluna += sep+obj[i].value;
	    sep= "XX";
	  }
	}
	document.form1.codeles.value = coluna;
	return true;
	//return coluna ;
  }

function js_pesquisapc01_codsubgrupo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_pcsubgrupo','func_pcsubgrupo.php?funcao_js=parent.js_mostrapcsubgrupo1|pc04_codsubgrupo|pc04_descrsubgrupo','Pesquisa',true);
  }else{
     if(document.form1.pc01_codsubgrupo.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_pcsubgrupo','func_pcsubgrupo.php?pesquisa_chave='+document.form1.pc01_codsubgrupo.value+'&funcao_js=parent.js_mostrapcsubgrupo','Pesquisa',false);
     }else{
       document.form1.pc04_descrsubgrupo.value = '';
     }
  }
}
function js_mostrapcsubgrupo(chave,erro){
  document.form1.pc04_descrsubgrupo.value = chave;
  if(erro==true){
    document.form1.pc01_codsubgrupo.focus();
    document.form1.pc01_codsubgrupo.value = '';
  }
}
function js_mostrapcsubgrupo1(chave1,chave2){
  document.form1.pc01_codsubgrupo.value = chave1;
  document.form1.pc04_descrsubgrupo.value = chave2;
  db_iframe_pcsubgrupo.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_preenchepesquisa|pc01_codmater&vertudo=true','Pesquisa',true);
}
function js_preenchepesquisa(chave){

  document.form1.pc01_codmater.value = chave;
  db_iframe_pcmater.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function js_janelaimporta(){
  qry = "&enviadescr=true";
  if(document.form1.pc01_descrmater.value!="" ){
    qry += "&chave_pc01_descrmater="+document.form1.pc01_descrmater.value;
  }
  js_OpenJanelaIframe('top.corpo','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_enviacodmater|pc01_codmater|pc01_descrmater&vertudo=true'+qry,'Pesquisa',true);
}
function js_enviacodmater(chave,descr){
  db_iframe_pcmater.hide();
  if(chave!=""){
      obj=document.createElement('input');
      obj.setAttribute('name','impmater');
      obj.setAttribute('type','hidden');
      obj.setAttribute('value',chave);
      document.form1.appendChild(obj);
      document.form1.submit();
  }
}

  js_executaIframe(document.form1.pc01_codsubgrupo.value);

  <?
  if(isset($vaiIframe) && trim($vaiIframe)!=""){
  	//echo "pcmater0011.location.href = 'com1_pcmater0011.php".$vaiIframe."';";
  	echo "pcmater0011.document.form1.codsubgrupo.value=document.form1.pc01_codsubgrupo.value;
          pcmater0011.document.form1.submit();";
  }
  ?>

function js_validaCaracteres(texto, campo){
  let temporario = '';
  temporario = texto.replace(/\n/g, ' ');

  /*Caracteres não permitidos na descrição e complemento material*/
  let charBuscados = [";", "'", "\"", "\\", "*", ":", "."];
  let novoTexto = temporario;
  let erro = '';

  charBuscados.map(caractere => {
    if(texto.includes(caractere)){
      erro = true;
    }
  })


  if(window.event){
    /* Lança o erro quando a tecla Enter é pressionada. */
    if(window.event.keyCode == 13){
      erro = true;
      novoTexto = texto.replace(/(\r\n|\n|\r)/g, '');
    }
  }

  /* Remove os caracteres contidos no array charBuscados */
  novoTexto = novoTexto.match(/[^;\*\\\.:\"\']/gm);

  for(let cont=0; cont < novoTexto.length; cont++){

    /* Remove aspas duplas e simples pelo código, pelo fato de virem de fontes diferentes*/

    if(novoTexto[cont].charCodeAt(0) == 8221 || novoTexto[cont].charCodeAt(0) == 8220 || novoTexto[cont].charCodeAt(0) == 8216){
      novoTexto[cont] = '';
      erro = true;
    }
  }

  if(erro){
    alert('Caractere não permitido para inclusão!');
  }

  novoTexto = novoTexto.join('');

  switch(campo){
    case 'pc01_descrmater':
      document.form1.pc01_descrmater.value = novoTexto;
      break;

    case 'pc01_complmater':
      document.form1.pc01_complmater.value = novoTexto;
      break;
  }
}

</script>
