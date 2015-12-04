<form name="form1" method="post" action="">
	<center>

	<fieldset><legend><b>Triagem</b></legend>
	<table border="1">
		<tr><td colspan="2"><b>Motivo:</b><?=@$sd24_v_motivo?></td></tr>
		<tr><td><b>Pressão:</b><?=@$sd24_v_pressao?></td><td><b>Peso:</b><?=@$sd24_f_peso?></td></tr>
		<tr><td colspan="2"><b>Temperatura:</b><?=@$sd24_f_temperatura?></td></tr>
		<tr><td colspan="2"><b>Profissional:</b><?=@$profissional_triagem?></td></tr>
		<tr><td colspan="2"><b>CBO:</b><?=@$cbo_triagem?></td></tr>
	</table>
	</fieldset>

</center>
<p>
<input name="botao_ok" type="submit" id="botao_ok" value="Fechar" onclick="parent.db_iframe_triagem.hide();">
</form>
