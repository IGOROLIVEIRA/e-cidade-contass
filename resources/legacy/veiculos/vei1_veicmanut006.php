<?

/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
//ini_set("display_errors","on");
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_app.utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_veiculos_classe.php");
include("classes/db_veicmanut_classe.php");
include("classes/db_veicmanutitem_classe.php");
include("classes/db_veicmanutoficina_classe.php");
include("classes/db_veicmanutretirada_classe.php");
include("classes/db_veicretirada_classe.php");
include("classes/db_veicabast_classe.php");
include("classes/db_veictipoabast_classe.php");
include("classes/db_veicmanutitempcmater_classe.php");
require_once("classes/db_pcmater_classe.php");
require_once("classes/db_condataconf_classe.php");
db_app::import("veiculos.*");

$clveiculos = new cl_veiculos;
$clveicmanut = new cl_veicmanut;
$clveicmanutitem = new cl_veicmanutitem;
$clveicmanutoficina = new cl_veicmanutoficina;
$clveicmanutretirada = new cl_veicmanutretirada;
$clveicretirada      = new cl_veicretirada;
$clveicabast = new cl_veicabast;

$clveictipoabast     = new cl_veictipoabast;
$clveicmanutitempcmater = new cl_veicmanutitempcmater;

db_postmemory($HTTP_POST_VARS);
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();
      db_query("delete from veicmanutitempcmater where ve64_veicmanutitem in (select ve63_codigo from veicmanutitem where ve63_veicmanut = ".$ve62_codigo." )");
    db_query("delete from veicmanutitem where ve63_veicmanut = ".$ve62_codigo."");
  if ($sqlerro==false){
    $result_oficina=$clveicmanutoficina->sql_record($clveicmanutoficina->sql_query(null,"*",null,"ve66_veicmanut=$ve62_codigo"));
    if($clveicmanutoficina->numrows>0){
      $clveicmanutoficina->excluir(null,"ve66_veicmanut=$ve62_codigo");
      if ($clveicmanutoficina->erro_status=="0"){
        $erro_msg=$clveicmanutoficina->erro_msg;
        $sqlerro=true;
      }
    }
  }
  if ($sqlerro==false){
    $result_retirada=$clveicmanutretirada->sql_record($clveicmanutretirada->sql_query(null,"*",null,"ve65_veicmanut=$ve62_codigo"));
    if($clveicmanutretirada->numrows>0){
      $clveicmanutretirada->excluir(null,"ve65_veicmanut=$ve62_codigo");
      if ($clveicmanutretirada->erro_status=="0"){
        $erro_msg=$clveicmanutretirada->erro_msg;
        $sqlerro=true;
      }
    }
  }
//  /**
//   * Verificar Encerramento Periodo Contabil
//   */
//  $dtmanut = db_utils::fieldsMemory(db_query($clveicmanut->sql_query_file($ve62_codigo,"ve62_dtmanut")),0)->ve62_dtmanut;
//  if (!empty($dtmanut)) {
//    $clcondataconf = new cl_condataconf;
//    if (!$clcondataconf->verificaPeriodoContabil($dtmanut)) {
//      $sqlerro  = true;
//      $erro_msg=$clcondataconf->erro_msg;
//    }
//  }

    /**
   * Verificar Encerramento Periodo Patrimonial
   */
  $dtmanut = db_utils::fieldsMemory(db_query($clveicmanut->sql_query_file($ve62_codigo,"ve62_dtmanut")),0)->ve62_dtmanut;
  if (!empty($dtmanut)) {
    $clcondataconf = new cl_condataconf;
    if (!$clcondataconf->verificaPeriodoPatrimonial($dtmanut)) {
      $sqlerro  = true;
      $erro_msg=$clcondataconf->erro_msg;
    }
  }


  if ($sqlerro==false){
    $clveicmanut->excluir($ve62_codigo);
    if($clveicmanut->erro_status==0){
      $sqlerro=true;
    }
    $erro_msg = $clveicmanut->erro_msg;
  }
  db_fim_transacao($sqlerro);
   $db_opcao = 3;
   $db_botao = true;
}
if(isset($chavepesquisa)){

  $db_opcao = 3;
  $result = $clveicmanut->sql_record($clveicmanut->sql_query($chavepesquisa));
  db_fieldsmemory($result,0);
  $result_oficina=$clveicmanutoficina->sql_record($clveicmanutoficina->sql_query(null,"*",null,"ve66_veicmanut=$chavepesquisa"));
  if($clveicmanutoficina->numrows>0){
    db_fieldsmemory($result_oficina,0);
  }
  $result_retirada=$clveicmanutretirada->sql_record($clveicmanutretirada->sql_query(null,"*",null,"ve65_veicmanut=$ve62_codigo"));
  if($clveicmanutretirada->numrows>0){
    db_fieldsmemory($result_retirada,0);
  }

  $result = $clveiculos->sql_record($clveiculos->sql_query($ve62_veiculos,"ve01_veictipoabast"));
  db_fieldsmemory($result,0);

  $result_veictipoabast = $clveictipoabast->sql_record($clveictipoabast->sql_query($ve01_veictipoabast,"ve07_sigla"));
  if ($clveictipoabast->numrows > 0){
    db_fieldsmemory($result_veictipoabast,0);
  }
  $sSqlItens = db_query("select * from veicmanutitem inner join veicmanut on veicmanut.ve62_codigo = veicmanutitem.ve63_veicmanut inner join veiccadtiposervico on veiccadtiposervico.ve28_codigo = veicmanut.ve62_veiccadtiposervico left join veicmanutitempcmater on ve64_veicmanutitem = ve63_codigo left join pcmater on ve64_pcmater = pc01_codmater where ve63_veicmanut = ".$chavepesquisa);

  $rSqlItens = db_utils::getColectionByRecord($sSqlItens);


}


  $db_botao = true;
  ?>
  <html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="javascript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="javascript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      .cabec {
        text-align: left;
        font-size: 10;
        color: darkblue;
        background-color: #aacccc;
        border: 1px solid $FFFFFF;
      }
      .corpo {
        font-size: 9;
        color: black;
        background-color: #ccddcc;
      }
    </style>
  </head>
  <body bgcolor="#CCCCCC" style='margin-right: 25px' leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
   <?
    /**
     * Alteração realizada para atender os diversis layouts do SICOM. Para cada ano, existem atualizações
     * nos formularios que conflitam entre se. Portanto foi adotado que fossem criados formulários específicos
     * para cada ano.
     */

    if(db_getsession('DB_anousu') > 2015)

      include("forms/db_frmveicmanutcstitens.php");
    else
      include("forms/db_frmveicmanut.php");
    ?>
  </body>
  <script type="text/javascript">
   <?php
   if(!isset($chavepesquisa)){
    echo "js_pesquisa();";
  }
  ?>
  function js_pesquisa() {
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_veicmanut', 'db_iframe_veicmanut', 'func_veicmanut.php?funcao_js=parent.js_preenchepesquisa|ve62_codigo', 'Pesquisa', true, '0');
  }

  function js_preenchepesquisa(chave) {
    db_iframe_veicmanut.hide();
    <?

    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";

    ?>
  }
</script>
</html>
<?
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clveicmanut->erro_campo!=""){
      echo "<script> document.form1.".$clveicmanut->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clveicmanut->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
 echo "
  <script>
    function js_db_tranca(){
      parent.location.href='vei1_veicmanut003.php';
    }\n
    js_db_tranca();
  </script>\n
 ";
  }
}
?>
