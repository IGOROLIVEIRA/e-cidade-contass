<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_libpessoal.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$gform = new cl_formulario_rel_pes;
$geraform = new cl_formulario_rel_pes;
db_postmemory($HTTP_POST_VARS);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
<table width="60%" border="0" cellspacing="4" cellpadding="0">
  <tr><td colspan="2">&nbsp;</td></tr>
  <form name="form1" method="post" action="">
  <tr>
    <td nowrap colspan="2">
    <?
    db_input("folhaselecion", 3, 0, true, 'hidden', 3);
    $arr_pontosgerfs_inicial = Array();
    $arr_pontosgerfs_final   = Array();
    $arr_pontos = Array(
                        "10" =>"Fixo",
                        "1" =>"Salário",
                        "2" =>"Adiantamento",
                        "3" =>"Férias",
                        "4" =>"Rescisão",
                        "5" =>"Saldo do 13o",
                        "8" =>"Complementar"
                       );
    if(isset($objeto1)){
      foreach($objeto1 as $index){
        $arr_pontosgerfs_inicial[$index] = $arr_pontos[$index];
      }
    }else{
      $arr_pontosgerfs_inicial = $arr_pontos;
    }
    if(isset($objeto2)){
      foreach ($objeto2 as $index) {
        $arr_pontosgerfs_final[$index] = $arr_pontos[$index];
      }
    }
    db_multiploselect("valor","descr", "", "", $arr_pontosgerfs_inicial, $arr_pontosgerfs_final, 6, 250, "", "", false, "");
    ?>
    </td>
  </tr>

 <!-- 
    <td align="right">
      <b>Tipo de folha:</b>
    </td>
    <td>
    
      <?
      /*
      $arr_tipofolha = Array("1"=>"Salário","2"=>"Adiantamento","3"=>"Férias","4"=>"Rescisão","5"=>"13o","8"=>"Complementar","10"=>"Fixo");
      db_select("opcao_geral", $arr_tipofolha, true, 1);
      */
      ?>
	
      </td>
      
    
  -->
    </tr>
      <?

    if(!isset($opcao_gml)){
      $opcao_gml = "m";
    }
    if(!isset($opcao_filtro)){
      $opcao_filtro = "s";
    }

  //	include("dbforms/db_classesgenericas.php");
  //	$geraform = new cl_formulario_rel_pes;

    $geraform->manomes = false;                     // PARA NÃO MOSTRAR ANO E MES DE COMPETÊNCIA DA FOLHA
    $geraform->complementajs = "js_complementar();";

    $geraform->usaregi = true;                      // PERMITIR SELEÇÃO DE MATRÍCULAS
    $geraform->usalota = true;                      // PERMITIR SELEÇÃO DE LOTAÇÕES
    $geraform->usarubr = true;                      // PERMITIR SELEÇÃO DE RUBRICAS

    $geraform->re1nome = "r110_regisi";             // NOME DO CAMPO DA MATRÍCULA INICIAL
    $geraform->re2nome = "r110_regisf";             // NOME DO CAMPO DA MATRÍCULA FINAL
    
    $geraform->lo1nome = "r110_lotaci";             // NOME DO CAMPO DA LOTAÇÃO INICIAL
    $geraform->lo2nome = "r110_lotacf";             // NOME DO CAMPO DA LOTAÇÃO FINAL

    $geraform->ru1nome = "r110_rubri";             // NOME DO CAMPO DA RUBRICA INICIAL
    $geraform->ru2nome = "r110_rubrf";             // NOME DO CAMPO DA RUBRICA FINAL
	  
    $geraform->trenome = "opcao_gml";             // NOME DO CAMPO TIPO DE RESUMO
    $geraform->tfinome = "opcao_filtro";            // NOME DO CAMPO TIPO DE FILTRO

    $geraform->campo_auxilio_regi = "faixa_regis";  // NOME DO DAS MATRÍCULAS SELECIONADAS
    $geraform->campo_auxilio_lota = "faixa_lotac";  // NOME DO DAS LOTAÇÕES SELECIONADAS
    $geraform->campo_auxilio_rubr = "faixa_rubr";   // NOME DA FAIXA RUBICAS SELECIONADAS

    $geraform->filtropadrao = "s";  // NOME DO DAS LOTAÇÕES SELECIONADAS
    $geraform->resumopadrao = "m";  // NOME DO DAS LOTAÇÕES SELECIONADAS

	  $geraform->strngtipores = "gmlr";                // OPÇÕES PARA MOSTRAR NO TIPO DE RESUMO g - geral,
							  //                                       m - Matrícula,
						    //                                       r - Resumo
	  $geraform->onchpad      = true;                 // MUDAR AS OPÇÕES AO SELECIONAR OS TIPOS DE FILTRO OU RESUMO
	  $geraform->gera_form(null,null);
	  ?>
    <tr>
      <td colspan='2' align='center'>
	<input type="submit" name="processar" value="Processar" onclick="return js_enviar_dados();">
      </td>
    </tr>
    </form>
  </table>
  </center>
  <? 
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
  </body>
  <script>
  function js_enviar_dados(){
    stringretorno = "";
    virstrretorno = "";

    for(i=0;i<document.form1.objeto2.length;i++){
      stringretorno+= virstrretorno+document.form1.objeto2.options[i].value;
      virstrretorno = ",";
    }

    if(stringretorno == ""){
      alert("Selecione o(s) tipo(s) de folha.");
      return false;
    }  
    if(document.form1.selregist){
      valores = '';
      virgula = '';
      for(i=0; i < document.form1.selregist.length; i++){
	valores+= virgula+document.form1.selregist.options[i].value;
	virgula = ',';
      }
      document.form1.faixa_regis.value = valores;
      document.form1.selregist.selected = 0;
    }else if(document.form1.sellotac){
      valores = '';
      virgula = '';
      for(i=0; i < document.form1.sellotac.length; i++){
	valores+= virgula+"'"+document.form1.sellotac.options[i].value+"'";
	virgula = ',';
      }
      document.form1.faixa_lotac.value = valores;
      document.form1.sellotac.selected = 0;
    }else if(document.form1.selrubri){
      valores = '';
      virgula = '';
      for(i=0; i < document.form1.selrubri.length; i++){
	valores+= virgula+"'"+document.form1.selrubri.options[i].value+"'";
	virgula = ',';
      }
      document.form1.faixa_rubr.value = valores;
      document.form1.selrubri.selected = 0;
    }
    document.form1.folhaselecion.value = stringretorno;
    document.form1.action = 'pes4_gerafolha002.php';
    return true;

  }
  js_trocacordeselect();
function js_complementar(){
  var x = document.form1;
  for(i=0; i<x.objeto1.length; i++){
    x.objeto1.options[i].selected = true;
  }
  for(i=0; i<x.objeto2.length; i++){
    x.objeto2.options[i].selected = true;
  }
}
</script>
</html>
