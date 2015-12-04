<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");
include("model/dbGeradorRelatorio.model.php");
include("model/dbPropriedadeRelatorio.php");
include("model/dbVariaveisRelatorio.php");
include("model/dbFiltroRelatorio.php");
include("model/dbColunaRelatorio.php");
include("model/dbOrdemRelatorio.model.php");
include("classes/db_db_relatorio_classe.php");
include("classes/db_db_syscampo_classe.php");


$oGet = db_utils::postMemory($_GET);

$cldb_relatorio    = new cl_db_relatorio();
$cldb_syscampo 	   = new cl_db_syscampo();
$oGeradorRelatorio = new dbGeradorRelatorio($oGet->codrel);


$rsConsultaRelatorio = $cldb_relatorio->sql_record($cldb_relatorio->sql_query($oGet->codrel));
$oConsultaRelatorio  = db_utils::fieldsMemory($rsConsultaRelatorio,0);

$codRel  	= $oConsultaRelatorio->db63_sequencial;
$nomeRel 	= $oConsultaRelatorio->db63_nomerelatorio;
$tipoRel 	= $oConsultaRelatorio->db13_sequencial;
$descrTipo  = $oConsultaRelatorio->db13_descricao;
$grupoRel   = $oConsultaRelatorio->db14_sequencial;
$descrGrupo = $oConsultaRelatorio->db14_descricao;
$dataRel	= $oConsultaRelatorio->db63_data;

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table align="center">
    <tr>
      <td>
  		<fieldset>
  		  <legend>
  		  	<b>Informações Relatório</b>
   		  </legend>
  		  <table>
			<tr>
			  <td>
			    <b>Código Relatório:</b>
			  </td>
			  <td>
			  	<?
				  db_input("codRel",44,"",true,"text",3,"");
			  	?>
			  </td>   		  
   		    </tr>  		  
			<tr>
			  <td>
			    <b>Nome Relatório:</b>
			  </td>
			  <td>
			  	<?
				  db_input("nomeRel",44,"",true,"text",3,"");
			  	?>
			  </td>   		  
   		    </tr>
			<tr>
			  <td>
			    <b>Tipo:</b>
			  </td>
			  <td>
			  	<?
				  db_input("tipoRel"  ,5,"",true,"text",3,"");  	
			  	  db_input("descrTipo",35,"",true,"text",3,"");
			  	?>
			  </td>   		  
   		    </tr>
			<tr>
			  <td>
			    <b>Grupo:</b>
			  </td>
			  <td>
			  	<?
				  db_input("grupoRel"  ,5,"",true,"text",3,"");
				  db_input("descrGrupo",35,"",true,"text",3,"");
			  	?>
			  </td>   		  
   		    </tr>   		       		    
			<tr>
			  <td>
			    <b>Ultima Alteração:</b>
			  </td>
			  <td>
			  	<?
			  	  
			  	  $sDia = substr($dataRel,8,2);
			  	  $sMes = substr($dataRel,5,2);
			  	  $sAno = substr($dataRel,0,4);
			  	  
				  db_inputdata("dateRel",$sDia,$sMes,$sAno,true,"text",3,"");
				  
			  	?>
			  </td>   		  
   		    </tr>
   		  </table>
        </fieldset>
      </td>
    </tr>
	<?
	  if ($oConsultaRelatorio->db63_db_tiporelatorio == 2 ) {
	?>
	<tr>
	  <td>
	    <fieldset>
	      <legend align="center">
	      	<b>Variáveis Documento</b>
	      </legend>
	      <table cellspacing="0" style="border:2px inset white;" >
		    <tr>
		  	  <th class="table_header" width="200px"><b>Descrição Campo</b></th>
		      <th class="table_header" width="200px"><b>Nome Variável</b></th>
		      <th class="table_header" width="12px" ><b>&nbsp;</b></th>
		    </tr>
		  <tbody id="relatoriosSalvos" style=" height:200px; overflow:scroll; overflow-x:hidden; background-color:white"  >
		  <?
			$aColunas = $oGeradorRelatorio->getColunas();

			foreach ( $aColunas as $sInd => $oColuna ) {
  			  $aNomeCampos[] = $oColuna->getNome();
			}
			$sDescrNomes = implode("','",$aNomeCampos);
			$rsConsultaCampos = $cldb_syscampo->sql_record($cldb_syscampo->sql_query_file(null,"nomecam,rotulo",null,"nomecam in ('".$sDescrNomes."')"));
			$iNroLinhas = $cldb_syscampo->numrows;
			
			for ($i=0; $i < $iNroLinhas; $i++) {
			  $oCampo = db_utils::fieldsMemory($rsConsultaCampos,$i);	
			  echo "<tr>";
			  echo "<td class='linhagrid'>".$oCampo->rotulo."</td>";
			  echo "<td class='linhagrid'>".$oCampo->nomecam."</td>";
			  echo "</tr>";
			}
		  ?>
		  </tbody>
	    </fieldset>
	  </td>
	</tr>
	<?
	  }
	?>	
  </table>
</body>
</html>

