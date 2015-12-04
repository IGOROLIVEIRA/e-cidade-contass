<?
//MODULO: fiscal
$clauto->rotulo->label();
$clautolocal->rotulo->label();
$clautoexec->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("descrdepto");
$clrotulo->label("y30_codnoti");
$clrotulo->label("y77_descricao");
$clrotulo->label("y39_codandam");
$clrotulo->label("y80_codsani");
$clrotulo->label("z01_numcgm");
$clrotulo->label("j01_matric");
$clrotulo->label("q02_inscr");
$clrotulo->label("y10_codigo");
$clrotulo->label("y10_codi");
$clrotulo->label("y10_numero");
$clrotulo->label("y10_compl");
$clrotulo->label("y11_codigo");
$clrotulo->label("y11_codi");
$clrotulo->label("y11_numero");
$clrotulo->label("y11_compl");
$clrotulo->label("j14_nome");
$clrotulo->label("j13_descr");
?>
<form name="form1" method="post" action="">
<?
if(isset($z01_numcgm) && $z01_numcgm != ""){
  db_input('z01_numcgm',5,$Iz01_numcgm,true,'hidden',1,"");
  include("classes/db_cgm_classe.php");
  $clcgm = new cl_cgm;
  $result = $clcgm->sql_record($clcgm->sql_query($z01_numcgm));
  if($clcgm->numrows > 0){
    db_fieldsmemory($result,0);
  }
  $dados = "<a style='text-decoration:none;color:#6699cc;background-color:yellow' onMouseOver='this.style.color=\"blue\"' onMouseOut='this.style.color=\"#6699cc\"'  onClick=\"js_abre('prot3_conscgm002.php?fechar=func_nome&numcgm=$z01_numcgm');return false\" href=''>CGM: ".$z01_numcgm." &nbsp;|&nbsp;".@$z01_nome."</a>";
}elseif(isset($j01_matric) && $j01_matric != ""){
  db_input('j01_matric',5,$Ij01_matric,true,'hidden',1,"");
  include("classes/db_iptubase_classe.php");
  $cliptubase = new cl_iptubase;
  $result = $cliptubase->sql_record($cliptubase->sql_query($j01_matric));
  if($cliptubase->numrows > 0){
    db_fieldsmemory($result,0);
    include("classes/db_cgm_classe.php");
    $clcgm = new cl_cgm;
    $result = $clcgm->sql_record($clcgm->sql_query($j01_numcgm));
    if($clcgm->numrows > 0){
      db_fieldsmemory($result,0);
    }
  }
  $dados = "<a style='text-decoration:none;color:#6699cc;background-color:yellow' onMouseOver='this.style.color=\"blue\"' onMouseOut='this.style.color=\"#6699cc\"'  onClick=\"js_abre('cad3_conscadastro_002.php?cod_matricula=$j01_matric');return false\" href=''>matrícula: ".$j01_matric." &nbsp;|&nbsp;".@$z01_nome."</a>";
}elseif(isset($q02_inscr)  && $q02_inscr  != ""){
  db_input('q02_inscr',5,$Iq02_inscr,true,'hidden',1,"");
  include("classes/db_issbase_classe.php");
  $clissbase = new cl_issbase;
  $result = $clissbase->sql_record($clissbase->sql_query($q02_inscr));
  if($clissbase->numrows > 0){
    db_fieldsmemory($result,0);
    include("classes/db_cgm_classe.php");
    $clcgm = new cl_cgm;
    $result = $clcgm->sql_record($clcgm->sql_query($q02_numcgm));
    if($clcgm->numrows > 0){
      db_fieldsmemory($result,0);
    }
  }
  $dados = "<a style='text-decoration:none;color:#6699cc;background-color:yellow' onMouseOver='this.style.color=\"blue\"' onMouseOut='this.style.color=\"#6699cc\"'  onClick=\"js_abre('iss3_consinscr003.php?numeroDaInscricao=$q02_inscr');return false\" href=''>inscrição: ".$q02_inscr." &nbsp;|&nbsp;".@$z01_nome."</a>";
}elseif(isset($y80_codsani)  && $y80_codsani  != ""){
  db_input('y80_codsani',5,$Iy80_codsani,true,'hidden',1,"");
  include("classes/db_sanitario_classe.php");
  $clsanitario = new cl_sanitario;
  $result = $clsanitario->sql_record($clsanitario->sql_query($y80_codsani));
  if($clsanitario->numrows > 0){
    db_fieldsmemory($result,0);
    include("classes/db_cgm_classe.php");
    $clcgm = new cl_cgm;
    $result = $clcgm->sql_record($clcgm->sql_query($y80_numcgm));
    if($clcgm->numrows > 0){
      db_fieldsmemory($result,0);
    }
  }
  $dados = "<a style='text-decoration:none;color:#6699cc;background-color:yellow' onMouseOver='this.style.color=\"blue\"' onMouseOut='this.style.color=\"#6699cc\"'  onClick=\"js_abre('fis3_consultasani002.php?y80_codsani=$y80_codsani');return false;\" href=''>sanitário: ".$y80_codsani." &nbsp;|&nbsp;".@$z01_nome."</a>";
}elseif(isset($y30_codnoti)  && $y30_codnoti  != ""){
  db_input('y30_codnoti',5,$Iy30_codnoti,true,'hidden',1,"");
  include("classes/db_fiscal_classe.php");
  $clfiscal = new cl_fiscal;
  $result = $clfiscal->sql_record($clfiscal->sql_query($y30_codnoti)); 
  db_fieldsmemory($result,0);
  include("classes/db_fiscalcgm_classe.php");
  $clfiscalcgm = new cl_fiscalcgm;
  $result = $clfiscalcgm->sql_record($clfiscalcgm->sql_query($y30_codnoti)); 
  if($clfiscalcgm->numrows > 0){
    db_fieldsmemory($result,0);
  }
  include("classes/db_fiscalinscr_classe.php");
  $clfiscalinscr = new cl_fiscalinscr;
  $result = $clfiscalinscr->sql_record($clfiscalinscr->sql_query($y30_codnoti)); 
  if($clfiscalinscr->numrows > 0){
    db_fieldsmemory($result,0);
  }
  include("classes/db_fiscalmatric_classe.php");
  $clfiscalmatric = new cl_fiscalmatric;
  $result = $clfiscalmatric->sql_record($clfiscalmatric->sql_query($y30_codnoti)); 
  if($clfiscalmatric->numrows > 0){
    db_fieldsmemory($result,0);
  }
  include("classes/db_fiscalsanitario_classe.php");
  $clfiscalsanitario = new cl_fiscalsanitario;
  $result = $clfiscalsanitario->sql_record($clfiscalsanitario->sql_query($y30_codnoti)); 
  if($clfiscalsanitario->numrows > 0){
    db_fieldsmemory($result,0);
  }
  include("classes/db_cgm_classe.php");
  $clcgm = new cl_cgm;
  $result = $clcgm->sql_record($clcgm->sql_query(@$z01_numcgm));
  if($clcgm->numrows > 0){
    db_fieldsmemory($result,0);
  }
  $dados = "<a style='text-decoration:none;color:#6699cc;background-color:yellow' onMouseOver='this.style.color=\"blue\"' onMouseOut='this.style.color=\"#6699cc\"'  onClick=\"js_abre('fis3_fiscal006.php?y30_codnoti=$y30_codnoti');return false;\" href=''>notificação: ".$y30_codnoti." &nbsp;|&nbsp;".@$z01_nome."</a>";
}
?>
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Ty50_codauto?>">
       <?=@$Ly50_codauto?>
    </td>
    <td> 
<?
db_input('y50_codauto',10,$Iy50_codauto,true,'text',3,"");
?>
       <?=@$Ly50_numbloco?>
<?
db_input('y50_numbloco',10,$Iy50_numbloco,true,'text',$db_opcao,"");
if($db_opcao == 1){
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;$dados&nbsp;</strong>";
}
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty50_data?>">
       <?=@$Ly50_data?>
    </td>
    <td> 
<?
if(empty($y50_data_dia)){
  $y50_data_dia = date("d",db_getsession("DB_datausu"));
  $y50_data_mes = date("m",db_getsession("DB_datausu"));
  $y50_data_ano = date("Y",db_getsession("DB_datausu"));
} 
db_inputdata('y50_data',@$y50_data_dia,@$y50_data_mes,@$y50_data_ano,true,'text',$db_opcao,"")
?>
       <?=@$Ly50_hora?>
<?
db_input('y50_hora',5,$Iy50_hora,true,'text',$db_opcao,"");
if($db_opcao == 1){
  echo "<script>document.form1.y50_hora.value='".db_hora()."'</script>";
}
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty50_obs?>">
       <?=@$Ly50_obs?>
    </td>
    <td> 
<?
db_textarea('y50_obs',2,50,$Iy50_obs,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty50_setor?>">
       <?
       db_ancora(@$Ly50_setor,"js_pesquisay50_setor(true);",3);
       ?>
    </td>
    <td> 
<?
db_input('y50_setor',10,$Iy50_setor,true,'text',3," onchange='js_pesquisay50_setor(false);'")
?>
       <?
db_input('descrdepto',40,$Idescrdepto,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty50_nome?>">
       <?=@$Ly50_nome?>
    </td>
    <td> 
<?
db_input('y50_nome',50,$Iy50_nome,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
      <fieldset>
      <legend align="center"><strong>Endereço registrado</strong></legend>
      <table>
  <tr>
    <td nowrap width="100" title="<?=@$Ty14_codigo?>">
       <?
       db_ancora(@$Ly14_codigo,"js_ruas1(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('y14_codigo',10,$Iy14_codigo,true,'text',$db_opcao," onChange='js_ruas1(false)'");
db_input('j14_nome',50,$Ij14_nome,true,'text',3,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty14_numero?>">
       <?=@$Ly14_numero?>
    </td>
    <td> 
<?
db_input('y14_numero',10,$Iy14_numero,true,'text',$db_opcao,"")
?>
       <?=@$Ly14_compl?>
<?
db_input('y14_compl',20,$Iy14_compl,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr> 
    <td nowrap title="<?=@$Ty14_codi?>"> 
      <?
      db_ancora(@$Ly14_codi,"js_bairro1(true);",$db_opcao);
      ?>
    </td>
    <td nowrap> 
      <?
        db_input('y14_codi',10,$Iy14_codi,true,'text',$db_opcao," onChange='js_bairro1(false)'");
        db_input('j13_descr',50,$Ij13_descr,true,'text',3);
      ?>
    </td>
  </tr>
  </table>
  </fieldset>
  </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
      <fieldset>
      <legend align="center"><strong>Endereço localizado</strong></legend>
      <table>
  <tr> 
    <td nowrap width="100" title="<?=@$Ty15_codigo?>"> 
       <?
       db_ancora(@$Ly15_codigo,"js_ruas(true);",$db_opcao);
       ?>
    </td>
    <td nowrap> 
      <?
	db_input('y15_codigo',10,$Iy15_codigo,true,'text',$db_opcao," onChange='js_ruas(false)'");
	db_input('j14_nome',50,$Ij14_nome,true,'text',3,"","j14_nome_exec");
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty15_numero?>">
       <?=@$Ly15_numero?>
    </td>
    <td> 
<?
db_input('y15_numero',10,$Iy15_numero,true,'text',$db_opcao,"")
?>
       <?=@$Ly15_compl?>
<?
db_input('y15_compl',20,$Iy15_compl,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr> 
    <td nowrap title="<?=@$Ty15_codi?>"> 
      <?
      db_ancora(@$Ly15_codi,"js_bairro(true);",$db_opcao);
      ?>
    </td>
    <td nowrap> 
      <?
        db_input('y15_codi',10,$Iy15_codi,true,'text',$db_opcao," onChange='js_bairro(false)'");
        db_input('j13_descr',50,$Ij13_descr,true,'text',3,"","j13_descr_exec");
      ?>
    </td>
  </tr>
  </table>
  </fieldset>
  </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Ty50_dtvenc?>">
       <?=@$Ly50_dtvenc?>
    </td>
    <td> 
<?
if(empty($y50_dtvenc_dia)){
  $dia = date("d",db_getsession("DB_datausu"));
  $mes = date("m",db_getsession("DB_datausu"));
  $ano = date("Y",db_getsession("DB_datausu"));
  $y50_dtvenc_dia = substr(verifica_data($dia,$mes+1,$ano),8,2);
  $y50_dtvenc_mes = substr(verifica_data($dia,$mes+1,$ano),5,2);
  $y50_dtvenc_ano = substr(verifica_data($dia,$mes+1,$ano),0,4);
} 
db_inputdata('y50_dtvenc',@$y50_dtvenc_dia,@$y50_dtvenc_mes,@$y50_dtvenc_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_bairro(mostra){
  if(mostra == true){
    js_OpenJanelaIframe('','db_iframe_bairros','func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro|j13_codi|j13_descr','pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_bairros','func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro1&pesquisa_chave='+document.form1.y15_codi.value,'pesquisa',false);
  }
}
function js_preenchebairro(chave,chave1){
  document.form1.y15_codi.value = chave;
  document.form1.j13_descr_exec.value = chave1;
  db_iframe_bairros.hide();
}
function js_preenchebairro1(chave,erro){
  document.form1.j13_descr_exec.value = chave;
  if(erro == true){
    document.form1.y15_codi.focus();
    document.form1.y15_codi.value='';
  }
  db_iframe_bairros.hide();
}
function js_bairro1(mostra){
  if(mostra == true){
    js_OpenJanelaIframe('','db_iframe_bairros','func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro2|j13_codi|j13_descr','pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_bairros','func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro22&pesquisa_chave='+document.form1.y14_codi.value,'pesquisa',false);
  }
}
function js_preenchebairro2(chave,chave1){
  document.form1.y14_codi.value = chave;
  document.form1.j13_descr.value = chave1;
  db_iframe_bairros.hide();
}
function js_preenchebairro22(chave,erro){
  document.form1.j13_descr.value = chave;
  if(erro == true){
    document.form1.y14_codi.focus();
    document.form1.y14_codi.value='';
  }
  db_iframe_bairros.hide();
}
function js_ruas(mostra){
  if(mostra == true){
    js_OpenJanelaIframe('','db_iframe_ruas','func_ruas.php?rural=1&funcao_js=parent.js_preencheruas|j14_codigo|j14_nome','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_ruas','func_ruas.php?rural=1&funcao_js=parent.js_preencheruas1&pesquisa_chave='+document.form1.y15_codigo.value+'','Pesquisa',false);
  }
}
function js_preencheruas(chave,chave1){
  document.form1.y15_codigo.value = chave;
  document.form1.j14_nome_exec.value = chave1;
  db_iframe_ruas.hide();
}
function js_preencheruas1(chave,erro){
  document.form1.j14_nome_exec.value = chave;
  if(erro == true){
    document.form1.y15_codigo.focus();
    document.form1.y15_codigo.value='';
  }
  db_iframe_ruas.hide();
}
function js_ruas1(mostra){
  if(mostra == true){
    js_OpenJanelaIframe('','db_iframe_ruas','func_ruas.php?rural=1&funcao_js=parent.js_preencheender|j14_codigo|j14_nome','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_ruas','func_ruas.php?rural=1&funcao_js=parent.js_preencheender1&pesquisa_chave='+document.form1.y14_codigo.value+'','Pesquisa',false);
  }
}
function js_preencheender(chave,chave1){
  document.form1.y14_codigo.value = chave;
  document.form1.j14_nome.value = chave1;
  db_iframe_ruas.hide();
}
function js_preencheender1(chave,erro){
  document.form1.j14_nome.value = chave;
  if(erro==true){ 
    document.form1.y14_codigo.focus(); 
    document.form1.y14_codigo.value = ''; 
  }
}
function js_pesquisay50_setor(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_db_depart','func_db_depart.php?funcao_js=parent.js_mostradb_depart1|coddepto|descrdepto','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_db_depart','func_db_depart.php?pesquisa_chave='+document.form1.y50_setor.value+'&funcao_js=parent.js_mostradb_depart','Pesquisa',false);
  }
}
function js_mostradb_depart(chave,erro){
  document.form1.descrdepto.value = chave; 
  if(erro==true){ 
    document.form1.y50_setor.focus(); 
    document.form1.y50_setor.value = ''; 
  }
}
function js_mostradb_depart1(chave1,chave2){
  document.form1.y50_setor.value = chave1;
  document.form1.descrdepto.value = chave2;
  db_iframe_db_depart.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_auto','func_auto.php?funcao_js=parent.js_preenchepesquisa|y50_codauto','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_auto.hide();
  <?
    if($db_opcao == 2 || $db_opcao == 22){
      echo " location.href = 'fis1_auto002.php?abas=1&chavepesquisa='+chave;";
    }elseif($db_opcao == 33 || $db_opcao == 3){
      echo " location.href = 'fis1_auto003.php?abas=1&chavepesquisa='+chave;";
    }
  ?>
}
function js_abre(pagina){
  js_OpenJanelaIframe('','db_iframe_consulta',pagina,'Pesquisa',true,0);
}
</script>
<?
if($db_opcao==1){
  echo "<script>document.form1.y50_setor.value='".db_getsession("DB_coddepto")."'</script>";
  echo "<script>js_pesquisay50_setor(false)</script>";
}
if($db_opcao != 1){
  if(isset($y14_codigo)){
    echo "<script>js_OpenJanelaIframe('','db_iframe_bairros','func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro1&pesquisa_chave=$y15_codi','pesquisa',false);</script>";
    echo "<script>js_OpenJanelaIframe('','db_iframe_ruas','func_ruas.php?rural=1&funcao_js=parent.js_preencheruas1&pesquisa_chave=$y15_codigo','Pesquisa',false);</script>";
    echo "<script>document.form1.y14_codigo.value = '$y14_codigo';js_ruas1(false);</script>";
    echo "<script>document.form1.y14_codi.value='$y14_codi';js_bairro1(false)</script>";
  }
}
if($db_opcao == 1){
  if(isset($j14_codigo) && $j14_codigo != ""){
    echo "<script>js_OpenJanelaIframe('','db_iframe_ruas','func_ruas.php?rural=1&funcao_js=parent.js_preencheruas1&pesquisa_chave=$j14_codigo','Pesquisa',false);</script>";
    echo "<script>document.form1.y15_codigo.value = '$j14_codigo';</script>";
    echo "<script>document.form1.y14_codigo.value = '$j14_codigo';js_ruas1(false);</script>";
  }
  if(isset($j13_codi) && $j13_codi != ""){
    echo "<script>js_OpenJanelaIframe('','db_iframe_bairros','func_bairro.php?rural=1&funcao_js=parent.js_preenchebairro1&pesquisa_chave=$j13_codi','pesquisa',false);</script>";
    echo "<script>document.form1.y15_codi.value='$j13_codi';</script>";
    echo "<script>document.form1.y14_codi.value='$j13_codi';js_bairro1(false)</script>";
  }
  if(isset($z01_numero) && $z01_numero != ""){
    echo "<script>document.form1.y14_numero.value='$z01_numero';</script>";
    echo "<script>document.form1.y15_numero.value='$z01_numero';</script>";
  }
  if(isset($z01_compl) && $z01_compl != ""){
    echo "<script>document.form1.y14_compl.value='$z01_compl';</script>";
    echo "<script>document.form1.y15_compl.value='$z01_compl';</script>";
  }
}
?>
