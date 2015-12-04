<?
$clrotulo = new rotulocampo;

$clrotulo->label("x01_matric");
$clrotulo->label("z01_nome");
$clrotulo->label("j14_codigo");
$clrotulo->label("j14_nome");
$clrotulo->label("j13_codi");
$clrotulo->label("j13_descr");



?>
<script>
	function mostraJanelaPesquisa() {
		F = document.form1;
		if (F.x01_matric.value.length > 0) {
			VisualizacaoMatricula.jan.location.href = 'agu3_conscadastro_002.php?cod_matricula=' + F.x01_matric.value;
			VisualizacaoMatricula.mostraMsg();
			VisualizacaoMatricula.show();
			VisualizacaoMatricula.focus();
		} else if (F.z01_nome.value.length > 0) {
			VisualizacaoProprietario.jan.location.href = 'func_nome.php?funcao_js=parent.mostraTodasMatCad|0&nomeDigitadoParaPesquisa=' + F.z01_nome.value;
			VisualizacaoProprietario.mostraMsg();
			VisualizacaoProprietario.show();
			VisualizacaoProprietario.focus();	  
		} else if(F.j14_codigo.value.length > 0) {
			VisualizacaoRuas.jan.location.href = 'func_ruas.php?funcao_js=parent.mostraTodasMatriculas_PesquisaRuas|0&codrua=' + F.j14_codigo.value;
			VisualizacaoRuas.mostraMsg();
			VisualizacaoRuas.show();
			VisualizacaoRuas.focus();	  
		} else if(F.j14_nome.value.length > 0) {
			VisualizacaoNomeRuas.jan.location.href='func_ruas.php?funcao_js=parent.mostraTodasMatriculas_PesquisaRuas|0&nomerua='+ F.j14_nome.value;
			VisualizacaoNomeRuas.mostraMsg();
			VisualizacaoNomeRuas.show();
			VisualizacaoNomeRuas.focus();	  
		} else if(F.j13_codi.value.length > 0) {
			VisualizacaoBairros.jan.location.href = 'func_bairros.php?funcao_js=parent.mostraTodasMatriculas_PesquisaBairro|0&codbairro=' + F.j13_codi.value;
			VisualizacaoBairros.mostraMsg();
			VisualizacaoBairros.show();
			VisualizacaoBairros.focus();	  
		} else if(F.j13_descr.value.length > 0) {
			VisualizacaoNomeBairro.jan.location.href = 'func_bairros.php?funcao_js=parent.mostraTodasMatriculas_PesquisaBairro|0&nomeBairro=' + F.j13_descr.value;
			VisualizacaoNomeBairro.mostraMsg();
			VisualizacaoNomeBairro.show();
			VisualizacaoNomeBairro.focus();	  
		}
		F.reset();
	}
  
	function mostraTodasMatCad(numerocgm){
		VisualizacaoTodasMatCad.jan.location.href = 'agu3_conscadastro_003.php?pesquisaPorNome=' + numerocgm;
		VisualizacaoTodasMatCad.mostraMsg();
		VisualizacaoTodasMatCad.show();
		VisualizacaoTodasMatCad.focus();
	}
	
	function mostraJanelaDadosImovel(numeroMat){
		VisualizacaoMatricula.jan.location.href = 'agu3_conscadastro_002.php?cod_matricula=' + numeroMat;
		VisualizacaoMatricula.mostraMsg();
		VisualizacaoMatricula.show();
		VisualizacaoMatricula.focus();	  
	}

	function mostraTodasMatriculas_PesquisaRuas(rua){
		VisualizacaoRuas.jan.location.href = 'agu3_conscadastro_003.php?pesquisaRua=' + rua;
		VisualizacaoRuas.mostraMsg();
		VisualizacaoRuas.show();
		VisualizacaoRuas.focus();	  
	}
	
	function mostraTodasMatriculas_PesquisaBairro(bairro){
		VisualizacaoBairros.jan.location.href = 'agu3_conscadastro_003.php?pesquisaBairro=' + bairro;
		VisualizacaoBairros.mostraMsg();
		VisualizacaoBairros.show();
		VisualizacaoBairros.focus();	  
	}

</script>
<table width="80%" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><form name="form1" method="post" action="">
        <table width="107%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td nowrap>&nbsp;</td>
            <td nowrap title="<?=@$Tx01_matric?>">
              <?=@$Lx01_matric?>
	    </td>  
            <td nowrap>
            <?
               db_input('x01_matric',10,$Ix01_matric,true,'text',1,"onBlur='js_ValidaCamposText(this,1);'")
            ?>
          </tr>
          <tr> 
            <td width="3%" nowrap>&nbsp;</td>
            <td nowrap title="<?=@$Tz01_nome?>">
              <?=@$Lz01_nome?>
	    </td>  
            <td nowrap>
            <?
               db_input('z01_nome',50,$Iz01_nome,true,'text',1,"")
            ?>
          </tr>
          </tr>
          <tr> 
            <td nowrap>&nbsp;</td>
            <td nowrap title="<?=@$Tj14_codigo?>"><?=@$Lj14_codigo?></td>
            <td nowrap><? db_input('j14_codigo',8,$Ij14_codigo,true,'text',1,"onBlur='js_ValidaCamposText(this,1)'"); ?></td>
          </tr>
          <tr> 
	    <td nowrap>&nbsp;</td>
            <td nowrap title="<?=@$Tj14_nome?>"><?=@$Lj14_nome?></td>
            <td nowrap><? db_input('j14_nome',50,$Ij14_nome,true,'text',1);?></td>
          </tr>
          <tr> 
	    <td nowrap>&nbsp;</td>
            <td nowrap title="<?=@$Tj13_codi?>"> <?=@$Lj13_codi?> </td>
            <td nowrap><? db_input('j13_codi',5,$Ij13_codi,true,'text',1,"onBlur='js_ValidaCamposText(this,1)'"); ?> </td>
          </tr>
          <tr> 
	    <td nowrap>&nbsp;</td>
            <td nowrap title="<?=@$Tj13_descr?>">
	      <?=@$Lj13_descr?>
	    </td>
            <td nowrap>
            <?
               db_input('j13_descr',50,$Ij13_descr,true,'text',1);
            ?>
	    </td>
          </tr>
          <tr> 
            <td colspan="3" align="left" valign="top" nowrap>&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="3"><input name="pesquisar" type="button" onClick="mostraJanelaPesquisa()" id="pesquisar" value="Pesquisar"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
