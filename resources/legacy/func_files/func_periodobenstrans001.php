<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bensbaix_classe.php");
$clbensbaix = new cl_bensbaix;
$clrotulo = new rotulocampo;
$clbensbaix->rotulo->label();
db_postmemory($HTTP_POST_VARS);
$t93_dataINI="";
$t93_dataFIM = "";

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?php
  db_app::load("scripts.js,
                strings.js,
                prototype.js,
                datagrid.widget.js,
                widgets/DBLancador.widget.js,
                estilos.css,
                grid.style.css");

  db_app::load("widgets/windowAux.widget.js,
                  widgets/dbtextField.widget.js,
                  dbmessageBoard.widget.js,
                  dbcomboBox.widget.js,
                  prototype.maskedinput.js,
                  DBTreeView.widget.js,
                  arrays.js");
?>

<script>
function js_abre(botao){
  var sURL = 'func_periodobenstrans002.php';
  dataINI="";
  dataFIM="";
  if(document.form1.t93_dataINI_dia.value!="" && document.form1.t93_dataINI_mes.value!="" && document.form1.t93_dataINI_ano.value!=""){
    dataINI = document.form1.t93_dataINI_ano.value+'-'+document.form1.t93_dataINI_mes.value+'-'+document.form1.t93_dataINI_dia.value;
    inicio= new Date(document.form1.t93_dataINI_ano.value,document.form1.t93_dataINI_mes.value-1,document.form1.t93_dataINI_dia.value);
  }
  if(document.form1.t93_dataFIM_dia.value!="" && document.form1.t93_dataFIM_mes.value!="" && document.form1.t93_dataFIM_ano.value!=""){
    dataFIM = document.form1.t93_dataFIM_ano.value+'-'+document.form1.t93_dataFIM_mes.value+'-'+document.form1.t93_dataFIM_dia.value;
    fim= new Date(document.form1.t93_dataFIM_ano.value,document.form1.t93_dataFIM_mes.value-1,document.form1.t93_dataFIM_dia.value);
  }

 ordem = document.form1.ordem.value;


  if (!(dataINI && dataFIM)) {
    alert('Datas não informadas. Favor, preencha-as');
    return;
  }

  if ( dataINI != "" && dataFIM != "" && fim < inicio ) {
    alert(_M("patrimonial.patrimonio.func_periodobenstrans002.data_inicial_menor_data_final"));
    document.form1.t93_dataINI_dia.focus();
  }else{
    if(botao=="relatorio"){
      sURL += '?dataINI=' + dataINI + '&dataFIM=' + dataFIM;
      sURL += '&ordem='+ ordem;
      jan = window.open(sURL, '', 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
    }
    jan.moveTo(0,0);
  }
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="30" onLoad="a=1">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
  </tr>
</table >

<form name="form1" method="post">
  <table align="center" border='0'>

      <tr>
       <td colspan="3">
         <div id="ctnDepartamentoOrigem"></div>
       </td>
      </tr>

      <tr>
        <td colspan=3 >
          <div id='ctnDptoDestino'></div>
        </td>
      </tr>

      <tr>
        <td>
            <tr id='ordem' style='display:""'>
                <td align="left"  title="">
                  <strong>Ordenar por:</strong>
                </td>
                <td>
                 <?
                 $tipo_ordem = array(
                    "selecione" => "Selecione",
                    "codigo" => "Cod. de Transferência",
                    "data" => "Data de Transferência",
                    "destino" => "Destino",
                    "origem" => "Origem",
                    "placa" => "Placa",
                    "usuario" => "Usuário"

                  );
                 db_select("ordem",$tipo_ordem,true,2); ?>
                </td>
            </tr>
            <tr>
              <td title="Bens baixados no intervalo de data"> <? db_ancora('Período:',"js_pesquisa_bem(true);",3);?>  </td>
              <td align="left">
                <?
                  db_inputdata('t93_dataINI',@$t93_dataINI_dia,@$t93_dataINI_mes,@$t93_dataINI_ano,true,'text',1,"");
                ?>
                <b>a</b>
                <?
                  db_inputdata('t93_dataFIM',@$t93_dataFIM_dia,@$t93_dataFIM_mes,@$t93_dataFIM_ano,true,'text',1,"");
                ?>
              </td>
            </tr>
              <tr>
               <td colspan="3" align="center">
                 <br>
                 <input name="relatorio" id="relatorio" type="button" onclick='js_abre(this.name);'  value="Gerar relatório">
               </td>
              </tr>
        </td>
      </tr>
  </table>
</form>



  <!-- </center> -->
  <? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>


  </body>
  </html>

  <script type="text/javascript">
    var oLancadorDestino = new DBLancador('LancadorDestino');
        oLancadorDestino.setLabelAncora("Depart.:");
        oLancadorDestino.setTextoFieldset("Departamentos - Destino");
        oLancadorDestino.setTituloJanela("Pesquisar Departamentos - Destino");
        oLancadorDestino.setNomeInstancia("oLancadorDestino");
        oLancadorDestino.setParametrosPesquisa("func_db_depart.php", ["coddepto", "descrdepto"]);
        oLancadorDestino.setGridHeight(150);
        oLancadorDestino.show($("ctnDptoDestino"));

    var oLancadorOrigem = new DBLancador('LancadorOrigem');
        oLancadorOrigem.setLabelAncora("Depart.:");
        oLancadorOrigem.setTextoFieldset("Departamentos - Origem");
        oLancadorOrigem.setTituloJanela("Pesquisar Departamentos - Origem");
        oLancadorOrigem.setNomeInstancia("oLancadorOrigem");
        oLancadorOrigem.setParametrosPesquisa("func_db_depart.php", ["coddepto", "descrdepto"]);
        oLancadorOrigem.setGridHeight(150);
        oLancadorOrigem.show($("ctnDepartamentoOrigem"));

  </script>
