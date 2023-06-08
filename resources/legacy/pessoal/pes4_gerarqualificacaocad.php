<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
require_once("dbforms/db_funcoes.php");
require_once("classes/db_gerfcom_classe.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_classesgenericas.php");

$clgerfcom = new cl_gerfcom;
$clrotulo  = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);
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

<style>

    .formTable td {
        text-align: left;
    }

</style>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">

<form name="form1">

    <center>

        <fieldset style="margin-top: 50px; width: 40%">
            <legend style="font-weight: bold;">Qualificação cadastral (CSV) </legend>

            <table align="left" class='formTable'>
                <?
                if(!isset($tipo)){
                    $tipo = "l";
                }
                if(!isset($filtro)){
                    $filtro = "i";
                }
                if(!isset($anofolha) || (isset($anofolha) && trim($anofolha) == "")){
                    $anofolha = db_anofolha();
                }
                if(!isset($mesfolha) || (isset($mesfolha) && trim($mesfolha) == "")){
                    $mesfolha = db_mesfolha();
                }


                $geraform = new cl_formulario_rel_pes;

                $geraform->gera_form($anofolha,$mesfolha);
                ?>


            </table>

        </fieldset>

        <table style="margin-top: 10px;">
            <tr>
                <td colspan="2" align = "center">
                    <!-- <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" > -->
                    <input  name="geraCSV" id="geraCSV" type="button" value="Processar" onclick="js_geraCsv();" >
                </td>
            </tr>
        </table>

    </center>
</form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>


<script>

    var sUrlRPC = "pes2_qualificacaocadcsv.RPC.php";

    function js_geraCsv() {

        var iAno      = $F("anofolha");
        var iMes      = $F("mesfolha");


        var oParametros       = new Object();
        var msgDiv            = "Gerando arquivo CSV \n Aguarde ...";

        oParametros.exec      = 'gerarCsv';
        oParametros.iAno      = iAno;
        oParametros.iMes      = iMes;

        js_divCarregando(msgDiv,'msgBox');

        var oAjaxLista  = new Ajax.Request(sUrlRPC,
            {method: "post",
                parameters:'json='+Object.toJSON(oParametros),
                onComplete: js_retornoCsv
            });
    }

    function js_retornoCsv(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("("+oAjax.responseText+")");

        // se o retorno do csv "status" for 1, significa que nao ocorreram erros e exibimos a opção de download

        if (oRetorno.status == 1) {

            var listagem  = oRetorno.sArquivo+"# Download do Arquivo - "+ oRetorno.sArquivo;
            js_montarlista(listagem,'form1');

        } else {  // senão  Exibimos o erro ocorriodo na geração do CSV

            alert(oRetorno.message);
            return false;

        }
    }
</script>