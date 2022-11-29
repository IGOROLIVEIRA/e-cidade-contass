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


?>

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

	<fieldset style="  height: 400px;
    overflow-y: scroll;">
		<legend align="center">
			<b>Amparo Legal</b>
		</legend>
		<table id="tablePerfis" class="DBGrid" style="width: 70%; border: 1px solid #a4a4a4;">
			<tr>
				<th class="table_header" style="background:#aacccc; color:#02038c; cursor: pointer; border: 1px solid #02038c;" onclick="marcarTodos();">M</th>
				<th style="border: 0px solid red;  background:#aacccc; color:#02038c; border: 1px solid #02038c;">Código</th>
				<th style="border: 0px solid red;  background:#aacccc; color:#02038c; border: 1px solid #02038c;">Lei</th>
			</tr>



			<?php
			$instit = db_getsession("DB_instit");
			$result = db_query("select * from amparolegal order by l212_codigo");



			$numrows = pg_numrows($result);
			for ($i = 0; $i < $numrows; $i++) {

				echo "<tr>
                          <td  style='text-align:center; background:#e6e6e6; border: 1px solid #a4a4a4;'>
                              <input id=" . pg_result($result, $i, "l212_codigo") . " type='checkbox' class='marca_itens' name='aItensMarcados[]' value='" . pg_result($result, $i, "l212_codigo") . "'>
                        </td>

						<td style='text-align:center; background:#cddecd; border: 1px solid #a4a4a4;'>" .
					pg_result($result, $i, "l212_codigo") . "
							</td>

                        <td style='text-align:left; background:#cddecd; border: 1px solid #a4a4a4;padding-left: 25px;'>" .
					pg_result($result, $i, "l212_lei") . "
                        </td>

                        
                      </tr>";
			}


			?>

		</table>
	</fieldset>
	<input style="margin-top: 20px;" value="Salvar" type="submit" name="incluir"></input>
</form>
<script>
	marcarTodosPerfis = false;

	function marcarTodos() {
		qntdperfis = document.getElementsByClassName("marca_itens").length;
		perfis = document.getElementsByClassName("marca_itens");

		if (marcarTodosPerfis == false) {
			for (let i = 0; i < qntdperfis; i++) {
				perfis[i].checked = true;
			}

			marcarTodosPerfis = true;
		} else {
			for (let i = 0; i < qntdperfis; i++) {
				perfis[i].checked = false;
			}

			marcarTodosPerfis = false;
		}


	}
</script>