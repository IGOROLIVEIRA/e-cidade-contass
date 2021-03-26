<?
//MODULO: issqn
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("z01_cgccpf");
$clrotulo->label("z01_incest");
$clrotulo->label("z01_cep");
$clrotulo->label("z01_ident");
$clrotulo->label("z01_munic");
$clrotulo->label("q02_inscr");
$clrotulo->label("q02_numcgm");
$clrotulo->label("q02_fanta");
$clrotulo->label("q30_quant");
$clrotulo->label("q30_anousu");
$clrotulo->label("q30_mult");
$clrotulo->label("j14_nome");
$clrotulo->label("j14_codigo");
$clrotulo->label("z01_ender");
$clrotulo->label("q02_compl");
$clrotulo->label("q02_numero");
$clrotulo->label("q02_cxpost");
$clrotulo->label("j13_codi");
$clrotulo->label("j13_descr");
$clrotulo->label("z01_bairro");
$clrotulo->label("q14_proces");
$clrotulo->label("q10_numcgm");
$clrotulo->label("q02_memo");
$clrotulo->label("q05_matric");
$clrotulo->label("q05_idcons");
$clrotulo->label("q02_regjuc");
$clrotulo->label("q02_dtcada");
$clrotulo->label("p58_requer");
$clrotulo->label("q40_codporte");
$clrotulo->label("q45_codporte");
$clrotulo->label("q45_descr");
$clrotulo->label("q40_descr");
$clrotulo->label("q02_capit");

$clrotulo->label("q35_zona");
$clrotulo->label("q35_area");
$clrotulo->label("j50_descr");

$tam_cgccpf=0;
if($db_opcao==1){
  $acao="iss1_issbase014.php";
}else if($db_opcao==2 || $db_opcao==22){
  $db_opcao=2;
  $acao="iss1_issbase015.php";
}else if($db_opcao==3 || $db_opcao==33){
  $acao="iss1_issbase016.php";
}
?>
<form name="form1" method="post" action="<?=$acao?>">
<script>
  function js_trocaid(obj){
    str=document.getElementById('idcar_'+obj).value;
    matriz=str.split('XabX');
    document.form1.j14_codigo.value=matriz[0];
    document.form1.j14_nome.value=matriz[1];
    document.form1.q02_numero.value=matriz[2];
    document.form1.q02_compl.value=matriz[3];
    document.form1.j13_codi.value=matriz[4];
    document.form1.j13_descr.value=matriz[5];
    document.form1.q30_quant.value=matriz[6];
  }
</script>
<center>
  <table>
    <tr>
      <td>
<fieldset><Legend align="center"><b><small>Dados do CGM</small></b></Legend>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap title="<?=@$Tq02_inscr?>" >
       <small><?=@$Lq02_inscr?></small>
    </td>
    <td>
  <?
  ?>
<?
db_input('testasub',4,0,true,'hidden',1);
db_input('q30_anousu',4,0,true,'hidden',1);

db_input('q02_inscr',6,$Iq02_inscr,true,'text',3);
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$z01_nome?>" >
       <small><?=$Lq02_numcgm?></small>
    </td>
    <td>
	 <?
    db_input('q02_numcgm',6,$Iq02_numcgm,true,'text',3);
    db_input('z01_nome',44,$Iz01_nome,true,'text',3,'')
	 ?>
      </td>
  </tr>
  <tr>
      <td nowrap title="<?=@$Tz01_ender?>">
	 <small><?=@$Lz01_ender?><small>
      </td>
      <td>
  <?
  db_input('z01_ender',35,$Iz01_ender,true,'text',3);
  ?>
      <small> <?=@$Lz01_cep?></small>
<?
db_input('z01_cep',13,$Iz01_cep,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tz01_munic?>">
       <small><?=@$Lz01_munic?></small>
    </td>
    <td >
<?
 db_input('z01_munic',32,$Iz01_munic,true,'text',3);
?>
      <small> <?=@$Lz01_cgccpf?><small>
<?
db_input('z01_cgccpf',15,$Iz01_cgccpf,true,'text',3)
?>
    </td>
  </tr>
</table>
</fieldset>
   </td>
   </tr>
   <tr>
   <td align="center">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td >
       <fieldset><Legend align="center"><b><small>Endereço no município</small></b></Legend>
        <table cellspacing="0" cellpadding="0">
<?

if($db_opcao==33 || $db_opcao==22 || strtoupper($munic)==strtoupper($z01_munic)){
?>
  <tr>
    <td nowrap title="<?=@$Tq05_matric?>">
    <?
     db_ancora($Lq05_matric,"js_matri(true);",$db_opcao);
    ?>
    </td>
    <td>
    <?
	db_input('q05_matric',5,$Iq05_matric,true,'text',$db_opcao,"onchange='js_matri(false)'");
	db_input('z01_nome',40,0,true,'text',3,"","z01_nome_matric","#E6E4F1");
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tq05_idcons?>">
      <?=$Lq05_idcons?>
      </td>
      <td>
      <?
      if(isset($q05_matric) && $q05_matric!=""){
	$result04=$cliptuconstr->sql_record($cliptuconstr->sql_query($q05_matric,"","j39_idcons as idcons,j39_codigo,j14_nome as nomerua,j39_numero,j39_compl,j34_bairro,j39_area","j39_idcons"));
	$xxx =  array();
	$numrows04=$cliptuconstr->numrows;
	if($numrows04>0){
  	  for($i=0; $i < $numrows04; $i++){
	    db_fieldsmemory($result04,$i);
	    $xxx[$idcons]=$idcons;
	    $wx="idcar_".$idcons;
	    if($j34_bairro!="" && $j34_bairro!=0){
  	      $result29 = $clbairro->sql_record($clbairro->sql_query_file($j34_bairro,"j13_descr"));
   	      db_fieldsmemory($result29,0);
  	      $$wx=$j39_codigo."XabX".$nomerua."XabX".$j39_numero."XabX".$j39_compl."XabX".$j34_bairro."XabX".$j13_descr."XabX".$j39_area;
	    }else{
  	      $$wx=$j39_codigo."XabX".$nomerua."XabX".$j39_numero."XabX".$j39_compl."XabXXabXXabX".$j39_area;
	    }
	    db_input('idcar_'.$idcons,20,0,true,'hidden',1);
	  }
	  if(!isset($chavepesquisa)){
   	    db_fieldsmemory($result04,0);
	    $q05_idcons=$idcons;
	  }
        }else{
	  $str_matric=false;
	  unset($q05_idcons);
	}
      }else{
	unset($q05_idcons);
      }
      if(isset($q05_matric) && $q05_matric!="" && $numrows04>1){
	db_select('q05_idcons',$xxx,true,$db_opcao,"onchange='js_trocaid(this.value);'");
      }else{
	if(empty($numrows04) && (isset($numrows04) && $numrows04!=1) ){
	  $q05_idcons="";
	}
        db_input('q05_idcons',5,$Iq05_idcons,true,'text',3);

      }
      ?>
      </td>
    </tr>
  <?
    }
  ?>
    <tr>
    <?
      $result02=$cldb_cgmruas->sql_record($cldb_cgmruas->sql_query($q02_numcgm,"ruas.j14_codigo,ruas.j14_nome"));
      $cgmnops="true";
      if($cldb_cgmruas->numrows>0 && empty($j14_codigo)){
        db_fieldsmemory($result02,0);
      }

      if(isset($q05_matric) && $q05_matric!="" ){
        echo "<td nowrap title='$Tj14_codigo'>";
        echo $Lj14_codigo;
        echo "</td>";
        echo "<td>";
	  db_input('j14_codigo',5,$Ij14_codigo,true,'text',3,'',"","#E6E4F1");
      }else{
        echo "<td nowrap title='$Tj14_codigo'>";
        db_ancora($Lj14_codigo,'js_pesquisaj14_codigo(true); ',$db_opcao);
        echo "</td>";
        echo "<td>";
        db_input('j14_codigo',5,$Ij14_codigo,true,'text',$db_opcao," onchange='js_pesquisaj14_codigo(false);'",'',"#E6E4F1");
      }
      db_input('j14_nome',40,$Ij14_nome,true,'text',3);
      echo "</td>";
    if($db_opcao!=33 && $db_opcao!=22 && strtoupper($munic)==strtoupper($z01_munic)){
    }else{
      $cgmnops="false";
    }
  ?>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tq02_numero?>">
	 <?=@$Lq02_numero?>
      </td>
      <td nowrap>
  <?
  if($db_opcao!=33 && $db_opcao!=22 && strtoupper($munic)!=strtoupper($z01_munic)){
    db_input('q02_numero',5,$Iq02_numero,true,'text',1)
    ?>
  	 <?=@$Lq02_compl?>
    <?
    db_input('q02_compl',16,$Iq02_compl,true,'text',1);
  }else{
    if($db_opcao!=33 && $db_opcao!=22 && empty($q02_numero) && strtoupper($munic)==strtoupper($z01_munic)){
      $q02_numero=@$z01_numero;
	$q02_compl=@$z01_compl;
    }
    db_input('q02_numero',5,$Iq02_numero,true,'text',$db_opcao);
    ?>
  	 <?=@$Lq02_compl?>
    <?
    db_input('q02_compl',16,$Iq02_compl,true,'text',$db_opcao);
  }
 ?>
 <?=@$Lq02_cxpost?>
  <?
  db_input('q02_cxpost',11,$Iq02_cxpost,true,'text',1);
  ?>

     <td>
    </tr>
    <tr>
  <?
      if(!isset($chavepesquisa)){
        $result03=$cldb_cgmbairro->sql_record($cldb_cgmbairro->sql_query_file($q02_numcgm," * "));
        if($cldb_cgmbairro->numrows>0){
          db_fieldsmemory($result03,0);
          $result53=$clbairro->sql_record($clbairro->sql_query_file($j13_codi));
          db_fieldsmemory($result53,0);
        }
      }
      if(isset($q05_matric) && $q05_matric!="" ){
        echo "<td nowrap title='$Tj13_codi'>";
        echo $Lj13_codi;
        echo "</td>";
        echo "<td>";
        db_input('j13_codi',5,$Ij13_codi,true,'text',3);
        db_input('j13_descr',40,$Ij13_descr,true,'text',3);
      }else{
        echo "<td nowrap title='$Tj13_codi'>";
        db_ancora($Lj13_codi,'js_bairro(true); ',$db_opcao);
        echo "</td>";
        echo "<td>";
        db_input('j13_codi',5,$Ij13_codi,true,'text',$db_opcao," onchange='js_bairro(false);'","","E6E4F1");
        db_input('j13_descr',40,$Ij13_descr,true,'text',3,"","","E6E4F1");
       }
    if($cgmnops=="true"){
    }else{
    }
  ?>
	       <td>
    </tr>
	 </table>
       </fieldset>
    </td>
  </tr>
<tr>
  <td>
       <fieldset><Legend align="center"><b><small>Outros dados</small></b></Legend>
<table cellspacing="0" cellpadding="0">
  <tr>
  <td nowrap colspan=2  title="<?=@$Tq40_codporte?>"> <?
  $tam_cgccpf=strlen($z01_cgccpf);
  if ($tam_cgccpf==14){
    db_ancora(@$Lq40_codporte,"js_pesquisa_porte(true,'j');",$db_opcao);
    db_input('q45_codporte',5,$Iq45_codporte,true,'text',$db_opcao,"onchange=js_pesquisa_porte(false,'j');");
  }else{
    db_ancora(@$Lq40_codporte,"js_pesquisa_porte(true,'f');",$db_opcao);
    db_input('q45_codporte',5,$Iq45_codporte,true,'text',$db_opcao,"onchange=js_pesquisa_porte(false,'f');");
  }
   db_input('q40_descr',30,$Iq40_descr,true,'text',3);

  $tam_cgccpf=strlen($z01_cgccpf);
  if ($tam_cgccpf==14){
  ?>


  <?=@$Lq02_capit?>
  <?
    $sql = $clsocios->sql_query_socios($q02_numcgm,"","sum(q95_perc) as somaval ");
    $result_testaval=pg_exec($sql);
    if (pg_numrows($result_testaval)!=0){
      db_fieldsmemory($result_testaval,0);


    }else $somaval=0;
    $somaval=db_formatar($somaval,'f');
    $q02_capit=$somaval;
   db_input('q02_capit',15,$Iq02_capit,true,'text',3);
  ?>
    </td>
  </tr>
  <?}else $q02_capit="0";
  ?>
  <tr>
    <td nowrap title="<?=@$Tq02_fanta?>">
       <?=@$Lq02_fanta?>
    </td>
    <td>
<?
!isset($q02_fanta)&&$db_opcao!=33&&$db_opcao!=22?$q02_fanta=$z01_nome:"";
db_input('q02_fanta',40,$Iq02_fanta,true,'text',$db_opcao,"")
?>
    <input type='button' name='copia' value='Copia nome' onclick="js_copia();">
    <td>
  </tr>
  <tr>
      <td nowrap title="<?=@$Tq10_numcgm?>">
	 <?
	 db_ancora(@$Lq10_numcgm,"js_pesquisaq10_numcgm(true);",$db_opcao);
	 ?>
      </td>
      <td nowrap title="<?=@$Tq14_proces?>">
  <?
  db_input('q10_numcgm',5,$Iq10_numcgm,true,'text',$db_opcao," onchange='js_pesquisaq10_numcgm(false);'");
  db_input('z01_nome',40,$Iz01_nome,true,'text',3,'','z01_nome_escrito',"E6E4F1");
  ?>
      <td>
    </tr>

    <tr>
      <td nowrap title="<?=@$Tq30_quant?>">
	 <?=@$Lq30_quant?>
      </td>
      <td>
  <?
if(!isset($q30_quant) && $db_opcao!=33 && $db_opcao!=3 && $db_opcao!=2 && $db_opcao!=22){
   $q30_quant='1';
}else if(isset($q05_matric) && $q05_matric!="" && isset($j39_area) ){
   $q30_quant=$j39_area;

}

!isset($q30_mult)&&$db_opcao!=33&&$db_opcao!=3&&$db_opcao!=2&&$db_opcao!=22?$q30_mult='1':"";
  db_input('q30_quant',8,$Iq30_quant,true,'text',$db_opcao,"")
  ?>
	 <?=@$Lq30_mult?>
  <?
  db_input('q30_mult',4,$Iq30_mult,true,'text',$db_opcao,"");
  $tam_cgccpf=strlen($z01_cgccpf);
  if ($tam_cgccpf==14){
  ?>
	 <?=$Lq02_regjuc?>
	 <?
  db_input('q02_regjuc',10,$Iq02_regjuc,true,'text',$db_opcao,"");
  }else{
    $q02_regjuc="";
    db_input('q02_regjuc',10,$Iq02_regjuc,true,'hidden',3,"");
  }
  ?>
      <td>
    </tr>
      <tr>
    <td nowrap title="<?=@$Tq30_area?>">
       <?=@$Lq30_area?>
    </td>
    <td>
<?
db_input('q30_area',10,$Iq30_area,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

    <!--  -->
    <tr>
    <td nowrap title="<?=@$Tq35_zona?>">
       <?
       db_ancora(@$Lq35_zona,"js_pesquisaq35_zona(true);",$db_opcao);
       ?>
    </td>
    <td>
		<?
			db_input('q35_zona',10,$Iq35_zona,true,'text',$db_opcao," onchange='js_pesquisaq35_zona(false);'")
		?>
       <?
			db_input('j50_descr',10,$Ij50_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <!--  -->
    <tr>
      <td nowrap title="<?=@$Tq14_proces?>">
	 <?
       db_ancora(@$Lq14_proces,"js_pesquisaq14_proces(true);",$db_opcao);
       ?>
      </td>
      <td>
  <?
  db_input('q14_proces',10,$Iq14_proces,true,'text',$db_opcao," onchange='js_pesquisaq14_proces(false);'")
  ?>
  <?db_input('p58_requer',40,$Ip58_requer,true,'text',3,'')

  ?>
      <td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tq02_memo?>" valign="top">
	 <?=$Lq02_memo?>
      </td>
      <td>
  <?
  db_textarea('q02_memo',1,37,$Iq02_memo,true,'text',$db_opcao,"")
  ?>
      <td>
    </tr>
    </table>
  </fieldset>
 </td>
 </tr>
</table>



    </center>
<?
if($db_opcao==22){
  $db_botao=false;
}
?>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2 || $db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2 || $db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>   <?=$db_opcao==1?"onclick='return js_testaproc();'":""?> >
  <input name="voltar" type="button" id="voltar" value="Voltar" onclick="js_voltar();" >
  </form>
  <script>

function js_pesquisaq35_zona(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_zonas','func_zonas.php?funcao_js=parent.js_mostrazonas1|j50_zona|j50_descr','Pesquisa',true);
  }else{
     if(document.form1.q35_zona.value != ''){
        js_OpenJanelaIframe('','db_iframe_zonas','func_zonas.php?pesquisa_chave='+document.form1.q35_zona.value+'&funcao_js=parent.js_mostrazonas','Pesquisa',false);
     }else{
       document.form1.j50_descr.value = '';
     }
  }
}
function js_mostrazonas(chave,erro){
  document.form1.j50_descr.value = chave;
  if(erro==true){
    document.form1.q35_zona.focus();
    document.form1.q35_zona.value = '';
  }
}
function js_mostrazonas1(chave1,chave2){
  document.form1.q35_zona.value = chave1;
  document.form1.j50_descr.value = chave2;
  db_iframe_zonas.hide();
}




    function js_testaproc(){

    if (document.form1.q14_proces.value==""){
      alert("Codigo do processo não está preenchido!!");
      document.form1.q14_proces.focus();
      return false;
    }else if (document.form1.q45_codporte.value==""){
      alert("Porte não está preenchido!!");
      document.form1.q45_codporte.focus();
      return false;

    }else  return true;


    }
    function js_copia(){
      document.form1.q02_fanta.value=document.form1.z01_nome.value;
    }
  function js_voltar(){
    <?
    if($db_opcao==1){
    echo "parent.location.href='iss1_issbase004.php';";
    }elseif($db_opcao==2 || $db_opcao==22){
    echo "parent.location.href='iss1_issbase005.php';";
    }else{
    echo "parent.location.href='iss1_issbase006.php';";
    }
    ?>
  }
  <?
   if(!isset($chavepesquisa) && isset($q05_idcons) && $q05_idcons!=""){
     echo "js_trocaid($q05_idcons);\n";
   }
  ?>
  function js_matri(mostra){
    matric=document.form1.q05_matric.value;
    /*----------------------------------------------Não sei o q faz!! comentei!!não abria ancora matricula!!
    if(matric=="" || matric==0){
      document.form1.q05_matric.value = '';
      document.form1.z01_nome_matric.value = '';
      document.form1.testasub.value = "ok";

	        obj=document.createElement('input');
  	        obj.setAttribute('name','first');
	        obj.setAttribute('type','hidden');
      	        obj.setAttribute('value',"ok");
	        document.form1.appendChild(obj);


      document.form1.submit();
    }else{*/
      if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe1','func_iptubasealt.php?funcao_js=parent.js_mostramatric|0|1|j39_idcons','Pesquisa',true,0);
      }else{
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe1','func_iptubasealt.php?pesquisa_chave='+matric+'&funcao_js=parent.js_mostramatric1','Pesquisa',false,0);
      }
//    }
  }
  function js_mostramatric(chave1,chave2,chave3){
    document.form1.q05_matric.value = chave1;
    document.form1.z01_nome_matric.value = chave2;
    document.form1.q05_idcons.value = chave3;
    document.form1.testasub.value = "ok";
    document.form1.submit();
    db_iframe1.hide();
  }
  function js_mostramatric1(chave,erro){
    document.form1.z01_nome_matric.value = chave;
    if(erro==true){
      document.form1.q05_matric.focus();
      document.form1.q05_matric.value = '';
    }else{
      document.form1.testasub.value = "ok";
      document.form1.submit();
    }
  }
  function js_pesquisaq10_numcgm(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe2','func_cadescritoalt.php?funcao_js=parent.js_mostraescrito|0|1','Pesquisa',true,0);
    }else{
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe2','func_cadescritoalt.php?pesquisa_chave='+document.form1.q10_numcgm.value+'&funcao_js=parent.js_mostraescrito1','Pesquisa',false,0);
    }
  }
  function js_mostraescrito(chave1,chave2){
    document.form1.q10_numcgm.value = chave1;
    document.form1.z01_nome_escrito.value = chave2;
    db_iframe2.hide();
  }
  function js_mostraescrito1(chave,erro){
    document.form1.z01_nome_escrito.value = chave;
    if(erro==true){
      document.form1.q10_numcgm.focus();
      document.form1.q10_numcgm.value = '';
    }
  }
  function js_bairro(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe_bairro','func_bairro.php?funcao_js=parent.js_mostrabairro1|0|1','Pesquisa',true,0);
    }else{
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe_bairro','func_bairro.php?pesquisa_chave='+document.form1.j13_codi.value+'&funcao_js=parent.js_mostrabairro','Pesquisa',false,0);
    }
  }
  function js_mostrabairro(chave,erro){
    document.form1.j13_descr.value = chave;
    if(erro==true){
      document.form1.j13_codi.focus();
      document.form1.j13_codi.value = '';
    }
  }
  function js_mostrabairro1(chave1,chave2){
    document.form1.j13_codi.value = chave1;
    document.form1.j13_descr.value = chave2;
    db_iframe_bairro.hide();
  }
  function js_pesquisaj14_codigo(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe','func_ruas.php?rural=1&funcao_js=parent.js_mostraruas1|0|1','Pesquisa',true,0);
    }else{
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe','func_ruas.php?rural=1&pesquisa_chave='+document.form1.j14_codigo.value+'&funcao_js=parent.js_mostraruas','Pesquisa',false,0);
    }
  }
  function js_mostraruas1(chave1,chave2){
    document.form1.j14_codigo.value = chave1;
    document.form1.j14_nome.value = chave2;
    db_iframe.hide();
  }
  function js_mostraruas(chave,erro){
    document.form1.j14_nome.value = chave;
    if(erro==true){
      document.form1.j14_codigo.focus();
      document.form1.j14_codigo.value = '';
    }
  }
function js_pesquisaq14_proces(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe_processo','func_protprocesso.php?funcao_js=parent.js_mostraprocesso1|p58_codproc|p58_requer','Pesquisa',true);
  }else{
     if(document.form1.q14_proces.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe_processo','func_protprocesso.php?pesquisa_chave='+document.form1.q14_proces.value+'&funcao_js=parent.js_mostraprocesso','Pesquisa',false);
     }else{
       document.form1.q14_proces.value = '';
     }
  }
}
function js_mostraprocesso(chave,erro){
  document.form1.p58_requer.value = chave;
  if(erro==true){
    document.form1.q14_proces.focus();
    document.form1.q14_proces.value = '';
  }
}
function js_mostraprocesso1(chave1,chave2){
  document.form1.q14_proces.value = chave1;
  document.form1.p58_requer.value = chave2;
  db_iframe_processo.hide();
}
function js_pesquisa_porte(mostra,pessoa){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe_porte','func_issporte.php?pessoa='+pessoa+'&funcao_js=parent.js_mostraporte1|q40_codporte|q40_descr','Pesquisa',true);
  }else{
     if(document.form1.q45_codporte.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issbase','db_iframe_porte','func_issporte.php?pessoa='+pessoa+'&pesquisa_chave='+document.form1.q45_codporte.value+'&funcao_js=parent.js_mostraporte','Pesquisa',false);
     }else{
       document.form1.q45_codporte.value = '';
     }
  }
}
function js_mostraporte(chave,erro){
  document.form1.q40_descr.value = chave;
  if(erro==true){
    document.form1.q45_codporte.focus();
    document.form1.q45_codporte.value = '';
  }
}
function js_mostraporte1(chave1,chave2){
  document.form1.q45_codporte.value = chave1;
  document.form1.q40_descr.value = chave2;
  db_iframe_porte.hide();
}

<?
if(isset($testasub)){
  echo "document.form1.testasub.value='';\n";
}
if(!isset($excluir) && !isset($alterar) && !isset($incluir)){
  if($db_opcao==1 && strtoupper($munic)!=strtoupper($z01_munic) && empty($q05_matric)){
    echo "alert('CGM de outra cidade.');";
  }
  if(isset($str_matric) && $str_matric==false){
    echo "alert('Matricula não é predial, portanto não poderá ser usada.');\n";
  }
  if(($db_opcao==22 || $db_opcao==33)){
    echo "js_pesquisa();\n";
  }
}
?>
</script>
