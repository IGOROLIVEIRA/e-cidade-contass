<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_processoaudit_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clprocessoaudit = new cl_processoaudit;

$clprocessoaudit->rotulo->label("ci03_codproc");
$clprocessoaudit->rotulo->label("ci03_numproc");
$clprocessoaudit->rotulo->label("ci03_anoproc");
$clprocessoaudit->rotulo->label("ci03_objaudit");
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
	<link href='estilos.css' rel='stylesheet' type='text/css'>
	<script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>
<body>
  	<form name="form2" method="post" action="" class="container">
		<table width="35%" border="0" align="center" cellspacing="3" class="form-container">
			<tr> 
				<td width="4%" align="right" nowrap title="<?=$Tci03_codproc?>">
				<?=$Lci03_codproc?>
				</td>
				<td width="96%" align="left" nowrap> 
				<?
				db_input("ci03_codproc",11,$Ici03_codproc,true,"text",4,"","chave_ci03_codproc");
				?>
				</td>
			</tr>
			<tr> 
				<td width="4%" align="right" nowrap title="<?=$Tci03_numproc?>">
				<?=$Lci03_numproc?>
				</td>
				<td width="96%" align="left" nowrap> 
				<?
				db_input("ci03_numproc",11,$Ici03_numproc,true,"text",4,"","chave_ci03_numproc");
				?>
				</td>
			</tr>
			<tr> 
				<td width="4%" align="right" nowrap title="<?=$Tci03_anoproc?>">
				<?=$Lci03_anoproc?>
				</td>
				<td width="96%" align="left" nowrap> 
				<?
				db_input("ci03_anoproc",11,$Ici03_anoproc,true,"text",4,"","chave_ci03_anoproc");
				?>
				</td>
			</tr>
			<tr> 
				<td width="4%" align="right" nowrap title="<?=$Tci03_objaudit?>">
				<?=$Lci03_objaudit?>
				</td>
				<td width="96%" align="left" nowrap> 
				<?
				db_input("ci03_objaudit",70,$Ici03_objaudit,true,"text",4,"","chave_ci03_objaudit");
				?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_processoaudit.hide();">
</form>
	<?
      	if(!isset($pesquisa_chave)){
        	if(isset($campos)==false){
           		if(file_exists("funcoes/db_func_processoaudit.php")==true){
             		include("funcoes/db_func_processoaudit.php");
           	}else{
           		$campos = "processoaudit.*";
           	}
		}
		
		if(isset($chave_ci03_codproc) && (trim($chave_ci03_codproc)!="") ){
			$sql = $clprocessoaudit->sql_query(null, $campos, "ci03_codproc", "ci03_codproc = {$chave_ci03_codproc} AND ci03_instit = ".db_getsession('DB_instit'));
		} elseif(isset($chave_ci03_numproc) && (trim($chave_ci03_numproc)!="") ){
			$sql = $clprocessoaudit->sql_query(null, $campos, "ci03_codproc", "ci03_numproc = {$chave_ci03_numproc} AND ci03_instit = ".db_getsession('DB_instit'));
		} elseif(isset($chave_ci03_anoproc) && (trim($chave_ci03_anoproc)!="") ){
			$sql = $clprocessoaudit->sql_query(null, $campos, "ci03_codproc", "ci03_anoproc = {$chave_ci03_anoproc} AND ci03_instit = ".db_getsession('DB_instit'));
		} elseif(isset($chave_ci03_objaudit) && (trim($chave_ci03_objaudit)!="") ){
			$sql = $clprocessoaudit->sql_query(null, $campos, "ci03_codproc", "ci03_objaudit like '{$chave_ci03_objaudit}%' AND ci03_instit = ".db_getsession('DB_instit'));
		} else {
			$sql = $clprocessoaudit->sql_query(null, $campos, "ci03_codproc", "ci03_instit = ".db_getsession('DB_instit'));
		}

		$repassa = array();
        echo '<div class="container">';
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '</div>';
      	}else{
        	if($pesquisa_chave!=null && $pesquisa_chave!=""){
			  $result = $clprocessoaudit->sql_record($clprocessoaudit->sql_query(null, "*", "ci03_codproc", "ci03_codproc = {$pesquisa_chave} AND ci03_instit = ".db_getsession('DB_instit')));
          	if($clprocessoaudit->numrows!=0){
				db_fieldsmemory($result,0);
				if (isset($objetivo) && $objetivo == true) {
					echo "<script>".$funcao_js."('$ci03_objaudit',false);</script>";
				} else {
					echo "<script>".$funcao_js."('$ci03_codproc',false);</script>";
				}
          	}else{
	         	echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          	}
        	}else{
	       		echo "<script>".$funcao_js."('',false);</script>";
        	}
      	}
	?>
</body>
</html>
<? if(!isset($pesquisa_chave)){ ?>
  	<script>
  	</script>
<? } ?>
