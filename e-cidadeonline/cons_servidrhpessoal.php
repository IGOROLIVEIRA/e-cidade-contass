<?
error_reporting('** CONSULTA FUNCIONAL! **');
session_start();

include("libs/db_conecta.php");
include("libs/db_stdlib.php");
include("libs/db_sql.php");
include("libs/db_utils.php");
include("dbforms/db_funcoes.php");

validaUsuarioLogado();

$aRetorno = array();
parse_str(base64_decode($HTTP_SERVER_VARS["QUERY_STRING"]),$aRetorno);

$id_usuario = $aRetorno['id_usuario'];
$matricula  = $aRetorno['matricula'];
$numcgm     = db_getsession("DB_login");
$anoFolha   = db_anofolha();
$mesFolha   = db_mesfolha();

db_logs("","",0,"Consulta Funcional.");

$sUrl       = base64_encode("iMatric=".$matricula);
$sUrlAverba = base64_encode("&averba");
?>
<html>
<head>
<title><?=$w01_titulo?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="legacy_config/portalservidor.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="scripts/db_script.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="<?=$w01_corbody?>">
<table width="100%" border="0" bordercolor="#cccccc" cellpadding="2" cellspacing="0" class="texto">
 <tr>
  <td><br></td>
 </tr>
</table>
<?
  if ($id_usuario != "") {
?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="texto">
  <tr>
    <td valign="top" width="10%">
     <table width="200" height="10%" id="navigation" border="0">
        <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('dadosCadastrais');">Consulta Dados Cadastrais</span>
           </td>
        </tr>
        <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('assentamentos');">Assentamentos</span>
           </td>
        </tr>
        <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('averbacao');">Averbação de Tempo de Serviço</span>
           </td>
        </tr>
        <tr>
            <td nowrap="nowrap" width="100%">
              <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('dependentes');">Dependendentes</span>
            </td>
         </tr>
         <tr>
            <td nowrap="nowrap" width="100%">
              <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('ferias');">Férias</span>
            </td>
         </tr>
         <tr>
             <td nowrap="nowrap" width="100%">
               <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('comprovanteRendimentos');">Comprovante de Rendimentos</span>
             </td>
         </tr>
         <tr>
            <td nowrap="nowrap" width="100%">
              <span class="navText" style="cursor: pointer;" onClick="js_atualizaFrame('fichaFinanceira');">Ficha Financeira</span>
            </td>
         </tr>
         <tr>
             <td nowrap="nowrap" width="100%">&nbsp;</td>
         </tr>
         <tr>
           <td nowrap="nowrap" width="100%">
             <span class="navText" style="cursor: pointer;" onClick="js_voltar('<?=$id_usuario?>');">Voltar</span>
           </td>
         </tr>
     </table>
    </td>
    <td valign="top" width="97%">
      <iframe id="iframePortalServidor" name="iframe" src="centro_pref.php" width="100%" height="500px;" style="border:hidden;"></iframe>
    </td width="3%">
    <td>&nbsp;</td>
  </tr>
</table>
<?
  } else if ($w13_permfornsemlog == "f") {
?>
 <table width="300" align="center" border="0" bordercolor="#cccccc" cellpadding="2" cellspacing="0" class="texto">
  <tr height="220">
   <td align="center">
    <img src="imagens/atencao.gif"><br>
    Para acessar suas informações, efetue login.
   </td>
  </tr>
 </table>
<?
}
?>
</body>
</html>
<script>
function imprimir(){
 jan=window.open('',
                 '',
                 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');

 jan.moveTo(0,0);
}

function js_voltar(id){
  var idusuario = id;
  document.location.href = 'cons_funcional.php?id_usuario='+idusuario;
}

function js_atualizaFrame( sOpcao ){

  var sQuery = '<?=$sUrl?>';

  if ( sOpcao == 'dadosCadastrais') {
    document.getElementById('iframePortalServidor').src = 'dadosfuncionario.php?'+sQuery;
  } else if (sOpcao == 'assentamentos') {
    document.getElementById('iframePortalServidor').src = 'dadosassentamentos.php?'+sQuery;
  } else if (sOpcao == 'averbacao') {
    document.getElementById('iframePortalServidor').src = 'dadosassentamentos.php?'+sQuery+'<?=$sUrlAverba?>';
  } else if (sOpcao == 'dependentes') {
    document.getElementById('iframePortalServidor').src = 'dependentesservidor.php?'+sQuery;
  } else if (sOpcao == 'ferias') {
    document.getElementById('iframePortalServidor').src = 'feriasservidor.php?'+sQuery;
  } else if (sOpcao == 'comprovanteRendimentos') {
    document.getElementById('iframePortalServidor').src = 'comprovanterendimentosservidor.php?'+sQuery;
  } else if (sOpcao == 'fichaFinanceira') {
    document.getElementById('iframePortalServidor').src = 'fichafinanceiraservidor.php?'+sQuery;
  }


}
</script>
