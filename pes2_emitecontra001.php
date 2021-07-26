<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_gerfcom_classe.php");
$aux = new cl_arquivo_auxiliar;
$clgerfcom = new cl_gerfcom;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
$clrotulo->label('r48_semest');
$clrotulo->label("rh56_localtrab");
$clrotulo->label("rh55_descr");
$gform = new cl_formulario_rel_pes;
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/classes/DBViewTipoFiltrosFolha.js"></script>
<script>
function js_filtra(){
  document.form1.submit();
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc">

  <form name="form1" class="container" method="post" action="">
  <fieldset>
    <legend>Contra-Cheques (Laser)</legend>

      <table align="center" border="0" class="form-container">

        <tr>
          <td align="right" nowrap title="Digite o Ano / Mês de competência">
            <strong>Ano / Mês :&nbsp;&nbsp;</strong>
          </td>
          <td>
            <?
            if(!isset($xano) || (isset($xano) && (trim($xano) == "" || $xano == 0))){
              $xano = db_anofolha();
            }
            $Sxano = "Ano";
            db_input('xano',4,1,true,'text',2,'onchange="js_anomes();"');
            ?>
            &nbsp;/&nbsp;
            <?
            if(!isset($xmes) || (isset($xmes) && trim($xmes) == "" || $xmes == 0)){
              $xmes = db_mesfolha();
            }
            $Sxmes = "Mês";
            db_input('xmes',2,1,true,'text',2,'onchange="js_anomes();"');
            ?>
          </td>
        </tr>
      <tr >
        <td align="right" nowrap title="Digite o Ano / Mes de competência" >
        <?
        $gform->selecao = true;
        $gform->desabam = false;
        $gform->manomes = false;
        $gform->gera_form(db_anofolha(),db_mesfolha());
        ?>
        </td>
      </tr>
        <tr>
          <td align="right" ><strong>Tipo de Folha :</strong></td>
          <td>
            <select name="folha" onchange="js_tipofolha();">
              <option value = 'salario'       <?=((isset($folha)&&$folha=="salario")?"selected":"")?>>Salário
              <option value = 'complementar'  <?=((isset($folha)&&$folha=="complementar")?"selected":"")?>>Complementar
              <option value = 'rescisao'      <?=((isset($folha)&&$folha=="rescisao")?"selected":"")?>>Rescisão
              <option value = '13salario'     <?=((isset($folha)&&$folha=="13salario")?"selected":"")?>>13o. Salário
              <option value = 'adiantamento'  <?=((isset($folha)&&$folha=="adiantamento")?"selected":"")?>>Adiantamento
          </td>
        </tr>
        <tr>
          <td colspan="2" id="containnerTipoFiltrosFolha"></td>
        </tr>
        <?
        if(isset($folha) && $folha == "complementar"){
          $result_semest = $clgerfcom->sql_record($clgerfcom->sql_query_file(null,null,null,null,"distinct r48_semest",null, " r48_anousu = $xano and r48_mesusu = $xmes and r48_instit = ".db_getsession('DB_instit')));
          if($clgerfcom->numrows > 0){
            echo "
                  <tr>
                    <td align='left' title='".$Tr48_semest."'><strong>Nro. Complementar:</strong></td>
                    <td>
                      <select name='r48_semest'>
                        <option value = '0'>Todos
                 ";
                 for($i=0; $i<$clgerfcom->numrows; $i++){
                   db_fieldsmemory($result_semest, $i);
                   echo "<option value = '$r48_semest'>$r48_semest";
                 }
            echo "
                    </td>
                  </tr>
	         ";
          }else{
        ?>
        <tr>
          <td colspan="2" align="center">
            <font color="red">Sem complementar para este período.</font>
            <?
            $r48_semest = 0;
            db_input("r48_semest", 2,0, true, 'hidden', 3);
            ?>
          </td>
        </tr>
        <?
          }
        }
        ?>
	<tr>
	  <td align="right" ><strong>Ordem:</strong></td>
	  <td>
	  <?
	  $arr=array("L"=>"Estrutural das lotações","N"=>"Nome dos funcionários","M"=>"Matrícula dos funcionários");
	  db_select("ordem",$arr,true,2);
	  ?>
	  </td>
	</tr>
	<tr>
	  <td  align="right" ><strong>Número de Vias:</strong></td>
	  <td>
	  <?
	  $arr_vias=array("1"=>"1","2"=>"2","3"=>"3");
	  db_select("num_vias",$arr_vias,true,2);
	  ?>
	  </td>
	</tr>

  <tr>
    <td colspan="2">
    <fieldset>
        <legend>Mensagem: </legend>
        <?php
         db_textarea("mensagem1",7,30,'',true,'text',1);
        ?>
      </fieldset>
    </td>
  </tr>

  </table>
  </fieldset>
        <input name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite(arguments[0]);">
  </form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
  var iInstit = <?=db_getsession("DB_instit") ?>;
function js_tipofolha(){
  if(document.form1.folha.value == "complementar" || document.form1.r48_semest){
    document.form1.submit();
  }
}
function js_anomes(){
  if(document.form1.folha.value == "complementar"){
    document.form1.submit();
  }
}

function js_emite(evt){

  var aCampos = ['xano', 'xmes', 'cod_ini', 'cod_fim'];
  var aCampoNotNull = ['xano', 'xmes'];
  for (var iIndex = 0; iIndex < aCampos.length; iIndex++) {
    try {
      var oCampo = $(aCampos[iIndex]);
    } catch (e) {
      return false;
    }

    if (!oCampo) {continue;}

    if (aCampos[iIndex] == aCampoNotNull[iIndex] && oCampo.value == "") {
      alert("Campo não pode ficar em branco.");
      oCampo.focus();
      evt.stopImmediatePropagation();
      return false;
    }
    var sValorAnterior = oCampo.value;
    //oCampo.onkeyup(evt);
    if (sValorAnterior != "" && oCampo.value == "") {
      evt.stopImmediatePropagation();
      return false;
    }
  };

  var oQuery = {};
  oQuery.iTipoRelatorio = $F('oCboTipoRelatorio');
  oQuery.iTipoFiltro    = $F('oCboTipoFiltro');
  /**
   * Se o tipo de relatorio dif  rente de geral e tipo de filtro igual a selecionado,
   * obrigar o lançamento de 1 registro no respectivo lançador.
   */
  var oTipoRelatorio = $F('oCboTipoRelatorio');
  var oTipoFiltro    = $F('oCboTipoFiltro');

  if (oTipoRelatorio != 0 && oTipoFiltro == 2) {
    
    var oLancadorSelecionado = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();
    if (oLancadorSelecionado.length == 0) {

      alert('Por Favor, realize pelo menos o lançamento de 1 registro.');
      return false 
    }
  }

  /**
   * Se o tipo de relatorio diferente de geral e tipo de filtro igual a Intervalo,
   * obrigar o preenchimento de intervalo.
   */
  if (oTipoRelatorio != 0 && oTipoFiltro == 1) {

    if ($F('InputIntervaloInicial') == '' || $F('InputIntervaloFinal') == '') {

      alert('Por favor, informe o intervalo para geração do relatório.');
      return false;
    }
  }

  /**
   * Verifica se o tipo escolhido foi intervalo 
   */
  if (oTipoFiltro == 1) {
     
    oQuery.iIntervaloInicial = $F('InputIntervaloInicial');
    oQuery.iIntervaloFinal   = $F('InputIntervaloFinal');
  }

  /**
   * Verifica se o tipo escolhido foi seleção
   */
  if (oTipoFiltro == 2) {
     
    var aSelecionados = [];
    var oTipoFiltros  = oTiposFiltrosFolha.getLancadorAtivo().getRegistros();

    /**
     * Percorre os itens selecionados no lancador
     */
    oTipoFiltros.each (function(oFiltro, iIndice) {
      aSelecionados[iIndice] = oFiltro.sCodigo;
    });
     
    oQuery.iRegistros = aSelecionados;
  }

  obj=document.form1;
  query="";

  if(document.form1.r48_semest){
    query+= "&semest="+document.form1.r48_semest.value;
  }
  query+="&selecao="+document.form1.selecao.value;
  query+="&ordem="+document.form1.ordem.value;
  query+="&num_vias="+document.form1.num_vias.value;
  jan = window.open('pes2_contra_cheque.php?opcao='+document.form1.folha.value+'&ano='+document.form1.xano.value+'&mes='+document.form1.xmes.value+'&msg='+document.form1.mensagem1.value+query+'&json=' + Object.toJSON(oQuery),'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}
var oTiposFiltrosFolha;
(function() {
  console.log("aqui ");
  oTiposFiltrosFolha     = new DBViewFormularioFolha.DBViewTipoFiltrosFolha(<?=db_getsession("DB_instit")?>);
  oTiposFiltrosFolha.sInstancia     = 'oTiposFiltrosFolha';
  oTiposFiltrosFolha.show($('containnerTipoFiltrosFolha'));
})();
</script>
