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

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_usuariosonline.php");
include("libs/db_liborcamento.php");
include("classes/db_lote_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_empempenho_classe.php");
include("classes/db_empresto_classe.php");
include("classes/db_empparametro_classe.php");
include("classes/db_orctiporec_classe.php");

$clpcmater  = new cl_pcmater;
$clcgm    = new cl_cgm;
$clempempenho = new cl_empempenho;

$clrotulo = new rotulocampo;
$clrotulo->label("e53_codord");
$clrotulo->label("k17_codigo");
$clpcmater->rotulo->label();
$clcgm->rotulo->label();
$clempempenho->rotulo->label();
//---  parser POST/GET
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
  select {
    width: 244;
  }
</style>
</head>
<body bgcolor=#CCCCCC bgcolor="#CCCCCC"  >
<center>
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="" align="left" valign="top" bgcolor="#CCCCCC">
       <form name="form1" method="post" action="">
    <table>
       <tr>
       <td>
        <br>
           <fieldset>
            <legend>Relatório Financeiro</legend>
           <table>
           <tr>
              <td>
                <strong>Data da Autorização: </strong>
              </td>
              <td>
                <?
                  db_inputdata("dtini","","","",true,"text",2);
                ?>
                <strong>a: </strong>
                <?
                  db_inputdata("dtfim","","","",true,"text",2);
                ?>
              </td>
            </tr>
            <tr>
              <td>
                  <strong>Filtros de Listagem:</strong>
              </td>
              <td>
                <?
                  $filtros = array(
                             ""=>"Selecione",
                             "sp"=>"Saldo a Pagar",
                             "tp"=>"Pagas",
                             "a"=>"Anuladas",
                             "pa"=>"Parcialmente Anuladas"
                            );

                  db_select("filtro",$filtros,true,"text",2,"");
                ?>
              </td>
          </tr>
          <tr>
            <td>
                <strong>Ordenar por:</strong>
            </td>
            <td>
              <?
                $ordem = array(
                           ""=>"Selecione",
                           "nos"=>"Nº Ord/Slip",
                           "da"=>"Data Autorização",
                           "dos"=>"Data OP/Slip",
                           "p"=>"Protocolo",
                           "s"=>"Situação"
                          );

                db_select("ordem",$ordem,true,"text",2,"");
              ?>
            </td>
          </tr>
          <tr>
            <td>
                <strong>Quebra:</strong>
            </td>
            <td>
              <?
                $quebra = array(
                           ""=>"Selecione",
                           "cr"=>"Credor",
                           "re"=>"Recurso",
                           "si"=>"Situação"
                          );

                db_select("quebra",$quebra,true,"text",2,"");
              ?>
            </td>
          </tr>
          <tr>
            <td>
                <strong>Tipo de Impressão:</strong>
            </td>
            <td>
              <?
                $tipo = array(
                           "a"=>"Analítico",
                           "s"=>"Sintético"
                          );

                db_select("tpimpressao",$tipo,true,"text",2,"");
              ?>
            </td>
          </tr>
          <tr>
            <td align="left" nowrap title="<?=$Te53_codord?>">
              <? db_ancora(@$Le53_codord,"js_buscae53_codord(true)",1); ?>
            </td>
            <td align="left" nowrap>
              <?
                db_input("e53_codord",7,$Ie53_codord,true,"text",4,"");
              ?>
            </td>
          </tr>
          <tr>
            <td  align="left" nowrap title="<?=$Te60_codemp?>">
              <? db_ancora(@$Le60_codemp,"js_pesquisae60_codemp(true);",1);  ?>
            </td>
            <td  nowrap="nowrap" title='<?=$Te60_codemp?>' >
              <?
                db_input("e60_codemp",7,$Ie60_codemp,true,"text",4,"onchange='js_pesquisae60_codemp(false);'");
              ?>
            </td>
          </tr>
          <tr>
            <td align="left" nowrap title="<?=$Tk17_codigo?>">
               <? db_ancora(@$Lk17_codigo,"js_pesquisak17_codigo(true);");  ?>
            </td>
            <td align="left" nowrap>
              <?
                db_input('k17_codigo',7,$Ik17_codigo,true,'text',$db_opcao,"") ;
              ?>
            </td>
          </tr>
          <tr>
            <td  align="left" nowrap title="<?=$Tz01_numcgm?>">
              <?
                 db_ancora($Lz01_numcgm,"js_pesquisaz01_numcgm(true);",1);
              ?>
            </td>
            <td align="left" nowrap>
              <?
                 db_input("z01_numcgm",7,$Iz01_numcgm,true,"text",1,"");
                 db_input("z01_nome",24,$Iz01_nome,true,"text",3);
              ?>
            </td>
          </tr>
    </table>
    </fieldset>
    </td>
      <tr>
        <td colspan="2" align="center"><br>
         <input type="button" value="Imprimir" onClick="js_emite()">
        </td>
      </tr>
   </form>
   </td>
  </tr>
</table>
</center>
  <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
</body>
</html>

<script>

function js_buscae53_codord(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_pagordemele','func_prot_pagordemele.php?funcao_js=parent.js_mostracodord1|e53_codord','Pesquisa',true);
  }
}

function js_mostracodord1(chave1){
  document.form1.e53_codord.value   = chave1;
  db_iframe_pagordemele.hide();

}

function js_pesquisae60_codemp(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_empempenho2','func_empempenho.php?funcao_js=parent.js_mostraempempenho2|e60_codemp|e60_anousu','Pesquisa',true);
  }
}

function js_mostraempempenho2(chave1, chave2){
  document.form1.e60_codemp.value = chave1+"/"+chave2;
  db_iframe_empempenho2.hide();
}

function js_pesquisak17_codigo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_slip','func_slip.php?protocolo=1&funcao_js=parent.js_mostraslip1|k17_codigo','Pesquisa',true);
  }
}

function js_mostraslip1(chave1){
  document.form1.k17_codigo.value = chave1;
  db_iframe_slip.hide();
}

function js_pesquisaz01_numcgm(mostra)
{
  if(mostra==true)
  {
    js_OpenJanelaIframe('CurrentWindow.corpo','func_nome','func_nome.php?funcao_js=parent.js_mostranumcgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }
}

function js_mostranumcgm1(chave1,chave2)
{
  document.form1.z01_numcgm.value = chave1;
  document.form1.z01_nome.value   = chave2;
  func_nome.hide();
}

function js_emite(){
  var dtini      = document.form1.dtini.value;
  var dtfim      = document.form1.dtfim.value;
  var filtro     = document.form1.filtro.value;
  var ordem      = document.form1.ordem.value;
  var quebra     = document.form1.quebra.value;
  var tpimpressao = document.form1.tpimpressao.value;
  var e53_codord = document.form1.e53_codord.value;
  var e60_codemp = document.form1.e60_codemp.value;
  var k17_codigo = document.form1.k17_codigo.value;
  var z01_numcgm = document.form1.z01_numcgm.value
  var query = "";
  query += ("dtini="+dtini+"&dtfim="+dtfim+"&filtro="+filtro+"&ordem="+ordem+"&quebra="+quebra+"&tpimpressao="+tpimpressao+
    "&e53_codord="+e53_codord+"&e60_codemp="+e60_codemp+"&k17_codigo="+k17_codigo+"&z01_numcgm="+z01_numcgm),

  jan = window.open(
    "pro2_protocolorelfinanceiro002.php?" + query,
    "",
    'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
  );
  jan.moveTo(0,0);
}

</script>
