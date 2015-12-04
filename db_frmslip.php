<?
include("classes/db_conplanoexe_classe.php");
include("classes/db_saltes_classe.php");
$clsaltes = new cl_saltes;
$clconplanoexe = new cl_conplanoexe;
//echo $clconplanoexe->sql_descr(db_getsession("DB_anousu"),null,'c62_reduz,c60_descr','c62_reduz');
$result = $clconplanoexe->sql_record($clconplanoexe->sql_descr(db_getsession("DB_anousu"),null,'*','c62_reduz'));
//$result = pg_query($sql1);
//echo $clsaltes->sql_query();
$result1 = $clsaltes->sql_record($clsaltes->sql_query());
$clrotulo = new rotulocampo;
$clrotulo->label("k17_hist");
$clrotulo->label("c50_descr");
$clrotulo->label("z01_nome");
$clrotulo->label("z01_numcgm");

?>
<script>
function js_atualiza1(qual){
  if(qual=='debito')
  document.form1.descr_debito.options[document.form1.debito.selectedIndex].selected = true;
  if(qual=='descr_debito')
  document.form1.debito.options[document.form1.descr_debito.selectedIndex].selected = true;
}
function js_atualiza2(qual){
  if(qual=='credito')
  document.form1.descr_credito.options[document.form1.credito.selectedIndex].selected = true;
  if(qual=='descr_credito')
  document.form1.credito.options[document.form1.descr_credito.selectedIndex].selected = true;
}
</script>
<form name="form1" method="post" onsubmit="return js_gravar()">
        <table width="100%">
          <tr> 
            <td valign="top"><table width="100%">
          <tr> 
            <td width="23%" align="right">&nbsp;</td>
            <td width="77%">&nbsp;</td>
          </tr>
          <tr> 
            <td align="left"><strong>C&oacute;digo do Slip:</strong></td>
            <td>
      	      <input name="numslip" type="text" id="numslip" readonly value="<?=@$numslip?>" size="10" >
	    </td>
          </tr>
          <tr> 
            <td align="left"><strong>
              <?
              db_ancora('Conta a Debitar(Receber): ',"js_pesquisac01_reduz(true);",2);
	      ?></strong>
	    </td>
            <td> <select onChange="js_atualiza1(this.name)" <?=@$read_only?> name="debito" id="debito">
                <?
	         for($i=0;$i<pg_numrows($result);$i++){
	            db_fieldsmemory($result,$i);
  	            echo "<option value=\"$c62_reduz\" ".(isset($debito)?($debito==$c62_reduz?"selected":""):"").">$c62_reduz</option>\n";
	         }
                ?>
              </select> <select onChange="js_atualiza1(this.name)" <?=@$read_only?> name="descr_debito" id="descr_debito"> 
              <?
  	       for($i=0;$i<pg_numrows($result);$i++){
	           db_fieldsmemory($result,$i);
  	           echo "<option value=\"$c62_reduz\" ".(isset($debito)?($debito==$c62_reduz?"selected":""):"").">$c60_descr</option>\n";
	       }
              ?></select>
              </td>
          </tr>
          <tr> 
            <td height="41" align="left"><strong>
              <?
              db_ancora('Conta a Creditar (Pagar): ',"js_pesquisac01_reduz1(true);",2);
	      ?></strong>
            <td> <select onChange="js_atualiza2(this.name)" <?=@$read_only?> name="credito" id="credito">
                <?
  	         for($ii=0;$ii<pg_numrows($result1);$ii++){
	            db_fieldsmemory($result1,$ii);
  	            echo "<option value=\"$k13_conta\" ".(isset($credito)?($credito==$k13_conta?"selected":""):"").">$k13_conta</option>\n";
		 }
                    ?>
              </select> <select onChange="js_atualiza2(this.name)" <?=@$read_only?> name="descr_credito" id="descr_credito">
                <?
     	         for($ii=0;$ii<pg_numrows($result1);$ii++){
	            db_fieldsmemory($result1,$ii);
  	            echo "<option value=\"$k13_conta\" ".(isset($credito)?($credito==$k13_conta?"selected":""):"").">$k13_descr</option>\n";
		 }
                ?>
              </select> </td>
          </tr>
          <tr> 
            <td align="left"> 
              <?
              db_ancora(@$Lk17_hist,"js_pesquisac50_codhist(true);",2);
	      ?>
            </td>
            <td> 
              <?
              db_input('k17_hist',5,$Ik17_hist,true,'text',1," onchange='js_pesquisac50_codhist(false);'");
              db_input('c50_descr',40,$Ic50_descr,true,'text',3)
	      ?>
          </tr>
          <tr> 
            <td align="left"> 
              <?
              db_ancora(@$Lz01_numcgm,"js_pesquisaz01_numcgm(true);",2);
	      ?>
            </td>
            <td> 
              <?
	      db_input('z01_numcgm',6,$Iz01_numcgm,true,'text',1," onchange='js_pesquisaz01_numcgm(false);'");
              db_input('z01_nome',40,$Iz01_nome,true,'text',3)
	      ?>
            </td>
          </tr>
          <tr> 
            <td height="21" align="left"><strong>Valor da Transa&ccedil;&atilde;o:</strong></td>
            <td><input name="valor" type="text" <?=@$read_only?> id="valor" value="<?=@$k17_valor?>" size="20" maxlength="30"></td>
          </tr>
          <tr> 
            <td height="85" align="left" valign="top"><strong>Observa&ccedil;&otilde;es:</strong></td>
            <td align="left" valign="top"><textarea name="texto" <?=@$read_only?> onDblClick="document.form1.texto.value=''" cols="60" rows="10" id="texto"><?=$k17_texto?></textarea></td>
          </tr>
          <tr align="center"> 
            <td colspan="2" valign="top"><input name="confirma" type="submit" id="confirma" value="Confirma"></td>
          </tr>
        </table></td>
          </tr>
        </table>
      </form>
<script>
js_Ipassacampo();
document.forms[0].elements[0].focus();

function js_pesquisac50_codhist(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_conhist.php?funcao_js=parent.js_mostrahist1|c50_codhist|c50_descr';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_conhist.php?pesquisa_chave='+document.form1.k17_hist.value+'&funcao_js=parent.js_mostrahist';
  }
}
function js_mostrahist(chave,erro){
  document.form1.c50_descr.value = chave; 
  if(erro==true){ 
    document.form1.k17_hist.focus(); 
    document.form1.c50_codhist.value = ''; 
  }
}
function js_mostrahist1(chave1,chave2){
  document.form1.k17_hist.value = chave1;
  document.form1.c50_descr.value = chave2;
  db_iframe.hide();
}

function js_pesquisaz01_numcgm(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostracgm';
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.z01_numcgm.focus(); 
    document.form1.z01_numcgm.value = ''; 
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.z01_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe.hide();
}



function js_pesquisac01_reduz(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_conplanoexe.php?funcao_js=parent.js_mostrareduz1|c62_reduz|c60_descr';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_conplanoexe.php?pesquisa_chave='+document.form1.c62_reduz.value+'&funcao_js=parent.js_mostrareduz';
  }
}
function js_mostrareduz(chave,erro){
  document.form1.c60_descr.value = chave; 
  if(erro==true){ 
    document.form1.c62_reduz.focus(); 
    document.form1.c62_reduz.value = ''; 
  }
}
function js_mostrareduz1(chave1,chave2){
//  alert(tipo);
  for(x=0;x<document.form1.debito.options.length;x++){
      if(document.form1.debito[x].value == chave1){
         document.form1.debito.options[x].selected = true;
         document.form1.descr_debito.options[x].selected = true;
         break;
      }
  }
  db_iframe.hide();
}
function js_pesquisac01_reduz1(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_saltes.php?funcao_js=parent.js_mostrareduz2|k13_conta|k13_descr';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_saltes.php?pesquisa_chave='+document.form1.k13_conta.value+'&funcao_js=parent.js_mostrareduz';
  }
}
function js_mostrareduz2(chav1,chav2){
  for(y=0;y<document.form1.credito.options.length;y++){
      if(document.form1.credito[y].value == chav1){
         document.form1.credito.options[y].selected = true;
         document.form1.descr_credito.options[y].selected = true;
         break;
      }
  }
  db_iframe.hide();
}
</script>
<?
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();
?>
