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
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_utils.php");
include("classes/db_rhrubricas_classe.php");
include("classes/db_baserubricasesocial_classe.php");
require_once("classes/db_rubricasesocial_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clbases = new cl_rhrubricas;
$clbaserubricasesocial = new cl_baserubricasesocial;
$clrubricasesocial  = new cl_rubricasesocial;

$db_opcao = 22;
$db_botao = false;

if(isset($salvar)){

  db_inicio_transacao();
  $clbaserubricasesocial->excluir(null,$e990_sequencial,db_getsession("DB_instit"));
  $aBaseManter = null;
  if ($e990_sequencial == '1000' || $e990_sequencial == '6000') {
    $aBaseManter = array("'1000'","'6000'");
  } else if ($e990_sequencial == '1020' || $e990_sequencial == '6006' || $e990_sequencial == '6007') {
    $aBaseManter = array("'1020'","'6006'","'6007'");
  }
  foreach($basesSelecionados as $cod){
    //tira a rubrica de outra tabela exceto as rubricas 2000 e 4000 e base 1000
    if ($cod[0] != '2' && $cod[0] != '4') {
      $clbaserubricasesocial->excluir($cod,null,db_getsession("DB_instit"), $aBaseManter);
    }
    //insere na tabela pivô
    $clbaserubricasesocial->e991_rubricasesocial = $e990_sequencial;
    $clbaserubricasesocial->e991_rubricas = $cod;
    $clbaserubricasesocial->e991_instit = db_getsession("DB_instit");
    $clbaserubricasesocial->incluir();
    if($clbaserubricasesocial->erro_status == 0){
      db_fim_transacao(true);
      db_msgbox($clbaserubricasesocial->erro_banco);

    }
  }
  if($clbaserubricasesocial->erro_status == 1){
    db_msgbox("Registros inseridos.");
  }
  db_fim_transacao(false);
  echo '<script type="text/javascript">';
  echo " parent.location.href='pes2_rubricasesocial002.php?liberaaba=true&chavepesquisa=$e990_sequencial' ";
  echo '</script>';

}
if(isset($chavepesquisa)){

 $db_opcao = 2;

 $result = $clbases->sql_record($clbases->sql_query(null,db_getsession("DB_instit"), "rhrubricas.rh27_rubric,
           rhrubricas.rh27_descr,
           rhrubricas.rh27_presta,
           case
             when rhrubricas.rh27_pd = 1 then 'PROVENTO'
             when rhrubricas.rh27_pd = 2 then 'DESCONTO'
             else 'BASE'
           end as rh27_pd,
           rhrubricas.rh27_form,
           rhrubricas.rh27_limdat,
           case
              when trim(rh27_form)='' then 'f'
              else 't'
           end as DB_formula,
           rh27_tipo as DB_rh27_tipo,
           rh27_obs", "rh27_rubric asc" ));
 $aBases = db_utils::getColectionByRecord($result);
 //bases vinculadas à tabela da consulta
 $result = $clbaserubricasesocial->sql_record("SELECT * FROM baserubricasesocial WHERE e991_rubricasesocial = '{$chavepesquisa}' AND e991_instit = ".db_getsession('DB_instit')."");
 $aBasesEsocial = db_utils::getColectionByRecord($result);
 //bases vinculadas à outras tabela da consulta
 $sWhere = "<> '{$chavepesquisa}'";
 if ($chavepesquisa == '1000' || $chavepesquisa == '6000') {
   $sWhere = "NOT IN ('1000','6000')";
 } else if ($chavepesquisa == '1020' || $chavepesquisa == '6006' || $chavepesquisa == '6007') {
   $sWhere = "NOT IN ('1020','6006','6007')";
 }
 $result = $clbaserubricasesocial->sql_record("SELECT e991_rubricas FROM baserubricasesocial WHERE e991_rubricasesocial {$sWhere} AND e991_instit = ".db_getsession('DB_instit')."");
 $aBasesEsocialOutras = db_utils::getColectionByRecord($result);
 $JSONaBasesEsocialOutras = "";
 foreach ($aBasesEsocialOutras as $b) {
   $JSONaBasesEsocialOutras[] = $b->e991_rubricas;
 }
 $JSONaBasesEsocialOutras = json_encode($JSONaBasesEsocialOutras);

 $rubrica = $clrubricasesocial->sql_query($chavepesquisa);
 $orubrica = $clrubricasesocial->sql_record($rubrica);

 $bases = array();
 $basesSelecionados = array();

 foreach ($aBases as $b) {

   $bases[$b->rh27_rubric] = $b->rh27_rubric.' | ';
   $bases[$b->rh27_rubric] .= $b->rh27_descr;
   $bases[$b->rh27_rubric] .= ' | '.$b->rh27_pd;

 }
 foreach ($aBasesEsocial as $b) {
   $basesSelecionados[$b->e991_rubricas] = $bases[$b->e991_rubricas];
 }

 db_fieldsmemory($orubrica);
 $db_botao = true;
}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1"
bgcolor="#cccccc">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <center>
        <?
        include("forms/db_frmbasesrubricasesocial.php");
        ?>
      </center>
    </td>
  </tr>
</table>

</body>
</html>
