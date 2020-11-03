<?
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

require("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_processoaudit_classe.php");
include("classes/db_processoauditdepart_classe.php");
require_once("dbforms/verticalTab.widget.php");

$clprocessoaudit = new cl_processoaudit;
$clprocessoaudit->rotulo->label();

$sSqlProcAudit  = $clprocessoaudit->sql_query($ci03_codproc);
$rsProcAudit    = $clprocessoaudit->sql_record($sSqlProcAudit);

if ($clprocessoaudit->numrows==0){	
	db_redireciona('db_erros.php?fechar=true&db_erro=Erro ao buscar processo.');
	exit;
}else{
	db_fieldsmemory($rsProcAudit,0);
}    

$sDeptos = '';

$clprocessoauditdepart = new cl_processoauditdepart;
$sSql = $clprocessoauditdepart->sql_query($ci03_codproc);
$rsResult = $clprocessoauditdepart->sql_record($sSql);

for ($i = 0; $i < pg_num_rows($rsResult); $i++) {

    $sDeptos .= db_utils::fieldsMemory($rsResult, $i)->descrdepto;

    if ($i < pg_num_rows($rsResult)-1) {
        $sDeptos .= ', ';
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
<link href="estilos/tab.style.css" rel="stylesheet" type="text/css">
<style type="text/css">

    .dado {
        background-color: #FFF;
        text-align: left;
    }
</style>
</head>
<body>
    <fieldset>
        <legend><b>Dados do Processo de Auditoria</b></legend>
        <table style="" border="0">
            <tr>
                <td title="<?= $Tci03_codproc ?>">
                    <?= $Lci03_codproc ?>
                </td>
                <td nowrap="nowrap" class="dado" style="width: 500px;">
                    <?= $ci03_codproc ?>
                </td>
            </tr>
            <tr>
                <td title="<?= $Tci03_numproc ?>">
                    <?= $Lci03_numproc ?>
                </td>
                <td nowrap="nowrap" class="dado">
                    <?= $ci03_numproc ?>
                </td>
                <td nowrap title="<?=@$Tci03_dataini?>" align="left" style="width: 30px;">
                    <?=@$Lci03_dataini?>
                </td>
                <td align="left" class="dado" style="width: 500px;"> 
                    <?= db_formatar($ci03_dataini, 'd') ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tci03_anoproc?>">
                    <?=@$Lci03_anoproc?>
                </td>
                <td class="dado"> 
                    <?= $ci03_anoproc ?>
                </td>
                <td nowrap title="<?=@$Tci03_datafim?>" align="left">
                    <?=@$Lci03_datafim?>
                </td>
                <td align="left" class="dado"> 
                    <?= db_formatar($ci03_datafim, 'd') ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tci03_grupoaudit?>">
                    <?=@$Lci03_grupoaudit?>
                </td>
                <td colspan="3" class="dado"> 
                    <?
                    $aGrupo = array(
                        1 => "Auditoria de Regularidade",
                        2 => "Auditoria Operacional",
                        3 => "Demanda Extraordinária"
                    );
                    echo $aGrupo[$ci03_grupoaudit];
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tci03_objaudit?>" align="right">
                    <?=@$Lci03_objaudit?>
                </td>
                <td colspan="3" class="dado"> 
                    <?= $ci03_objaudit ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tci03_protprocesso?>">
                    <?=@$Lci03_protprocesso?>
                </td>
                <td colspan="3" class="dado"> 
                    <?= $ci03_protprocesso != '' ? $p58_numero.'/'.$p58_ano : '' ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="Setor(es)">
                    <b>Setor(es):</b>
                </td>
                <td colspan="3" class="dado">
                    <?= $sDeptos ?>
                </td>
            </tr>
        </table>
    </fieldset>
</body>
