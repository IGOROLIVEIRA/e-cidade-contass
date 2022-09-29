<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clcflicitatemplateata->rotulo->label();

if (isset($db_opcaoal)) {
	$db_opcao = 33;
	$db_botao = false;
} else if (isset($oPost->opcao) && $oPost->opcao == "excluir") {
	$db_opcao = 3;
	$db_botao = true;
} else {
	$db_opcao = 1;
	$db_botao = true;
	if (isset($oPost->novo) || isset($oPost->excluir) || (isset($oPost->incluir) && !$lErro)) {
		$l37_db_documentotemplate = "";
		$db82_descricao           = "";
	}
}
?>
<style>
	td {
		white-space: nowrap
	}

	fieldset table td:first-child {
		width: 60px;
		white-space: nowrap
	}
</style>
<form name="form1" method="post" action="">
	<fieldset>
		<legend>
			<b></b>
		</legend>
		<table align="left">
			<tr>
				<td nowrap title="<?= @$Tl03_codigo ?>">
					<b> Modalidade de Compra: </b>
				</td>
				<td>
					<?
					db_input('l03_codigo', 8, $Il03_codigo, true, 'text', 3, "")
					?>
				</td>
			</tr>
			<tr>
				<td nowrap title="<?= @$Tl03_codigo ?>">
					<b> Descrição da Modalidade: </b>
				</td>
				<td>
					<?
					db_input('l03_descr', 40, $Il03_descr, true, 'text', 3, "")
					?>
				</td>
			</tr>
		</table>
	</fieldset>

	<fieldset>
		<legend>
			<b>Amparo Legal</b>
		</legend>
		<table align="left">

		</table>
	</fieldset>
</form>
<script>
	//document.getElementById('l03_descr').value = <?php echo $l03_descr; ?>;
</script>