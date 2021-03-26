<?PHP
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_inventario_classe.php");
require_once("classes/db_inventarioanulado_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);

$clinventario        = new cl_inventario;
$clinventarioanulado = new cl_inventarioanulado;
$clrotulo            = new rotulocampo;
$db_botao            = true;

$clinventario->rotulo->label();
$clinventarioanulado->rotulo->label();
$clrotulo->label("p58_codproc");
$clrotulo->label("ac08_descricao");

db_app::load("scripts.js");
db_app::load("prototype.js");
db_app::load("strings.js");
db_app::load("estilos.css");
db_app::load("datagrid.widget.js");
db_app::load("strings.js");
db_app::load("grid.style.css");
db_app::load("estilos.css");

$db_opcao = 3;

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC>
  <form class="container" name="form1" method="post" action="">
    <fieldset>
      <legend>Desprocessar inventário</legend>
      <table class="form-container">
        <tr>
          <td nowrap title="<?php echo $Tt75_sequencial?>">
           <?php
           db_ancora('<b>Inventário:</b>',"js_pesquisa();", 1);
           ?>
         </td>
         <td>
          <?php
          db_input('iInventario', 10, $It75_sequencial, true, 'text',3);
          ?>
        </td>
      </tr>

      <tr>
        <td nowrap title="<?php echo $Tt75_dataabertura ?>">
         <?php echo $Lt75_dataabertura ?>
       </td>
       <td>
        <?php
        db_inputdata('t75_dataabertura',
          @$t75_dataabertura_dia,
          @$t75_dataabertura_mes,
          @$t75_dataabertura_ano,
          true,
          'text',
          3,
          "");
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?php echo $Tt75_periodoinicial?>">
         <?php echo $Lt75_periodoinicial?>
       </td>
       <td>
        <?php
        db_inputdata('t75_periodoinicial',@$t75_periodoinicial_dia,@$t75_periodoinicial_mes,@$t75_periodoinicial_ano,true,'text',$db_opcao,"")
        ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?php echo @$Tt75_periodofinal?>">
       <?php echo @$Lt75_periodofinal?>
     </td>
     <td>
      <?php
      db_inputdata('t75_periodofinal',@$t75_periodofinal_dia,@$t75_periodofinal_mes,@$t75_periodofinal_ano,true,'text',$db_opcao,"")
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?php echo @$Tt75_exercicio?>">
     <?php echo @$Lt75_exercicio?>
   </td>
   <td>
    <?
    db_input('t75_exercicio',10,$It75_exercicio,true,'text', 3,"")
    ?>
  </td>
</tr>
<tr>
  <td nowrap title="<?php echo @$Tt75_processo?>">
   <?php
   db_ancora(@$Lt75_processo,"js_pesquisat75_processo(true);",$db_opcao);
   ?>
 </td>
 <td>
  <?
  db_input('t75_processo',10,$It75_processo,true,'hidden',$db_opcao," onchange='js_pesquisat75_processo(false);'");
  db_input('p58_codproc',10,$Ip58_codproc,true,'text',3,'');
  ?>
</td>
</tr>
<tr>
  <td nowrap title="<?php echo @$Tt75_acordocomissao?>">
   <?
   db_ancora(@$Lt75_acordocomissao,"js_pesquisat75_acordocomissao(true);",$db_opcao);
   ?>
 </td>
 <td>
  <?
  db_input('t75_acordocomissao',10,$It75_acordocomissao,true,'text',$db_opcao," onchange='js_pesquisat75_acordocomissao(false);'");
  db_input('ac08_descricao',39,$Iac08_descricao,true,'text',3,'');
  ?>
</td>
</tr>
<tr>
  <td colspan="2">
    <fieldset class="separator">
      <legend>Observações</legend>
      <?php
      db_textarea('t75_observacao',2,70,$It75_observacao,true,'text',$db_opcao,"")
      ?>
    </fieldset>
  </td>
</tr>

</table>

<div id='ctnGridMateriais'>
</div>
</fieldset>
<br>
<input onclick='js_processar();' name="excluir" type="button" id="db_opcao" value="Desprocessar"  >
</form>

<?PHP  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
<script>

  js_pesquisa();
  js_gridMateriais();
  var sUrlRPC      = 'mat4_inventario.RPC.php';
  var oParametros  = new Object();


//   Metodo para excluir Materiais selecionados do inventario

function js_processar() {

  var iInventario     = $F('iInventario');
  var msgDiv          = "Processando...";

  oParametros.exec = 'desprocessaInventario';
  oParametros.iInventario = iInventario;


  if (iInventario == '') {

    alert('Selecione o inventário');
    return false;
  }

  js_divCarregando(msgDiv,'msgBox');

  var oAjaxLista  = new Ajax.Request(sUrlRPC,
    {method: "post",
    parameters:'json='+Object.toJSON(oParametros),
    onComplete: js_retornoProcessar
  });


}
function js_retornoProcessar(oAjax) {
  //console.log(oAjax);
  js_removeObj('msgBox');
  var oRetorno = eval("("+oAjax.responseText+")");

  alert(oRetorno.sMessage.urlDecode());

  if (oRetorno.iStatus == "1") {

    js_pesquisa();
    js_gridMateriais();
  }

}



//////////////////////////////////// METODO PARA EXIBIR Materiais DO INVENTARIO
function js_exibirMateriais() {

  var iInventario = $F('iInventario');

  var msgDiv                  = "Carregando inventário \n Aguarde ...";
  oParametros.exec            = 'getMateriaisVinculadosProcessados';
  oParametros.iInventario     = iInventario;

  if (iInventario == '') {

    alert("Selecione o inventário.");
    return false;
  }


  js_divCarregando(msgDiv,'msgBox');

  var oAjaxLista  = new Ajax.Request(sUrlRPC,
   {method: "post",
   parameters:'json='+Object.toJSON(oParametros),
   onComplete: js_retornoExibirMateriais
 });

}
function js_retornoExibirMateriais(oAjax) {


  js_removeObj('msgBox');
  var oRetorno = eval("("+oAjax.responseText+")");

  if (oRetorno.iStatus == 1) {

    oGridMateriais.clearAll(true);
    oRetorno.aDados.each(
      function (oDado, iInd) {
        console.log(oDado);

        aRow     = new Array();
        aRow[0]  = oDado.m70_codmatmater;
        aRow[1]  = oDado.m60_descr;
        aRow[2]  = oDado.descrdepto;
        aRow[3]  = oDado.m70_quant ;
        aRow[4]  = oDado.i77_contagem ;
        aRow[5]  = js_formatar(oDado.i77_valormedio, 'f')  ;
        oGridMateriais.addRow(aRow);
      });
    oGridMateriais.renderRows();
    /* $('col2').style.display="none";
    for (var i = 0; i < oRetorno.aDados.length; i++) {
      $('Interessadosrow'+i+'cell1').style.display="none";
    }*/
  } else {

    alert(oRetorno.sMessage.urlDecode());
    js_pesquisa();
    js_gridMateriais();
  }



}

/////////////////////////////////////////////////////////////////////////


/*
 * grid para exibir os Materiais do inventario selecionado
 */

 function js_gridMateriais() {

  oGridMateriais = new DBGrid('Interessados');
  oGridMateriais.nameInstance = 'oGridMateriais';
  //oGridMateriais.setCheckbox(false);
  //oGridMateriais.allowSelectColumns(true);
  oGridMateriais.setCellWidth(new Array(
    '100px' ,
    '300px' ,
    '300px',
    '100px',
    '100px',
    '100px'
    ));

  oGridMateriais.setCellAlign(new Array( 'left'  ,'left'  ,
    'left'  ,
    'left',
    'left',
    'left'
    ));


  oGridMateriais.setHeader(new Array( 'Cód. Mat',

   'Descrição',
   'Almoxarifado',
   'Estoque',
   'Contagem',
   'Preço Unitário'
   ));

  oGridMateriais.setHeight(300);
  oGridMateriais.show($('ctnGridMateriais'));
  oGridMateriais.clearAll(true);

}

function js_pesquisa(){

  var sQuery  = "func_inventario.php?situacao=3&funcao_js=parent.js_preenchepesquisa|t75_sequencial|t75_dataabertura|t75_periodoinicial|t75_periodofinal|t75_processo|t75_exercicio|t75_acordocomissao|ac08_descricao|t75_observacao";

  js_OpenJanelaIframe('CurrentWindow.corpo',
    'db_iframe_inventario',
    sQuery,
    'Pesquisa',
    true);
}
function js_mostraInventario(iInventario) {
  db_iframe_inventario.hide();
  $('iInventario').value = iInventario;
}
function js_preenchepesquisa(iSequencial,
  dDataAbertura,
  dPeriodoInicial,
  dPeriodoFinal,
  iProcesso,
  iExercicio,
  iComissao,
  sComissao,
  sObservacao
  ){

//alert(sComissao);
dDataAbertura   = js_formatar(dDataAbertura  ,'d','');
dPeriodoInicial = js_formatar(dPeriodoInicial,'d','');
dPeriodoFinal   = js_formatar(dPeriodoFinal  ,'d','');

$("iInventario")    .value = iSequencial;
$("t75_dataabertura")  .value = dDataAbertura
$("t75_periodoinicial").value = dPeriodoInicial;
$("t75_periodofinal")  .value = dPeriodoFinal;
$("p58_codproc")       .value = iProcesso;
$("t75_exercicio")     .value = iExercicio;
$("t75_acordocomissao").value = iComissao;
$("ac08_descricao")    .value = sComissao;
$("t75_observacao")    .value = sObservacao;

db_iframe_inventario.hide();
js_exibirMateriais();

}
</script>
<script>

  $("t75_sequencial").addClassName("field-size2");
  $("t75_dataabertura").addClassName("field-size2");
  $("t75_periodoinicial").addClassName("field-size2");
  $("t75_periodofinal").addClassName("field-size2");
  $("t75_exercicio").addClassName("field-size2");
  $("p58_codproc").addClassName("field-size2");
  $("t75_acordocomissao").addClassName("field-size2");
  $("ac08_descricao").addClassName("field-size7");

</script>
