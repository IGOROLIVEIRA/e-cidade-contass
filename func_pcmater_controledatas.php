<?php
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
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

include("classes/db_pcmater_classe.php");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);

$clpcmater = new cl_pcmater;
$clpcmater->rotulo->label("pc01_codmater");
$clpcmater->rotulo->label("pc01_descrmater");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
            <form name="form1" method="post" action="" >
                <tr>
                    <td width="4%" align="right" nowrap title="<?=$Tpc01_codmater?>"><?=$Lpc01_codmater?></td>
                    <td width="96%" align="left" nowrap><?php db_input("pc01_codmater", 6, $Ipc01_codmater, true, "text", 4, "", "chave_pc01_codmater"); ?> </td>
                </tr>
                <tr>
                    <td width="4%" align="right" nowrap title="<?=$Tpc01_descrmater?>"> <?=$Lpc01_descrmater?></td>
                    <td width="96%" align="left" nowrap><?php db_input("pc01_descrmater", 80, $Ipc01_descrmater, true, "text", 4, "", "chave_pc01_descrmater"); ?></td>
                </tr>
                <tr>
                    <td width="4%" align="right" nowrap title="Selecionar todos, ativos ou inativos"><b>Seleção por:</b></td>
                    <td width="96%" align="left" nowrap>
                        <?php
                        if(!isset($opcao)){
                            $opcao = "f";
                        }
                        if(!isset($opcao_bloq)){
                            $opcao_bloq = 1;
                        }
                        $arr_opcao = array("i"=>"Todos","f"=>"Ativos","t"=>"Inativos");
                        db_select('opcao',$arr_opcao,true,$opcao_bloq);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                        <input name="limpar" type="button" id="limpar" value="Limpar">
                        <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_pcmater.hide();">
                    </td>
                </tr>
            </form>
        </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
        <?php
        if (!isset($campos)) {
            if (file_exists("funcoes/db_func_pcmater.php")) {
                include("funcoes/db_func_pcmater.php");
            } else {
                $campos = "pcmater.*";
            }
        }

        $campos = " distinct ". $campos;

        $where_ativo = "";
        if (isset($opcao) && trim($opcao)!="i") {
            $where_ativo = " and pc01_ativo='$opcao' ";
        }

        if($filtra_atuais == 'true'){
            $where_ativo = $where_ativo ? $where_ativo . " AND " : $where_ativo;
            $where_ativo .= " extract(year from pc01_data) <= " . db_getsession('DB_anousu');
        }
        $where_ativo .= " and pc01_instit in (" . db_getsession('DB_instit').",0)";

        if (isset($chave_pc01_codmater) && (trim($chave_pc01_codmater) !== "") ) {
            $sWhere = " pc01_codmater = {$chave_pc01_codmater}";
            $sql = $clpcmater->sql_query(null, $campos, "pc01_codmater desc", "$sWhere $where_ativo");
        } else if (isset($chave_pc01_descrmater) && (trim($chave_pc01_descrmater)!="")) {
            $sql = $clpcmater->sql_query("",$campos,"pc01_descrmater"," pc01_descrmater like '$chave_pc01_descrmater%'  $where_ativo");
        } else {
            $sql = $clpcmater->sql_query("",$campos,"pc01_descrmater","1=1 $where_ativo");
        }

        db_lovrot($sql ,15,"()","",$funcao_js,"","NoMe",array(),false);
      ?>
     </td>
   </tr>
</table>
</body>
<script>
    let selecaoPor = document.getElementById('opcao');
    const limparCampos = document.getElementById('limpar');
    const camposInput = document.getElementsByTagName('input');

    selecaoPor.addEventListener('change', () => {
        document.form1.submit();
    });

    limparCampos.addEventListener('click', () => {
        Array.from(camposInput).forEach(
            function(element) {
                if (element.name === 'chave_pc01_codmater' || element.name === 'chave_pc01_descrmater') {
                    element.value = '';
                }
            }
        );

        selecaoPor.options[1].selected = true;
        document.form1.submit();
    });
</script>
</html>
