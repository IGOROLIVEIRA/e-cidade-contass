<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBselller Servicos de Informatica             
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
$clconcurcargo->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("h06_eaber");
if ( isset($opcao) && $opcao == "alterar" ) {
  $db_opcao = 2;
} elseif ( isset($opcao) && $opcao == "excluir" ) {
  $db_opcao = 3;
} elseif ( isset($db_opcaoal) ) {

	if ( $db_opcaoal == "false" ) {

    $db_opcao = 3;
    $opcoesae = 4;
  }
}
?>
<form name="form1" method="post" action="">
	<center>
		<table border="0" >

			<tr>
		    <td nowrap title="<?=@$Th82_sequencial?>">
		       <?=@$Lh82_sequencial?>
		    </td>
		    <td> 
			<?
			db_input('h82_sequencial',11,$Ih82_sequencial,true,'text',3,"")
			?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap title="<?=@$Th82_concur?>">
		       <?=@$Lh82_concur?>
		    </td>
		    <td> 
			<?
			if(!empty($h06_refer)) {
			  $h82_concur=$h06_refer;
		    }
			db_input('h82_concur',11,$Ih82_concur,true,'text',3);
			db_input('h06_eaber',11,$Ih06_eaber,true,'text',3);
			?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap title="<?=@$Th82_cargo?>">
		       <?=@$Lh82_cargo?>
		    </td>
		    <td> 
			<?
			db_input('h82_cargo',25,$Ih82_cargo,true,'text',$db_opcao,"")
			?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap title="<?=@$Th82_vagas?>">
		       <?=@$Lh82_vagas?>
		    </td>
		    <td> 
			<?
			db_input('h82_vagas',11,$Ih82_vagas,true,'text',$db_opcao,"")
			?>
		    </td>
		  </tr>
			<tr>
				<td colspan="2" align="center">
					<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>>
					<?php 
						if($db_opcao!=1){
							echo '<input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" >&nbsp;';
						}
					?>
				</td>							
			</tr>

		</table>

		<table  width="50%" height="70%" border=0>

			<tr>
				<td valign="top"  align="center" width="100%" height="100%">
					<?php
						$where = " h82_concur= ".@$h82_concur;
						$chavepri= array("h82_sequencial"=>@$h82_sequencial);
						$cliframe_alterar_excluir->chavepri=$chavepri;
						$cliframe_alterar_excluir->sql           = $clconcurcargo->sql_query(null, "*", "h82_sequencial", $where);
						$cliframe_alterar_excluir->campos        = "h82_cargo,h82_vagas";
						$cliframe_alterar_excluir->legenda       = "ITENS LANÇADOS";
						$cliframe_alterar_excluir->iframe_height = "250";
						$cliframe_alterar_excluir->iframe_width  = "90%";
						$cliframe_alterar_excluir->opcoes        = $opcoesae;
						$cliframe_alterar_excluir->iframe_alterar_excluir(1);
					?>
				</td>
			</tr>

		</table>

	</center>
</form>

<script>
  function js_cancelar() {
    document.location.href = "rec1_concurcargo001.php?chavepesquisa="+document.form1.h82_concur.value;
  }
</script>