<form name="form1" method="post" action="">
<fieldset style="width: 550px; height: 420px; margin-top: 15px;"><legend><b>Informações Complementares Sicom</b></legend>
<input type="hidden" name="instituicao" value="<?php echo db_getsession('DB_instit') ?>" />
<table cellspacing="5px">
<tr>
	<td>Código do Orgão:</td>
	<td>
	<input type="text" name="codOrgao" maxlength="2" value="<?php echo $oOrgao->codOrgao ?>" onkeyup="js_ValidaCampos(this,1,'Ano Inicial','f','f',event);" />
	</td>
</tr>
<tr>
	<td>CPF do Gestor:</td>
	<td>
	<input type="hidden" name="codigo" id="codigo" value="<?php echo $oOrgao->codigo ?>"/>
	<input type="text" name="cpfGestor" maxlength="11" value="<?php echo $oOrgao->cpfGestor ?>" onkeyup="js_ValidaCampos(this,1,'Ano Inicial','f','f',event);" />
	</td>
</tr>
<tr>
	<td>Tipo do Orgão:</td>
	<td><select name="tipoOrgao" id="tipoOrgao" onchange="mostrar_cnpj_camara();">
	<option value="01" <?php if($oOrgao->tipoOrgao == "01") echo "selected=\"selected\"" ?>>Câmara Municipal</option>
	<option value="02" <?php if($oOrgao->tipoOrgao == "02") echo "selected=\"selected\"" ?>>Prefeitura Municipal</option>
	<option value="03" <?php if($oOrgao->tipoOrgao == "03") echo "selected=\"selected\"" ?>>Autarquia (exceto RPPS)</option>
	<option value="04" <?php if($oOrgao->tipoOrgao == "04") echo "selected=\"selected\"" ?>>Fundação</option>
	<option value="05" <?php if($oOrgao->tipoOrgao == "05") echo "selected=\"selected\"" ?>>RPPS (Regime Próprio de Previdência Social)</option>
	<option value="06" <?php if($oOrgao->tipoOrgao == "06") echo "selected=\"selected\"" ?>>RPPS - Assistência à Saúde</option>
	<option value="07" <?php if($oOrgao->tipoOrgao == "07") echo "selected=\"selected\"" ?>>Consórcio Público Intermunicipal</option>
	<option value="08" <?php if($oOrgao->tipoOrgao == "08") echo "selected=\"selected\"" ?>>Empresa Pública (apenas as dependentes)</option>
	<option value="09" <?php if($oOrgao->tipoOrgao == "09") echo "selected=\"selected\"" ?>>Sociedade de Economia Mista (apenas as dependentes)</option>
	</select></td>
</tr>
<tr id="mostraCnpj" >
	<td>Cnpj Prefeitura:</td>
	<td>
	<input type="text" name="cnpjCamara" id="cnpjCamara" value="<?php echo $oOrgao->cnpjCamara ?>" maxlength="14"/>
	</td>
</tr>
<tr>
	<td>Opção Semestralidade:</td>
	<td><select name="opcaoSemestralidade">
	<option value="01" <?php if($oOrgao->opcaoSemestralidade == "01") echo "selected=\"selected\"" ?>>Semestral</option>
	<option value="02" <?php if($oOrgao->opcaoSemestralidade == "02") echo "selected=\"selected\"" ?>>Quadrimestral</option>
	</select></td>
</tr>
<tr>
	<td>Contas de INSS:</td>
	<td>
	<input type="text" name="ctINSS" value="<?php echo $oOrgao->ctINSS ?>" size="50" />
	</td>
</tr>
<tr>
	<td>Contas de RPPS:</td>
	<td>
	<input type="text" name="ctRPPS" value="<?php echo $oOrgao->ctRPPS ?>" size="50" />
	</td>
</tr>
<tr>
	<td>Contas de IRRF:</td>
	<td>
	<input type="text" name="ctIRRF" value="<?php echo $oOrgao->ctIRRF ?>" size="50" />
	</td>
</tr>
<tr>
	<td>Contas de ISSQN:</td>
	<td>
	<input type="text" name="ctISSQN" value="<?php echo $oOrgao->ctISSQN ?>" size="50" />
	</td>
</tr>
<tr>
	<td>Contas de REPASSE CÂMARA:</td>
	<td>
	<input type="text" name="ctRepasseCamara" value="<?php echo $oOrgao->ctRepasseCamara ?>" size="50"/>
	</td>
</tr>
<tr>
	<td>Trada código da unidade:</td>
	<td><select name="trataCodUnidade">
	<option value="01" <?php if($oOrgao->trataCodUnidade == "01") echo "selected=\"selected\"" ?>>Não</option>
	<option value="02" <?php if($oOrgao->trataCodUnidade == "02") echo "selected=\"selected\"" ?>>Sim</option>
	</select></td>
</tr>
<tr>
	<td>CPF do Ordenador de pagamento:</td>
	<td>
	<input type="text" name="cpfOrdPag" maxlength="11" value="<?php echo $oOrgao->cpfOrdPag ?>" onkeyup="js_ValidaCampos(this,1,'Ano Inicial','f','f',event);" />
	</td>
</tr>
<tr>
	<td>Tipo de liquidante</td>
	<td><select name="tipoLiquidante">
	<option value="01" <?php if($oOrgao->tipoLiquidante == "01") echo "selected=\"selected\"" ?>>Por unidade</option>
	<option value="02" <?php if($oOrgao->tipoLiquidante == "02") echo "selected=\"selected\"" ?>>Por usuário</option>
	</select></td>
</tr>
<tr>
	<td></td>
	<td align="right"><input type="submit" value="Salvar" name="btnSalvar" /></td>
</tr>
</table>
</fieldset>
</form>

<script type="text/javascript">
function mostrar_cnpj_camara(){
	
	if ($('tipoOrgao').value == 01) {
		document.getElementById('mostraCnpj').style.visibility = "visible";	
	} else {

		document.getElementById('mostraCnpj').style.visibility = "hidden";
	  $('cnpjCamara').value = "";  
		
	}
}
</script>