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
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_liccomissaocgm_classe.php");
require_once("classes/db_liccomissao_classe.php");
require_once("classes/db_liclicita_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clliccomissaocgm = new cl_liccomissaocgm;
$clliccomissao = new cl_liccomissao;
$clliclicita   = new cl_liclicita;
$db_opcao = 22;
$db_botao = false;
$oPost = db_utils::postMemory($_POST);

if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
/*
$clliccomissaocgm->l31_codigo = $l31_codigo;
$clliccomissaocgm->l31_liccomissao = $l31_liccomissao;
$clliccomissaocgm->l31_numcgm = $l31_numcgm;
*/
}
$cpf = $oPost->z01_cgccpf;
$cpfCnpj = false;
if($cpf != null){
    if($cpf == '00000000000'){
      $sigla = 'CPF';
    }else if($cpf  == '00000000000000'){
      $sigla = 'CNPJ';
    }else if($cpf == ''){
      $sigla = 'CPF/CNPJ';
    }else $cpfCnpj = true;

    if(!$cpfCnpj){
        echo "<script>alert('O CGM selecionado n�o possui ".$sigla.", corrija o cadastro e em seguida tente novamente.')</script>";
    }
}


if(isset($incluir) && $cpfCnpj){
   if($sqlerro==false){

    db_inicio_transacao();
    $clliccomissaocgm->l31_licitacao = $l31_licitacao;
    $clliccomissaocgm->incluir(null);
    $erro_msg = $clliccomissaocgm->erro_msg;
    if($clliccomissaocgm->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);

          $clliclicita->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $l31_licitacao and pc50_pctipocompratribunal in (100,101,102,103)"));

          if ($clliclicita->numrows > 0) {

              $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7)"));
              if ($clliccomissaocgm->numrows == 7) {
                  $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
                  echo $script;
              }

          }else {

              if ($l20_naturezaobjeto == 6) {

                  $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7,8,9)"));
                  if ($clliccomissaocgm->numrows == 9) {
                      $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
                      echo $script;
                  }

              } else {
                  $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7,8)"));
                  if ($clliccomissaocgm->numrows == 8) {
                      $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
                      echo $script;
                  }
              }

          }
      }
      $clliccomissaocgm->l31_licitacao = $l31_licitacao;


}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clliccomissaocgm->l31_licitacao = $l31_licitacao;
    $clliccomissaocgm->alterar($l31_codigo);
    $erro_msg = $clliccomissaocgm->erro_msg;
    if($clliccomissaocgm->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clliccomissaocgm->excluir($l31_codigo);
    $erro_msg = $clliccomissaocgm->erro_msg;
    if($clliccomissaocgm->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);

  }
}else if(isset($opcao)){

  $result = $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file(null,"*",null,"l31_codigo=$l31_codigo"));

  if($result!=false && $clliccomissaocgm->numrows>0){
     db_fieldsmemory($result,0);
   }

  $clliclicita->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $l31_licitacao and pc50_pctipocompratribunal in (100,101,102,103)"));

  if ($clliclicita->numrows > 0) {

    $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7)"));
    if ($clliccomissaocgm->numrows == 7) {
      $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
      echo $script;
    }

  }else {

    if ($l20_naturezaobjeto == 6) {

      $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7,8,9)"));
      if ($clliccomissaocgm->numrows == 9) {
        $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
        echo $script;
      }

    } else {
      $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7,8,9)"));
      if ($clliccomissaocgm->numrows == 8) {
        $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
        echo $script;
      }
    }

  }
}


$result = $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query(null,"
l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm),
               case
               when l31_tipo::varchar = '1' then '1-Autoriza��o para abertura do procedimento licitat�rio'
               when l31_tipo::varchar = '2' then '2-Emiss�o do edital'
               when l31_tipo::varchar = '3' then '3-Pesquisa de pre�os'
               when l31_tipo::varchar = '4' then '4-Informa��o de exist�ncia de recursos or�ament�rios'
               when l31_tipo::varchar = '5' then '5-Condu��o do procedimento licitat�rio'
               when l31_tipo::varchar = '6' then '6-Homologa��o'
               when l31_tipo::varchar = '7' then '7-Adjudica��o'
               when l31_tipo::varchar = '8' then '8-Publica��o em �rg�o Oficial'
               end as l31_tipo
",null,"l31_codigo=$l31_codigo"));

if($result!=false && $clliccomissaocgm->numrows>0){
  db_fieldsmemory($result,0);
}

$clliclicita->sql_record($clliclicita->sql_query('', '*', '', "l20_codigo = $l31_licitacao and pc50_pctipocompratribunal in (100,101,102,103)"));

if ($clliclicita->numrows > 0) {

  $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7)"));

  if ($clliccomissaocgm->numrows == 7) {
    $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
    echo $script;
  }

}else {

  if ($l20_naturezaobjeto == 6) {

    $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7,8,9)"));
    if ($clliccomissaocgm->numrows == 9) {
      $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
      echo $script;
    }

  } else {
    $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file('', 'distinct l31_tipo', '', "l31_licitacao = $l31_licitacao
    and l31_tipo::int in (1,2,3,4,5,6,7,8,9)"));
    if ($clliccomissaocgm->numrows == 8) {
      $script = "<script>parent.document.formaba.liclicitem.disabled=false;
      </script>";
      echo $script;
    }
  }

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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmresplicitacao.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){

    //    db_msgbox($erro_msg);

    if($clliccomissaocgm->erro_campo!=""){
        echo "<script> document.form1.".$clliccomissaocgm->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clliccomissaocgm->erro_campo.".focus();</script>";
    }
    if ($sqlerro==false){
    	echo "<script>location.href='lic1_resplicitacao001.php?l31_licitacao=$l31_licitacao&l20_codtipocom=$l20_codtipocom';</script>";
    }
}
?>