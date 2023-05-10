<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_iptuisen_classe.php");
include("classes/db_isenexe_classe.php");
include("classes/db_iptubase_classe.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

$db_botao=1;
$db_opcao=1;
$consultando=false;
$alterando=false;
$pesq=true;  
$clisenexe = new cl_isenexe;

$cliptubase = new cl_iptubase;
$cliptubase->rotulo->label();

$cliptuisen = new cl_iptuisen;
$cliptuisen->rotulo->label();

$rotulocampo = new rotulocampo;
$rotulocampo->label("z01_nome");
$rotulocampo->label("j45_descr");
//$rotulocampo->label("z01_nome");  



if(isset($incluir)){
  db_inicio_transacao();
    $cliptuisen->incluir($j46_codigo);
    for($ano=$j46_dtinc_ano;$ano<=$j46_dtfim_ano;$ano++){
      $j47_codigo=$cliptuisen->j46_codigo;
      $clisenexe->j47_codigo=$j47_codigo;
      $clisenexe->anousu=$ano;
      $clisenexe->incluir($j47_codigo,$ano);
    }
  db_fim_transacao();
}else if(isset($excluir)){
    $clisenexe->j47_codigo=$j46_codigo;
    $clisenexe->excluir($j46_codigo);
    $cliptuisen->excluir($j46_codigo);
}else if(isset($j46_codigo) && !isset($nova)&& !isset($pesquisar)){
    $sql=$cliptuisen->sql_query($j46_codigo,"iptuisen.*#tipoisen.j45_descr#cgm.z01_nome as z01_nomematri","","j46_matric=$j46_matric and j46_codigo=$j46_codigo");            
    $result = $cliptuisen->sql_record($sql);
    $alterando=true;  
    $db_opcao=3;
    @db_fieldsmemory($result,0);
}else if(isset($j46_matric)){ 
    $sql=$cliptuisen->sql_query("","iptuisen.*","","j46_matric=$j46_matric");
    $result = $cliptuisen->sql_record($sql);
    if($cliptuisen->numrows!=0 && !isset($nova)){
      $consultando=true;
      $db_opcao=1;
    }else if(isset($pesquisar) && $cliptuisen->numrows==0){
      $pesq=false;  
    }   
    $result = $cliptubase->sql_record($cliptubase->sql_query("","cgm.z01_nome as z01_nomematri","","j01_matric=$j46_matric"));
    @db_fieldsmemory($result,0);
    if($cliptubase->numrows==0){
      db_redireciona("cad4_iptuisen001.php?invalido=true");
    }
    unset($j46_codigo); 
    unset($j46_tipo); 
    unset($j45_descr); 
    unset($j46_tipo); 
    unset($j46_dtini); 
    unset($j46_dtini_dia); 
    unset($j46_dtini_mes); 
    unset($j46_dtini_ano); 
    unset($j46_dtfim); 
    unset($j46_dtfim_dia); 
    unset($j46_dtfim_mes); 
    unset($j46_dtfim_ano); 
    unset($j46_dtinc); 
    unset($j46_dtinc_dia); 
    unset($j46_dtinc_mes); 
    unset($j46_dtinc_ano); 
    unset($j46_idusu); 
    unset($j46_perc); 
    unset($j46_hist); 
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
td {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
}
input {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        height: 17px;
        border: 1px solid #999999;
}
-->
</style>


</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table height="430" width="790" border="0" cellspacing="0" cellpadding="0">
<form name="form1" method="post" action=""  onSubmit="return js_verifica_campos_digitados();"  >
<?
  if($consultando==true){
?>
  <tr>
    <td align="left"  valign="top" bgcolor="#CCCCCC">
      <input name="nova" type="submit" id="nova" value="Nova Isenção ">
<?
      db_input('j46_matric',4,$Ij46_matric,true,'hidden',3,"");
      db_lovrot($sql,15,"()","","js_preenchecampos|0");
?>
    </td>
  </tr>
<?
  }else{
?>
  <tr>
    <td align="left" valign="center" bgcolor="#CCCCCC">
    <center>
    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tj46_codigo?>">
         <?=@$Lj46_codigo?>
        </td>
        <td> 
<? 
db_input('j46_codigo',4,"",true,'text',3,"")
?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_matric?>">
          <?=@$Lj46_matric?>
        </td>
        <td> 
<?
db_input('j46_matric',4,$Ij46_matric,true,'text',3," onchange='js_pesquisaj46_matric(false);'");         
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'','z01_nomematri');
?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_tipo?>">
<?
db_ancora(@$Lj46_tipo,"js_pesquisaj46_tipo(true);",$db_opcao);
?>
        </td>
        <td> 
<?
db_input('j46_tipo',4,$Ij46_tipo,true,'text',$db_opcao," onchange='js_pesquisaj46_tipo(false);'");
db_input('j45_descr',40,$Ij45_descr,true,'text',3,'');
?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_dtini?>">
        <?=@$Lj46_dtini?>
        </td>
        <td> 
<?
db_inputdata('j46_dtini',@$j46_dtini_dia,@$j46_dtini_mes,@$j46_dtini_ano,true,'text',$db_opcao,"")
?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_dtfim?>">
         <?=@$Lj46_dtfim?>
        </td>
        <td> 
<?
db_inputdata('j46_dtfim',@$j46_dtfim_dia,@$j46_dtfim_mes,@$j46_dtfim_ano,true,'text',$db_opcao,"")
?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_perc?>">
        <?=@$Lj46_perc?>
        </td>
        <td> 
<?
db_input('j46_perc',4,$Ij46_perc,true,'text',$db_opcao,"")
?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_dtinc?>">
        <?=@$Lj46_dtinc?>
        </td>
        <td> 
<?
db_inputdata('j46_dtinc',@$j46_dtinc_dia,@$j46_dtinc_mes,@$j46_dtinc_ano,true,'text',$db_opcao,"")
?>
        </td>
      </tr>
      <tr>
        <td> 
<?
$j46_idusu=db_getsession("DB_id_usuario");

db_input('j46_idusu',4,$Ij46_idusu,true,'hidden',$db_opcao,"")
?> 
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tj46_hist?>">
        <?=@$Lj46_hist?>
        </td>
        <td> 
<?
db_textarea('j46_hist',0,0,$Ij46_hist,true,'text',$db_opcao,"")
?>
        </td>
      </tr>
    </table>
    <input name="incluir" type="submit" id="incluir" value="Incluir" <?=($alterando==true?"disabled":"")?> >
    <input name="excluir" type="submit" id="excluir" value="Excluir" <?=($alterando==true?"":"disabled")?>>
    <input name="nova" type="submit" id="nova" value="Nova Isenção" <?=($alterando==true?"":"disabled")?>>
    <input name="pesquisar" type="submit" id="pesquisar" value="Pesquisar">
    </center>
    </td>
  </tr>
<?}?>
</form>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
function js_preenchecampos(chave){
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>?j46_codigo='+chave+'&j46_matric=<?=@$j46_matric?>';                      
}
function js_pesquisaj46_tipo(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_tipoisen.php?funcao_js=parent.js_mostratipoisen1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_tipoisen.php?pesquisa_chave='+document.form1.j46_tipo.value+'&funcao_js=parent.js_mostratipoisen';
  }
}
function js_mostratipoisen(chave,erro){
  document.form1.j45_descr.value = chave; 
  if(erro==true){ 
    document.form1.j46_tipo.focus(); 
    document.form1.j46_tipo.value = ''; 
  }
}
function js_mostratipoisen1(chave1,chave2){
  document.form1.j46_tipo.value = chave1;
  document.form1.j45_descr.value = chave2;
  db_iframe.hide();
}
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_iptuisen.php?funcao_js=parent.js_preenchepesquisa|0';
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}
function js_preenchepesquisa(chave){
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
}
function js_pesquisaj46_matric(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_iptubase.php?funcao_js=parent.js_mostraiptubase1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_iptubase.php?pesquisa_chave='+document.form1.j46_matric.value+'&funcao_js=parent.js_mostraiptubase';
  }
}
function js_mostraiptubase(chave,erro){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.j46_matric.focus(); 
    document.form1.j46_matric.value = ''; 
  }
}
function js_mostraiptubase1(chave1,chave2){
  document.form1.j46_matric.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe.hide();
}
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_iptuisen.php?funcao_js=parent.js_preenchepesquisa|0';
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}
function js_preenchepesquisa(chave){
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
}
function js_cgm(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_nome.php?funcao_js=parent.js_mostra1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_nome.php?pesquisa_chave='+document.form1.j46_numcgm.value+'&funcao_js=parent.js_mostra';
  }
}
function js_mostra1(chave1,chave2){
  document.form1.j46_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe.hide();
}
function js_mostra(erro,chave){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.j46_numcgm.focus();
    document.form1.j46_numcgm.value="";
  }
}
</script>
<?
if($pesq==false){
  db_msgbox("Não foi encontrado nenhum registro!");

}  
if($consultando==false){
  $func_iframe = new janela('db_iframe','');
  $func_iframe->posX=1;
  $func_iframe->posY=20;
  $func_iframe->largura=780;
  $func_iframe->altura=430;
  $func_iframe->titulo='Pesquisa';
  $func_iframe->iniciarVisivel = false;
  $func_iframe->mostrar();
}
if(isset($excluir)){
  if($cliptuisen->erro_status=="0"){
    $cliptuisen->erro(true,false);
    if($cliptuisen->erro_campo!=""){
      echo "<script> document.form1.".$cliptuisen->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cliptuisen->erro_campo.".focus();</script>";
    }
  }else{
    $cliptuisen->erro(true,false);
    db_redireciona("cad4_iptuisen001.php");
  }
}
if(isset($incluir)){
  if($cliptuisen->erro_status=="0"){
    $cliptuisen->erro(true,false);
    if($cliptuisen->erro_campo!=""){
      echo "<script> document.form1.".$cliptuisen->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cliptuisen->erro_campo.".focus();</script>";
    }
  }else{
    $cliptuisen->erro(true,false);
     db_redireciona("cad4_iptuisen001.php");
  }
}
?>
