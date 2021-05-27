<?
$clrhpessoal->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("r70_estrut");
$clrotulo->label("r70_descr");
$clrotulo->label("rh02_salari");

?>
<form name="form1" method="post" action="">
<table border="0" cellspacing="8" cellpadding="0" width="95%">
  <tr>
    <td colspan="2" align='center'>
      <fieldset>
        <Legend align="left">
          <b>Reajuste de Salrios</b>
        </Legend>
        <center>
        <table cellspacing="8" cellpadding="0">
	  <?
	  $dbwhere = " rh02_anousu = ".$anofolha." and rh02_mesusu = ".$mesfolha;
	  if(isset($para) && $para == "s"){
	    $dbwhere .= " and rh02_salari > 0 ";
	  }
	  if(isset($matini) || isset($matfim)){
            if(trim($matini) != "" && trim($matfim) != ""){
              $dbwhere.= " and rh01_regist between ".$matini." and ".$matfim;
            }else if(trim($matini) != ""){
	      $dbwhere.= " and rh01_regist >= ".$matini;
            }else if(trim($matfim) != ""){
              $dbwhere.= " and rh01_regist <= ".$matfim;
            }
	  }
          if(isset($selmatri) && count($selmatri) > 0){
	    $campo_auxilio_regi = "";
	    for($i=0; $i<count($selmatri); $i++){
	      $campo_auxilio_regi.= ($i==0?"":",").$selmatri[$i];
	    }
          }
	  if(isset($campo_auxilio_regi) && trim($campo_auxilio_regi) != ""){
            $dbwhere.= " and rh01_regist in (".$campo_auxilio_regi.") ";
	  }
	  if(isset($lotini) || isset($lotfim)){
	    if(trim($lotini) != "" && trim($lotfim) != ""){
	      $dbwhere.= " and r70_estrut between '".$lotini."' and '".$lotfim."' ";
	    }else if(trim($lotini) != ""){
	      $dbwhere.= " and r70_estrut >= '".$lotini."' ";
	    }else if(trim($lotfim) != ""){
	      $dbwhere.= " and r70_estrut <= '".$lotfim."' ";
            }
	  }
	  if(isset($sellotac) && count($sellotac) > 0){
	    $campo_auxilio_lota = "";
	    for($i=0; $i<count($sellotac); $i++){
	      $campo_auxilio_lota.= ($i==0?"":",")."'".$sellotac[$i]."'";
	    }
	  }
	  if(isset($campo_auxilio_lota) && trim($campo_auxilio_lota) != ""){
            $dbwhere.= " and r70_estrut in (".$campo_auxilio_lota.") ";
	  }
          db_input('vallancar',10, 0, true, 'hidden', 3);
          db_input('anofolha',4, 0, true, 'hidden', 3);
          db_input('mesfolha',2, 0, true, 'hidden', 3);
          db_input('para',2, 0, true, 'hidden', 3);
          db_input('matini',2, 0, true, 'hidden', 3);
          db_input('matfim',2, 0, true, 'hidden', 3);
          db_input('lotini',2, 0, true, 'hidden', 3);
          db_input('lotfim',2, 0, true, 'hidden', 3);
          db_input('lotfim',2, 0, true, 'hidden', 3);
          db_input('campo_auxilio_regi',2, 0, true, 'hidden', 3);
          db_input('campo_auxilio_lota',2, 0, true, 'hidden', 3);
          $campofocar = "valor";

	  if( !empty($selecao) ) {
            $oDaoSelecao   = new cl_selecao();
            $dbwhere .= " and ".$oDaoSelecao->getCondicaoSelecao($selecao);
          }

    if(!empty($dbwhere)){
      $dbwhere .= " and ";
    }
    $dbwhere .= ' rh05_recis IS NULL ';
    if(!empty($vinculo)){
      switch ( $vinculo ) {
          case 'a': //Ativos
          $dbwhere .= " and rh30_vinculo = 'A' ";
          break;
          case 'i': //Inativos
          $dbwhere .= " and rh30_vinculo = 'I' ";
          break;
          case 'p': //Pensionista
          $dbwhere .= " and rh30_vinculo = 'P' ";
          break;
          case 'ip': //Inativos Pensionistas
          $dbwhere .= " and rh30_vinculo in ('I','P') ";
          break;
      }
    }
    if (!empty($tipoReajuste) || $tipoReajuste == 0) {
      $dbwhere .= " and rh01_reajusteparidade = '{$tipoReajuste}'";
    }

    if ($tipoResumo != 0) {

      $aTiposResumo = array( 2 => "r70_codigo", 
       3 => "rh01_regist", 
       5 => "rh02_funcao");

      $sCampo = $aTiposResumo[$tipoResumo];

      if (isset($intervaloInicial) || isset($intervaloFinal)) {

        if (isset($intervaloInicial) && isset($intervaloFinal)) {
          $dbwhere .= " and {$sCampo} between {$intervaloInicial} and {$intervaloFinal}";
        } else if (isset($intervaloInicial)) {
          $dbwhere .= " and {$sCampo} >= $intervaloInicial";
        } else if (isset($intervaloFinal)) {
          $dbwhere .= " and {$sCampo} <= $intervaloFinal";
        }
      }

      if (!empty($sRegistros)) {
        $dbwhere .= " and {$sCampo} in ({$sRegistros})";
      }
    }

    if (($tipoLancamento == 'm' && $para == 's') || $tipoLancamento == 'a'){
      $dbwhere .= " and rh02_salari > 0";
    }

    $result_rhpessoal = $clrhpessoal->sql_record($clrhpessoal->sql_query_cgmmov(null,"rh01_regist,rh02_seqpes,rh01_numcgm,z01_nome,rh02_salari,r70_codigo,r70_estrut,r70_descr","",$dbwhere));

    for($i=0;$i<$clrhpessoal->numrows;$i++){
	    db_fieldsmemory($result_rhpessoal, $i);
	    if($campofocar == ""){
	      $campofocar = 'valor_'.$rh01_regist;
            }
	    if($i==0){
	  ?>
          <thead>
            <tr>
              <td align='center' width="5%" ><b><?=$RLrh01_regist?></b></td>
              <td align='center' width="25%"><b><?=$RLz01_nome?></b></td>
              <td align='center' width="10%"><b><?=$RLr70_estrut?></b></td>
              <td align='center' width="30%"><b><?=$RLr70_descr?></b></td>
              <td align='center' width="5%" ><b><?=$RLrh02_salari?></b></td>
              <td align='center' width="10%"><b>Valor</b></td>
              <td align='center' width="3%"><b>(%)</b></td>
              <td align='center' width="12%"><b>Novo Valor</b></td>
              <td align='center'>&nbsp;</td>
              <td align='center'>&nbsp;</td>

            </tr>
          </thead>
          <tbody style='max-height:35ex;max-width:90%;overflow:auto;'>
	    <?
	    }
	    ?>
            <tr>
              <td align='center' width="5%" ><?=$rh01_regist?></td>
              <td align='left'   width="25%"><?=$z01_nome?>   </td>
              <td align='center' width="10%"><?=$r70_estrut?> </td>
              <td align='left'   width="30%"><?=$r70_descr?>  </td>
              <td align='right'  width="5%" class="valor"><?=db_formatar($rh02_salari,"f")?></td>
              <td align='center' width="10%">
                <?
                db_input('rh02_salari',10, $Irh02_salari, true, 'text', 1, "onchange='js_desabcampos(\"".$rh02_seqpes."\",\"valor_\",\"perce_\",\"novovalor_\", this.value);'", 'valor_'.$rh02_seqpes);
                ?>
              </td>
              <td align='center' width="3%">
                <?
                db_input('rh02_salari',10, $Irh02_salari, true, 'text', 1, "onchange='js_desabcampos(\"".$rh02_seqpes."\",\"perce_\",\"novovalor_\", \"\", this.value, ".$rh02_salari.");'", 'perce_'.$rh02_seqpes);
                ?>
              </td>
              <td align='center' width="12%">
                <?
                db_input('rh02_salari',10, $Irh02_salari, true, 'text', 3, "onchange='js_desabcampos(\"".$rh02_seqpes."\",\"valor_\",\"perce_\);'", 'novovalor_'.$rh02_seqpes, '#DEB887');
                ?>
              </td>
              <td align='center'>&nbsp;</td>
              <td align='center'>&nbsp;</td>
	    </tr>
	    <?
	    }
	    ?>
          </tbody>
        </table>
        </center>
      </fieldset>
    </td>
  </tr>
  <tr>
    <td colspan="2" align='center'>
      <fieldset>
        <Legend align="left">
          <b>Lanar valores</b>
        </Legend>
        <center>
        <table cellspacing="8" cellpadding="0">
      	  <tr>
            <td align='right'>Valor padrão: </td>
            <td align='left'>
              <?
              db_input('rh02_salari',10, $Irh02_salari, true, 'text', 1, "onchange='js_lancarvalor(\"v\",this.value);'", 'valor');
              ?>
            </td>
            <td align='right'>Percentual padrão: </td>
            <td align='left'>
              <?
              db_input('rh02_salari',10, $Irh02_salari, true, 'text', 1, "onchange='js_lancarvalor(\"p\",this.value, \"".$rh02_salari."\");'", 'perce');
              ?>
            </td>
      	  </tr>
      	</table>
      </fieldset>
    </td>
  </tr>
  <tr>
    <td colspan='2' align='center'>
      <input type="submit" name="processar" value="Processar" onclick="return js_testecampos();">
      <input type="button" name="limpar"    value="Limpar" onclick="js_limparcampos('');">
      <input type="button" name="voltar"    value="Voltar" onclick="location.href='pes1_reajustesal001.php'">
      <!-- <input type="button" name="zerar"     value="Zerar"  onclick="js_limparcampos('0');"> -->
    </td>
  </tr>
</table>
</form>
<script>
var time;
var camposel;
function js_testecampos(){
  vallancar = "";
  virgula   = "";
  for(var i=0; i<document.form1.length;i++){
    if(document.form1.elements[i].type == "text"){
      arr = document.form1.elements[i].name.split("_");
      if(document.form1.elements[i].readOnly == false && arr[0] && arr[1]){
	if(document.form1.elements[i].value != ""){
          vallancar += virgula + arr[1] + "-" + arr[0] + "-" + document.form1.elements[i].value;
	  virgula = ",";
	}
      }
    }
  }
  document.form1.vallancar.value = "";
  if(vallancar != ""){
    document.form1.vallancar.value = vallancar;
    return true;
  }
  alert("Informe os valores a serem lanados.");
  return false;
}
function js_lancarvalor(PorV,valor,salario=null){

  if(PorV == 'v' && valor!=''){
    document.form1.perce.readOnly = true;
    document.form1.perce.style.background = '#DEB887';
  }else if(PorV == 'p' && valor!=''){
    document.form1.valor.readOnly = true;
    document.form1.valor.style.background = '#DEB887';
  }else {
    document.form1.valor.readOnly = false;
    document.form1.valor.style.background = '';
    document.form1.perce.readOnly = false;
    document.form1.perce.style.background = '';
  }

  var valores = document.getElementsByClassName('valor');
  var contadorElementos = 0;

  for(var i=0; i<document.form1.length;i++){
    if(document.form1.elements[i].type == "text"){
      let valorcampo = new Number(document.form1.elements[i].value);
      valor = new Number(valor);
      novo_salario = null;
      arr = document.form1.elements[i].name.split("_");

      if( document.form1.elements[i].readOnly == false || arr[0] == 'novovalor'){

        if((PorV == "v" && arr[0] == "valor") || (PorV == 'p' && arr[0] == 'perce')){
          if(valor > 0)
            document.form1.elements[i].value = valor;
          else document.form1.elements[i].value = '';
        }

        if(PorV == 'p' && arr[0] == 'novovalor'){
          if(valores[contadorElementos]){
            var salario = parseFloat(valores[contadorElementos].textContent.trim().replace('.', '').replace(',', '.'), 10);
            if(valor > 0){
              salario_retorno = (salario + (salario * (valor/100)));
              novo_salario = js_formatar(salario_retorno, 'f', 2);
              document.form1.elements[i].value = String(novo_salario).replace('.', ',');
            }
            contadorElementos++;
          }
        }

        js_desabcampos(arr[1],"valor_","perce_", "novovalor_", valor, novo_salario);

      }
    }
  }
}
function js_limparcampos(valor){
  for(var i=0; i<document.form1.length;i++){
    if(document.form1.elements[i].type == "text"){
      arr = document.form1.elements[i].name.split("_");
      document.form1.elements[i].value = valor;
      i++;
      document.form1.elements[i].value = valor;
      js_desabcampos(arr[1],"valor_","perce_","novovalor_");
    }
  }
  document.getElementById(`valor`).style.background = '';
  document.getElementById(`valor`).readOnly = false;
  document.getElementById(`perce`).style.background = '';
  document.getElementById(`perce`).readOnly = false;
}
function js_chamafuncao(campo,focar){
  js_tabulacaoforms("form1",campo,focar,1,campo,focar);
}
function js_seleciona_campo_confirma(){
  if(document.form1.elements[camposel]){
    js_chamafuncao(document.form1.elements[camposel].name,true);
  }
  clearInterval(time);
}
function js_desabcampos(campo,opcao,receb,novo=null,valor=null,novo_valor=null){

  if(opcao == 'perce_' && receb == 'novovalor_' && campo){
    var n_valor = Number(novo_valor);
    var novo_salario = parseFloat(n_valor + (n_valor * (Number(valor)/100)), 2);
    document.getElementById(`novovalor_${campo}`).value = js_formatar(novo_salario, 'f', 2);
  }

  if(campo && valor > 0){
    if(receb && novo_valor){
      let elemento = document.getElementById(`${novo}${campo}`);
      elemento.value = novo_valor;
    }
    else if(novo_valor == null){
      let elemento = document.getElementById(`${novo}${campo}`);
      elemento.value = valor;
    }
  }else if(campo){
    document.getElementById(`${receb}${campo}`).value = '';
    document.getElementById(`${novo}${campo}`).value = '';
  }

  camposel = "";

  if(eval("document.form1."+opcao+campo) && eval("document.form1."+receb+campo)){
    eval("valorcampoop = new Number(document.form1."+opcao+campo+".value);");
    eval("valorcamporc = new Number(document.form1."+receb+campo+".value);");

    if(valorcampoop == 0 && valorcamporc == 0){
      eval("document.form1."+opcao+campo+".readOnly = false;");
      eval("document.form1."+opcao+campo+".style.backgroundColor = '';");

      eval("document.form1."+receb+campo+".readOnly = false;");
      eval("document.form1."+receb+campo+".style.backgroundColor = '';");

   }else if(valorcampoop > 0){
      eval("document.form1."+receb+campo+".value    = '';");
      eval("document.form1."+receb+campo+".readOnly = true;");
      eval("document.form1."+receb+campo+".style.backgroundColor = '#DEB887';");
      for(var i=0; i<document.form1.length;i++){
        if(document.form1.elements[i].name == opcao+campo){
          break;
        }
      }
      if(document.form1.elements[(i+2)]){
        camposel = document.form1.elements[(i+2)].name;
        // time = setInterval(js_seleciona_campo_confirma,10);
      }
    }else if(valorcamporc > 0){
      eval("document.form1."+opcao+campo+".value    = '';");
      eval("document.form1."+opcao+campo+".readOnly = true;");
      eval("document.form1."+opcao+campo+".style.backgroundColor = '#DEB887';");
      for(var i=0; i<document.form1.length;i++){
        if(document.form1.elements[i].name == receb+campo){
          break;
        }
      }
      if(document.form1.elements[(i+2)]){
        camposel = document.form1.elements[(i+1)].name;
        // time = setInterval(js_seleciona_campo_confirma,10);
      }
    }
  }
}
</script>
