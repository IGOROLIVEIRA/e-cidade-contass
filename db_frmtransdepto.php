<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_proctransfer_classe.php");
include("classes/db_proctransferproc_classe.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

$clproctransfer = new cl_proctransfer;
$clproctransferproc = new cl_proctransferproc;
$clproctransfer->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("nome");
$clrotulo->label("descrdepto");
$db_opcao = 1;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
.dono {background-color:#FFFFFF;
       color:red
      }

</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
<form name="form1" method="post" action="">
<center>
<table width="100%" border="0">
  <tr>

    <td nowrap title="<?=@$Tp62_coddeptorec?>" >
       <?
       db_ancora(@$Lp62_coddeptorec,"js_pesquisap62_coddeptorec(true);",$db_opcao);

       ?>
    </td>
    <td nowrap>

<?
db_input('p62_coddeptorec',10,$Ip62_coddeptorec,true,'text',$db_opcao," onchange='js_pesquisap62_coddeptorec(false);'");
db_input('descrdepto',60,$Idescrdepto,true,'text',3);
       ?>
    </td>
  </tr>
  <tr>
   <? if (isset($p62_coddeptorec)){?>
    <td  nowrap title="<?=@$Tp62_id_usorec?>">
       <?=@$Lp62_id_usorec; ?>
    </td>
    <td nowrap>
<?
   $sqlusu = "select U.id_usuario,nome
              from   db_usuarios U inner join db_depusu D
                     on U.id_usuario  = D.id_usuario
              where  D.coddepto = $p62_coddeptorec
              order by nome ";
  echo "<select  name='p62_id_usorec' size='-1'>";
  echo "<option value=0>Selecione</Option>";
  $rs = pg_exec($sqlusu);
  for ($i = 0;$i < pg_num_rows($rs);$i++){
     db_fieldsmemory($rs,$i);
     echo "<option value='".$id_usuario."'>".$nome."</option>";

  }
  echo "</select>";
  }
 ?>
   </td>
   </tr>
</table>
</form>
<script>
function js_pesquisap62_id_usorec(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tran','func_db_usutran.php?funcao_js=parent.campos.js_mostradb_usuarios1|0|1','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tran','func_db_usutran.php?pesquisa_chave='+document.form1.p62_id_usorec.value+'&funcao_js=parent.campos.js_mostradb_usuarios','Pesquisa',false);
  }
}
function js_mostradb_usuarios(chave,erro){
  document.form1.nome.value = chave;
  if(erro==true){
    document.form1.p62_id_usorec.focus();
    document.form1.p62_id_usorec.value = '';
  }
}
function js_mostradb_usuarios1(chave1,chave2){
  document.form1.p62_id_usorec.value = chave1;
  document.form1.nome.value = chave2;
  CurrentWindow.corpo.db_iframe_tran.hide();
}
function js_pesquisap62_coddeptorec(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tran','func_db_depart.php?funcao_js=parent.campos.js_mostradb_depart1|0|1&todasinstit=1','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tran','func_db_depart.php?pesquisa_chave='+document.form1.p62_coddeptorec.value+'&funcao_js=parent.campos.js_mostradb_depart&todasinstit=1','Pesquisa',false);
  }
}
function js_mostradb_depart(chave,erro){
  if(erro==true){
    alert("Departamento não encontrado ou desativado.Verifique.");
    document.form1.p62_coddeptorec.focus();
    document.form1.p62_coddeptorec.value = '';
    document.form1.descrdepto.value = '';
  }else{
    document.form1.descrdepto.value = chave;
    document.form1.submit();
  }
}
function js_mostradb_depart1(chave1,chave2){
  document.form1.p62_coddeptorec.value = chave1;
  document.form1.descrdepto.value = chave2;
  CurrentWindow.corpo.db_iframe_tran.hide();
  document.form1.submit();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tran','func_proctransfer.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
}
</script>
</center>
</body>
</html>
