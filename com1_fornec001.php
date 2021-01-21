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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "libs/db_utils.php";
require_once "libs/db_app.utils.php";
require_once "dbforms/db_funcoes.php";
require_once "model/CgmFactory.model.php";
require_once "model/fornecedor.model.php";
require_once ("classes/db_pcorcamval_classe.php");
require_once ("classes/db_condataconf_classe.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

$clpcorcamforne = new cl_pcorcamforne;
$clpcorcam      = new cl_pcorcam;
$clpcorcamitem  = new cl_pcorcamitem;
$clpcparam      = new cl_pcparam;
$pcorcamjulg    = new cl_pcorcamjulg;
$clpcorcamval   = new cl_pcorcamval;
$sqlerro        = false;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)|| isset($verificado)) {

    try {

        $oFornecedor = new fornecedor($pc21_numcgm);
        if($solicitacao == 'true') {
            $oFornecedor->verificaBloqueioSolicitacao($pc10_numero);
        } else if ($solicitacao == 'false'){
            $oFornecedor->verificaBloqueioProcessoCompra($pc80_codproc);
        }

        $iStatusBloqueio = $oFornecedor->getStatusBloqueio();
    } catch (Exception $eException) {

        $sqlerro  = true;
        $erro_msg = $eException->getMessage();
    }

    if ($iStatusBloqueio == 2) {
        $erro_msg  = "\\nusuário:\\n\\n Fornecedor com débito na prefeitura !\\n\\n\\n\\n";
    }

    //VERIFICA SE O FORNECEDOR ESTÁ BLOQUEADO
    $oForne = db_utils::getDao("pcforne");
    $oForne = $oForne->sql_record($oForne->sql_query($pc21_numcgm));
    $oForne = db_utils::fieldsMemory($oForne);

    if(!empty($oForne->pc60_databloqueio_ini) && !empty($oForne->pc60_databloqueio_fim)){

        if(strtotime(date("Y-m-d",db_getsession("DB_datausu"))) >= strtotime($oForne->pc60_databloqueio_ini) &&
            strtotime(date("Y-m-d",db_getsession("DB_datausu"))) <= strtotime($oForne->pc60_databloqueio_fim)){
            $erro_msg  = "\\nusuário:\\n\\n Fornecedor ".$oForne->z01_nome." está bloqueado para fornecer orçamentos !\\n\\n\\n\\n";
            $sqlerro=true;
        }

    }


    $clpcorcamforne->pc21_orcamforne = $pc21_orcamforne;
    $clpcorcamforne->pc21_codorc = $pc21_codorc;
    $clpcorcamforne->pc21_numcgm = $pc21_numcgm;
    $clpcorcamforne->pc21_importado = '0';
}


if (isset($incluir)) {


    db_inicio_transacao();

    if ($sqlerro==false) {

        $result_igualcgm = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null,"pc21_codorc",""," pc21_numcgm=$pc21_numcgm and pc21_codorc=$pc21_codorc"));
        if($clpcorcamforne->numrows > 0){

            $sqlerro = true;
            $erro_msg = "ERRO: Número de CGM já cadastrado.";
        }
    }

    if($sqlerro==false){

        $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$pc21_numcgm} and z09_tipo = 1");
        db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
        $dtsession   = date("Y-m-d",db_getsession("DB_datausu"));

        if($dtsession < $z09_datacadastro){
            $erro_msg = "Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!";
            $sqlerro = true;
        }

        /**
         * controle de encerramento peri. Patrimonial
         */
        $clcondataconf = new cl_condataconf;
        $resultControle = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit'),'c99_datapat'));
        db_fieldsmemory($resultControle,0);

        if($dtsession <= $c99_datapat){
            $erro_msg = "O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.";
            $sqlerro = true;
        }
    }

    //VERIFICA CPF E CNPJ ZERADOS OC 7037
    if ($sqlerro==false) {
        $result_cgmzerado = db_query("select z01_cgccpf from cgm where z01_numcgm = {$pc21_numcgm} ");
        db_fieldsmemory($result_cgmzerado, 0)->z01_cgccpf;

        if (strlen($z01_cgccpf) == 14) {
            if ($z01_cgccpf == '00000000000000') {
                $sqlerro = true;
                $erro_msg = "ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente";
            }
        }

        if (strlen($z01_cgccpf) == 11) {
            if ($z01_cgccpf == '00000000000') {
                $sqlerro = true;
                $erro_msg = "ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente";
            }
        }

    }
    //FIM OC 7037
    if ($sqlerro==false) {

        $clpcorcamforne->incluir($pc21_orcamforne);
        $erro_msg = $clpcorcamforne->erro_msg;
        if ($clpcorcamforne->erro_status==0) {
            $sqlerro=true;
        }
    }

    db_fim_transacao($sqlerro);
} else if (isset($excluir)) {

    if($sqlerro==false) {

        db_inicio_transacao();
        $pcorcamval = $clpcorcamval->sql_record($clpcorcamval->sql_query_file($pc21_orcamforne,null,"sum(pc23_vlrun) as valor",null,""));
        db_fieldsmemory($pcorcamval,0)->valor;
        if($valor > 0 ) {
            $sqlerro = true;
            $erro_msg = "Fornecedor com valores lançados";
        }else{
                $clpcorcamval->excluir($pc21_orcamforne);
                if($clpcorcamval->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg->clpcorcamval->erro_msg;
                }

                $pcorcamjulg->excluir(null,$pc21_orcamforne,null);
                if($pcorcamjulg->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg->pcorcamjulg->erro_msg;
                }

                $clpcorcamforne->excluir($pc21_orcamforne);
                if ($clpcorcamforne->erro_status==0) {
                    $sqlerro=true;
                    $erro_msg = $clpcorcamforne->erro_msg;
                }

            }

            db_fim_transacao($sqlerro);
        }
    } else if(isset($opcao)) {

    $result = $clpcorcamforne->sql_record($clpcorcamforne->sql_query($pc21_orcamforne,"pc21_orcamforne,pc21_codorc,pc21_numcgm,z01_nome"));
    if ($result!=false && $clpcorcamforne->numrows > 0) {
        db_fieldsmemory($result,0);
    }
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js, strings.js, widgets/dbtextField.widget.js,
               dbViewNotificaFornecedor.js, dbmessageBoard.widget.js, dbautocomplete.widget.js,
               dbcomboBox.widget.js,datagrid.widget.js,widgets/dbtextFieldData.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>
<style>
    #db_opcao, #exportarxls, #xlsbranco {
        width: 110px;
    }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <?
                include("forms/db_frmfornec.php");
                ?>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
<?
if (isset($alterar) || isset($excluir) || isset($incluir) || isset($verificado)) {

    if ($sqlerro==true) {

        db_msgbox($erro_msg);
        if ($clpcorcamforne->erro_campo!="") {

            echo "<script> document.form1.".$clpcorcamforne->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clpcorcamforne->erro_campo.".focus();</script>";
        }
    } else if ($iStatusBloqueio == 2) {
        db_msgbox($erro_msg);
    }
}

$result_libera = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null,"pc21_codorc","","pc21_codorc=$pc21_codorc"));
$tranca = "true";
if ($clpcorcamforne->numrows > 0) {
    $tranca = "false";
}
?>
