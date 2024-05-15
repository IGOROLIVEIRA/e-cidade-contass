<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_cgm_classe.php");
include("classes/db_issbase_classe.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$clrotulo = new rotulocampo;
$clcgm     = new cl_cgm;
$clcriaabas     = new cl_criaabas;
$clissbase = new cl_issbase;
if(isset($q02_numcgm)){
      $result01=$clcgm->sql_record($clcgm->sql_query_file($q02_numcgm,"z01_ident,z01_munic,z01_nome,z01_incest,z01_cgccpf,z01_cep,z01_ender,z01_bairro,z01_compl as q02_compl,z01_numero as q02_numero,z01_cxpostal as q02_cxpost"));
      if($clcgm->numrows!=1){
	db_redireciona('iss1_issbase004.php?invalido=true');
	exit;    
      }else{
	db_fieldsmemory($result01,0);
	if($z01_cep==""){
	  db_redireciona('iss1_issbase004.php?cep=true');
	  exit;    
	}
	if($z01_cgccpf==""){
	  db_redireciona('iss1_issbase004.php?cgccpf=true');
   	  exit;    
	}
      }	
      $db_opcao=1;
}else if(isset($alterar)){
      $result01=$clissbase->sql_record($clissbase->sql_query($q02_inscr,'z01_nome,q02_numcgm'));
      if($clissbase->numrows<1){
	db_redireciona('iss1_issbase005.php?invalido=true');
	exit;    
      }	
      db_fieldsmemory($result01,0);
      $db_opcao=2;
}else if(isset($excluir)){
      $result01=$clissbase->sql_record($clissbase->sql_query($q02_inscr,'z01_nome,q02_numcgm'));
      if($clissbase->numrows<1){
	db_redireciona('iss1_issbase006.php?invalido=true');
	exit;    
      }	
      db_fieldsmemory($result01,0);
      $db_opcao=3;
}	
?>
  <html>
  <head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
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
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
     <td>
     <?
       $clcriaabas->identifica = array("issbase"=>"Inscrição","atividades"=>"Atividades","socios"=>"Sócios","calculo"=>"Cálculo");//nome do iframe e o label    
       $clcriaabas->title      = array("issbase"=>"Manutenção de inscrição","atividades"=>"Manutenção de atividades","socios"=>"Sócios cadastrados","calculo"=>"Cálculo");//nome do iframe e o label    
       // $clcriaabas->corfundo   = array("atividades"=>"green");// nome do iframe e a cor do iframe
       // $clcriaabas->cortexto   = array("atividades"=>"yellow");// nome do iframe e a cor do iframe
       // $clcriaabas->src = array("socios"=>"cad_iptubase0021.php");  //nome do iframe e SRC  
       $clcriaabas->cria_abas();    
     ?> 
     </td>
  </tr>
<tr>
</tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if($db_opcao==1){
  echo "
         
	 <script>
	   function js_src(){
            iframe_issbase.location.href='iss1_issbase014.php?q02_numcgm=$q02_numcgm';\n
	    document.formaba.atividades.disabled=true; 
	    document.formaba.socios.disabled=true; 
	    document.formaba.calculo.disabled=true; 
	   }
	   js_src();
         </script>
       "; 
}else if($db_opcao==2){
  echo "
         <script>
	   function js_src(){
	    document.formaba.atividades.disabled=false; 
	    document.formaba.socios.disabled=false; 
	    document.formaba.calculo.disabled=false; 
            iframe_issbase.location.href='iss1_issbase015.php?chavepesquisa=$q02_inscr';\n
            iframe_atividades.location.href='iss1_tabativ004.php?z01_nome=$z01_nome&q07_inscr=$q02_inscr';\n
	    iframe_socios.location.href='iss1_socios004.php?z01_nome_inscr=$z01_nome&q07_inscr=$q02_inscr&z01_nome=$z01_nome&q95_cgmpri=$q02_numcgm';\n
	    iframe_calculo.location.href='iss1_isscalc004.php?q07_inscr=$q02_inscr&z01_nome=$z01_nome';\n
	   }
	   js_src();
         </script>
       "; 
}else if($db_opcao==3){
  echo "
         <script>
	   function js_src(){
	    document.formaba.atividades.disabled=false; 
	    document.formaba.socios.disabled=false; 
            iframe_issbase.location.href='iss1_issbase016.php?chavepesquisa=$q02_inscr';\n
            iframe_atividades.location.href='iss1_tabativ004.php?db_opcaoal=3&z01_nome=$z01_nome&q07_inscr=$q02_inscr';\n
	    iframe_socios.location.href='iss1_socios004.php?db_opcaoal=3&q07_inscr=$q02_inscr&z01_nome=$z01_nome&q95_cgmpri=$q02_numcgm';\n
	   }
	   js_src();
         </script>
       "; 
}
?>
